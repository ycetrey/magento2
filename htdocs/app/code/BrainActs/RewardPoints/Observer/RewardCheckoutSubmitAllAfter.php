<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Observer;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class RewardCheckoutSubmitAllAfter
 * @author BrainActs Commerce OÜ Core Team <support@brainacts.com>
 */
class RewardCheckoutSubmitAllAfter implements ObserverInterface
{

    private $ruleValidator;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var \BrainActs\RewardPoints\Model\HistoryFactory
     */
    private $historyFactory;

    /**
     * @var \BrainActs\RewardPoints\Model\Rule\SpendFactory
     */
    private $spendRuleFactory;

    /**
     * @var \BrainActs\RewardPoints\Model\Rule\EarningFactory
     */
    private $earningRuleFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $loger;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $helper;

    /**
     * @var Message\AfterPlaceOrder
     */
    private $messageManager;

    /**
     * RewardCheckoutSubmitAllAfter constructor.
     * @param CheckoutSession $checkoutSession
     * @param CustomerSession $customerSession
     * @param \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory
     * @param \BrainActs\RewardPoints\Model\Rule\SpendFactory $spendRuleFactory
     * @param \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory
     * @param \Psr\Log\LoggerInterface $loger
     * @param \BrainActs\RewardPoints\Model\Validator $ruleValidator
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \BrainActs\RewardPoints\Helper\Data $helper
     * @param Message\AfterPlaceOrder $messageManager
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        CustomerSession $customerSession,
        \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory,
        \BrainActs\RewardPoints\Model\Rule\SpendFactory $spendRuleFactory,
        \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory,
        \Psr\Log\LoggerInterface $loger,
        \BrainActs\RewardPoints\Model\Validator $ruleValidator,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \BrainActs\RewardPoints\Helper\Data $helper,
        \BrainActs\RewardPoints\Observer\Message\AfterPlaceOrder $messageManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->historyFactory = $historyFactory;
        $this->spendRuleFactory = $spendRuleFactory;
        $this->earningRuleFactory = $earningRuleFactory;
        $this->loger = $loger;
        $this->ruleValidator = $ruleValidator;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        if (!$this->helper->isEnabled()) {
            return $this;
        }

        if (!$this->customerSession->isLoggedIn()) {
            return $this;
        }
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $observer->getData('order');
        /** @var \Magento\Quote\Api\Data\CartInterface $quote */
        $quote = $observer->getData('quote');

        $rewardAmount = $quote->getRewardPointsAmount();
        $ruleId = $quote->getRewardPointsRule();
        if ($rewardAmount > 0 && $ruleId) {

            /** @var \BrainActs\RewardPoints\Model\Rule\Spend $rule */
            $rule = $this->spendRuleFactory->create()->load($ruleId);

            if ($rule->getId() == $ruleId) {
                $name = [$quote->getCustomer()->getFirstname(), $quote->getCustomer()->getLastname()];
                try {
                    /** @var \BrainActs\RewardPoints\Model\History $model */
                    $model = $this->historyFactory->create();
                    $model->setCustomerId($quote->getCustomer()->getId());
                    $model->setCustomerName(implode(', ', $name));
                    $model->setPoints(-$quote->getRewardPoints());
                    $model->setRuleName($rule->getName());
                    $model->setRuleSpendId($rule->getId());
                    $model->setOrderId($order->getId());
                    $model->setOrderIncrementId($order->getIncrementId());
                    $model->setStoreId($quote->getStoreId());
                    $model->setTypeRule(1);

                    $model->save();
                } catch (\Exception $e) {
                    $this->loger->critical($e);
                }
            }
        }

        //apply rules
        $store = $this->storeManager->getStore($quote->getStoreId());

        $this->ruleValidator->setCustomerGroupId($quote->getCustomer()->getGroupId())
            ->setWebsiteId($store->getWebsiteId());

        $items = $quote->getItems();
        $ids = [];
        foreach ($items as $item) {
            $ids = array_merge($ids, $this->ruleValidator->process($item, $quote));
        }
        $ids = array_unique($ids);

        $totalPoints = 0;
        foreach ($ids as $ruleId) {
            /** @var \BrainActs\RewardPoints\Model\Rule\Earning $rule */
            $rule = $this->earningRuleFactory->create()->load($ruleId);
            $points = $this->updateHistory($quote, $order, $rule);

            $totalPoints += $points;
        }

        if ($totalPoints > 0) {
            $this->messageManager->showMessage($totalPoints);
        }

        return $this;
    }

    /**
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \BrainActs\RewardPoints\Model\Rule\Earning $rule
     * @return float|int
     */
    private function updateHistory($quote, $order, $rule)
    {
        $name = [$quote->getCustomer()->getFirstname(), $quote->getCustomer()->getLastname()];
        try {
            /** @var \BrainActs\RewardPoints\Model\History $model */
            $model = $this->historyFactory->create();
            $model->setCustomerId($quote->getCustomer()->getId());
            $model->setCustomerName(implode(', ', $name));

            if ($rule->getType() == 1) {
                $points = $rule->getPoints();
            } elseif ($rule->getType() == 2) {
                $subtotal = $order->getSubtotal();
                $points = floor($subtotal / $rule->getSpend() * $rule->getEarn());
            }
            $model->setPoints($points);
            $model->setRuleName($rule->getName());
            $model->setRuleSpendId($rule->getId());
            $model->setOrderId($order->getId());
            $model->setOrderIncrementId($order->getIncrementId());
            $model->setStoreId($quote->getStoreId());
            $model->setTypeRule(2);

            $model->save();
        } catch (\Exception $e) {
            $this->loger->critical($e);

            return 0;
        }

        return $points;
    }
}

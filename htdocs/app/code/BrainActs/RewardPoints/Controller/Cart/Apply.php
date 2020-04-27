<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Cart;

use Magento\Checkout\Controller\Cart;

/**
 * Class Apply
 * @author BrainActs Commerce OÜ Core Team <support@brainacts.com>
 */
class Apply extends Cart
{
    /**
     * Sales quote repository
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $pointsHelper;

    /**
     * @var
     */
    private $rule;

    /**
     * Apply constructor.
     *
     * @param \Magento\Framework\App\Action\Context              $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session                    $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator     $formKeyValidator
     * @param \Magento\Checkout\Model\Cart                       $cart
     * @param \Magento\Quote\Api\CartRepositoryInterface         $quoteRepository
     * @param \BrainActs\RewardPoints\Helper\Data                $pointsHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \BrainActs\RewardPoints\Helper\Data $pointsHelper
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
        $this->quoteRepository = $quoteRepository;
        $this->pointsHelper = $pointsHelper;
    }

    /**
     * Initialize coupon
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {

        $rewardPoints = trim($this->getRequest()->getParam('reward_point_manually'));
        $cartQuote = $this->cart->getQuote();
        try {
            $amount = $this->_validate($rewardPoints);

            if ($amount === false || $rewardPoints < 0) {
                $this->messageManager->addError(__('We cannot apply the reward points.'));
                return $this->_goBack();
            }

            $itemsCount = $cartQuote->getItemsCount();
            if ($itemsCount) {
                $cartQuote->getShippingAddress()->setCollectShippingRates(true);
                $cartQuote->setRewardPointsAmount($amount)
                    ->setRewardPoints($rewardPoints)
                    ->setRewardPointsRule($this->rule->getId())
                    ->collectTotals();

                $this->quoteRepository->save($cartQuote);
                $this->messageManager->addSuccess(__('We applied "%1" points.', $rewardPoints));
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(__('We cannot apply the reward points.'));
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
        }

        return $this->_goBack();
    }

    /**
     * Validate reward points amount
     *
     * @param  $points
     * @return bool|float
     */
    private function _validate($points)
    {

        if (!is_numeric($points)) {
            return false;
        }

        $storeId = $this->_storeManager->getStore()->getId();
        $customerGroupId = $this->_checkoutSession->getQuote()->getCustomerGroupId();
        $rule = $this->pointsHelper->getRule($storeId, $customerGroupId);

        if (!$rule) {
            return false;
        }
        $this->rule = $rule;
        $subtotal = $this->_checkoutSession->getQuote()->getSubtotal();

        $exchange = $rule->getPoints() / $rule->getAmount();

        $amount = round($points / $exchange, 2);
        if ($amount > $subtotal) {
            return false;
        }

        return $amount;
    }
}

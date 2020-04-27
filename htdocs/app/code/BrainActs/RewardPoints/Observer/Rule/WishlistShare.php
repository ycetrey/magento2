<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Observer\Rule;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Class WishlistShare
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class WishlistShare implements ObserverInterface
{

    /**
     * @var \BrainActs\RewardPoints\Model\HistoryFactory
     */
    private $historyFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $loger;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $helper;

    /**
     * WishlistShare constructor.
     * @param \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory
     * @param \Psr\Log\LoggerInterface $loger
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param CustomerSession $customerSession
     * @param \BrainActs\RewardPoints\Helper\Data $helper
     */
    public function __construct(
        \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory,
        \Psr\Log\LoggerInterface $loger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CustomerSession $customerSession,
        \BrainActs\RewardPoints\Helper\Data $helper
    ) {
    
        $this->historyFactory = $historyFactory;
        $this->loger = $loger;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $this->customerSession->getCustomer();

        $name = [$customer->getFirstname(), $customer->getLastname()];
        try {
            $points = $this->helper->getShareWishListRulePoints();
            if (empty($points)) {
                return  $this;
            }

            /** @var \BrainActs\RewardPoints\Model\History $model */
            $model = $this->historyFactory->create();
            $model->setCustomerId($customer->getId());
            $model->setCustomerName(implode(', ', $name));
            $model->setPoints($points);
            $model->setRuleName(__('Share Wish List'));
            $model->setStoreId($this->storeManager->getStore()->getId());
            $model->setTypeRule(3);
            $model->save();
        } catch (\Exception $e) {
            $this->loger->critical($e);
        }
        return $this;
    }
}

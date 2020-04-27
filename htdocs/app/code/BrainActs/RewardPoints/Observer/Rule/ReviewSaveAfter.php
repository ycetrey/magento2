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
 * Class ReviewSaveAfter
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class ReviewSaveAfter implements ObserverInterface
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
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $helper;

    /**
     * ReviewSaveAfter constructor.
     * @param \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory
     * @param \Psr\Log\LoggerInterface $loger
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param CustomerSession $customerSession
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \BrainActs\RewardPoints\Helper\Data $helper
     */
    public function __construct(
        \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory,
        \Psr\Log\LoggerInterface $loger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CustomerSession $customerSession,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \BrainActs\RewardPoints\Helper\Data $helper
    ) {
    
        $this->historyFactory = $historyFactory;
        $this->loger = $loger;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $wishList = $observer->getData('object');

        $customerId = $wishList->getCustomerId();
        if (empty($customerId)) {
            return $this;
        }

        $oldStatus = $wishList->getOrigData('status_id');

        if ($wishList->getStatusId() == \Magento\Review\Model\Review::STATUS_APPROVED
            && $oldStatus != \Magento\Review\Model\Review::STATUS_APPROVED
        ) {

            /**
             * @var \Magento\Customer\Model\Customer
             */
            $model = $this->customerFactory->create();
            $customer = $model->load($customerId);

            $name = [$customer->getFirstname(), $customer->getLastname()];
            try {
                $points = $this->helper->getSubmitReviewRulePoints();
                if (empty($points)) {
                    return $this;
                }

                /** @var \BrainActs\RewardPoints\Model\History $model */
                $model = $this->historyFactory->create();
                $model->setCustomerId($customer->getId());
                $model->setCustomerName(implode(', ', $name));
                $model->setPoints($points);
                $model->setRuleName(__('Submit Review'));
                $model->setStoreId($this->storeManager->getStore()->getId());
                $model->setTypeRule(3);
                $model->save();
            } catch (\Exception $e) {
                $this->loger->critical($e);
            }
        }
        return $this;
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\DB\Select;

/**
 * Class RewardConfigProvider
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class RewardConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $historyCollectionFactory;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $pointsHelper;

    /**
     * @var null
     */
    private $points = null;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        CheckoutSession $checkoutSession,
        CustomerSession $customerSession,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory,
        \BrainActs\RewardPoints\Helper\Data $pointsHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->_storeManager = $storeManager;

        $this->historyCollectionFactory = $historyCollectionFactory;
        $this->pointsHelper = $pointsHelper;
    }

    public function getConfig()
    {
        $amount = $this->checkoutSession->getQuote()->getRewardPointsAmount();
        $selectedPoints = $this->checkoutSession->getQuote()->getRewardPoints();
        $availablePoints = $this->getAvailablePoints();
        $maxPoints = $this->getMaxPoints();

        if ($availablePoints > $maxPoints) {
            $points = $maxPoints;
        } else {
            $points = $availablePoints;
        }
        $selectedPoints = $selectedPoints ? $selectedPoints : 0;
        $output['reward'] = [
            'amount' => $amount,
            'selected_points' => $selectedPoints,
            'available_points' => $points,
            'max_points' => $this->getAvailablePoints(),
            'exchange' => $this->exchange,
            'is_visible' => $this->isVisible()
        ];

        return $output;
    }

    private function getAvailablePoints()
    {
        if (!$this->customerSession->isLoggedIn()) {
            $this->points = 0;
            return $this->points;
        }

        if ($this->points == null) {
            /** @var \BrainActs\RewardPoints\Model\ResourceModel\History\Collection $collection */
            $collection = $this->historyCollectionFactory->create();
            $collection->getSelect()->reset(Select::COLUMNS)
                ->columns(['total' => new \Zend_Db_Expr('SUM(points)')])->group('customer_id');
            $collection->addFieldToFilter('customer_id', ['eq' => $this->customerSession->getCustomerId()]);
            $collection->load();
            $item = $collection->fetchItem();
            if ($item) {
                $this->points = $item->getData('total');
            }
            //$this->convertToCurrency($this->points);
        }
        return $this->points;
    }

    private function getMaxPoints()
    {
        $subtotal = $this->checkoutSession->getQuote()->getSubtotal();
        $rule = $this->getConvertRule();
        if (!$rule) {
            $this->exchange = 0;
            return 0;
        }
        $exchange = $rule->getPoints() / $rule->getAmount();
        $maxPoints = $subtotal * $exchange;
        $this->exchange = $exchange;
        return $maxPoints;
    }

    private function getConvertRule()
    {
        $customerGroupId = $this->customerSession->getCustomer()->getGroupId();

        return $this->pointsHelper->getRule($this->checkoutSession->getQuote()->getStoreId(), $customerGroupId);
    }

    private function isVisible()
    {
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }

        if (!$this->pointsHelper->isEnabled()) {
            return false;
        }

        //check rules for this store and customer group
        $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
        $rule = $this->pointsHelper->getRule($this->_storeManager->getStore()->getId(), $customerGroupId);
        if (!$rule) {
            return false;
        }

        return true;
    }
}

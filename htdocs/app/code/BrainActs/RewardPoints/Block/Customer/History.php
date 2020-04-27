<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Customer;

use Magento\Customer\Model\Session;
use BrainActs\RewardPoints\Model\History as PointsHistory;
use Magento\Store\Model\ScopeInterface;

/**
 * Class History
 * @author BrainActs Core Team <support@brainacts.com>
 */
class History extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'points/history.phtml';

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $pointsCollectionFactory;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    private $orderConfig;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\Collection
     */
    private $points;


    /**
     * @var int
     */
    private $totalPoints = 0;

    /**
     * @var
     */
    private $isExpirationEnable = null;

    /**
     * History constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $pointsCollectionFactory
     * @param Session $customerSession
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $pointsCollectionFactory,
        Session $customerSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        array $data = []
    )
    {
        $this->pointsCollectionFactory = $pointsCollectionFactory;
        $this->customerSession = $customerSession;
        $this->orderConfig = $orderConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->pageConfig->getTitle()->set(__('Reward Points History'));
    }

    /**
     * @return $this|bool|\BrainActs\RewardPoints\Model\ResourceModel\History\Collection
     */
    public function getPoints()
    {
        if (!($customerId = $this->customerSession->getCustomerId())) {
            return false;
        }

        if (!$this->points) {
            /** @var  points */
            $this->points = $this->pointsCollectionFactory->create()->addFieldToSelect(
                '*'
            )->addFieldToFilter(
                'customer_id',
                ['eq' => $customerId]
            )->addFieldToFilter(
                'is_deleted',
                ['eq' => 0]
            )->addFieldToFilter(
                'is_expired',
                ['eq' => 0]
            )->setOrder(
                'created_at',
                'desc'
            );

            if ($this->isExpirationEnabled()){
                $this->points->addExpiredField($this->getExpirationDays());
            }
            $this->calcTotal();
        }

        return $this->points;
    }

    private function calcTotal()
    {
        foreach ($this->points as $item) {
            $this->totalPoints += $item->getPoints();
        }
    }

    public function getRewardPointsTotal()
    {
        return $this->totalPoints;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getOrders()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'points.history.pager'
            )->setCollection(
                $this->getOrders()
            );
            $this->setChild('pager', $pager);
            $this->getOrders()->load();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('customer/account/');
    }

    /**
     * @param string $name
     * @param string $reason
     * @return string
     */
    public function prepareReason($name, $reason)
    {
        if (!empty($reason)) {
            return $reason;
        }

        return $name;
    }

    /**
     * Check if is expiration logic is enable
     * @return bool
     */
    public function isExpirationEnabled()
    {
        if ($this->isExpirationEnable!=null){
            return $this->isExpirationEnable;
        }

        $isExpirationEnable = (bool)$this->_scopeConfig
            ->getValue(PointsHistory::POINTS_EXPIRATION_XML, ScopeInterface::SCOPE_STORE);
        $this->isExpirationEnable = $isExpirationEnable;
        if ($isExpirationEnable) {
            return $this->isExpirationEnable;
        }

        return $this->isExpirationEnable;
    }

    public function getExpirationDays(){
        return $this->_scopeConfig
            ->getValue(PointsHistory::POINTS_EXPIRATION_PERIOD_XML, ScopeInterface::SCOPE_STORE);
    }
}

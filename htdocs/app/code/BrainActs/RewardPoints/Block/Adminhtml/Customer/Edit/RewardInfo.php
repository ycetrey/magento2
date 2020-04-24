<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\DB\Select;

class RewardInfo extends \Magento\Backend\Block\Template
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $historyCollectionFactory;

    private $points = 0;

    /**
     * RewardInfo constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                               $context
     * @param \Magento\Framework\Registry                                           $registry
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory
     * @param array                                                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->historyCollectionFactory = $historyCollectionFactory;

        parent::__construct($context, $data);
    }

    /**
     * Retrieve customer id
     *
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    public function getRewardPoints()
    {
        if ($this->points == null) {
            /** @var \BrainActs\RewardPoints\Model\ResourceModel\History\Collection $collection */
            $collection = $this->historyCollectionFactory->create();
            $collection->getSelect()->reset(Select::COLUMNS)
                ->columns(['total' => new \Zend_Db_Expr('SUM(points)')])->group('customer_id');
            $collection->addFieldToFilter('customer_id', ['eq' => $this->getCustomerId()]);
            $collection->load();
            $item = $collection->fetchItem();
            if ($item) {
                $this->points = $item->getData('total');
            }
        }

        return $this->points;
    }
}

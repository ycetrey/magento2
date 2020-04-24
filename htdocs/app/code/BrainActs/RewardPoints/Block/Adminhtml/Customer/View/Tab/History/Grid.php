<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\Customer\View\Tab\History;

use Magento\Customer\Controller\RegistryConstants;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry|null
     */
    private $coreRegistry = null;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('reward_points_customer_history_grid');
        $this->setDefaultSort('created_at', 'desc');
        $this->setPagerVisibility(true);
        $this->setFilterVisibility(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $customerId = $this->coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
        $collection->addFieldToFilter('customer_id', ['eq' => $customerId]);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'history_id',
            [
                'header' => __('ID'),
                'index' => 'history_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'rule_name',
            [
                'header' => __('Rule Name'),
                'type' => 'text',
                'index' => 'rule_name',
                'header_css_class' => 'col-points',
                'column_css_class' => 'col-points'
            ]
        );

        $this->addColumn(
            'points',
            [
                'header' => __('Points'),
                'type' => 'number',
                'index' => 'points',
                'header_css_class' => 'col-points',
                'column_css_class' => 'col-points'
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'type' => 'datetime',
                'index' => 'created_at',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );

        $this->addColumn(
            'reason',
            [
                'header' => __('Reason'),
                'type' => 'text',
                'index' => 'reason',
                'header_css_class' => 'col-reason',
                'column_css_class' => 'col-reason'
            ]
        );

        $this->addColumn(
            'modifier_name',
            [
                'header' => __('Modifier'),
                'type' => 'text',
                'index' => 'modifier_name',
                'header_css_class' => 'col-modifier',
                'column_css_class' => 'col-modifier'
            ]
        );

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

    /**
     * Get row url
     *
     * @param  \Magento\Review\Model\Review|\Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getCurrentUrl();
    }
}

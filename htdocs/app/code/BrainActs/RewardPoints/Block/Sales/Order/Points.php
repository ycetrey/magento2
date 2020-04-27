<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Sales\Order;

class Points extends \Magento\Framework\View\Element\Template
{

    /**
     * Tax configuration model
     *
     * @var \Magento\Tax\Model\Config
     */
    public $config;

    /**
     * @var Order
     */
    public $order;

    /**
     * @var \Magento\Framework\DataObject
     */
    public $source;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Tax\Model\Config                        $taxConfig
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Tax\Model\Config $taxConfig,
        array $data = []
    ) {
        $this->config = $taxConfig;
        parent::__construct($context, $data);
    }

    /**
     * Check if we need display full tax total info
     *
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->source;
    }

    public function getStore()
    {
        return $this->order->getStore();
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * @return array
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return \Magento\Tax\Block\Sales\Order\Tax
     */
    public function initTotals()
    {

        $parent = $this->getParentBlock();
        $this->order = $parent->getOrder();
        $this->source = $parent->getSource();

        $store = $this->getStore();

        $rewardPoints = new \Magento\Framework\DataObject(
            [
                'code' => 'reward_points',
                'strong' => true,
                'value' => -$this->order->getRewardPointsAmount(),
                'label' => __('Reward Points'),
            ]
        );

        $parent->addTotal($rewardPoints, 'reward_points');

        return $this;
    }
}

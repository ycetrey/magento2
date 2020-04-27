<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\Sales\Order\Invoice;

class Points extends \Magento\Framework\View\Element\Template
{
    private $config;

    private $order;

    private $source;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Tax\Model\Config $taxConfig,
        array $data = []
    ) {
        $this->config = $taxConfig;
        parent::__construct($context, $data);
    }

    public function displayFullSummary()
    {
        return true;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getStore()
    {
        return $this->order->getStore();
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->order = $parent->getOrder();
        $this->source = $parent->getSource();

        $store = $this->getStore();

        $value = $this->order->getRewardPointsAmount();
        $fee = new \Magento\Framework\DataObject(
            [
                'code' => 'reward_points',
                'strong' => false,
                'value' => -$value,
                'base_value' => -$value,
                'label' => __('Reward Points'),
            ]
        );
        $parent->addTotal($fee, 'reward_points');
        return $this;
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class EarningType
 * @author BrainActs Core Team <support@brainacts.com>
 */
class EarningType implements ArrayInterface
{

    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Please select',
                'value' => 0
            ],
            1 => [
                'label' => __('Fixed'),
                'value' => 1
            ],
            2 => [
                'label' => __('For Each X Spend Customer Receive Y Points'),
                'value' => 2
            ],
        ];

        return $options;
    }

}

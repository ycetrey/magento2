<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\Rule\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class IsActive implements OptionSourceInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

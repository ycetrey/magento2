<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Ui\Component\Listing\Column\Rules;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

/**
 * Class Groups
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Groups implements OptionSourceInterface
{
    /**
     * @var array
     */
    public $options;

    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = $this->collectionFactory->create()->setIgnoreIdFilter([0])->toOptionArray();
        }
        return $this->options;
    }
}

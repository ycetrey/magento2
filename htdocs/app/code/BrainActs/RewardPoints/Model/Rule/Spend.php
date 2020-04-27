<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\Rule;

use BrainActs\RewardPoints\Api\Data\RuleSpendInterface;
use Magento\Framework\Model\AbstractModel as MagentoAbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Spend
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Spend extends MagentoAbstractModel implements RuleSpendInterface, IdentityInterface
{

    /**#@+
     * Page's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Store Locator page cache tag
     */
    const CACHE_TAG = 'brainacts_points_rule_spend';

    /**
     * @var string
     */
    protected $_cacheTag = 'brainacts_points_rule_spend';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'brainacts_points_rule_spend';

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::RULE_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::RULE_ID, $id);
    }

    /**
     * Prepare statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}

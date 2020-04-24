<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model;

use BrainActs\RewardPoints\Api\Data\HistoryInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class History
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class History extends AbstractModel implements HistoryInterface, IdentityInterface
{

    const POINTS_EXPIRATION_XML = 'brainacts_reward_points/general/expire';

    const POINTS_EXPIRATION_PERIOD_XML = 'brainacts_reward_points/general/expire_period';

    /**
     * Store Locator page cache tag
     */
    const CACHE_TAG = 'reward_history';

    /**
     * @var string
     */
    protected $_cacheTag = 'reward_history';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'reward_history';

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('BrainActs\RewardPoints\Model\ResourceModel\History');
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
        return $this->getData(self::HISTORY_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::HISTORY_ID, $id);
    }

    public function getExpirationPeriod()
    {
        if ($this->getPoints() >= 0) {
            return $this->getExpiredIn() . ' ' . __('Day(s)');
        }

        return '';
    }
}

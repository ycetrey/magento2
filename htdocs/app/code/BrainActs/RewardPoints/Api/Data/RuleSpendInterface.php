<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Api\Data;

/**
 * Interface RuleSpendInterface
 *
 * @author BrainActs Core Team <support@brainacts.com>
 * @api
 */
interface RuleSpendInterface
{

    const RULE_ID = 'spend_rule_id';
    const NAME = 'name';
    const CUSTOMER_GROUP = 'customer_group';
    const STORE_ID = 'store_id';
    const POINTS = 'points';
    const CURRENCY = 'currency';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'update_at';

    //SETTERS

    /**
     * Sets the ID.
     *
     * @param  int $id
     * @return \BrainActs\RewardPoints\Api\Data\RuleSpendInterface
     */
    public function setId($id);

    //GETTERS

    /**
     * Get ID
     *
     * @return int|null History Item ID
     */
    public function getId();
}

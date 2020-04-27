<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Api\Data;

/**
 * Interface HistoryInterface
 *
 * @author BrainActs Core Team <support@brainacts.com>
 * @api
 */
interface HistoryInterface
{

    const HISTORY_ID = 'history_id';
    const CUSTOMER_ID= 'customer_id';
    const CUSTOMER_NAME = 'customer_name';
    const POINTS = 'points';
    const RULE_NAME= 'rule_name';
    const ORDER_ID = 'order_id';
    const ORDER_INCREMENT_ID = 'order_increment_id';
    const CREATED_AT = 'created_at';
    const MODIFIER_NAME = 'modifier_name';
    const REASON = 'reason';

    //SETTERS
    /**
     * Sets the ID.
     *
     * @param  int $id
     * @return \BrainActs\RewardPoints\Api\Data\HistoryInterface
     */
    public function setId($id);

    /**
     * Get ID
     *
     * @return int|null History Item ID
     */
    public function getId();
}

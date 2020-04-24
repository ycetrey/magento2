<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Api\Data;

/**
 * Interface RuleEarningInterface
 *
 * @author BrainActs Core Team <support@brainacts.com>
 * @api
 */
interface RuleEarningInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Return rule id
     *
     * @return int|null
     */
    public function getRuleId();

    /**
     * Set rule id
     *
     * @param  int $ruleId
     * @return $this
     */
    public function setRuleId($ruleId);

    /**
     * Get rule name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set rule name
     *
     * @param  string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     *
     * @param  string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get a list of websites the rule applies to
     *
     * @return int[]
     */
    public function getWebsiteIds();

    /**
     * Set the websites the rule applies to
     *
     * @param  int[] $websiteIds
     * @return $this
     */
    public function setWebsiteIds(array $websiteIds);

    /**
     * Get ids of customer groups that the rule applies to
     *
     * @return int[]
     */
    public function getCustomerGroupIds();

    /**
     * Set the customer groups that the rule applies to
     *
     * @param  int[] $customerGroupIds
     * @return $this
     */
    public function setCustomerGroupIds(array $customerGroupIds);

    /**
     * Get the start date when the coupon is active
     *
     * @return string|null
     */
    public function getFromDate();

    /**
     * Set the star date when the coupon is active
     *
     * @param  string $fromDate
     * @return $this
     */
    public function setFromDate($fromDate);

    /**
     * Get the end date when the coupon is active
     *
     * @return string|null
     */
    public function getToDate();

    /**
     * Set the end date when the coupon is active
     *
     * @param  string $fromDate
     * @return $this
     */
    public function setToDate($fromDate);

    /**
     * Whether the coupon is active
     *
     * @return                                       bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsActive();

    /**
     * Set whether the coupon is active
     *
     * @param  bool $isActive
     * @return bool
     */
    public function setIsActive($isActive);

    /**
     * Get condition for the rule
     *
     * @return \Magento\SalesRule\Api\Data\ConditionInterface|null
     */
    public function getCondition();

    /**
     * Set condition for the rule
     *
     * @param  \Magento\SalesRule\Api\Data\ConditionInterface|null $condition
     * @return $this
     */
    public function setCondition(\Magento\SalesRule\Api\Data\ConditionInterface $condition = null);

    /**
     * Whether to stop rule processing
     *
     * @return                                       bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getStopRulesProcessing();

    /**
     * Set whether to stop rule processing
     *
     * @param  bool $stopRulesProcessing
     * @return $this
     */
    public function setStopRulesProcessing($stopRulesProcessing);

    /**
     * Return product ids
     *
     * @return int[]|null
     */
    public function getProductIds();

    /**
     * Set product ids
     *
     * @param  int[]|null $productIds
     * @return $this
     */
    public function setProductIds(array $productIds = null);

    /**
     * Get sort order
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * Get points
     *
     * @return float
     */
    public function getPoints();

    /**
     * @param float $points
     * @return $this
     */
    public function setPoints($points);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\SalesRule\Api\Data\RuleExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Magento\SalesRule\Api\Data\RuleExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Magento\SalesRule\Api\Data\RuleExtensionInterface $extensionAttributes);
}

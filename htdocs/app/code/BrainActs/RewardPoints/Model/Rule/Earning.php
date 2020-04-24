<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Model\Rule;

use Magento\Quote\Model\Quote\Address;

/**
 * Shopping Cart Rule data model
 *
 * @method \BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning _getResource()
 * @method \BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning getResource()
 *
 * @method getSpend()
 * @method getEarn()
 * @method getType()
 */

class Earning extends \BrainActs\RewardPoints\Model\Rule\AbstractModel implements
    \BrainActs\RewardPoints\Api\Data\RuleEarningInterface
{
    const KEY_RULE_ID = 'earning_rule_id';
    const KEY_NAME = 'name';
    const KEY_DESCRIPTION = 'description';
    const KEY_FROM_DATE = 'from_date';
    const KEY_TO_DATE = 'to_date';
    const KEY_IS_ACTIVE = 'is_active';
    const KEY_CONDITION = 'condition';
    const KEY_STOP_RULES_PROCESSING = 'stop_rules_processing';
    const KEY_WEBSITES = 'website_ids';
    const KEY_PRODUCT_IDS = 'product_ids';
    const KEY_CUSTOMER_GROUPS = 'customer_group_ids';
    const KEY_SORT_ORDER = 'sort_order';
    const KEY_POINTS = 'points';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'reward_points_earning_rule';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getRule() in this case
     *
     * @var string
     */
    protected $_eventObject = 'rule';

    /**
     * Store already validated addresses and validation results
     *
     * @var array
     */
    protected $_validatedAddresses = [];

    /**
     * @var \Magento\SalesRule\Model\Rule\Condition\CombineFactory
     */
    protected $_condCombineFactory;

    /**
     * @var \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory
     */
    protected $_condProdCombineF;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Earning constructor.
     *
     * @param \Magento\Framework\Model\Context                               $context
     * @param \Magento\Framework\Registry                                    $registry
     * @param \Magento\Framework\Data\FormFactory                            $formFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface           $localeDate
     * @param \Magento\SalesRule\Model\Rule\Condition\CombineFactory         $condCombineFactory
     * @param \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory $condProdCombineF
     * @param \Magento\Store\Model\StoreManagerInterface                     $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null   $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null             $resourceCollection
     * @param array                                                          $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\SalesRule\Model\Rule\Condition\CombineFactory $condCombineFactory,
        \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory $condProdCombineF,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_condCombineFactory = $condCombineFactory;
        $this->_condProdCombineF = $condProdCombineF;
        $this->storeManager = $storeManager;
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $localeDate,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Set resource model and Id field name
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning');
        $this->setIdFieldName('earning_rule_id');
    }

    /**
     * @return $this
     */
    protected function _afterLoad()
    {
        return parent::_afterLoad();
    }

    /**
     * Save/delete
     *
     * @return $this
     */
    public function afterSave()
    {
        parent::afterSave();
        return $this;
    }

    /**
     * Initialize rule model data from array.
     * Set store labels if applicable.
     *
     * @param  array $data
     * @return $this
     */
    public function loadPost(array $data)
    {
        parent::loadPost($data);
        return $this;
    }

    /**
     * Get rule condition combine model instance
     *
     * @return \Magento\SalesRule\Model\Rule\Condition\Combine
     */
    public function getConditionsInstance()
    {
        return $this->_condCombineFactory->create();
    }

    /**
     * Check cached validation result for specific address
     *
     * @param  Address $address
     * @return bool
     */
    public function hasIsValidForAddress($address)
    {
        $id = $this->_getAddressId($address);
        return isset($this->_validatedAddresses[$id]) ? true : false;
    }

    /**
     * Set validation result for specific address to results cache
     *
     * @param  Address $address
     * @param  bool    $validationResult
     * @return $this
     */
    public function setIsValidForAddress($address, $validationResult)
    {
        $addressId = $this->_getAddressId($address);
        $this->_validatedAddresses[$addressId] = $validationResult;
        return $this;
    }

    /**
     * Get cached validation result for specific address
     *
     * @param                                        Address $address
     * @return                                       bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsValidForAddress($address)
    {

        $addressId = $this->_getAddressId($address);
        return isset($this->_validatedAddresses[$addressId]) ? $this->_validatedAddresses[$addressId] : false;
    }

    /**
     * Return id for address
     *
     * @param  Address $address
     * @return string
     */
    private function _getAddressId($address)
    {
        if ($address instanceof Address) {
            return $address->getId();
        }
        return $address;
    }

    /**
     * @param string $formName
     * @return string
     */
    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    /**
     * @param string $formName
     * @return string
     */
    public function getActionsFieldSetId($formName = '')
    {
        return $formName . 'rule_actions_fieldset_' . $this->getId();
    }

    /**
     * Return rule id
     *
     * @return int|null
     */
    public function getRuleId()
    {
        return $this->getData(self::KEY_RULE_ID);
    }

    /**
     * Set rule id
     *
     * @param  int $ruleId
     * @return $this
     */
    public function setRuleId($ruleId)
    {
        return $this->setData(self::KEY_RULE_ID, $ruleId);
    }

    /**
     * Get rule name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::KEY_NAME);
    }

    /**
     * Set rule name
     *
     * @param  string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::KEY_NAME, $name);
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::KEY_DESCRIPTION);
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::KEY_DESCRIPTION, $description);
    }

    /**
     * Get the start date when the coupon is active
     *
     * @return string|null
     */
    public function getFromDate()
    {
        return $this->getData(self::KEY_FROM_DATE);
    }

    /**
     * Set the star date when the coupon is active
     *
     * @param  string $fromDate
     * @return $this
     */
    public function setFromDate($fromDate)
    {
        return $this->setData(self::KEY_FROM_DATE, $fromDate);
    }

    /**
     * Get the end date when the coupon is active
     *
     * @return string|null
     */
    public function getToDate()
    {
        return $this->getData(self::KEY_TO_DATE);
    }

    /**
     * Set the end date when the coupon is active
     *
     * @param  string $toDate
     * @return $this
     */
    public function setToDate($toDate)
    {
        return $this->setData(self::KEY_TO_DATE, $toDate);
    }

    /**
     * Whether the rule is active
     *
     * @return                                       bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsActive()
    {
        return $this->getData(self::KEY_IS_ACTIVE);
    }

    /**
     * Set whether the coupon is active
     *
     * @param  bool $isActive
     * @return bool
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::KEY_IS_ACTIVE, $isActive);
    }

    /**
     * Get condition for the rule
     *
     * @return \Magento\SalesRule\Api\Data\ConditionInterface|null
     */
    public function getCondition()
    {
        return $this->_get(self::KEY_CONDITION);
    }

    /**
     * Set condition for the rule
     *
     * @param  \Magento\SalesRule\Api\Data\ConditionInterface|null $condition
     * @return $this
     */
    public function setCondition(\Magento\SalesRule\Api\Data\ConditionInterface $condition = null)
    {
        return $this->setData(self::KEY_CONDITION, $condition);
    }

    /**
     * Whether to stop rule processing
     *
     * @return                                       bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getStopRulesProcessing()
    {
        return $this->getData(self::KEY_STOP_RULES_PROCESSING);
    }

    /**
     * Set whether to stop rule processing
     *
     * @param  bool $stopRulesProcessing
     * @return $this
     */
    public function setStopRulesProcessing($stopRulesProcessing)
    {
        return $this->setData(self::KEY_STOP_RULES_PROCESSING, $stopRulesProcessing);
    }

    /**
     * Get a list of websites the rule applies to
     *
     * @return int[]
     */
    public function getWebsiteIds()
    {
        return $this->getData(self::KEY_WEBSITES);
    }

    /**
     * Set the websites the rule applies to
     *
     * @param  int[] $websites
     * @return $this
     */
    public function setWebsiteIds(array $websites)
    {
        return $this->setData(self::KEY_WEBSITES, $websites);
    }

    /**
     * Get ids of customer groups that the rule applies to
     *
     * @return int[]
     */
    public function getCustomerGroupIds()
    {
        if (!$this->hasCustomerGroupIds()) {
            $customerGroupIds = $this->_getResource()->getCustomerGroupIds($this->getId());
            $this->setData(self::KEY_CUSTOMER_GROUPS, (array)$customerGroupIds);
        }
        return $this->_getData(self::KEY_CUSTOMER_GROUPS);
    }

    /**
     * Set the customer groups that the rule applies to
     *
     * @param  int[] $customerGroups
     * @return $this
     */
    public function setCustomerGroupIds(array $customerGroups)
    {
        return $this->setData(self::KEY_CUSTOMER_GROUPS, $customerGroups);
    }

    /**
     * Return product ids
     *
     * @return int[]|null
     */
    public function getProductIds()
    {
        return $this->getData(self::KEY_PRODUCT_IDS);
    }

    /**
     * Set product ids
     *
     * @param  int[]|null $productIds
     * @return $this
     */
    public function setProductIds(array $productIds = null)
    {
        return $this->setData(self::KEY_PRODUCT_IDS, $productIds);
    }

    /**
     * Get sort order
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getData(self::KEY_SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::KEY_SORT_ORDER, $sortOrder);
    }

    /**
     * Get simple action of the rule
     *
     * @return float
     */
    public function getPoints()
    {
        return $this->getData(self::KEY_POINTS);
    }

    /**
     * Set simple action
     *
     * @param  float $points
     * @return $this
     */
    public function setPoints($points)
    {
        return $this->setData(self::KEY_POINTS, $points);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Magento\SalesRule\Api\Data\RuleExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Magento\SalesRule\Api\Data\RuleExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\SalesRule\Api\Data\RuleExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning;

use Magento\Quote\Model\Quote\Address;

/**
 * Class Collection
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Collection extends \Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'earning_rule_id';

    /**
     * Store associated with rule entities information map
     *
     * @var array
     */
    protected $_associatedEntitiesMap;

    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\DateApplier
     */
    protected $dateApplier;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_date;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param mixed $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_date = $date;
        $this->_associatedEntitiesMap = $this->getAssociatedEntitiesMap();
    }

    /**
     * Set resource model and determine field mapping
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'BrainActs\RewardPoints\Model\Rule\Earning',
            'BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning'
        );
        $this->_map['fields']['earning_rule_id'] = 'main_table.earning_rule_id';
    }

    /**
     * @param $entityType
     * @param $objectField
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function mapAssociatedEntities($entityType, $objectField)
    {
        if (!$this->_items) {
            return;
        }

        $entityInfo = $this->_getAssociatedEntityInfo($entityType);

        $fieldId = $entityInfo['rule_id_field'];

        $entityIds = $this->getColumnValues($fieldId);


        $select = $this->getConnection()->select()->from(
            $this->getTable($entityInfo['associations_table'])
        )->where(
            $fieldId . ' IN (?)',
            $entityIds
        );

        $associatedEntities = $this->getConnection()->fetchAll($select);

        array_map(
            function ($associatedEntity) use ($entityInfo, $fieldId, $objectField) {
                $item = $this->getItemByColumnValue($fieldId, $associatedEntity[$fieldId]);
                $itemAssociatedValue = $item->getData($objectField) === null ? [] : $item->getData($objectField);
                $itemAssociatedValue[] = $associatedEntity[$entityInfo['entity_id_field']];
                $item->setData($objectField, $itemAssociatedValue);
            },
            $associatedEntities
        );
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function _afterLoad()
    {
        $this->mapAssociatedEntities('website', 'website_ids');
        $this->mapAssociatedEntities('customer_group', 'customer_group_ids');

        $this->setFlag('add_websites_to_result', false);
        return parent::_afterLoad();
    }

    /**
     * Filter collection by specified website, customer group, coupon code, date.
     * Filter collection to use only active rules.
     * Involved sorting by sort_order column.
     *
     * @param  int $websiteId
     * @param  int $customerGroupId
     * @param  string|null $now
     * @return $this
     */
    public function setValidationFilter($websiteId, $customerGroupId, $now = null)
    {
        if (!$this->getFlag('validation_filter')) {
            $this->getSelect()->reset();
            parent::_initSelect();

            $this->addWebsiteGroupDateFilter($websiteId, $customerGroupId, $now);

            $this->setOrder('sort_order', self::SORT_ORDER_ASC);
            $this->setFlag('validation_filter', true);
        }

        return $this;
    }

    /**
     * Filter collection by website(s), customer group(s) and date.
     * Filter collection to only active rules.
     * Sorting is not involved
     *
     * @param  int $websiteId
     * @param  int $customerGroupId
     * @param  string|null $now
     * @use    $this->addWebsiteFilter()
     * @return $this
     */
    public function addWebsiteGroupDateFilter($websiteId, $customerGroupId, $now = null)
    {
        if (!$this->getFlag('website_group_date_filter')) {
            if ($now === null) {
                $now = $this->_date->date()->format('Y-m-d');
            }

            $this->addWebsiteFilter($websiteId);

            $entityInfo = $this->_getAssociatedEntityInfo('customer_group');
            $connection = $this->getConnection();
            $this->getSelect()->joinInner(
                ['customer_group_ids' => $this->getTable($entityInfo['associations_table'])],
                $connection->quoteInto(
                    'main_table.' .
                    $entityInfo['rule_id_field'] .
                    ' = customer_group_ids.' .
                    $entityInfo['rule_id_field'] .
                    ' AND customer_group_ids.' .
                    $entityInfo['entity_id_field'] .
                    ' = ?',
                    (int)$customerGroupId
                ),
                []
            );

            $this->getDateApplier()->applyDate($this->getSelect(), $now);

            $this->addIsActiveFilter();

            $this->setFlag('website_group_date_filter', true);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function _initSelect()
    {
        parent::_initSelect();
        return $this;
    }

    /**
     * Find product attribute in conditions or actions
     *
     * @param  string $attributeCode
     * @return $this
     */
    public function addAttributeInConditionFilter($attributeCode)
    {
        $substring = substr(serialize(['attribute' => $attributeCode]), 5, -1);
        $match = sprintf('%%%s%%', $substring);
        $field = $this->_getMappedField('conditions_serialized');
        $cCond = $this->_getConditionSql($field, ['like' => $match]);
        $field = $this->_getMappedField('actions_serialized');
        $aCond = $this->_getConditionSql($field, ['like' => $match]);

        $this->getSelect()->where(
            sprintf('(%s OR %s)', $cCond, $aCond),
            null,
            \Magento\Framework\DB\Select::TYPE_CONDITION
        );

        return $this;
    }

    /**
     * Excludes price rules with generated specific coupon codes from collection
     *
     * @return $this
     */
    public function addAllowedSalesRulesFilter()
    {
        $this->addFieldToFilter('main_table.use_auto_generation', ['neq' => 1]);

        return $this;
    }

    /**
     * Limit rules collection by specific customer group
     *
     * @param  int $customerGroupId
     * @return $this
     */
    public function addCustomerGroupFilter($customerGroupId)
    {
        $entityInfo = $this->_getAssociatedEntityInfo('customer_group');
        if (!$this->getFlag('is_customer_group_joined')) {
            $this->setFlag('is_customer_group_joined', true);
            $this->getSelect()->join(
                ['customer_group' => $this->getTable($entityInfo['associations_table'])],
                $this->getConnection()
                    ->quoteInto('customer_group.' . $entityInfo['entity_id_field'] . ' = ?', $customerGroupId)
                . ' AND main_table.' . $entityInfo['rule_id_field'] . ' = customer_group.'
                . $entityInfo['rule_id_field'],
                []
            );
        }
        return $this;
    }

    /**
     * @return array
     * @deprecated
     */
    private function getAssociatedEntitiesMap()
    {
        if (!$this->_associatedEntitiesMap) {
            $this->_associatedEntitiesMap = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('BrainActs\RewardPoints\Model\ResourceModel\Rule\AssociatedEntityMap')
                ->getData();
        }
        return $this->_associatedEntitiesMap;
    }

    /**
     * @return DateApplier
     * @deprecated
     */
    private function getDateApplier()
    {
        if (null === $this->dateApplier) {
            $this->dateApplier = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\SalesRule\Model\ResourceModel\Rule\DateApplier::class);
        }

        return $this->dateApplier;
    }
}

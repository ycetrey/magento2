<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Model\ResourceModel\Rule;

use BrainActs\RewardPoints\Model\Rule\Earning as EarningRule;
use BrainActs\RewardPoints\Api\Data\RuleEarningInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DB\Select;
use Magento\Rule\Model\ResourceModel\AbstractResource;
use Magento\Framework\EntityManager\EntityManager;

/**
 * Class Earning
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Earning extends AbstractResource
{
    /**
     * Store associated with rule entities information map
     *
     * @var array
     */
    protected $_associatedEntitiesMap = [];

    /**
     * @var array
     */
    public $customerGroupIds = [];

    /**
     * @var array
     */
    public $websiteIds = [];

    /**
     * Magento string lib
     *
     * @var \Magento\Framework\Stdlib\StringUtils
     */
    public $string;

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\StringUtils             $string
     * @param string                                            $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\StringUtils $string,
        $connectionName = null
    ) {
        $this->string = $string;
        $this->_associatedEntitiesMap = $this->getAssociatedEntitiesMap();
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize main table and table id field
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('brainacts_points_rule_earning', 'earning_rule_id');
    }

    /**
     * @param AbstractModel $object
     * @return void
     * @deprecated
     */
    public function loadCustomerGroupIds(AbstractModel $object)
    {
        if (!$this->customerGroupIds) {
            $this->customerGroupIds = (array)$this->getCustomerGroupIds($object->getId());
        }
        $object->setData('customer_group_ids', $this->customerGroupIds);
    }

    /**
     * @param AbstractModel $object
     * @return void
     * @deprecated
     */
    public function loadWebsiteIds(AbstractModel $object)
    {
        if (!$this->websiteIds) {
            $this->websiteIds = (array)$this->getWebsiteIds($object->getId());
        }

        $object->setData('website_ids', $this->websiteIds);
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    public function _beforeSave(AbstractModel $object)
    {
        parent::_beforeSave($object);
        return $this;
    }

    /**
     * Load an object
     *
     * @param                                         EarningRule|AbstractModel $object
     * @param                                         mixed                     $value
     * @param                                         string                    $field  field to load by (defaults to model id)
     * @return                                        $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $this->getEntityManager()->load($object, $value);
        return $this;
    }

    /**
     * Bind sales rule to customer group(s) and website(s).
     * Save rule's associated store labels.
     * Save product attributes used in rule.
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        // Save product attributes used in rule
        $ruleProductAttributes = array_merge(
            $this->getProductAttributes(serialize($object->getConditions()->asArray()))
        );

        if (!empty($ruleProductAttributes)) {
            $this->setActualProductAttributes($object, $ruleProductAttributes);
        }

        return parent::_afterSave($object);
    }

    /**
     * Return codes of all product attributes currently used in promo rules
     *
     * @return array
     */
    public function getActiveAttributes()
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            ['a' => $this->getTable('salesrule_product_attribute')],
            new \Zend_Db_Expr('DISTINCT ea.attribute_code')
        )->joinInner(
            ['ea' => $this->getTable('eav_attribute')],
            'ea.attribute_id = a.attribute_id',
            []
        );
        return $connection->fetchAll($select);
    }

    /**
     * Save product attributes currently used in conditions and actions of rule
     *
     * @param  \BrainActs\RewardPoints\Model\Rule\Earning $rule
     * @param  mixed                                      $attributes
     * @return $this
     */
    public function setActualProductAttributes($rule, $attributes)
    {
        $connection = $this->getConnection();
        $connection->delete($this->getTable('salesrule_product_attribute'), ['rule_id=?' => $rule->getId()]);

        //Getting attribute IDs for attribute codes
        $attributeIds = [];
        $select = $this->getConnection()->select()->from(
            ['a' => $this->getTable('eav_attribute')],
            ['a.attribute_id']
        )->where(
            'a.attribute_code IN (?)',
            [$attributes]
        );
        $attributesFound = $this->getConnection()->fetchAll($select);
        if ($attributesFound) {
            foreach ($attributesFound as $attribute) {
                $attributeIds[] = $attribute['attribute_id'];
            }

            $data = [];
            foreach ($rule->getCustomerGroupIds() as $customerGroupId) {
                foreach ($rule->getWebsiteIds() as $websiteId) {
                    foreach ($attributeIds as $attribute) {
                        $data[] = [
                            'rule_id' => $rule->getId(),
                            'website_id' => $websiteId,
                            'customer_group_id' => $customerGroupId,
                            'attribute_id' => $attribute,
                        ];
                    }
                }
            }
            $connection->insertMultiple($this->getTable('salesrule_product_attribute'), $data);
        }

        return $this;
    }

    /**
     * Collect all product attributes used in serialized rule's action or condition
     *
     * @param  string $serializedString
     * @return array
     */
    public function getProductAttributes($serializedString)
    {
        $result = [];
        if (preg_match_all(
            '~s:32:"salesrule/rule_condition_product";s:9:"attribute";s:\d+:"(.*?)"~s',
            $serializedString,
            $matches
        )
        ) {
            foreach ($matches[1] as $attributeCode) {
                $result[] = $attributeCode;
            }
        }

        return $result;
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function save(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->getEntityManager()->save($object);
        return $this;
    }

    /**
     * Delete the object
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function delete(AbstractModel $object)
    {
        $this->getEntityManager()->delete($object);
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
     * @return \Magento\Framework\EntityManager\EntityManager
     * @deprecated
     */
    private function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\EntityManager\EntityManager::class);
        }
        return $this->entityManager;
    }
}

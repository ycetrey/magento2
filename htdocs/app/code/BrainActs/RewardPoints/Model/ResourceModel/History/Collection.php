<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\ResourceModel\History;

use Magento\Framework\DB\Select;
use Magento\Store\Model\Store;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'history_id';

    /**
     * Load data for preview flag
     *
     * @var bool
     */
    public $_previewFlag;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\EntityManager\MetadataPool
     */
    private $metadataPool;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $helper;

    /**
     * Collection constructor.
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     * @param \BrainActs\RewardPoints\Helper\Data $helper
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\EntityManager\MetadataPool $metadataPool,
        \BrainActs\RewardPoints\Helper\Data $helper,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
    
        $this->storeManager = $storeManager;
        $this->metadataPool = $metadataPool;
        $this->helper = $helper;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('BrainActs\RewardPoints\Model\History', 'BrainActs\RewardPoints\Model\ResourceModel\History');
        $this->_map['fields']['history_id'] = 'main_table.history_id';
    }

    /**
     * Set first store flag
     *
     * @param  bool $flag
     * @return $this
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    /**
     * Add filter by store
     *
     * @param  int|array|\Magento\Store\Model\Store $store
     * @param  bool                                 $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }

    public function _beforeLoad()
    {
        parent::_beforeLoad();

        //if (!$this->helper->isAllowFullAccess()) {
        $this->addFieldToFilter('is_deleted', ['neq' => 1]);
        $this->addFieldToFilter('is_expired', ['neq' => 1]);
        //}
        return $this;
    }

    /**
     * Filter by expired days
     * @param $days
     */
    public function addExpiredFilter($days){

        $this->addFieldToFilter('points',['gt'=>0]);

        $queryExpr = new \Zend_Db_Expr("DATEDIFF(NOW(), main_table.created_at)>='{$days}'");


        $this->getSelect()->where($queryExpr);
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->_previewFlag = false;
        return parent::_afterLoad();
    }

    /**
     * Add field filter to collection
     *
     * @param  array|string          $field
     * @param  string|int|array|null $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($field === 'store_id') {
            return $this->addStoreFilter($condition, false);
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Perform adding filter by store
     *
     * @param  int|array|Store $store
     * @param  bool            $withAdmin
     * @return void
     */
    protected function performAddStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        $this->addFilter('store', ['in' => $store], 'public');
    }

    /**
     * Get SQL for get record count
     *
     * Extra GROUP BY strip added.
     *
     * @return Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Select::GROUP);
        return $countSelect;
    }

    /**
     * Add dynamic field to
     * @param $days
     */
    public function addExpiredField($days){

        $queryExpr = new \Zend_Db_Expr("*, $days - DATEDIFF(NOW(), main_table.created_at)");

        $this->addFieldToSelect($queryExpr, 'expired_in');



     //   $this->getSelect()->where($queryExpr);
    }
}

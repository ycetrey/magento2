<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\ResourceModel;

use BrainActs\RewardPoints\Model\History as HistoryModel;
use BrainActs\RewardPoints\Api\Data\HistoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DB\Select;

/**
 * Class History
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class History extends AbstractDb
{
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var MetadataPool
     */
    private $metadataPool;


    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        $connectionName = null
    ) {
    
        parent::__construct($context, $connectionName);
        $this->storeManager = $storeManager;
        $this->entityManager = $entityManager;
        $this->metadataPool = $metadataPool;
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('brainacts_points_history', 'history_id');
    }

    /**
     * @param AbstractModel $object
     * @param string        $value
     * @param string|null   $field
     * @return bool|int|string
     * @throws LocalizedException
     * @throws \Exception
     */
    private function getHistoryId(AbstractModel $object, $value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(HistoryInterface::class);

        if (!$field) {
            $field = $entityMetadata->getIdentifierField();
        }

        $historyId = $value;

        $select = $this->_getLoadSelect($field, $value, $object);
        $select->reset(Select::COLUMNS)
            ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
            ->limit(1);
        $result = $this->getConnection()->fetchCol($select);
        $historyId = count($result) ? $result[0] : false;

        return $historyId;
    }

    /**
     * Load an object
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @param  mixed                                  $value
     * @param  string                                 $field  field to load by (defaults to model id)
     * @return $this
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $historyId = $this->getHistoryId($object, $value, $field);

        if ($historyId) {
            $this->entityManager->load($object, $historyId);
        }
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
        $this->entityManager->delete($object);
        return $this;
    }

    /**
     * Save object object data
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);
        return $this;
    }

    /**
     * Retrieve select object for load object data
     *
     * @param  string                     $field
     * @param  mixed                      $value
     * @param  HistoryModel|AbstractModel $object
     * @return Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $entityMetadata = $this->metadataPool->getMetadata(HistoryInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = [
                Store::DEFAULT_STORE_ID,
                (int)$object->getStoreId(),
            ];
            $select->where('store_id IN (?)', $storeIds)->limit(1);
        }

        return $select;
    }
}

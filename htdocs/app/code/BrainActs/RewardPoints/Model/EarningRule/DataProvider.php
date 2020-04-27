<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Model\EarningRule;

use BrainActs\RewardPoints\Model\RegistryConstants;
use BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning\Collection;
use BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning\CollectionFactory;
use BrainActs\RewardPoints\Model\Rule\Earning;

/**
 * Class DataProvider
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var Metadata\ValueProvider
     */
    private $metadataValueProvider;

    /**
     * DataProvider constructor.
     *
     * @param string                      $name
     * @param string                      $primaryFieldName
     * @param string                      $requestFieldName
     * @param CollectionFactory           $collectionFactory
     * @param \Magento\Framework\Registry $registry
     * @param Metadata\ValueProvider      $metadataValueProvider
     * @param array                       $meta
     * @param array                       $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        \BrainActs\RewardPoints\Model\EarningRule\Metadata\ValueProvider $metadataValueProvider,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->coreRegistry = $registry;
        $this->metadataValueProvider = $metadataValueProvider;
        $meta = array_replace_recursive($this->getMetadataValues(), $meta);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get metadata values
     *
     * @return array
     */
    private function getMetadataValues()
    {
        $rule = $this->coreRegistry
            ->registry(RegistryConstants::CURRENT_REWARD_POINTS_RULE);

        return $this->metadataValueProvider->getMetadataValues($rule);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /**
 * @var Earning $rule
*/
        foreach ($items as $rule) {
            $rule->load($rule->getId());
            $this->loadedData[$rule->getId()] = $rule->getData();
        }
        return $this->loadedData;
    }
}

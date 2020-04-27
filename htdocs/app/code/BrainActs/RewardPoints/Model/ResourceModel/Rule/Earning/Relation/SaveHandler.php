<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning\Relation;

use BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\AttributeInterface;

/**
 * Class SaveHandler
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class SaveHandler implements AttributeInterface
{
    /**
     * @var Earning
     */
    private $ruleResource;

    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @param Earning $ruleResource
     * @param MetadataPool $metadataPool
     */
    public function __construct(Earning $ruleResource, MetadataPool $metadataPool)
    {
        $this->ruleResource = $ruleResource;
        $this->metadataPool = $metadataPool;
    }

    /**
     * @param string $entityType
     * @param array $entityData
     * @param array $arguments
     * @return array
     * @throws \Exception
     */
    public function execute($entityType, $entityData, $arguments = [])
    {
        $linkField = $this->metadataPool->getMetadata($entityType)->getLinkField();

        if (isset($entityData['website_ids'])) {
            $websiteIds = $entityData['website_ids'];
            if (!is_array($websiteIds)) {
                $websiteIds = explode(',', (string)$websiteIds);
            }
            $this->ruleResource
                ->bindRuleToEntity($entityData[$linkField], $websiteIds, 'website');
        }

        if (isset($entityData['customer_group_ids'])) {
            $customerGroupIds = $entityData['customer_group_ids'];
            if (!is_array($customerGroupIds)) {
                $customerGroupIds = explode(',', (string)$customerGroupIds);
            }
            $this->ruleResource
                ->bindRuleToEntity($entityData[$linkField], $customerGroupIds, 'customer_group');
        }
        return $entityData;
    }
}

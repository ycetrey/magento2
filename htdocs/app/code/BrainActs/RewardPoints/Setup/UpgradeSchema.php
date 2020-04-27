<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Cms module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.2') < 0) {
            $this->addTypeFields($setup);
        }
    }

    /**
     * Add meta title
     *
     * @param SchemaSetupInterface $setup
     * @return $this
     */
    protected function addTypeFields(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable('brainacts_points_rule_earning'),
            'type',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length' => 6,
                'nullable' => true,
                'comment' => 'Type of Points rule'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('brainacts_points_rule_earning'),
            'spend',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'length' => '10,2',
                'nullable' => true,
                'comment' => 'X Spend'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('brainacts_points_rule_earning'),
            'earn',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length' => 10,
                'nullable' => true,
                'comment' => 'Y Earn'
            ]
        );
        return $this;
    }
}

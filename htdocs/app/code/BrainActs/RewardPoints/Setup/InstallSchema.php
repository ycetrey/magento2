<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @author BrainActs Core Team <support@brainacts.com>
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * InstallSchema constructor.
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     */
    public function __construct(
        \Magento\Framework\App\ProductMetadataInterface $productMetadata
    ) {
        $this->productMetadata = $productMetadata;
    }

    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * Installs DB schema for a module
     *
     * @param  SchemaSetupInterface $setup
     * @param  ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $this->createBrainActsPointsRuleSpend($installer);
        $this->createBrainActsPointsRuleEarning($installer);
        $this->createBrainActsPointsRuleEarningWebsite($installer);
        $this->createBrainActsPointsRuleEarningCustomerGroup($installer);
        $this->createBrainActsPointsHistory($installer);

        $this->updateQuoteTable($installer);

        $installer->endSetup();
    }

    /**
     * Create table 'brainacts_points_rule_spend'
     *
     * @param $installer
     */
    private function createBrainActsPointsRuleSpend(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('brainacts_points_rule_spend')
        )->addColumn(
            'spend_rule_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'identity' => true, 'primary' => true, 'nullable' => false]
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'COMMENT' => 'Rule']
        )->addColumn(
            'group_id',
            Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'COMMENT' => 'Customer']
        )->addColumn(
            'store_id',
            Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'COMMENT' => 'Store']
        )->addColumn(
            'points',
            Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'COMMENT' => 'Points']
        )->addColumn(
            'amount',
            Table::TYPE_DECIMAL,
            [12, 4],
            ['nullable' => false, 'COMMENT' => 'Currency']
        )->addColumn(
            'is_active',
            Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'COMMENT' => 'Rule']
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                'COMMENT' => 'Created'
            ]
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE,
                'COMMENT' => 'Updated'
            ]
        );
        $installer->getConnection()->createTable($table);
    }

    /**
     * Create table 'brainacts_points_rule_earning'
     * @param SchemaSetupInterface $installer
     * @throws \Zend_Db_Exception
     */
    private function createBrainActsPointsRuleEarning(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('brainacts_points_rule_earning')
        )->addColumn(
            'earning_rule_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'identity' => true, 'primary' => true, 'nullable' => false]
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'COMMENT' => 'Rule']
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            '64k',
            ['default' => '', 'COMMENT' => 'Rule']
        )->addColumn(
            'from_date',
            Table::TYPE_DATE,
            null,
            ['default' => null, 'COMMENT' => 'Start']
        )->addColumn(
            'to_date',
            Table::TYPE_DATE,
            null,
            ['default' => null, 'COMMENT' => 'End']
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            6,
            ['nullable' => false, 'COMMENT' => 'Is']
        )->addColumn(
            'conditions_serialized',
            Table::TYPE_TEXT,
            '2M',
            ['default' => '', 'COMMENT' => 'Condition']
        )->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            10,
            ['default' => null, 'COMMENT' => 'Position']
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT, 'COMMENT' => 'Created']
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE, 'COMMENT' => 'Updated']
        )->addColumn(
            'points',
            Table::TYPE_INTEGER,
            11,
            ['default' => null, 'COMMENT' => 'Points']
        )->addColumn(
            'stop_rules_processing',
            Table::TYPE_SMALLINT,
            1,
            ['default' => '0', 'COMMENT' => 'Stop']
        );
        $installer->getConnection()->createTable($table);
    }

    /**
     * Create table 'brainacts_points_rule_earning_website'
     *
     * @param SchemaSetupInterface $installer
     * @throws \Zend_Db_Exception
     */
    private function createBrainActsPointsRuleEarningWebsite(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('brainacts_points_rule_earning_website')
        )->addColumn(
            'earning_rule_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Rule Id'
        )->addColumn(
            'website_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Website Id'
        )->addIndex(
            $installer->getIdxName('brainacts_points_rule_earning_website', ['website_id']),
            ['website_id']
        )->addForeignKey(
            $installer->getFkName(
                'brainacts_points_rule_earning_website',
                'earning_rule_id',
                'brainacts_points_rule_earning',
                'earning_rule_id'
            ),
            'earning_rule_id',
            $installer->getTable('brainacts_points_rule_earning'),
            'earning_rule_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'brainacts_points_rule_earning_website',
                'website_id',
                'store_website',
                'website_id'
            ),
            'website_id',
            $installer->getTable('store_website'),
            'website_id',
            Table::ACTION_CASCADE
        );
        $installer->getConnection()->createTable($table);
    }

    /**
     * Create table 'brainacts_points_rule_earning_customer_group'
     *
     * @param SchemaSetupInterface $installer
     * @throws \Zend_Db_Exception
     */
    private function createBrainActsPointsRuleEarningCustomerGroup(SchemaSetupInterface $installer)
    {
        $version = $this->getMagentoVersion();
        if (version_compare($version, '2.2.0') == -1){
            $type =     \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT;
        }else{
            $type =     \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER;
        }

        $rulesCustomerGroupsTable = $installer->getTable('brainacts_points_rule_earning_customer_group');
        $customerGroupsTable = $installer->getTable('customer_group');

        /**
         * Create table 'brainacts_points_rule_earning_customer_group' if not exists. This table will be used instead of
         * column customer_group_ids of main catalog rules table
         */
        $table = $installer->getConnection()->newTable(
            $rulesCustomerGroupsTable
        )->addColumn(
            'earning_rule_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Rule Id'
        )->addColumn(
            'customer_group_id',
            $type,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Customer Group Id'
        )->addIndex(
            $installer->getIdxName('brainacts_points_rule_earning_customer_group', ['customer_group_id']),
            ['customer_group_id']
        )->addForeignKey(
            $installer->getFkName(
                'brainacts_points_rule_earning_customer_group',
                'earning_rule_id',
                'brainacts_points_rule_earning',
                'earning_rule_id'
            ),
            'earning_rule_id',
            $installer->getTable('brainacts_points_rule_earning'),
            'earning_rule_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'brainacts_points_rule_earning_customer_group',
                'customer_group_id',
                'customer_group',
                'customer_group_id'
            ),
            'customer_group_id',
            $customerGroupsTable,
            'customer_group_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Rules To Customer Groups Relations'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * Create table 'brainacts_points_history'
     *
     * @param SchemaSetupInterface $installer
     * @throws \Zend_Db_Exception
     */
    private function createBrainActsPointsHistory(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('brainacts_points_history')
        )->addColumn(
            'history_id',
            Table::TYPE_INTEGER,
            11,
            ['unsigned' => true, 'identity' => true, 'primary' => true, 'nullable' => false]
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'COMMENT' => 'Customer']
        )->addColumn(
            'customer_name',
            Table::TYPE_TEXT,
            145,
            ['nullable' => false, 'COMMENT' => 'Customer']
        )->addColumn(
            'points',
            Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'COMMENT' => 'Points']
        )->addColumn(
            'rule_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'COMMENT' => 'Rule']
        )->addColumn(
            'rule_earn_id',
            Table::TYPE_INTEGER,
            11,
            ['unsigned' => true, 'COMMENT' => 'Rule']
        )->addColumn(
            'rule_spend_id',
            Table::TYPE_INTEGER,
            11,
            ['unsigned' => true, 'COMMENT' => 'Rule']
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'COMMENT' => 'Real']
        )->addColumn(
            'order_increment_id',
            Table::TYPE_TEXT,
            50,
            ['default' => null, 'COMMENT' => 'Increment']
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT,
                'COMMENT' => 'Created'
            ]
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT_UPDATE,
                'COMMENT' => 'Updated'
            ]
        )->addColumn(
            'modifier_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'COMMENT' => 'User']
        )->addColumn(
            'modifier_name',
            Table::TYPE_TEXT,
            255,
            ['default' => null, 'COMMENT' => '']
        )->addColumn(
            'reason',
            Table::TYPE_TEXT,
            '64k',
            ['default' => '', 'COMMENT' => 'Reason']
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            5,
            ['unsigned' => true, 'COMMENT' => 'Store']
        )->addColumn(
            'type_rule',
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false, 'COMMENT' => 'Type']
        )->addColumn(
            'is_deleted',
            Table::TYPE_SMALLINT,
            1,
            ['default' => '0', 'COMMENT' => '']
        )->addColumn(
            'is_expired',
            Table::TYPE_SMALLINT,
            1,
            ['default' => '0', 'COMMENT' => '']
        )->addIndex(
            $installer->getIdxName('brainacts_points_history', 'customer_id'),
            ['customer_id']
        )->addIndex(
            $installer->getIdxName('brainacts_points_history', 'store_id'),
            ['store_id']
        )->addIndex(
            $installer->getIdxName('brainacts_points_history', 'modifier_id'),
            ['modifier_id']
        )->addForeignKey(
            $installer->getFkName('brainacts_points_history', 'modifier_id', 'admin_user', 'user_id'),
            'modifier_id',
            $installer->getTable('admin_user'),
            'user_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('brainacts_points_history', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('brainacts_points_history', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        );
        $installer->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $installer
     */
    private function updateQuoteTable(SchemaSetupInterface $installer)
    {

        $connection = $installer->getConnection();

        $column = [
            'type' => Table::TYPE_DECIMAL,
            'length' => '12,4',
            'nullable' => false,
            'comment' => 'Amount',
            'default' => '0'
        ];
        $connection->addColumn($installer->getTable('quote'), 'reward_points_amount', $column);

        $column = [
            'type' => Table::TYPE_DECIMAL,
            'length' => '12,4',
            'nullable' => true,
            'comment' => 'Points',
        ];
        $connection->addColumn($installer->getTable('quote'), 'reward_points', $column);

        $column = [
            'type' => Table::TYPE_INTEGER,
            'length' => 10,
            'nullable' => true,
            'comment' => 'Points Rule ID'
        ];
        $connection->addColumn($installer->getTable('quote'), 'reward_points_rule', $column);

        $column = [
            'type' => Table::TYPE_DECIMAL,
            'length' => '12,4',
            'nullable' => true,
            'comment' => 'Points AMOUNT'
        ];
        $connection->addColumn($installer->getTable('sales_order'), 'reward_points_amount', $column);
    }
}

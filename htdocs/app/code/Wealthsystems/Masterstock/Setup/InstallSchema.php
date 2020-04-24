<?php

namespace Wealthsystems\Masterstock\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $tablename = $setup->getTable('productstock');
        if (!$installer->tableExists($tablename)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tablename)
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Price Table ID'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Product Id'
                )
                ->addColumn(
                    'qty',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Qty'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'warehouse_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Warehouse Id'
                )
                ->addColumn(
                    'arrival_forecast',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Arrival Forecast'
                )
                ->addColumn(
                    'erp_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'ERP Code'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('productstockmovement');
        if (!$installer->tableExists($tablename)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tablename)
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Price Table ID'
                )
                ->addColumn(
                    'order_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Order Id'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Order Id'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Product Id'
                )
                ->addColumn(
                    'qty',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Qty'
                )
                ->addColumn(
                    'is_processed',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'erp_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'ERP Code'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }
       
        $installer->endSetup();
    }
}

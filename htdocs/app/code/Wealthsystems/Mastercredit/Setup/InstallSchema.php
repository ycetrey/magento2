<?php

namespace Wealthsystems\Mastercredit\Setup;

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

        $tablename = $setup->getTable('creditlimit');
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
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Custormer ID'
                )
                ->addColumn(
                    'limit',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,4',
                    ['nullable => true'],
                    'Limit'
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

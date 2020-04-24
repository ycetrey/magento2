<?php

namespace Wealthsystems\Masterprice\Setup;

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

        $tablename = $setup->getTable('pricetable');
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
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Description'
                )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Code'
                )
                ->addColumn(
                    'validity_init',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Validity Init'
                )
                ->addColumn(
                    'validity_end',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Validity End'
                )
                ->addColumn(
                    'erp_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'ERP Code'
                )
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    5,
                    [],
                    'Is Active'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('pricetablelink');
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
                    'Price Table Link ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'price_table_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Price Table Id'
                )
                ->addColumn(
                    'condpay_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Condpay Id'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Id'
                )
                ->addColumn(
                    'customer_group_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Group Id'
                )
                ->addColumn(
                    'region_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Region Id'
                )
                ->addColumn(
                    'erp_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'ERP Code'
                )
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    5,
                    [],
                    'Is Active'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('pricetableproduct');
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
                    'Price Table Link ID'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'price_table_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Price Table Id'
                )
                ->addColumn(
                    'price',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,4',
                    ['nullable => true'],
                    'Price'
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


        $tablename = $setup->getTable('pricetablerule');
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
                    'Price Table Link ID'
                )
                ->addColumn(
                    'query',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Query'
                )
                ->addColumn(
                    'variable',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Variable'
                )                         
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('discount');
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
                    'Price Table Link ID'
                )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable => true'],
                    'Code'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Product Id'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'percentage',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,4',
                    ['nullable => true'],
                    'Percentage'
                )
                ->addColumn(
                    'region_from',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable => true'],
                    'Region From'
                )
                ->addColumn(
                    'region_to',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable => true'],
                    'Region To'
                )
                ->addColumn(
                    'billing_method_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Billing Method Id'
                )
                ->addColumn(
                    'price_table_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Price Table Id'
                )
                ->addColumn(
                    'manufacturer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Manufacturer Id'
                )
                ->addColumn(
                    'condpay_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Condpay Id'
                )
                ->addColumn(
                    'category_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Category Id'
                )
                ->addColumn(
                    'brand_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Brand Id'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Id'
                )
                ->addColumn(
                    'salesman_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Id'
                )
                ->addColumn(
                    'customer_group_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Group Id'
                )
                ->addColumn(
                    'cust_attribute_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Customer Attribute Code'
                )    
                ->addColumn(
                    'cust_attribute_value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Customer Attribute Value'
                )   
                ->addColumn(
                    'prod_attribute_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Product Attribute Code'
                )    
                ->addColumn(
                    'prod_attribute_value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Product Attribute Value'
                )   
                ->addColumn(
                    'date_from',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Date From'
                )
                ->addColumn(
                    'date_to',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Date To'
                )
                ->addColumn(
                    'erp_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'ERP Code'
                )
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    5,
                    [],
                    'Is Active'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('discountrule');
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
                    'Price Table Link ID'
                )
                ->addColumn(
                    'query',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Query'
                )
                ->addColumn(
                    'variable',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Variable'
                )  
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }


        $tablename = $setup->getTable('tax');
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
                    'ID'
                )
                ->addColumn(
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    75,
                    [],
                    'Description'
                )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    75,
                    [],
                    'Code'
                )
                ->addColumn(
                    'rules',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    75,
                    [],
                    'Rules'
                )
                ->addColumn(
                    'calculation',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Calculation'
                )                              
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'Is Active'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('taxlink');
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
                    'ID'
                )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable => true'],
                    'Code'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Product Id'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Store Id'
                )
                ->addColumn(
                    'percentage',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,4',
                    ['nullable => true'],
                    'Percentage'
                )
                ->addColumn(
                    'region_from',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable => true'],
                    'Region From'
                )
                ->addColumn(
                    'region_to',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable => true'],
                    'Region To'
                )
                ->addColumn(
                    'billing_method_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Billing Method Id'
                )
                ->addColumn(
                    'price_table_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Price Table Id'
                )
                ->addColumn(
                    'manufacturer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Manufacturer Id'
                )
                ->addColumn(
                    'condpay_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Condpay Id'
                )
                ->addColumn(
                    'category_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Category Id'
                )
                ->addColumn(
                    'brand_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Brand Id'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Id'
                )
                ->addColumn(
                    'salesman_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Id'
                )
                ->addColumn(
                    'customer_group_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => true'],
                    'Customer Group Id'
                )
                ->addColumn(
                    'cust_attribute_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Customer Attribute Code'
                )    
                ->addColumn(
                    'cust_attribute_value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Customer Attribute Value'
                )   
                ->addColumn(
                    'prod_attribute_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Product Attribute Code'
                )    
                ->addColumn(
                    'prod_attribute_value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable => true'],
                    'Product Attribute Value'
                )   
                ->addColumn(
                    'date_from',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Date From'
                )
                ->addColumn(
                    'date_to',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Date To'
                )
                ->addColumn(
                    'erp_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    [],
                    'ERP Code'
                )
                ->addColumn(
                    'is_active',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    5,
                    [],
                    'Is Active'
                )
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $tablename = $setup->getTable('taxrule');
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
                    'Price Table Link ID'
                )
                ->addColumn(
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    75,
                    [],
                    'Description'
                )
                ->addColumn(
                    'query',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Query'
                )
                ->addColumn(
                    'variable',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Variable'
                )  
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}

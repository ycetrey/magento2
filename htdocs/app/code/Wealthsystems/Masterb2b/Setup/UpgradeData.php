<?php

namespace Wealthsystems\Masterb2b\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * Customer setup factory
     *
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var IndexerRegistry
     */
	protected $indexerRegistry;
	
	/**
     * @var AttributeSetFactory
     */
    protected $attributeSetFactory;

    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param IndexerRegistry $indexerRegistry
     * @param \Magento\Eav\Model\Config $eavConfig
     */
    public function __construct(
        \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory,
        IndexerRegistry $indexerRegistry,
		\Magento\Eav\Model\Config $eavConfig,
		AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->indexerRegistry = $indexerRegistry;
		$this->eavConfig = $eavConfig;
		$this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $this->upgradeVersion101($customerSetup);
        } 
        
        if (version_compare($context->getVersion(), "1.0.2", "<")) {
            $this->upgradeVersion102($customerSetup);
        } 

        $indexer = $this->indexerRegistry->get(Customer::CUSTOMER_GRID_INDEXER_ID);
        $indexer->reindexAll();
        $this->eavConfig->clear();

        $setup->endSetup();
    }

    /**
     * @param CustomerSetup $customerSetup
     * @return void
     */
    private function upgradeVersion101($customerSetup)
    {
		$customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $attribute = $customerSetup->getEavConfig()->getAttribute(
            Customer::ENTITY,
            'salesman_id'
        );

        $attribute->addData(
            [
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId
            ]
        );

        $attribute->save();
    }

    /**
     * @param CustomerSetup $customerSetup
     * @return void
     */
    private function upgradeVersion102($customerSetup)
    {
        //remove

        $customerSetup->removeAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'salesman_id'
        );

        $customerSetup->removeAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'erp_code'
        );

        //install

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'salesman_id', [
            'type' => 'varchar',
            'label' => 'Salesman ID',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 400,
            'system' => false,
            'backend' => ''
        ]);
        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'salesman_id')
        ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout'
            ]
        ]);
        
        $attribute->save();        

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'erp_code', [
            'type' => 'varchar',
            'label' => 'ERP Code',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 410,
            'system' => false,
            'backend' => ''
        ]);
        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'erp_code')
        ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout'
            ]
        ]);
        
        $attribute->save();

    }

}
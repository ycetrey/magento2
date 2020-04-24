<?php

namespace Wealthsystems\Masterdirectdata\Setup;

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
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_check');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_approved');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_attempts');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_return');

        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_check');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_approved');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_attempts');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_return');

        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_check');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_approved');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_attempts');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_return');

        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'directdata_problem');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'directdata_check');
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'directdata_approves');

        //SINTEGRA - Attributes

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_check', [
            'type' => 'int',
            'label' => 'SINTEGRA: Checked',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1001,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_check')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_approved', [
            'type' => 'int',
            'label' => 'SINTEGRA: Approved',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1002,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_approved')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_attempts', [
            'type' => 'varchar',
            'label' => 'SINTEGRA: Attempts',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 1003,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_attempts')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sintegra_return', [
            'type' => 'varchar',
            'label' => 'SINTEGRA: Return',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 1004,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_return')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        //REVENUE - Attributes        
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_check', [
            'type' => 'int',
            'label' => 'REVENUE: Checked',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1005,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'revenue_check')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_approved', [
            'type' => 'int',
            'label' => 'REVENUE: Approved',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1006,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'revenue_approved')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_attempts', [
            'type' => 'varchar',
            'label' => 'REVENUE: Attempts',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 1007,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'revenue_attempts')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'revenue_return', [
            'type' => 'varchar',
            'label' => 'REVENUE: Return',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 1008,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'revenue_return')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();


        //SEFAZ - Attributes        
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_check', [
            'type' => 'int',
            'label' => 'SEFAZ: Checked',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1009,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_check')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_approved', [
            'type' => 'int',
            'label' => 'SEFAZ: Approved',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1010,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_approved')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_attempts', [
            'type' => 'varchar',
            'label' => 'SEFAZ: Attempts',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 1011,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_attempts')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sefaz_return', [
            'type' => 'varchar',
            'label' => 'SEFAZ: Return',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 1012,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_return')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        //DIRECTDATA - Attributes        
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'directdata_problem', [
            'type' => 'int',
            'label' => 'DirectData: Problem',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1013,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'directdata_problem')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'directdata_checked', [
            'type' => 'int',
            'label' => 'DirectData: Checked',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1014,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'directdata_checked')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'directdata_approves', [
            'type' => 'int',
            'label' => 'DirectData: Approves',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'visible' => true,
            'position' => 1015,
            'system' => false,
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'directdata_approves')
            ->addData(['used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout']]);
        $attribute->save();
    }
}

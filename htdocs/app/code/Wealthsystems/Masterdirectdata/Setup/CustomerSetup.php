<?php

namespace Wealthsystems\Masterdirectdata\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Setup\Context;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory;

class CustomerSetup extends EavSetup
{

	protected $eavConfig;

	public function __construct(
		ModuleDataSetupInterface $setup,
		Context $context,
		CacheInterface $cache,
		CollectionFactory $attrGroupCollectionFactory,
		Config $eavConfig
	) {
		$this->eavConfig = $eavConfig;
		parent::__construct($setup, $context, $cache, $attrGroupCollectionFactory);
	}

	public function installAttributes($customerSetup)
	{
		$this->installCustomerAttributes($customerSetup);
		$this->installCustomerAddressAttributes($customerSetup);
	}

	public function installCustomerAttributes($customerSetup)
	{


		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sintegra_check',
			[
				'label' => 'SINTEGRA: Checked',
				'system' => 0,
				'position' => 1001,
				'sort_order' => 1001,
				'visible' =>  true,
				'note' => '',
				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_check')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sintegra_approved',
			[
				'label' => 'SINTEGRA: Approved',
				'system' => 0,
				'position' => 1002,
				'sort_order' => 1002,
				'visible' =>  true,
				'note' => '',
				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_approved')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sintegra_attempts',
			[
				'label' => 'SINTEGRA: Attempts',
				'system' => 0,
				'position' => 1003,
				'sort_order' => 1003,
				'visible' =>  true,
				'note' => '',
				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_attempts')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sintegra_return',
			[
				'label' => 'SINTEGRA: Return',
				'system' => 0,
				'position' => 1004,
				'sort_order' => 1004,
				'visible' =>  true,
				'note' => '',


				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sintegra_return')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'revenue_check',
			[
				'label' => 'REVENUE: Checked',
				'system' => 0,
				'position' => 1005,
				'sort_order' => 1005,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'revenue_check')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'revenue_approved',
			[
				'label' => 'REVENUE: Approved',
				'system' => 0,
				'position' => 1006,
				'sort_order' => 1006,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'revenue_approved')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'revenue_attempts',
			[
				'label' => 'REVENUE: Attempts',
				'system' => 0,
				'position' => 1007,
				'sort_order' => 1007,
				'visible' =>  true,
				'note' => '',


				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'revenue_attempts')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'revenue_return',
			[
				'label' => 'REVENUE: Return',
				'system' => 0,
				'position' => 1008,
				'sort_order' => 1008,
				'visible' =>  true,
				'note' => '',


				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'revenue_return')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sefaz_check',
			[
				'label' => 'SEFAZ: Checked',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_check')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sefaz_approved',
			[
				'label' => 'SEFAZ: Approved',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_approved')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sefaz_attempts',
			[
				'label' => 'SEFAZ: Attempts',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_attempts')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'sefaz_return',
			[
				'label' => 'SEFAZ: Return',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'sefaz_return')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'directdata_problem',
			[
				'label' => 'DirectData: Problem',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'directdata_problem')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'directdata_check',
			[
				'label' => 'DirecData: Checked',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'directdata_check')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();



		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'directdata_approves',
			[
				'label' => 'DirectData: Approves',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  true,
				'note' => '',


				'type' => 'int',
				'input' => 'boolean',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'directdata_approves')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();
	}

	public function installCustomerAddressAttributes($customerSetup)
	{ }

	public function getEavConfig()
	{
		return $this->eavConfig;
	}
}

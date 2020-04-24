<?php

namespace Wealthsystems\Masterb2b\Setup;

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
			'salesman_id',
			[
				'label' => 'Salesman ID',
				'system' => 0,
				'position' => 100,
				'sort_order' => 100,
				'visible' =>  false,
				'note' => '',
				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'salesman_id')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();
	
		$customerSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'erp_code',
			[
				'label' => 'ERP Code',
				'system' => 0,
				'position' => 110,
				'sort_order' => 110,
				'visible' =>  false,
				'note' => '',
				'type' => 'varchar',
				'input' => 'text',

			]
		);

		$customerSetup->getEavConfig()->getAttribute('customer', 'erp_code')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'adminhtml_checkout'])->save();
	
	}

	public function installCustomerAddressAttributes($customerSetup)
	{ }

	public function getEavConfig()
	{
		return $this->eavConfig;
	}
}

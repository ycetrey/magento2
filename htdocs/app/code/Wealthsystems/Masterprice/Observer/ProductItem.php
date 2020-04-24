<?php

namespace Wealthsystems\Masterprice\Observer;

use Wealthsystems\Masterprice\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductItem implements ObserverInterface
{
	/** @var Data */
	private $helper;

	public function __construct(
		Data $helper
	) {
		$this->helper = $helper;
	}

	/**
	 * @param Observer $observer
	 */
	public function execute(Observer $observer)
	{
		$_product = $observer->getEvent()->getProduct();

		if ($this->helper->PriceEnable()) {
			$this->helper->PriceItem($_product);
		}
		
		if ($this->helper->DiscountEnable()) {
			$this->helper->DiscountItem($_product);
		}	
		
		if ($this->helper->TaxEnable()) {
			$this->helper->TaxItem($_product);
		}
	}
}

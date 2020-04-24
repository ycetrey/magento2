<?php

namespace Wealthsystems\Masterprice\Observer;

use Wealthsystems\Masterprice\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductCollection implements ObserverInterface
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
		$_collect = $observer->getEvent()->getCollection();

		if ($this->helper->PriceEnable()) {
			$this->helper->PriceCollection($_collect);
		}		

		if ($this->helper->DiscountEnable()) {
			$this->helper->DiscountCollection($_collect);
		}

		if ($this->helper->TaxEnable()) {
			$this->helper->TaxCollection($_collect);
		}
	}
}

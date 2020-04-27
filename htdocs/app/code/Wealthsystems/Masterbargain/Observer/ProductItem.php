<?php

namespace Wealthsystems\Masterbargain\Observer;

use Wealthsystems\Masterbargain\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Productitem implements ObserverInterface
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

		if ($this->helper->BargainEnable()) {
			$this->helper->PriceItem($_product);
		}
	}
}

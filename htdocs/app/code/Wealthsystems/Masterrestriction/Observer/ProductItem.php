<?php

namespace Wealthsystems\Masterrestriction\Observer;

use Wealthsystems\Masterrestriction\Helper\Data;
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

		if ($this->helper->RestrictionEnable()) {
			$this->helper->RestrictionItem($_product);
		}
	}
}

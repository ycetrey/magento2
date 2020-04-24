<?php

namespace Wealthsystems\Buyer\Observer;

use Wealthsystems\Buyer\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Update implements \Magento\Framework\Event\ObserverInterface
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

	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		if ($this->helper->BuyerEnable()) {
			$product = $observer->getProduct();
			$quoteItem = $observer->getQuoteItem();
		}

		return $this;
	}
}

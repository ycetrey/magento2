<?php

namespace Wealthsystems\Masterstock\Observer;

use Wealthsystems\Masterstock\Helper\Data;
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

		foreach($_collect as $_product){
			if ($this->helper->StockEnable()) {
				$this->helper->StockItem($_product);
			}
		}			
	}
}

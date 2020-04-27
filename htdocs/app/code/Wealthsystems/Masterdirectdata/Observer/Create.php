<?php

namespace Wealthsystems\Masterdirectdata\Observer;

use Wealthsystems\Masterdirectdata\Helper\Data;

class Create implements \Magento\Framework\Event\ObserverInterface
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
		$customer = $observer->getEvent()->getCustomer();

		$this->helper->validateCustomer($customer);

		return $this;
	}
}

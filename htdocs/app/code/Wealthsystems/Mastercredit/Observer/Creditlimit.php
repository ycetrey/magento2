<?php

namespace Wealthsystems\Mastercredit\Observer;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Creditlimit implements \Magento\Framework\Event\ObserverInterface
{

	protected $configWriter;
	public function __construct(WriterInterface $configWriter)
	{
		$this->configWriter = $configWriter;
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
	{		

	}
}

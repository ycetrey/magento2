<?php

namespace Wealthsystems\Masterbargain\Controller\Index;

use Wealthsystems\Masterbargain\Model\Bargain;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Priceapproves extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wealthsystems\Masterbargain\Model\BargainFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $_bargain_id = $_POST['id'];
        $status = $_POST['status'];
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        $_bargain = $objectManager->create('\Wealthsystems\Masterbargain\Model\Bargain')->load($_bargain_id);

        $_bargain->setStatus($status);
        $_bargain->save();
    }
}

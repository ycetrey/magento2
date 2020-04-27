<?php

namespace Wealthsystems\Masterdirectdata\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Directdata extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wealthsystems\Masterdirectdata\Helper\Data $helper
    ) {
        parent::__construct($context);
        $this->_helper = $helper;
    }

    public function execute()
    {
        $this->_helper->validateCustomer(null);
    
    }
}

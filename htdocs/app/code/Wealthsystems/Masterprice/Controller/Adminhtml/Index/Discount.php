<?php

namespace Wealthsystems\Masterprice\Controller\Adminhtml\Index;


class Discount extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}

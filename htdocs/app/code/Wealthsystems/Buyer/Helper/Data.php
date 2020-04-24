<?php

namespace Wealthsystems\Buyer\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function isLogged()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        return $customerSession->isLoggedIn();
    }

    public function getCustomer()
    {
        if ($this->isLogged()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->create('Magento\Customer\Model\Session');

            return $customerSession->getCustomer();
        } else {
            return false;
        }
    }

    public function getStoreId()
    {
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

        return $storeManager->getStore()->getStoreId();
    }

    public function BuyerEnable()
    {
        return boolval($this->scopeConfig->getValue('buyer/general/enable_buyer', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }    

    public function IsBuyer()
    {
        return boolval($this->scopeConfig->getValue('buyer/general/customer_group_buyer', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }    
}

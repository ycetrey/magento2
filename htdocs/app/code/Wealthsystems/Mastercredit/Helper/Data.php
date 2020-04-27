<?php

namespace Wealthsystems\Mastercredit\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function CreditEnable()
    {
        return boolval($this->scopeConfig->getValue('wscredit/general/enable_credit', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function CreditVisible()
    {
        return boolval($this->scopeConfig->getValue('wscredit/general/show_credit', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function isLogged()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        return $customerSession->isLoggedIn();
    }

    public function getCustomerId()
    {
        if($this->isLogged()){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->create('Magento\Customer\Model\Session'); 
            
            return $customerSession->getCustomer()->getId();
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
}

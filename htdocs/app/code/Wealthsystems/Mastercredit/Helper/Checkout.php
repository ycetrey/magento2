<?php

namespace Wealthsystems\Mastercredit\Helper;
 
use Magento\Store\Model\ScopeInterface;
use Magento\Checkout\Helper\Data as MainHelper;
 
class Checkout extends MainHelper
{
    public function CreditEnable()
    {
        return boolval($this->scopeConfig->getValue('wscredit/general/enable_credit', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    /**
     * Get onepage checkout availability
     *
     * @return bool
     */
    public function canOnepageCheckout()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        $grandTotal = $cart->getQuote()->getGrandTotal();

        if((($this->checkCredit() > 0) && ($this->checkCredit() > $grandTotal)) || !$this->CreditEnable()){
            return $this->scopeConfig->isSetFlag(
                'checkout/options/onepage_checkout_enabled',
                ScopeInterface::SCOPE_STORE
            ); 
        } else {
            return false;
        }        
    }

    public function checkCredit()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $creditLimit = $objectManager->create('\Wealthsystems\Mastercredit\Model\Creditlimit');

        if($this->isLogged()){
            $customerCredit = $creditLimit->getCollection()
                ->addFieldToFilter('customer_id',$this->getCustomerId())
                ->addFieldToFilter('store_id',$this->getStoreId())
                ->getFirstItem();

            if (count($customerCredit) > 0) {
                return $customerCredit->getLimit();
            } 
        }

        return false;
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

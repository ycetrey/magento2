<?php

namespace Wealthsystems\Masterprice\Helper;

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

    //Price validation and product price update
    public function PriceEnable()
    {
        return boolval($this->scopeConfig->getValue('wsprice/general/enable_price', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function PriceItem($_product)
    {
        $price = $this->getProductPrice($_product);
        if ($price) {
            $_product->setPriceOriginal($price);
            if(!$_product->getIsBargain()){
                $_product->setPrice($price);
            }            
        } else {
            $_product->setPriceOriginal(0);
            $_product->setPrice(0);
            $_product->setVisibility(1);
            $_product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
        }
    }

    public function PriceCollection($_collect)
    {
        foreach ($_collect as $_item) {
            $this->PriceItem($_item);
        }
    }

    public function getProductPrice($_product)
    {
        $price = $this->getPriceByTablePrice($_product, $this->getCustomer());

        return $price;
    }

    public function getPriceByTablePrice($_product, $_customer)
    {
        $priceTableLink = null;
        $currentDate = date('Y-m-d');
        $storeID = $this->getStoreId();

        if ($this->isLogged()) {
            $priceTablesCustomers = $this->priceTableFilter($_customer, $storeID, $_product);
        }

        if ($this->isLogged() && $priceTablesCustomers[0]['price_table_id'] > 0) {
            $priceTableLink = $priceTablesCustomers[0]['price_table_id'];
        } else {
            $priceTableLink = $this->scopeConfig->getValue('wsprice/pricetable/defaulttable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        if (is_null($priceTableLink)) {
            return false;
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricetable = $objectManager->create('\Wealthsystems\Masterprice\Model\Pricetable');

        $priceTable = $pricetable->getCollection()
            ->addFieldToFilter('id', array('eq' => $priceTableLink))
            ->addFieldToFilter('is_active', array('eq' => 1))
            ->addFieldToFilter('validity_init', array('lt' => $currentDate))
            ->addFieldToFilter('validity_end', array('gt' => $currentDate))
            ->getFirstItem();

        if (!$priceTable->getId()) {
            return false;
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $priceproduct = $objectManager->create('\Wealthsystems\Masterprice\Model\Pricetableproduct');

        $priceTableProduct = $priceproduct->getCollection()
            ->addFieldToFilter('price_table_id', $priceTable->getId())
            ->addFieldToFilter('product_id', $_product->getId())
            ->getFirstItem();

        if (!$priceTableProduct->getId()) {
            return false;
        }

        $price = $priceTableProduct->getPrice();

        return $price;
    }

    public function priceTableFilter($_customer, $storeID, $_product)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricerule = $objectManager->create('\Wealthsystems\Masterprice\Model\Pricetablerule');
        $pricelink = $objectManager->create('\Wealthsystems\Masterprice\Model\Pricetablelink');

        if (count($pricelink->getCollection()) > 0) {
            foreach ($pricerule->getCollection() as $rule) {
                $select = $pricelink->getCollection()->getSelect();
                $variables = json_decode($rule->getVariable(), true);

                $select->where(vsprintf($rule->getQuery(), $this->_getConditionValues($variables, $_customer, $storeID, $_product)));
                $result = $this->_executeSelect($select);

                if ($this->_stopSearch($result)) {
                    return $result;
                }
            }
        }

        return false;
    }

    protected function _getConditionValues($variables, $_customer, $storeID, $_product)
    {
        $values = array();

        foreach ($variables as $variable) {
            switch ($variable) {
                case 'store_id':
                    $values[] = $storeID;
                    break;
                case 'region_id':
                    $values[] = $this->_getCustomerRegionId($_customer);
                    break;
                case 'product_id':
                    $values[] = $_product->getId();                  
                    break;
                case 'condpay_id':
                    /*                
                    if (Mage::getSingleton('core/session')->getCondpaySelected()) {
                        $condpay_id = Mage::getSingleton('core/session')->getCondpaySelected();
                    } else {
                        $condpay_id = $_customer->getCondpayId();
                    }
                    $values[] = $condpay_id;
                    */
                    break;
                case 'customer_group_id':
                    $values[] = $_customer->getGroupId();
                    break;
                case 'customer_id':
                    $values[] = $_customer->getId();
                    break;
                case 'order_type':
                    //$values[] = $this->getOrderType();
                    break;
                default:
                    $values[] = $_customer->getData($variable);
                    break;
            }
        }

        return $values;
    }

    /**
     * Return if search is to stop or not
     *
     * @param array $results
     * @return bool
     */
    protected function _stopSearch($results)
    {
        return count($results) == 1;
    }

    protected function _executeSelect($select)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $result = $connection->fetchAll($select);

        return $result;
    }

    //Discount validation and product discount update
    public function DiscountEnable()
    {
        return boolval($this->scopeConfig->getValue('wsprice/general/enable_discount', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function DiscountItem($_product)
    {
        if ($this->isLogged() && $_product->getId()) {
            $_percentage = $this->discountTableFilter($this->getCustomer(), $this->getStoreId(), $_product);

            if($_product->getOriginalPrice()){
                $_price = $_product->getOriginalPrice();
            } else {
                $_price = $_product->getPrice();
            }

            $newspecialprice = $_price - (($_price * $_percentage) / 100);

            if(($_product->getDiscount() > 0) && ($_product->getPrice() > $newspecialprice)){
                $_product->setSpecialPriceOriginal($newspecialprice);
                $_product->setSpecialPrice($newspecialprice);
                $_product->setDiscount($_percentage);
            }
        }
    }

    public function discountTableFilter($_customer, $storeID, $_product)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $discountrule = $objectManager->create('\Wealthsystems\Masterprice\Model\Discountrule');
        $discount = $objectManager->create('\Wealthsystems\Masterprice\Model\Discount');

        if (count($discount->getCollection()) > 0) {
            foreach ($discountrule->getCollection() as $rule) {
                $select = $discount->getCollection()->getSelect();
                $variables = json_decode($rule->getVariable(), true);

                $select->where(vsprintf($rule->getQuery(), $this->_getConditionValues($variables, $_customer, $storeID, $_product)));
                $result = $this->_executeSelect($select);

                if (isset($result[0])) {                    
                    return $result[0]['percentage'];
                }
            }
        }

        return false;
    }

    public function DiscountCollection($_collect)
    {
        foreach ($_collect as $_item) {
            $this->DiscountItem($_item);
        }
    }

    //Tax validation and product tax update
    public function TaxEnable()
    {
        return boolval($this->scopeConfig->getValue('wsprice/general/enable_tax', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function TaxCollection($_collect)
    {
        foreach ($_collect as $_item) {
            $this->TaxItem($_item);
        }        
    }

    public function TaxItem($_product)
    {
        if ($_product->getId()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $taxModel = $objectManager->create('Wealthsystems\Masterprice\Model\Tax');

            $taxCollection = $taxModel->getCollection();
            foreach ($taxCollection as $_tax) { 
                $rule = json_decode($_tax->getRules());
                $type = $_tax->getCalculation();
                $percentage = 0;

                $rule_ids = array();

                foreach($rule as $item){               
                    array_push($rule_ids,$item);
                }                             
                $taxesFiltered = $this->TaxFilter($rule_ids, $_tax->getCode(), $_product);
                
                if($taxesFiltered[0]){
                    $percentage = $taxesFiltered[0]['percentage']; 
                }     

                if($percentage > 0){
                    $finalprice = $_product->getPrice();       

                    if($type == 0){                    
                        $price = $_product->getOriginalPrice();
                    } else {
                        $price = $_product->getPrice();
                    }
        
                    $_product->setData('tax_'.$_tax->getCode(),(($price * floatval($percentage)) / 100));
                    
                    $_finalprice = $finalprice + (($price * floatval($percentage)) / 100);        
                    $_product->setPrice($_finalprice);   
                    
                    if($_product->getDiscount() > 0){
                        if($type == 0){
                            $_specialprice = $_product->getSpecialPrice() + (($_product->getSpecialPriceOriginal() * $percentage) / 100); 
                        } else {
                            $_specialprice = $_product->getSpecialPrice() + (($_product->getSpecialPrice() * $percentage) / 100); 
                        }
                        
                        if($_specialprice > 0){
                            $_product->setSpecialPrice($_specialprice);
                        }      
                    }                                
                } 
            }
        }
    }

    public function TaxFilter($ids, $tax, $_product)
    {        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $taxes = $objectManager->create('\Wealthsystems\Masterprice\Model\Taxlink');
        $_taxes = $taxes->getCollection()->addFieldToFilter('code',$tax)->addFieldToFilter('is_active', 1);

        $taxesRule = $objectManager->create('\Wealthsystems\Masterprice\Model\Taxrule');
        $_taxesRule = $taxesRule->getCollection()->addFieldToFilter('id', array('in' => $ids));

        if (count($_taxes) > 0) {
            foreach ($_taxesRule as $rule) {                
                $select = $_taxes->getSelect();
                $variables = json_decode($rule->getVariable(), true);                

                $select->where(vsprintf($rule->getQuery(), $this->_getConditionValues($variables, $this->getCustomer(), $this->getStoreId(), $_product)));                
                $result = $this->_executeSelect($select);

                if ($this->_stopSearch($result)) {
                    return $result;
                }
            }
        }

        return false;
    }
}

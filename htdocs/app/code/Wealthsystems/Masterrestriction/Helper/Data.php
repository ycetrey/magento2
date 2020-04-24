<?php

namespace Wealthsystems\Masterrestriction\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function RestrictionEnable()
    {
        return boolval($this->scopeConfig->getValue('wsrestriction/general/enable_restriction', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }    

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

    public function RestrictionCollection($_collect)
    {
        foreach ($_collect as $_item) {
            $this->RestrictionItem($_item);
        }
    }

    public function RestrictionItem($_product)
    {        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $restrictiontable = $objectManager->create('\Wealthsystems\Masterrestriction\Model\Restriction');

        $restrictionTable = $restrictiontable->getCollection(); 

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        $_customer = $customerSession->getCustomer();
        
        //Store filter
        $this->_filterStoreId($restrictionTable);

        //Customer filter
        $this->_filterCustomerId($restrictionTable, $_customer);
        $this->_filterCustomerGroupId($restrictionTable, $_customer);
        $this->_filterSalesmanId($restrictionTable, $_customer);
        $this->_filterCustomerType($restrictionTable, $_customer);

        //Product filter
        $this->_filterProductId($restrictionTable, $_product);
        $this->_filterManufacturerId($restrictionTable, $_product);
        $this->_filterBrandId($restrictionTable, $_product);
        $this->_filterCategoryId($restrictionTable, $_product);        

        $restrictionTable = $restrictionTable->getFirstItem();

        if($restrictionTable->getId()){
            $_product->setPriceOriginal(0);
            $_product->setPrice(0);
            $_product->setVisibility(1);
            $_product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);        
        }        
    }

    protected function _filterStoreId($collection)
    {
        $collection->addFieldToFilter(
            array('store_id'),
            array(
                array(
                    array('eq' => $this->getStoreId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterProductId($collection,$_product)
    {
        $collection->addFieldToFilter(
            array('product_id'),
            array(
                array(
                    array('eq' => $_product->getId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterManufacturerId($collection,$_product)
    {
        $collection->addFieldToFilter(
            array('manufacturer_id'),
            array(
                array(
                    array('eq' => $_product->getManufacturerId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterBrandId($collection,$_product)
    {
        $collection->addFieldToFilter(
            array('brand_id'),
            array(
                array(
                    array('eq' => $_product->getBrandId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterCategoryId($collection,$_product)
    {
        $collection->addFieldToFilter(
            array('category_id'),
            array(
                array(
                    array('in' => $_product->getCategoryIds()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterCustomerId($collection, $_customer)
    {
        $collection->addFieldToFilter(
            array('customer_id'),
            array(
                array(
                    array('eq' => $_customer->getId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterCustomerGroupId($collection, $_customer)
    {
        $collection->addFieldToFilter(
            array('customer_group_id'),
            array(
                array(
                    array('eq' => $_customer->getGroupId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterSalesmanId($collection, $_customer)
    {
        $collection->addFieldToFilter(
            array('salesman_id'),
            array(
                array(
                    array('eq' => $_customer->getSalesmanId()),
                    array('null' => true)
                )
            )
        );
    }

    protected function _filterCustomerType($collection, $_customer)
    {
        if($_customer->getLegalType() == 1){
            $type = 'PF';
        } else {
            $type = 'PJ';
        }

        $collection->addFieldToFilter(
            array('customer_type'),
            array(
                array(
                    array('eq' => $type),
                    array('null' => true)
                )
            )
        );
    }

}

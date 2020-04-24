<?php

namespace Wealthsystems\Masterstock\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $_stockStateInterface;
    protected $_stockRegistry;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface,
        \Magento\Catalog\Model\Product $product,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
    ) {
        $this->_stockStateInterface = $stockStateInterface;
        $this->_stockRegistry = $stockRegistry;
        $this->_product = $product;
        parent::__construct($context);
    }

    public function StockEnable()
    {
        return boolval($this->scopeConfig->getValue('wsstock/general/enable_stock', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function StockMovementEnable()
    {
        return boolval($this->scopeConfig->getValue('wsstock/general/enable_movement', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function StockQuantityEnable()
    {
        return boolval($this->scopeConfig->getValue('wsstock/general/enable_quantity', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function WarehouseEnable()
    {
        return boolval($this->scopeConfig->getValue('wsstock/general/enable_warehouse', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function LowStock()
    {
        return $lowstock = $this->scopeConfig->getValue('wsstock/general/low_stock', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function ArrivalForecast()
    {
        return $lowstock = $this->scopeConfig->getValue('wsstock/general/enable_forecast', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
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

    public function StockItem($_product)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $modelStock = $objectManager->create('\Wealthsystems\Masterstock\Model\Productstock');

        if($this->WarehouseEnable()){
            $Stock = $modelStock->getCollection()
                ->addFieldToFilter('store_id', $this->getStoreId())
                ->addFieldToFilter('product_id', $_product->getId())
                ->addFieldToFilter('warehouse_id', $_product->getWarehouseId())
                ->getFirstItem();
        } else {
            $Stock = $modelStock->getCollection()
                ->addFieldToFilter('store_id', $this->getStoreId())
                ->addFieldToFilter('product_id', $_product->getId())
                ->getFirstItem();
        }
                    
        $qty = $Stock->getQty();

        if($qty > 0){
            $_product->setIsSalable(true);
            $_product->setInStock(true);
            $_product->setStockQty($qty);
            $_product->isAvailable(true);

            $lowstock = $this->LowStock();

            if($lowstock > 0 && $lowstock >= $qty){
                $_product->setLowStock(true);
            }
        } else {
            $_product->setIsSalable(false);
            $_product->setInStock(false);
            $_product->setStockQty(0);
            $_product->isAvailable(false);

            if($Stock->getArrivalForecast() && $this->ArrivalForecast()){
                $_product->setArrivalForecast($Stock->getArrivalForecast());
            }
        }
    }
}

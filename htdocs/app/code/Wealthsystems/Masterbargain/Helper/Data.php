<?php

/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_SocialShare
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Wealthsystems\Masterbargain\Helper;

use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Data
 * @package Mageplaza\SocialShare\Helper
 */
class Data extends AbstractData
{
    public function BargainEnable()
    {
        return boolval($this->scopeConfig->getValue('wsbargain/general/enable_bargain', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function MaxApprove()
    {
        return boolval($this->scopeConfig->getValue('wsbargain/general/max_approve', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function MaxApprovePercentage()
    {
        return $this->scopeConfig->getValue('wsbargain/general/max_approve_percentage', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
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

    public function PriceItem($_product)
    {
        if (!$this->isLogged()) {
            return false;
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $bargain = $objectManager->create('\Wealthsystems\Masterbargain\Model\Bargain');

        $bargain = $bargain->getCollection()
            ->addFieldToFilter('product_id', $_product->getId())
            ->addFieldToFilter('customer_id', $this->getCustomer()->getId())
            ->addFieldToFilter('status', 1)
            ->getLastItem();

        if ($bargain->getId()) {
            $_product->setPrice($bargain->getPrice());
            $_product->setIsBargain(true);
        } else {
            $_product->setIsBargain(false);
        }
    }

    public function PriceCollection($_collect)
    {
        foreach ($_collect as $_item) {
            $this->PriceItem($_item);
        }
    }

    public function deleteRecord($product_id, $customer_id)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $bargain = $objectManager->create('\Wealthsystems\Masterbargain\Model\Bargain');

        $bargain = $bargain->getCollection()
        ->addFieldToFilter('customer_id',$customer_id)
        ->addFieldToFilter('product_id',$product_id);

        foreach($bargain as $_item){
            $_item->delete();
        }

        $bargain->save();
    }
}

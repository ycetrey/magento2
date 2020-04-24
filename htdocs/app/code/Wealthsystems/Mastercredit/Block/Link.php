<?php

namespace Wealthsystems\Mastercredit\Block;

use \Wealthsystems\Mastercredit\Helper\Data;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData)
    {
        parent::__construct($context, $data);
        $this->_helperData = $helperData;
    }

    /**
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        if($this->_helperData->CreditEnable() && $this->_helperData->CreditVisible() && $this->_helperData->isLogged()){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $creditLimit = $objectManager->create('\Wealthsystems\Mastercredit\Model\Creditlimit');

            $credit = 0;

            if($this->_helperData->isLogged()){
                $customerCredit = $creditLimit->getCollection()
                    ->addFieldToFilter('customer_id',$this->_helperData->getCustomerId())
                    ->addFieldToFilter('store_id',$this->_helperData->getStoreId())
                    ->getFirstItem();

                if (count($customerCredit) > 0) {
                    $credit = $customerCredit->getLimit();
                } 
            }
            
            $priceHelper = $objectManager->create('Magento\Framework\Pricing\Helper\Data'); 
            $price =  $credit;
            $formattedPrice = $priceHelper->currency($price, true, false);

            return '<li class="creditlimit"><div>'.$formattedPrice.'</div></li>';
        }
    }
}

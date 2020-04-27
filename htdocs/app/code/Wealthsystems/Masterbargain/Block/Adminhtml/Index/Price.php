<?php

namespace Wealthsystems\Masterbargain\Block\Adminhtml\Index;

use \Wealthsystems\Masterbargain\Helper\Data;

class Price extends \Magento\Backend\Block\Widget\Container
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData)
    {
        parent::__construct($context, $data);
        $this->_helperData = $helperData;
    }

    public function getPrices()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Wealthsystems\Masterbargain\Model\Bargain');

        return $model;
    }
}

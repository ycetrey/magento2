<?php

namespace Wealthsystems\Masterprice\Block\Adminhtml\Index;

use \Wealthsystems\Masterprice\Helper\Data;

class Taxrule extends \Magento\Backend\Block\Widget\Container
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData)
    {
        parent::__construct($context, $data);
        $this->_helperData = $helperData;
    }

    public function getRules()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Wealthsystems\Masterprice\Model\Taxrule');

        return $model;
    }
}

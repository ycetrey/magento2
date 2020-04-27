<?php

namespace Wealthsystems\Mastertheme\Controller\Adminhtml\Index;

use Wealthsystems\Masterprice\Model\Pricetablerule;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Themesave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;
    protected $_helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wealthsystems\Mastertheme\Model\ThemecustomFactory $moduleFactory,
        \Wealthsystems\Mastertheme\Helper\Data $helper
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
        $this->_helper = $helper;
    }

    public function execute()
    {
        $result = $_POST['result'];
        $result = json_decode($result);

        $model = $this->_moduleFactory->create();

        $connection = $model->getResource()->getConnection();
        $tableName = $model->getResource()->getMainTable();
        $connection->truncateTable($tableName);

        foreach ($result as $_item) {
            $item0 = array_values($_item[0]);
            $item1 = array_values($_item[1]);

            $element = $item0[0];
            $value = $item1[0];

            $model->setData(['element' => $element, 'value' => $value]);
            $model->save();
        }

        $this->_helper->createCSS();
    }
}

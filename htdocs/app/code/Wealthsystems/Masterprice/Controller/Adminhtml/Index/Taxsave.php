<?php

namespace Wealthsystems\Masterprice\Controller\Adminhtml\Index;

use Wealthsystems\Masterprice\Model\Tax;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Taxsave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wealthsystems\Masterprice\Model\TaxFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
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
            $variables = array();
            $item = array_values($_item);

            foreach ($item[0] as $_variable) {
                array_push($variables, $_variable);
            }

            $description = $item[1];
            $type = $item[2];
            $code = $item[3];      
            
            $model->setData(['description' => $description, 'calculation' => $type, 'code' => $code, 'is_active' => 1, 'rules' => json_encode($variables)]);
            $model->save();
        }        
    }
}

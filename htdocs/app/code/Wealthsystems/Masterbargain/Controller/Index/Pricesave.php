<?php

namespace Wealthsystems\Masterbargain\Controller\Index;

use Wealthsystems\Masterbargain\Model\Bargain;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Pricesave extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $_moduleFactory;
    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wealthsystems\Masterbargain\Model\BargainFactory $moduleFactory,
        \Wealthsystems\Masterbargain\Helper\Data $helper
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
        $this->_helper = $helper;
    }

    public function execute()
    {
        $product_id = $_POST['product_id'];
        $customer_id = $_POST['customer_id'];
        $new_price = $_POST['new_price'];        

        $model = $this->_moduleFactory->create();

        $this->_helper->deleteRecord($product_id, $customer_id);   

        $status = 0;

        if($this->_helper->MaxApprove()){
            $percentage = $this->_helper->MaxApprovePercentage();

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
            $price = $product->getPrice();

            $diff = (($price - $new_price) / ($price)) * 100;

            if($percentage >= $diff){
                $status = 1;
            }            
        }

        $model->setData(['product_id' => $product_id, 'customer_id' => $customer_id, 'price' => floatval($new_price), 'date' => null, 'status' => $status, 'viewed' => 0]);
        $model->save();        
    }
}

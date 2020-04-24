<?php
namespace Wealthsystems\Masterstock\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $checkoutSession;
    protected $orderRepository;

	public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Wealthsystems\Masterstock\Model\Productstock $moduleFactory,
		\Magento\Checkout\Model\Cart $cart
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
		$this->_moduleFactory = $moduleFactory;
		$this->_cart = $cart;
        parent::__construct($context);
    }

	public function execute()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->create('\Wealthsystems\Masterstock\Model\Productstock');		

		$quote = $this->_cart->getQuote()->getAllVisibleItems();
		$_products = array();

		foreach($quote as $item){
			$productstock = $model->getCollection()->addFieldToFilter('product_id',$item->getProductId())->getFirstItem();

			if(!empty($productstock->getQty())){				
				if($productstock->getQty() < $item->getQty()){
					array_push($_products,$item->getProductId());
				}
			} else {
				array_push($_products,$item->getProductId());
			}
		}

		echo json_encode($_products);
	}
}
<?php
namespace Mageplaza\ShareCart\Controller\Index\Index;

/**
 * Interceptor class for @see \Mageplaza\ShareCart\Controller\Index\Index
 */
class Interceptor extends \Mageplaza\ShareCart\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Checkout\Model\Cart $cart, \Magento\Catalog\Model\ProductRepository $productRepository, \Magento\Store\Model\StoreManagerInterface $storeManager, \Mageplaza\ShareCart\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $cartRepository, $cart, $productRepository, $storeManager, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}

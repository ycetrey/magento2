<?php
namespace MercadoPago\Core\Controller\Api\Coupon;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Api\Coupon
 */
class Interceptor extends \MercadoPago\Core\Controller\Api\Coupon implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \MercadoPago\Core\Helper\Data $coreHelper, \MercadoPago\Core\Model\Core $coreModel, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Quote\Api\CartRepositoryInterface $quoteRepository, \Magento\Framework\Registry $registry, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $coreHelper, $coreModel, $checkoutSession, $quoteRepository, $registry, $storeManager);
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

<?php
namespace MercadoPago\Core\Controller\Customticket\Success;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Customticket\Success
 */
class Interceptor extends \MercadoPago\Core\Controller\Customticket\Success implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\OrderFactory $orderFactory)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $orderFactory);
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

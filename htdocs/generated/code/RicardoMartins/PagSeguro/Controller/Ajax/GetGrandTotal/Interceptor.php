<?php
namespace RicardoMartins\PagSeguro\Controller\Ajax\GetGrandTotal;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Controller\Ajax\GetGrandTotal
 */
class Interceptor extends \RicardoMartins\PagSeguro\Controller\Ajax\GetGrandTotal implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($checkoutSession, $context);
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

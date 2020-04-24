<?php
namespace RicardoMartins\PagSeguro\Controller\Ajax\UpdateInstallments;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Controller\Ajax\UpdateInstallments
 */
class Interceptor extends \RicardoMartins\PagSeguro\Controller\Ajax\UpdateInstallments implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Action\Context $context, \Magento\Framework\Serialize\SerializerInterface $serializer)
    {
        $this->___init();
        parent::__construct($checkoutSession, $context, $serializer);
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

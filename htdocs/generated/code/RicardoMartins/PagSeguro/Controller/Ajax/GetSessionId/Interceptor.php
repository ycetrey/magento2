<?php
namespace RicardoMartins\PagSeguro\Controller\Ajax\GetSessionId;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Controller\Ajax\GetSessionId
 */
class Interceptor extends \RicardoMartins\PagSeguro\Controller\Ajax\GetSessionId implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\RicardoMartins\PagSeguro\Helper\Data $pagSeguroHelper, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($pagSeguroHelper, $context);
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

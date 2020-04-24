<?php
namespace RicardoMartins\PagSeguro\Controller\Test\GetConfig;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Controller\Test\GetConfig
 */
class Interceptor extends \RicardoMartins\PagSeguro\Controller\Test\GetConfig implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \RicardoMartins\PagSeguro\Helper\Data $helper, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory)
    {
        $this->___init();
        parent::__construct($context, $helper, $jsonFactory);
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

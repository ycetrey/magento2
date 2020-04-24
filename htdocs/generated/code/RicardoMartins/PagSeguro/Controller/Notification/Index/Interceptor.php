<?php
namespace RicardoMartins\PagSeguro\Controller\Notification\Index;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Controller\Notification\Index
 */
class Interceptor extends \RicardoMartins\PagSeguro\Controller\Notification\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\RicardoMartins\PagSeguro\Helper\Data $pagSeguroHelper, \RicardoMartins\PagSeguro\Model\Notifications $pagSeguroAbModel, \Magento\Framework\App\CacheInterface $cache, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($pagSeguroHelper, $pagSeguroAbModel, $cache, $context);
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

<?php
namespace MercadoPago\Core\Controller\Basic\Pay;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Basic\Pay
 */
class Interceptor extends \MercadoPago\Core\Controller\Basic\Pay implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \MercadoPago\Core\Model\Basic\Payment $paymentFactory, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\UrlInterface $urlInterface, \MercadoPago\Core\Helper\Data $coreHelper)
    {
        $this->___init();
        parent::__construct($context, $paymentFactory, $scopeConfig, $messageManager, $resultFactory, $urlInterface, $coreHelper);
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

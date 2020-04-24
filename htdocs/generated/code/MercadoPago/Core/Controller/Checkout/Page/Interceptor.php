<?php
namespace MercadoPago\Core\Controller\Checkout\Page;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Checkout\Page
 */
class Interceptor extends \MercadoPago\Core\Controller\Checkout\Page implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender, \Psr\Log\LoggerInterface $logger, \MercadoPago\Core\Helper\Data $helperData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \MercadoPago\Core\Model\Core $core, \Magento\Catalog\Model\Session $catalogSession)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $orderFactory, $orderSender, $logger, $helperData, $scopeConfig, $core, $catalogSession);
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

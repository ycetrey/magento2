<?php
namespace MercadoPago\Core\Controller\Notifications\Basic;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Notifications\Basic
 */
class Interceptor extends \MercadoPago\Core\Controller\Notifications\Basic implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \MercadoPago\Core\Model\Basic\Payment $paymentFactory, \MercadoPago\Core\Helper\Data $coreHelper, \MercadoPago\Core\Model\Core $coreModel, \Magento\Sales\Model\OrderFactory $orderFactory, \MercadoPago\Core\Model\Notifications\Notifications $notifications)
    {
        $this->___init();
        parent::__construct($context, $paymentFactory, $coreHelper, $coreModel, $orderFactory, $notifications);
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

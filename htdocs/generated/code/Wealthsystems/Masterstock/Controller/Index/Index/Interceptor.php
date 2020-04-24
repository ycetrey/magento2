<?php
namespace Wealthsystems\Masterstock\Controller\Index\Index;

/**
 * Interceptor class for @see \Wealthsystems\Masterstock\Controller\Index\Index
 */
class Interceptor extends \Wealthsystems\Masterstock\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Checkout\Model\Session $checkoutSession, \Wealthsystems\Masterstock\Model\Productstock $moduleFactory, \Magento\Checkout\Model\Cart $cart)
    {
        $this->___init();
        parent::__construct($context, $orderRepository, $checkoutSession, $moduleFactory, $cart);
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

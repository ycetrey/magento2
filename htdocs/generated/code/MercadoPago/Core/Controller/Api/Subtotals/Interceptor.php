<?php
namespace MercadoPago\Core\Controller\Api\Subtotals;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Api\Subtotals
 */
class Interceptor extends \MercadoPago\Core\Controller\Api\Subtotals implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Quote\Api\CartRepositoryInterface $quoteRepository, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $quoteRepository, $registry);
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

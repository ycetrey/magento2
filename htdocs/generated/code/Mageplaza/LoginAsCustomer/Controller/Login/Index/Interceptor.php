<?php
namespace Mageplaza\LoginAsCustomer\Controller\Login\Index;

/**
 * Interceptor class for @see \Mageplaza\LoginAsCustomer\Controller\Login\Index
 */
class Interceptor extends \Mageplaza\LoginAsCustomer\Controller\Login\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Model\Account\Redirect $accountRedirect, \Magento\Checkout\Model\Cart $checkoutCart, \Mageplaza\LoginAsCustomer\Helper\Data $helper, \Mageplaza\LoginAsCustomer\Model\LogFactory $logFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $accountRedirect, $checkoutCart, $helper, $logFactory);
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

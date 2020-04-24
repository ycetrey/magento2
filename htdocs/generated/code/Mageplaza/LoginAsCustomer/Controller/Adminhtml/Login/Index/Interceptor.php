<?php
namespace Mageplaza\LoginAsCustomer\Controller\Adminhtml\Login\Index;

/**
 * Interceptor class for @see \Mageplaza\LoginAsCustomer\Controller\Adminhtml\Login\Index
 */
class Interceptor extends \Mageplaza\LoginAsCustomer\Controller\Adminhtml\Login\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Customer\Model\CustomerFactory $customerFactory, \Mageplaza\LoginAsCustomer\Model\LogFactory $logFactory, \Mageplaza\LoginAsCustomer\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $customerFactory, $logFactory, $helper);
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

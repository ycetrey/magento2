<?php
namespace Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\AuthIndex;

/**
 * Interceptor class for @see \Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\AuthIndex
 */
class Interceptor extends \Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\AuthIndex implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Session\SessionManager $storageSession, \Mageplaza\TwoFactorAuth\Helper\Data $helperData)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $storageSession, $helperData);
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

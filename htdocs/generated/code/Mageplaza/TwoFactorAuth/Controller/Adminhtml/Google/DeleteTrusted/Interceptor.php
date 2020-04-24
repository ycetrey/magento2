<?php
namespace Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\DeleteTrusted;

/**
 * Interceptor class for @see \Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\DeleteTrusted
 */
class Interceptor extends \Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\DeleteTrusted implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mageplaza\TwoFactorAuth\Model\TrustedFactory $trustedFactory)
    {
        $this->___init();
        parent::__construct($context, $trustedFactory);
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

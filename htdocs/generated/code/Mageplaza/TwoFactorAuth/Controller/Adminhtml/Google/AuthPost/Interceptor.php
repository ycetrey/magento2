<?php
namespace Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\AuthPost;

/**
 * Interceptor class for @see \Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\AuthPost
 */
class Interceptor extends \Mageplaza\TwoFactorAuth\Controller\Adminhtml\Google\AuthPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Google\Authenticator\GoogleAuthenticator $googleAuthenticator, \Magento\Framework\Session\SessionManager $storageSession, \Magento\Security\Model\AdminSessionsManager $sessionsManager, \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress, \Mageplaza\TwoFactorAuth\Model\TrustedFactory $trustedFactory)
    {
        $this->___init();
        parent::__construct($context, $googleAuthenticator, $storageSession, $sessionsManager, $remoteAddress, $trustedFactory);
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

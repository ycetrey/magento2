<?php
namespace BitExpert\ForceCustomerLogin\Controller\LoginCheck;

/**
 * Interceptor class for @see \BitExpert\ForceCustomerLogin\Controller\LoginCheck
 */
class Interceptor extends \BitExpert\ForceCustomerLogin\Controller\LoginCheck implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \BitExpert\ForceCustomerLogin\Model\Session $session, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface $whitelistRepository, \BitExpert\ForceCustomerLogin\Helper\Strategy\StrategyManager $strategyManager, \BitExpert\ForceCustomerLogin\Controller\ModuleCheck $moduleCheck, \Magento\Framework\App\Response\Http $response)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $session, $scopeConfig, $whitelistRepository, $strategyManager, $moduleCheck, $response);
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

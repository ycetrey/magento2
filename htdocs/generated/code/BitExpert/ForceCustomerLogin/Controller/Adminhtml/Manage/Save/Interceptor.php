<?php
namespace BitExpert\ForceCustomerLogin\Controller\Adminhtml\Manage\Save;

/**
 * Interceptor class for @see \BitExpert\ForceCustomerLogin\Controller\Adminhtml\Manage\Save
 */
class Interceptor extends \BitExpert\ForceCustomerLogin\Controller\Adminhtml\Manage\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\BitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface $whitelistEntityFactory, \BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface $whitelistRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($whitelistEntityFactory, $whitelistRepository, $context);
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

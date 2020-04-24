<?php
namespace Wealthsystems\Masterprice\Controller\Adminhtml\Index\Taxrule;

/**
 * Interceptor class for @see \Wealthsystems\Masterprice\Controller\Adminhtml\Index\Taxrule
 */
class Interceptor extends \Wealthsystems\Masterprice\Controller\Adminhtml\Index\Taxrule implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($context);
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

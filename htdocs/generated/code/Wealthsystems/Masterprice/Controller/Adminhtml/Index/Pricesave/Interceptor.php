<?php
namespace Wealthsystems\Masterprice\Controller\Adminhtml\Index\Pricesave;

/**
 * Interceptor class for @see \Wealthsystems\Masterprice\Controller\Adminhtml\Index\Pricesave
 */
class Interceptor extends \Wealthsystems\Masterprice\Controller\Adminhtml\Index\Pricesave implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wealthsystems\Masterprice\Model\PricetableruleFactory $moduleFactory)
    {
        $this->___init();
        parent::__construct($context, $moduleFactory);
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

<?php
namespace Wealthsystems\Masterprice\Controller\Adminhtml\Index\Discountsave;

/**
 * Interceptor class for @see \Wealthsystems\Masterprice\Controller\Adminhtml\Index\Discountsave
 */
class Interceptor extends \Wealthsystems\Masterprice\Controller\Adminhtml\Index\Discountsave implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wealthsystems\Masterprice\Model\DiscountruleFactory $moduleFactory)
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

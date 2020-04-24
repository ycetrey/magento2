<?php
namespace Wealthsystems\Mastertheme\Controller\Adminhtml\Index\Themesave;

/**
 * Interceptor class for @see \Wealthsystems\Mastertheme\Controller\Adminhtml\Index\Themesave
 */
class Interceptor extends \Wealthsystems\Mastertheme\Controller\Adminhtml\Index\Themesave implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wealthsystems\Mastertheme\Model\ThemecustomFactory $moduleFactory, \Wealthsystems\Mastertheme\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $moduleFactory, $helper);
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

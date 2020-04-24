<?php
namespace Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Edit;

/**
 * Interceptor class for @see \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Edit
 */
class Interceptor extends \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Etatvasoft\Productsattachment\Model\Productsattachment $model)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $model);
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

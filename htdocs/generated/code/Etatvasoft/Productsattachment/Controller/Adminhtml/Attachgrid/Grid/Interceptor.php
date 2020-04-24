<?php
namespace Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Grid;

/**
 * Interceptor class for @see \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Grid
 */
class Interceptor extends \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Grid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\Registry $coreRegistry, \Etatvasoft\Productsattachment\Model\Productsattachment $attachmentLoader, \Magento\Framework\Controller\Result\Json $resultJson)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $layoutFactory, $coreRegistry, $attachmentLoader, $resultJson);
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

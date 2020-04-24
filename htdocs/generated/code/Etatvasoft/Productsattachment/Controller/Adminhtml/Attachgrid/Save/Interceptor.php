<?php
namespace Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Save;

/**
 * Interceptor class for @see \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Save
 */
class Interceptor extends \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\PostDataProcessor $dataProcessor, \Etatvasoft\Productsattachment\Model\Productsattachment $model, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Magento\Framework\Registry $coreRegistry, \Etatvasoft\Productsattachment\Model\Productsattachment $attachmentLoader, \Magento\Framework\Controller\Result\Json $resultJson)
    {
        $this->___init();
        parent::__construct($context, $dataProcessor, $model, $dataPersistor, $coreRegistry, $attachmentLoader, $resultJson);
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

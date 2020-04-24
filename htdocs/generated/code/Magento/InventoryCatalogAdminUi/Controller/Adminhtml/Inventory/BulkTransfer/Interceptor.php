<?php
namespace Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Inventory\BulkTransfer;

/**
 * Interceptor class for @see \Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Inventory\BulkTransfer
 */
class Interceptor extends \Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Inventory\BulkTransfer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\InventoryCatalogAdminUi\Controller\Adminhtml\Bulk\BulkPageProcessor $processBulkPage)
    {
        $this->___init();
        parent::__construct($context, $processBulkPage);
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

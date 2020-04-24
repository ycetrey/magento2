<?php
namespace ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\Save;

/**
 * Interceptor class for @see \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\Save
 */
class Interceptor extends \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\PostDataProcessor $dataProcessor, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \ImaginationMedia\Correios\Helper\Data $data, \ImaginationMedia\Correios\Model\CotacoesFactory $factory)
    {
        $this->___init();
        parent::__construct($context, $dataProcessor, $dataPersistor, $data, $factory);
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

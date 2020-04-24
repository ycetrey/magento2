<?php
namespace ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\InlineEdit;

/**
 * Interceptor class for @see \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\InlineEdit
 */
class Interceptor extends \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\InlineEdit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \ImaginationMedia\Correios\Helper\Data $data, \ImaginationMedia\Correios\Model\ResourceModel\CotacoesFactory $cotacoesFactory, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $jsonFactory, $data, $cotacoesFactory, $timezone);
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

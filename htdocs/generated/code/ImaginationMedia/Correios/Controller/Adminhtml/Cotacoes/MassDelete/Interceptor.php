<?php
namespace ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\MassDelete;

/**
 * Interceptor class for @see \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\MassDelete
 */
class Interceptor extends \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \ImaginationMedia\Correios\Model\CotacoesRepository $cotacao)
    {
        $this->___init();
        parent::__construct($context, $filter, $cotacao);
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

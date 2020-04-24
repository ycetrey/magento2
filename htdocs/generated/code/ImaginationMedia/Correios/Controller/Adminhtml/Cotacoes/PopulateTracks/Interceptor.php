<?php
namespace ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\PopulateTracks;

/**
 * Interceptor class for @see \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\PopulateTracks
 */
class Interceptor extends \ImaginationMedia\Correios\Controller\Adminhtml\Cotacoes\PopulateTracks implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \ImaginationMedia\Correios\Model\CotacoesRepository $cotacoesRepository)
    {
        $this->___init();
        parent::__construct($context, $cotacoesRepository);
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

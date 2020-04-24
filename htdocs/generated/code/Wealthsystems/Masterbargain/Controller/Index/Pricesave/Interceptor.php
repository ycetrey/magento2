<?php
namespace Wealthsystems\Masterbargain\Controller\Index\Pricesave;

/**
 * Interceptor class for @see \Wealthsystems\Masterbargain\Controller\Index\Pricesave
 */
class Interceptor extends \Wealthsystems\Masterbargain\Controller\Index\Pricesave implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wealthsystems\Masterbargain\Model\BargainFactory $moduleFactory, \Wealthsystems\Masterbargain\Helper\Data $helper)
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

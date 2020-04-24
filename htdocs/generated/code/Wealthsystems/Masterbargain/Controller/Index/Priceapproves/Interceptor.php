<?php
namespace Wealthsystems\Masterbargain\Controller\Index\Priceapproves;

/**
 * Interceptor class for @see \Wealthsystems\Masterbargain\Controller\Index\Priceapproves
 */
class Interceptor extends \Wealthsystems\Masterbargain\Controller\Index\Priceapproves implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wealthsystems\Masterbargain\Model\BargainFactory $moduleFactory)
    {
        $this->___init();
        parent::__construct($context, $moduleFactory);
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

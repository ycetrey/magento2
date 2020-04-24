<?php
namespace Wealthsystems\Masterdirectdata\Controller\Index\Directdata;

/**
 * Interceptor class for @see \Wealthsystems\Masterdirectdata\Controller\Index\Directdata
 */
class Interceptor extends \Wealthsystems\Masterdirectdata\Controller\Index\Directdata implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wealthsystems\Masterdirectdata\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $helper);
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

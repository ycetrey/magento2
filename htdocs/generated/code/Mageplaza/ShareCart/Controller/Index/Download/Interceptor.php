<?php
namespace Mageplaza\ShareCart\Controller\Index\Download;

/**
 * Interceptor class for @see \Mageplaza\ShareCart\Controller\Index\Download
 */
class Interceptor extends \Mageplaza\ShareCart\Controller\Index\Download implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Mageplaza\ShareCart\Model\Template\Processor $templateProcessor, \Mageplaza\ShareCart\Helper\PrintProcess $printProcess)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $templateProcessor, $printProcess);
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

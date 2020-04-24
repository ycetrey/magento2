<?php
namespace Mageplaza\BetterPopup\Controller\Adminhtml\Send\Send;

/**
 * Interceptor class for @see \Mageplaza\BetterPopup\Controller\Adminhtml\Send\Send
 */
class Interceptor extends \Mageplaza\BetterPopup\Controller\Adminhtml\Send\Send implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mageplaza\BetterPopup\Helper\Data $helperData, \Mageplaza\BetterPopup\Block\Email\Template $template, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Store\Model\StoreManagerInterface $storeManager, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $helperData, $template, $transportBuilder, $storeManager, $logger);
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

<?php
namespace Mageplaza\BannerSlider\Controller\Adminhtml\Slider\Index;

/**
 * Interceptor class for @see \Mageplaza\BannerSlider\Controller\Adminhtml\Slider\Index
 */
class Interceptor extends \Mageplaza\BannerSlider\Controller\Adminhtml\Slider\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($resultPageFactory, $context);
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

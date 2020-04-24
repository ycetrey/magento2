<?php
namespace Mageplaza\BannerSlider\Controller\Adminhtml\Banner\Edit;

/**
 * Interceptor class for @see \Mageplaza\BannerSlider\Controller\Adminhtml\Banner\Edit
 */
class Interceptor extends \Mageplaza\BannerSlider\Controller\Adminhtml\Banner\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Mageplaza\BannerSlider\Model\BannerFactory $bannerFactory, \Magento\Framework\Registry $registry, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($resultPageFactory, $bannerFactory, $registry, $context);
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

<?php
namespace Mageplaza\BannerSlider\Controller\Adminhtml\Banner\Save;

/**
 * Interceptor class for @see \Mageplaza\BannerSlider\Controller\Adminhtml\Banner\Save
 */
class Interceptor extends \Mageplaza\BannerSlider\Controller\Adminhtml\Banner\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mageplaza\BannerSlider\Helper\Image $imageHelper, \Mageplaza\BannerSlider\Model\BannerFactory $bannerFactory, \Magento\Framework\Registry $registry, \Magento\Backend\Helper\Js $jsHelper, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($imageHelper, $bannerFactory, $registry, $jsHelper, $context);
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

<?php
namespace Mageplaza\BannerSlider\Controller\Adminhtml\Banner\InlineEdit;

/**
 * Interceptor class for @see \Mageplaza\BannerSlider\Controller\Adminhtml\Banner\InlineEdit
 */
class Interceptor extends \Mageplaza\BannerSlider\Controller\Adminhtml\Banner\InlineEdit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Mageplaza\BannerSlider\Model\BannerFactory $bannerFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($jsonFactory, $bannerFactory, $context);
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

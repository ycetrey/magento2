<?php
namespace Mageplaza\Productslider\Controller\Adminhtml\Slider\Edit;

/**
 * Interceptor class for @see \Mageplaza\Productslider\Controller\Adminhtml\Slider\Edit
 */
class Interceptor extends \Mageplaza\Productslider\Controller\Adminhtml\Slider\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mageplaza\Productslider\Model\SliderFactory $sliderFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($context, $sliderFactory, $coreRegistry, $resultPageFactory, $resultJsonFactory);
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

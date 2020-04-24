<?php
namespace Mageplaza\Productslider\Controller\Adminhtml\Slider\Save;

/**
 * Interceptor class for @see \Mageplaza\Productslider\Controller\Adminhtml\Slider\Save
 */
class Interceptor extends \Mageplaza\Productslider\Controller\Adminhtml\Slider\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mageplaza\Productslider\Model\SliderFactory $sliderFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $sliderFactory, $coreRegistry, $dateFilter, $dataPersistor);
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

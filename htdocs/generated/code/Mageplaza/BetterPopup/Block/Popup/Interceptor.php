<?php
namespace Mageplaza\BetterPopup\Block\Popup;

/**
 * Interceptor class for @see \Mageplaza\BetterPopup\Block\Popup
 */
class Interceptor extends \Mageplaza\BetterPopup\Block\Popup implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Mageplaza\BetterPopup\Helper\Data $helperData, \Magento\Newsletter\Model\ResourceModel\Subscriber\CollectionFactory $subscriberCollectionFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $helperData, $subscriberCollectionFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}

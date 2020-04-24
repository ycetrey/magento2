<?php
namespace Mageplaza\Productslider\Block\Widget\Slider;

/**
 * Interceptor class for @see \Mageplaza\Productslider\Block\Widget\Slider
 */
class Interceptor extends \Mageplaza\Productslider\Block\Widget\Slider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Mageplaza\Productslider\Helper\Data $helperData, \Magento\Framework\App\Http\Context $httpContext, \Mageplaza\Productslider\Model\Config\Source\ProductType $productType, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $productCollectionFactory, $catalogProductVisibility, $dateTime, $helperData, $httpContext, $productType, $data);
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

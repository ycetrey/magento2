<?php
namespace Dotdigitalgroup\Email\Block\Recommended\Bestsellers;

/**
 * Interceptor class for @see \Dotdigitalgroup\Email\Block\Recommended\Bestsellers
 */
class Interceptor extends \Dotdigitalgroup\Email\Block\Recommended\Bestsellers implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Dotdigitalgroup\Email\Model\ResourceModel\Catalog $catalog, \Dotdigitalgroup\Email\Helper\Data $helper, \Dotdigitalgroup\Email\Helper\Recommended $recommended, \Magento\Catalog\Model\ProductFactory $productFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $catalog, $helper, $recommended, $productFactory, $data);
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

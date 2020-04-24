<?php
namespace MercadoPago\Core\Model\Preference\Basic;

/**
 * Interceptor class for @see \MercadoPago\Core\Model\Preference\Basic
 */
class Interceptor extends \MercadoPago\Core\Model\Preference\Basic implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Checkout\Model\Session $checkoutSession, \MercadoPago\Core\Helper\Data $helperData, \Magento\Catalog\Helper\Image $helperImage, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Payment\Model\Method\Logger $logger)
    {
        $this->___init();
        parent::__construct($orderFactory, $checkoutSession, $helperData, $helperImage, $urlBuilder, $scopeConfig, $customerSession, $context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $logger);
    }

    /**
     * {@inheritdoc}
     */
    public function denyPayment(\Magento\Payment\Model\InfoInterface $payment)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'denyPayment');
        if (!$pluginInfo) {
            return parent::denyPayment($payment);
        } else {
            return $this->___callPlugins('denyPayment', func_get_args(), $pluginInfo);
        }
    }
}

<?php
namespace MercadoPago\Core\Model\Basic\Payment;

/**
 * Interceptor class for @see \MercadoPago\Core\Model\Basic\Payment
 */
class Interceptor extends \MercadoPago\Core\Model\Basic\Payment implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MercadoPago\Core\Helper\Data $helperData, \Magento\Catalog\Helper\Image $helperImage, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Customer\Model\Session $customerSession, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Payment\Model\Method\Logger $logger, \MercadoPago\Core\Model\Preference\Basic $basic, array $data = [])
    {
        $this->___init();
        parent::__construct($helperData, $helperImage, $checkoutSession, $customerSession, $orderFactory, $urlBuilder, $context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $basic, $data);
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

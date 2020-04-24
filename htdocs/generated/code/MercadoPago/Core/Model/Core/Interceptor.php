<?php
namespace MercadoPago\Core\Model\Core;

/**
 * Interceptor class for @see \MercadoPago\Core\Model\Core
 */
class Interceptor extends \MercadoPago\Core\Model\Core implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \MercadoPago\Core\Helper\Data $coreHelper, \Magento\Sales\Model\OrderFactory $orderFactory, \MercadoPago\Core\Helper\Message\MessageInterface $statusMessage, \MercadoPago\Core\Helper\Message\MessageInterface $statusDetailMessage, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Model\Method\Logger $logger, \Magento\Payment\Helper\Data $paymentData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\DB\TransactionFactory $transactionFactory, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Catalog\Helper\Image $helperImage, \Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->___init();
        parent::__construct($storeManager, $coreHelper, $orderFactory, $statusMessage, $statusDetailMessage, $context, $registry, $extensionFactory, $customAttributeFactory, $logger, $paymentData, $scopeConfig, $transactionFactory, $invoiceSender, $orderSender, $customerSession, $urlBuilder, $helperImage, $checkoutSession);
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

<?php
namespace RicardoMartins\PagSeguro\Model\Notifications;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Model\Notifications
 */
class Interceptor extends \RicardoMartins\PagSeguro\Model\Notifications implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Payment\Model\Method\Logger $logger, \Magento\Framework\Module\ModuleListInterface $moduleList, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Directory\Model\CountryFactory $countryFactory, \RicardoMartins\PagSeguro\Helper\Data $pagSeguroHelper, \Magento\Sales\Api\Data\OrderInterface $orderModel, \Magento\Framework\DB\Transaction $transactionFactory, \Magento\Sales\Model\Order\Email\Sender\OrderCommentSender $commentSender, \Magento\Sales\Model\Service\InvoiceService $invoiceService, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Framework\App\CacheInterface $cache, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $moduleList, $localeDate, $countryFactory, $pagSeguroHelper, $orderModel, $transactionFactory, $commentSender, $invoiceService, $invoiceSender, $cache, $data);
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

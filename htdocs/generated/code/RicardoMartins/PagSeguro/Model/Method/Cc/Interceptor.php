<?php
namespace RicardoMartins\PagSeguro\Model\Method\Cc;

/**
 * Interceptor class for @see \RicardoMartins\PagSeguro\Model\Method\Cc
 */
class Interceptor extends \RicardoMartins\PagSeguro\Model\Method\Cc implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Payment\Model\Method\Logger $logger, \Magento\Framework\Module\ModuleListInterface $moduleList, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Directory\Model\CountryFactory $countryFactory, \RicardoMartins\PagSeguro\Helper\Data $pagSeguroHelper, \RicardoMartins\PagSeguro\Model\Notifications $pagSeguroAbModel, \Magento\Backend\Model\Auth\Session $adminSession, \Magento\Framework\Message\ManagerInterface $messageManager, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $moduleList, $localeDate, $countryFactory, $pagSeguroHelper, $pagSeguroAbModel, $adminSession, $messageManager, $data);
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
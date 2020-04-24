<?php
namespace MercadoPago\Core\Helper\Data;

/**
 * Interceptor class for @see \MercadoPago\Core\Helper\Data
 */
class Interceptor extends \MercadoPago\Core\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MercadoPago\Core\Helper\Message\MessageInterface $messageInterface, \Magento\Framework\App\Helper\Context $context, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Payment\Model\Method\Factory $paymentMethodFactory, \Magento\Store\Model\App\Emulation $appEmulation, \Magento\Payment\Model\Config $paymentConfig, \Magento\Framework\App\Config\Initial $initialConfig, \MercadoPago\Core\Logger\Logger $logger, \Magento\Sales\Model\ResourceModel\Status\Collection $statusFactory, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Backend\Block\Store\Switcher $switcher, \Magento\Framework\Composer\ComposerInformation $composerInformation, \Magento\Framework\Module\ResourceInterface $moduleResource)
    {
        $this->___init();
        parent::__construct($messageInterface, $context, $layoutFactory, $paymentMethodFactory, $appEmulation, $paymentConfig, $initialConfig, $logger, $statusFactory, $orderFactory, $switcher, $composerInformation, $moduleResource);
    }

    /**
     * {@inheritdoc}
     */
    public function getMethodInstance($code)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMethodInstance');
        if (!$pluginInfo) {
            return parent::getMethodInstance($code);
        } else {
            return $this->___callPlugins('getMethodInstance', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentMethods()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPaymentMethods');
        if (!$pluginInfo) {
            return parent::getPaymentMethods();
        } else {
            return $this->___callPlugins('getPaymentMethods', func_get_args(), $pluginInfo);
        }
    }
}

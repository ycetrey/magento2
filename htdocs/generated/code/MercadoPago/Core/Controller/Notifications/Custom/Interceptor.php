<?php
namespace MercadoPago\Core\Controller\Notifications\Custom;

/**
 * Interceptor class for @see \MercadoPago\Core\Controller\Notifications\Custom
 */
class Interceptor extends \MercadoPago\Core\Controller\Notifications\Custom implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \MercadoPago\Core\Helper\Data $coreHelper, \MercadoPago\Core\Model\Core $coreModel, \MercadoPago\Core\Model\Notifications\Notifications $notifications)
    {
        $this->___init();
        parent::__construct($context, $coreHelper, $coreModel, $notifications);
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

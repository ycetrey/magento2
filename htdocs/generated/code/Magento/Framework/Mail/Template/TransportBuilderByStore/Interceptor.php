<?php
namespace Magento\Framework\Mail\Template\TransportBuilderByStore;

/**
 * Interceptor class for @see \Magento\Framework\Mail\Template\TransportBuilderByStore
 */
class Interceptor extends \Magento\Framework\Mail\Template\TransportBuilderByStore implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Mail\MessageInterface $message, \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver)
    {
        $this->___init();
        parent::__construct($message, $senderResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function setFromByStore($from, $store)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFromByStore');
        if (!$pluginInfo) {
            return parent::setFromByStore($from, $store);
        } else {
            return $this->___callPlugins('setFromByStore', func_get_args(), $pluginInfo);
        }
    }
}

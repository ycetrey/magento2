<?php
namespace Magento\Paypal\Model\Cart;

/**
 * Interceptor class for @see \Magento\Paypal\Model\Cart
 */
class Interceptor extends \Magento\Paypal\Model\Cart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Payment\Model\Cart\SalesModel\Factory $salesModelFactory, \Magento\Framework\Event\ManagerInterface $eventManager, $salesModel)
    {
        $this->___init();
        parent::__construct($salesModelFactory, $eventManager, $salesModel);
    }

    /**
     * {@inheritdoc}
     */
    public function getAmounts()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAmounts');
        if (!$pluginInfo) {
            return parent::getAmounts();
        } else {
            return $this->___callPlugins('getAmounts', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllItems()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllItems');
        if (!$pluginInfo) {
            return parent::getAllItems();
        } else {
            return $this->___callPlugins('getAllItems', func_get_args(), $pluginInfo);
        }
    }
}

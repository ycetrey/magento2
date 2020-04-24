<?php
namespace BrainActs\RewardPoints\Controller\Adminhtml\History\Customers;

/**
 * Interceptor class for @see \BrainActs\RewardPoints\Controller\Adminhtml\History\Customers
 */
class Interceptor extends \BrainActs\RewardPoints\Controller\Adminhtml\History\Customers implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $customerCollectionFactory);
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

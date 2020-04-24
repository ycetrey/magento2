<?php
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\MassDelete;

/**
 * Interceptor class for @see \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\MassDelete
 */
class Interceptor extends \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory);
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

<?php
namespace BrainActs\RewardPoints\Controller\Adminhtml\History\Delete;

/**
 * Interceptor class for @see \BrainActs\RewardPoints\Controller\Adminhtml\History\Delete
 */
class Interceptor extends \BrainActs\RewardPoints\Controller\Adminhtml\History\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory, \BrainActs\RewardPoints\Model\ResourceModel\History $resourceHistory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $historyFactory, $resourceHistory);
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

<?php
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\Index;

/**
 * Interceptor class for @see \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\Index
 */
class Interceptor extends \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistorInterface)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $dataPersistorInterface);
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

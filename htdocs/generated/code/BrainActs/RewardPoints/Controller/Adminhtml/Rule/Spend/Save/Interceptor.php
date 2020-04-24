<?php
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend\Save;

/**
 * Interceptor class for @see \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend\Save
 */
class Interceptor extends \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend\PostDataProcessor $dataProcessor, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $dataProcessor, $dataPersistor);
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

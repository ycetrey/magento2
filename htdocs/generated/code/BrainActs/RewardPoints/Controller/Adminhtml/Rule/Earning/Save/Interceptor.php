<?php
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\Save;

/**
 * Interceptor class for @see \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\Save
 */
class Interceptor extends \BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory, \BrainActs\RewardPoints\Model\Rule\SpendFactory $spendRuleFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $fileFactory, $dateFilter, $earningRuleFactory, $spendRuleFactory);
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

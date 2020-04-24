<?php
namespace Mageplaza\CustomerApproval\Console\Command\Approve;

/**
 * Interceptor class for @see \Mageplaza\CustomerApproval\Console\Command\Approve
 */
class Interceptor extends \Mageplaza\CustomerApproval\Console\Command\Approve implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Customer $customer, \Magento\Framework\App\State $appState, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface, \Mageplaza\CustomerApproval\Helper\Data $helperData, $name = null)
    {
        $this->___init();
        parent::__construct($customer, $appState, $customerRepositoryInterface, $helperData, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        if (!$pluginInfo) {
            return parent::run($input, $output);
        } else {
            return $this->___callPlugins('run', func_get_args(), $pluginInfo);
        }
    }
}

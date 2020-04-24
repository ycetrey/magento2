<?php
namespace Dotdigitalgroup\Email\Controller\Customer\Newsletter;

/**
 * Interceptor class for @see \Dotdigitalgroup\Email\Controller\Customer\Newsletter
 */
class Interceptor extends \Dotdigitalgroup\Email\Controller\Customer\Newsletter implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Dotdigitalgroup\Email\Helper\Data $helper, \Magento\Customer\Model\Session $session, \Dotdigitalgroup\Email\Model\ConsentFactory $consentFactory, \Magento\Framework\App\Action\Context $context, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory)
    {
        $this->___init();
        parent::__construct($helper, $session, $consentFactory, $context, $localeDate, $formKeyValidator, $customerRepository, $subscriberFactory);
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

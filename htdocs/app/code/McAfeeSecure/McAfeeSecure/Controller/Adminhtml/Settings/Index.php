<?php

namespace McAfeeSecure\McAfeeSecure\Controller\Adminhtml\Settings;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('McAfeeSecure_McAfeeSecure::settings');
        $resultPage->addBreadcrumb(__('TrustedSite'), __('TrustedSite'));
        $resultPage->addBreadcrumb(__('Settings'), __('Settings'));
        $resultPage->getConfig()->getTitle()->prepend(__('TrustedSite Settings'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('McAfeeSecure_McAfeeSecure::settings');
    }
}

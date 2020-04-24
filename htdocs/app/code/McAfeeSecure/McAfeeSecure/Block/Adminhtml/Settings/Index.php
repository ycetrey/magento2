<?php

namespace McAfeeSecure\McAfeeSecure\Block\Adminhtml\Settings;

use Magento\Backend\Block\Template;

class Index extends Template
{

    protected $backendAuthSession;

    public function __construct(Template\Context $context, \Magento\Backend\Model\Auth\Session $backendAuthSession, array $data = [])
    {
        $this->backendAuthSession = $backendAuthSession;
        parent::__construct($context, $data);
    }

    public function getHost()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getUserEmail()
    {
        if ($this->backendAuthSession->isLoggedIn()) {
            return $this->backendAuthSession->getUser()->getEmail();
        }

        return "";
    }
}

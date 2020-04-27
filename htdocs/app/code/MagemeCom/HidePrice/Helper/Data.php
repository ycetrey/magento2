<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    MagemeCom
 * @package     MagemeCom_HidePrice
 * @author      MageMe Team <support@mageme.com>
 * @copyright   Copyright (c) MageMe (https://mageme.com)
 * @license     https://mageme.com/license
 */

namespace MagemeCom\HidePrice\Helper;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package MagemeCom\HidePrice\Helper
 */
class Data extends AbstractHelper
{
    /** @var ScopeConfigInterface */
    protected $config;
    /** @var Session */
    protected $userSession;

    public function __construct(
        Context $context,
        Session $userSession
    )
    {
        parent::__construct(
            $context
        );
        $this->config      = $context->getScopeConfig();
        $this->userSession = $userSession;
    }

    /**
     * @return bool
     */
    public function hidePrice()
    {
        $isHidePriceEnabled = $this->config->getValue('hideprice/general/enable', ScopeInterface::SCOPE_STORE);
        $showForLoggedIn    = $this->config->getValue('hideprice/general/show_for_logged_in', ScopeInterface::SCOPE_STORE);
        $isUserLoggedIn     = $this->userSession->getCustomerGroupId() > 0;

        if (!$isHidePriceEnabled) {
            return false;
        }

        if ($showForLoggedIn && $isUserLoggedIn) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->userSession->isLoggedIn();
    }

    /**
     * @return integer
     */
    public function getGroupId()
    {
        return $this->userSession->getCustomerGroupId();
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Observer\Message;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;
use BrainActs\RewardPoints\Model\History;

/**
 * Class BeforeCreateCustomerAccount
 * @author BrainActs Core Team <support@brainacts.com>
 */
class AbstractMessage
{

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    public $helper;

    /**
     * AbstractMessage constructor.
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \BrainActs\RewardPoints\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \BrainActs\RewardPoints\Helper\Data $helper
    ) {
        $this->messageManager = $messageManager;
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
    }

    public function getBeforeRegistrationMessage()
    {
        $points = $this->helper->getRegistrationRulePoints();
        if (!empty($points)) {
            return __('You will receive %1 points after registration.', $points);
        }

        return false;
    }

    public function getAfterRegistrationMessage()
    {
        $points = $this->helper->getRegistrationRulePoints();
        if (!empty($points)){
            return __('%1 Reward Points have been added to your balance.', $points);
        }

        return false;
    }

    public function getBeforeShareWishListMessage()
    {
        $points = $this->helper->getShareWishListRulePoints();
        if (!empty($points)) {
            return __('You will receive %1 points for sharing the wish list.', $points);
        }
        return false;
    }

    public function getAfterShareWishListMessage()
    {
        $points = $this->helper->getShareWishListRulePoints();
        if (!empty($points)) {
            return __('%1 Reward Points have been added to your balance.', $points);
        }
        return false;
    }

    public function getAfterPlaceOrderMessage($points)
    {
        if (!empty($points)) {
            return __('%1 Reward Points have been added to your balance.', $points);
        }
        return false;
    }


}


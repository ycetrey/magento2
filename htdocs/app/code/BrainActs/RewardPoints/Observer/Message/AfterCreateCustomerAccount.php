<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Observer\Message;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class AfterCreateCustomerAccount
 * @author BrainActs Core Team <support@brainacts.com>
 */
class AfterCreateCustomerAccount extends AbstractMessage implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->helper->isEnabled() && $this->getAfterRegistrationMessage()) {
            $this->messageManager->addNoticeMessage($this->getAfterRegistrationMessage());
        }
    }
}

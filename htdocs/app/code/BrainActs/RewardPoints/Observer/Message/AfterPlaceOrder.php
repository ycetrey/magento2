<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Observer\Message;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class AfterPlaceOrder
 * @author BrainActs Core Team <support@brainacts.com>
 */
class AfterPlaceOrder extends AbstractMessage
{

    /**
     * @param $points
     */
    public function showMessage($points)
    {
        if ($this->helper->isEnabled() && $this->getAfterPlaceOrderMessage($points)) {
            $this->messageManager->addNoticeMessage($this->getAfterPlaceOrderMessage($points));
        }
    }
}

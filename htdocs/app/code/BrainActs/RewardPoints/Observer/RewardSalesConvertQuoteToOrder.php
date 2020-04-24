<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class RewardSalesConvertQuoteToOrder
 * @author BrainActs Commerce OÜ Core Team <support@brainacts.com>
 */
class RewardSalesConvertQuoteToOrder implements ObserverInterface
{

    /**
     * Setup Reward Points Amount to Order(magento default logic to convert quote to order does not work ~2.1.7)
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getData('order');
        $quote = $observer->getData('quote');

        $order->setRewardPointsAmount($quote->getRewardPointsAmount());
    }
}

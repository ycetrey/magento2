<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\Order\Invoice\Total;

/**
 * Class Points
 * @author BrainActs Commerce OÜ Core Team <support@brainacts.com>
 */
class Points extends \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $points = $invoice->getOrder()->getRewardPointsAmount();
        $invoice->setGrandTotal($invoice->getGrandTotal() - $points);
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $points);
        return $this;
    }
}

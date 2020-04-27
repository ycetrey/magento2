<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model;

/**
 * Class Utility
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Utility
{
    /**
     * Check if rule can be applied for specific address/quote/customer
     *
     * @param  \BrainActs\RewardPoints\Model\Rule\Earning $rule
     * @param  \Magento\Quote\Model\Quote\Address         $address
     * @return bool
     */
    public function canProcessRule($rule, $address)
    {
        if ($rule->hasIsValidForAddress($address) && !$address->isObjectNew()) {
            return $rule->getIsValidForAddress($address);
        }

        $rule->afterLoad();
        /**
         * quote does not meet rule's conditions
         */
        if (!$rule->validate($address)) {
            $rule->setIsValidForAddress($address, false);
            return false;
        }
        /**
         * passed all validations, remember to be valid
         */
        $rule->setIsValidForAddress($address, true);
        return true;
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\Customer;

use Magento\Customer\Controller\Adminhtml\Index;

/**
 * Class History
 * @author BrainActs Core Team <support@brainacts.com>
 */
class History extends Index
{
    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}

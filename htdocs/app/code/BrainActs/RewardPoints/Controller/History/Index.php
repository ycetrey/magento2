<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Controller\History;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Index extends \BrainActs\RewardPoints\Controller\AbstractIndex
{

    /**
     * Display customer reward points history
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\Rule\Spend\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class GenericButton
{
    /**
     * @var Context
     */
    public $context;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Generate url by route and parameters
     *
     * @param  string $route
     * @param  array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return Rule ID
     *
     * @return int|null
     */
    public function getRuleId()
    {
        try {
            return $this->context->getRequest()->getParam('spend_rule_id');
        } catch (NoSuchEntityException $e) {

        }
        return null;
    }
}

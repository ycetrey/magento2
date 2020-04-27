<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\Rule\Earning\Edit;

/**
 * Class GenericButton
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    public $urlBuilder;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * Return the current sales Rule Id.
     *
     * @return int|null
     */
    public function getRuleId()
    {
        $rule = $this->registry->registry(\BrainActs\RewardPoints\Model\RegistryConstants::CURRENT_REWARD_POINTS_RULE);
        return $rule ? $rule->getId() : null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * Check where button can be rendered
     *
     * @param  string $name
     * @return string
     */
    public function canRender($name)
    {
        return $name;
    }
}

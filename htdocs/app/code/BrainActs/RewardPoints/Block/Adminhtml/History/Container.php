<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\History;

/**
 * Class Add
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Container extends \Magento\Backend\Block\Template
{

    /**
     * Get the url for save
     *
     * @return string
     */
    public function getSaveUrl()
    {
        if ($this->getTemplateId()) {
            $params = ['template_id' => $this->getTemplateId()];
        } else {
            $params = ['id' => $this->getRequest()->getParam('id')];
        }
        return $this->getUrl('*/*/save', $params);
    }

    public function getCustomerUrl()
    {
        return $this->getUrl('*/*/customers', []);
    }
}

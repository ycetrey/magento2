<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend;

use BrainActs\RewardPoints\Controller\Adminhtml\Rule\AbstractRule;

/**
 * Class Delete
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Delete extends AbstractRule
{
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_spend_delete';
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('spend_rule_id');
        if ($id) {
            try {
                $model = $this->spendRuleFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the rule.'));
                $this->_redirect('points/rule_spend/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t delete the rule right now. Please review the log and try again.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('points/rule_spend/edit', ['id' => $this->getRequest()->getParam('spend_rule_id')]);
                return;
            }
        }
        $this->messageManager->addError(__('We can\'t find a rule to delete.'));
        $this->_redirect('points/rule_spend/');
    }
}

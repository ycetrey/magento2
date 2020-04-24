<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning;

use BrainActs\RewardPoints\Controller\Adminhtml\Rule\AbstractRule;

/**
 * Class Save
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Save extends AbstractRule
{
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_earning_save';

    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                /** @var $model \BrainActs\RewardPoints\Model\Rule\Earning */
                $model = $this->earningRuleFactory->create();
                $data = $this->getRequest()->getPostValue();

                $inputFilter = new \Zend_Filter_Input(
                    ['from_date' => $this->dateFilter, 'to_date' => $this->dateFilter],
                    [],
                    $data,
                    ['allowEmpty' => true]
                );

                if (array_key_exists('from_date', $data)) {
                    $data['from_date'] = trim($data['from_date']) ? $inputFilter->getUnescaped('from_date') : '';
                }
                if (array_key_exists('to_date', $data)) {
                    $data['to_date'] = trim($data['to_date']) ? $inputFilter->getUnescaped('to_date') : '';
                }
                $id = $this->getRequest()->getParam('earning_rule_id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong rule is specified.'));
                    }
                }

                $session = $this->_objectManager->get('Magento\Backend\Model\Session');

                $validateResult = $model->validateData(new \Magento\Framework\DataObject($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) {
                        $this->messageManager->addError($errorMessage);
                    }
                    $session->setPageData($data);
                    $this->_redirect('points/rule_earning/edit', ['id' => $model->getId()]);
                    return;
                }

                if (isset($data['rule']['conditions'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                }
                unset($data['rule']);

                $model->loadPost($data);

                $session->setPageData($model->getData());

                $model->save();

                $this->messageManager->addSuccess(__('You saved the rule.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('points/rule_earning/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('points/rule_earning/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('earning_rule_id');
                if (!empty($id)) {
                    $this->_redirect('points/rule_earning/edit', ['id' => $id]);
                } else {
                    $this->_redirect('points/rule_earning/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the rule data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect(
                    'points/rule_earning/edit',
                    [
                        'id' => $this->getRequest()->getParam('earning_rule_id')
                    ]
                );
                return;
            }
        }
        $this->_redirect('points/rule_earning/*');
    }
}

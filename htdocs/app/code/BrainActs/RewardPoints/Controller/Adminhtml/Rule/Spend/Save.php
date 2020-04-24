<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend;

use Magento\Backend\App\Action;
use BrainActs\RewardPoints\Model\Rule\Spend;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_spend_save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Action\Context         $context
     * @param PostDataProcessor      $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Spend::STATUS_ENABLED;
            }
            if (empty($data['spend_rule_id'])) {
                $data['spend_rule_id'] = null;
            }

            /** @var \BrainActs\RewardPoints\Model\Rule\Spend $model */
            $model = $this->_objectManager->create('BrainActs\RewardPoints\Model\Rule\Spend');

            $id = $this->getRequest()->getParam('spend_rule_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->dataPersistor->set('reward_points', $data);
                return $resultRedirect->setPath('*/rule_spend/edit', ['spend_rule_id' => $model->getId(), '_current' => true]);
            }

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the rule.'));
                $this->dataPersistor->clear('reward_points');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/rule_spend/edit', ['spend_rule_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/rule_spend/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the rule.'));
            }

            $this->dataPersistor->set('reward_points', $data);
            return $resultRedirect->setPath('*/rule_spend/edit', ['spend_rule_id' => $this->getRequest()->getParam('spend_rule_id')]);
        }
        return $resultRedirect->setPath('*/rule_spend/');
    }
}

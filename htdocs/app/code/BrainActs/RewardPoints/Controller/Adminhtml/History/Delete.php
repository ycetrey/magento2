<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\History;

use \Magento\Backend\App\Action;

/**
 * Class Delete
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::history_delete';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \BrainActs\RewardPoints\Model\HistoryFactory
     */
    private $historyFactory;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History
     */
    private $resourceHistory;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History $resourceHistory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory,
        \BrainActs\RewardPoints\Model\ResourceModel\History $resourceHistory
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->historyFactory = $historyFactory;
        $this->resourceHistory = $resourceHistory;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('history_id');

        if ($id) {
            try {
                // init model and delete

                /** @var \BrainActs\RewardPoints\Model\History $model */
                $history = $this->historyFactory->create();
                $this->resourceHistory->load($history, $id);

                $history->setIsDeleted(1);
                $this->resourceHistory->save($history);

                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the history item.'));

                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/*');
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a history item to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

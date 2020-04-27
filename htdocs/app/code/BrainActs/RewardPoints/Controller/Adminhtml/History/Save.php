<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\History;

use \Magento\Backend\App\Action;
use Magento\Backend\Model\Auth\Session;

/**
 * Class Delete
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::history_save';

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
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var Session
     */
    private $adminSession;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History $resourceHistory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param Session $adminSession
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \BrainActs\RewardPoints\Model\HistoryFactory $historyFactory,
        \BrainActs\RewardPoints\Model\ResourceModel\History $resourceHistory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Session $adminSession
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->historyFactory = $historyFactory;
        $this->resourceHistory = $resourceHistory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->adminSession = $adminSession;
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

        $result = $this->resultJsonFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $data['history_id'] = null;
                $data['modifier_id'] = $this->adminSession->getUser()->getId();
                $data['modifier_name'] = $this->adminSession->getUser()->getName();
                $data['rule_name'] = __('Custom Update By Manager');

                if ($data['type_rule'] == 1) {
                    $data['points'] = abs($data['points']);
                }

                if ($data['type_rule'] == 2) {
                    $data['points'] = abs($data['points']) * (-1);
                }
                // init model and save

                /**
                 * @var \BrainActs\RewardPoints\Model\History $model
                 */
                $history = $this->historyFactory->create();
                $history->setData($data);
                $this->resourceHistory->save($history);

                // display success message
                $this->messageManager->addSuccessMessage(__('You apply additional rule to customer.'));

                // go to grid
                $result->setData(['redirect' => $this->_backendUrl->getUrl('points/history/')]);
                return $result;
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());

                // go back to edit form
                $result->setData(['redirect' => $this->_backendUrl->getUrl('points/history/')]);
                return $result;
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t  apply additional rule to customer.'));

        // go to grid
        $result->setData(['redirect' => $this->_backendUrl->getUrl('points/history/')]);
        return $result;
    }
}

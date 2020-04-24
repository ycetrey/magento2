<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Rules
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_earning';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * Rules constructor.
     *
     * @param Context                $context
     * @param PageFactory            $resultPageFactory
     * @param DataPersistorInterface $dataPersistorInterface
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistorInterface
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistorInterface;
    }

    /**
     * Action to show grid page with earning rules
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('BrainActs_RewardPoints::reward_earning_rule');
        $resultPage->getConfig()->getTitle()->prepend(__('Earning Rules'));
        $this->dataPersistor->clear('reward_points');

        return $resultPage;
    }
}

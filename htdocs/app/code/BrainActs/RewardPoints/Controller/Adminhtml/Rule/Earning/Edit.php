<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Earning;

class Edit extends \BrainActs\RewardPoints\Controller\Adminhtml\Rule\AbstractRule
{
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_earning_save';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param \Magento\Backend\App\Action\Context               $context
     * @param \Magento\Framework\Registry                       $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory  $fileFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date    $dateFilter
     * @param \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory
     * @param \BrainActs\RewardPoints\Model\Rule\SpendFactory   $spendRuleFactory
     * @param \Magento\Framework\View\Result\PageFactory        $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory,
        \BrainActs\RewardPoints\Model\Rule\SpendFactory $spendRuleFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $coreRegistry, $fileFactory, $dateFilter, $earningRuleFactory, $spendRuleFactory);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * View Edit/New Page
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->earningRuleFactory->create();

        $this->coreRegistry
            ->register(\BrainActs\RewardPoints\Model\RegistryConstants::CURRENT_REWARD_POINTS_RULE, $model);

        $resultPage = $this->resultPageFactory->create();
        if ($id) {
            $model->load($id);

            if (!$model->getRuleId()) {
                $this->messageManager->addError(__('This rule no longer exists.'));
                $this->_redirect('points/rule_earning/*');
                return;
            }
            $model->getConditions()->setFormName('points_earning_form');
            $model->getConditions()->setJsFormObject(
                $model->getConditionsFieldSetId($model->getConditions()->getFormName())
            );
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->initAction();

        $this->_addBreadcrumb($id ? __('Edit Rule') : __('New Rule'), $id ? __('Edit Rule') : __('New Rule'));

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getRuleId() ? $model->getName() : __('New Reward Points Rule')
        );
        $this->_view->renderLayout();
    }
}

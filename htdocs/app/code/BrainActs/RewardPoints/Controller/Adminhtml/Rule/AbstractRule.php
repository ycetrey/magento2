<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule;

abstract class AbstractRule extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_earning';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    public $coreRegistry = null;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    public $fileFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    public $dateFilter;

    /**
     * @var \BrainActs\RewardPoints\Model\Rule\EarningFactory
     */
    public $earningRuleFactory;

    /**
     * @var \BrainActs\RewardPoints\Model\Rule\SpendFactory
     */
    public $spendRuleFactory;

    /**
     * AbstractRule constructor.
     *
     * @param \Magento\Backend\App\Action\Context               $context
     * @param \Magento\Framework\Registry                       $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory  $fileFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date    $dateFilter
     * @param \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory
     * @param \BrainActs\RewardPoints\Model\Rule\SpendFactory   $spendRuleFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory,
        \BrainActs\RewardPoints\Model\Rule\SpendFactory $spendRuleFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->fileFactory = $fileFactory;
        $this->dateFilter = $dateFilter;
        $this->earningRuleFactory = $earningRuleFactory;
        $this->spendRuleFactory = $spendRuleFactory;
    }

    /**
     * Initiate rule
     *
     * @return void
     */
    //    public function _initRule()
    //    {
    //        $this->coreRegistry->register(
    //            \BrainActs\RewardPoints\Model\RegistryConstants::CURRENT_REWARD_POINTS_RULE,
    //            $this->objectManager->create('Magento\SalesRule\Model\Rule')
    //        );
    //        $id = (int)$this->getRequest()->getParam('id');
    //
    //        if (!$id && $this->getRequest()->getParam('rule_id')) {
    //            $id = (int)$this->getRequest()->getParam('rule_id');
    //        }
    //
    //        if ($id) {
    //            $this->coreRegistry->registry(\BrainActs\RewardPoints\Model\RegistryConstants::CURRENT_REWARD_POINTS_RULE)
    //                ->load($id);
    //        }
    //    }

    /**
     * Initiate action
     *
     * @return $this
     */
    public function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('BrainActs_RewardPoints::reward_earning_rule')
            ->_addBreadcrumb(__('Reward Points'), __('Reward Points'));

        return $this;
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend;

/**
 * Class NewAction
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class NewAction extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'BrainActs_RewardPoints::rule_spend_save';

    /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    private $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context               $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /**
 * @var \Magento\Backend\Model\View\Result\Forward $resultForward
*/
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}

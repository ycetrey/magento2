<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\DB\Select;

/**
 * Class Data
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Data extends AbstractHelper
{

    const XML_PATH_ENABLED = 'brainacts_reward_points/general/enabled';

    const XML_PATH_RESTRICT_PERMISSION = 'brainacts_reward_points/admin/report_access_role';

    /**
     * @var Session
     */
    private $adminSession;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\CollectionFactory
     */
    private $ruleCollectionFactory;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $historyCollectionFactory;

    /**
     * Data constructor.
     * @param Context $context
     * @param Session $adminSession
     * @param \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\CollectionFactory $ruleCollectionFactory
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory
     */
    public function __construct(
        Context $context,
        Session $adminSession,
        \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\CollectionFactory $ruleCollectionFactory,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory
    ) {
    
        $this->adminSession = $adminSession;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->historyCollectionFactory = $historyCollectionFactory;
        parent::__construct($context);
    }

    public function isAllowFullAccess($store = null)
    {
        $currentUserRole = $this->adminSession->getUser()->getRole()->getId();

        $configReportRole = $this->scopeConfig->getValue(
            self::XML_PATH_RESTRICT_PERMISSION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );

        if ($configReportRole == $currentUserRole || $configReportRole == null || empty($configReportRole)) {
            return true;
        }
        return false;
    }

    public function isEnabled($store = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getRule($storeId, $customerGroupId)
    {
        $collection = $this->ruleCollectionFactory->create();
        $collection->addFieldToFilter('store_id', ['eq' => $storeId]);
        $collection->addFieldToFilter('group_id', ['eq' => $customerGroupId]);
        $collection->addFieldToFilter('is_active', ['eq' => 1]);//active
        $collection->setPageSize(1);
        $collection->setCurPage(1);

        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }

        $collection = $this->ruleCollectionFactory->create();
        $collection->addFieldToFilter('store_id', ['eq' => 0]);//all
        $collection->addFieldToFilter('group_id', ['eq' => $customerGroupId]);
        $collection->addFieldToFilter('is_active', ['eq' => 1]);//active
        $collection->setPageSize(1);
        $collection->setCurPage(1);

        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }

        return false;
    }

    /**
     * @param $customerId
     * @return float
     */
    public function getCustomerPoints($customerId)
    {
        if (!$customerId) {
            return 0;
        }
        /**
 * @var \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\Collection $collection
*/
        $collection = $this->historyCollectionFactory->create();

        $collection->getSelect()->reset(Select::COLUMNS)
            ->columns(['total' => new \Zend_Db_Expr('SUM(points)')])->group('customer_id');

        $collection->addFieldToFilter('customer_id', ['eq' => $customerId]);
        $collection->load();
        $item = $collection->fetchItem();
        if ($item) {
            return $item->getData('total');
        }
        return 0;
    }

    public function getRegistrationRulePoints()
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->getValue(
            'brainacts_reward_points/rules/register',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getShareWishListRulePoints()
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->getValue(
            'brainacts_reward_points/rules/wishlist',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSubmitReviewRulePoints()
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->getValue(
            'brainacts_reward_points/rules/review',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}

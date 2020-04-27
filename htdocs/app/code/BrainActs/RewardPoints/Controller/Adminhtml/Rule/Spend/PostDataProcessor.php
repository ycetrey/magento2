<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\Rule\Spend;

/**
 * Class PostDataProcessor
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    private $dateFilter;

    /**
     * @var \Magento\Framework\View\Model\Layout\Update\ValidatorFactory
     */
    private $validatorFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\CollectionFactory
     */
    private $collectionFactory;

    /**
     * PostDataProcessor constructor.
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory
     * @param \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\CollectionFactory $spendRuleCollectionFactory
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory,
        \BrainActs\RewardPoints\Model\ResourceModel\Rule\Spend\CollectionFactory $spendRuleCollectionFactory
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
        $this->collectionFactory = $spendRuleCollectionFactory;
    }

    /**
     * Validate post data
     *
     * @param  array $data
     * @return bool     Return FALSE if someone item is invalid
     */
    public function validate($data)
    {
        $errorNo = true;

        $storeId = $data['store_id'];

        $id = $data['spend_rule_id'] ? $data['spend_rule_id'] : false;
        if ($storeId === '0') {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('group_id', ['eq' => $data['group_id']]);
            if ($id) {
                $collection->addFieldToFilter('spend_rule_id', ['neq' => $id]);
            }
            if ($collection->getSize() > 0) {
                $names = $collection->getColumnValues('name');
                $errorNo = false;
                $name = implode(', ', $names);
                $this->messageManager->addError(__('This rule will conflict with another rule: "%1"', $name));
            }
        } else {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('group_id', ['eq' => $data['group_id']]);
            $collection->addFieldToFilter('store_id', ['eq' => $storeId]);
            if ($id) {
                $collection->addFieldToFilter('spend_rule_id', ['neq' => $id]);
            }
            if ($collection->getSize() > 0) {
                $names = $collection->getColumnValues('name');
                $errorNo = false;
                $name = implode(', ', $names);
                $this->messageManager->addError(__('This rule will conflict with another rule: "%1"', $name));
            }
        }

        return $errorNo;
    }

    /**
     * Check if required fields is not empty
     *
     * @param  array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'name' => __('Page Title'),
            'group_id' => __('Customer Group'),
            'store_id' => __('Store'),
            'points' => __('Points'),
            'amount' => __('Amount'),
            'is_active' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}

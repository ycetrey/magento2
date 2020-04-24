<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller\Adminhtml\History;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

/**
 * Class LoadBlock
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Customers extends Action
{

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\CustomerFactory
     */
    private $customerCollectionFactory;

    /**
     * Customers constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
    ) {
    
        $this->resultJsonFactory = $resultJsonFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $customer = trim($this->getRequest()->getParam('search'));
        /**
         * @var \Magento\Customer\Model\ResourceModel\Customer\Collection $collection
         */
        $collection = $this->customerCollectionFactory->create();
        if ($customer) {
            $searchString = '%' . $customer . '%';

            $attributes = [
                ['attribute' => 'email', 'like' => $searchString],
                ['attribute' => 'firstname', 'like' => $searchString],
                ['attribute' => 'lastname', 'like' => $searchString]
            ];
            $collection->addAttributeToFilter($attributes);
        }
        $collection->load();
        $data = $collection->toArray(['entity_id', 'created_in', 'firstname', 'lastname']);
        sort($data);
        $result->setData(['customers' => $data]);
        return $result;
    }
}

<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace BrainActs\RewardPoints\Model\EarningRule\Metadata;

use BrainActs\RewardPoints\Model\Rule\Earning;
use Magento\SalesRule\Model\ResourceModel\Rule\Collection;
use Magento\Store\Model\System\Store;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Convert\DataObject;

/**
 * Class ValueProvider
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class ValueProvider
{
    /**
     * @var Store
     */
    private $store;

    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var DataObject
     */
    private $objectConverter;

    /**
     * @var \BrainActs\RewardPoints\Model\Rule\EarningFactory
     */
    private $earningRuleFactory;

    /**
     * ValueProvider constructor.
     *
     * @param Store                                             $store
     * @param GroupRepositoryInterface                          $groupRepository
     * @param SearchCriteriaBuilder                             $searchCriteriaBuilder
     * @param DataObject                                        $objectConverter
     * @param \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory
     */
    public function __construct(
        Store $store,
        GroupRepositoryInterface $groupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DataObject $objectConverter,
        \BrainActs\RewardPoints\Model\Rule\EarningFactory $earningRuleFactory
    ) {
        $this->store = $store;
        $this->groupRepository = $groupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->objectConverter = $objectConverter;
        $this->earningRuleFactory = $earningRuleFactory;
    }

    /**
     * Get metadata for rule form. It will be merged with form UI component declaration.
     *
     * @param  Earning $rule
     * @return array
     */
    public function getMetadataValues(Earning $rule)
    {
        $customerGroups = $this->groupRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        return [
            'rule_information' => [
                'children' => [
                    'website_ids' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->store->getWebsiteValuesForForm(),
                                ],
                            ],
                        ],
                    ],
                    'is_active' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Active'), 'value' => '1'],
                                        ['label' => __('Inactive'), 'value' => '0']
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'customer_group_ids' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->objectConverter->toOptionArray($customerGroups, 'id', 'code'),
                                ],
                            ],
                        ],
                    ],

                ]
            ],
            'actions' => [
                'children' => [
                    'points' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => '0',
                                ],
                            ],
                        ],
                    ],
                    'stop_rules_processing' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Yes'), 'value' => '1'],
                                        ['label' => __('No'), 'value' => '0'],
                                    ],
                                ],
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }
}

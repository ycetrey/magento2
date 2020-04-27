<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item\AbstractItem;

/**
 * Validator Model
 *
 * Allows dispatching before and after events for each controller action
 *
 * @method mixed getCouponCode()
 * @method Validator setCouponCode($code)
 * @method mixed getWebsiteId()
 * @method Validator setWebsiteId($id)
 * @method mixed getCustomerGroupId()
 * @method Validator setCustomerGroupId($id)
 */
class Validator extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Rule source collection
     *
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\Collection
     */
    private $rules;

    /**
     * Catalog data
     *
     * @var \Magento\Catalog\Helper\Data|null
     */
    private $catalogData = null;

    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Utility
     */
    private $validatorUtility;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * Counter is used for assigning temporary id to quote address
     *
     * @var int
     */
    private $counter = 0;

    /**
     * Validator constructor.
     *
     * @param \Magento\Framework\Model\Context                             $context
     * @param \Magento\Framework\Registry                                  $registry
     * @param ResourceModel\Rule\Earning\CollectionFactory                 $collectionFactory
     * @param \Magento\Catalog\Helper\Data                                 $catalogData
     * @param Utility                                                      $utility
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface            $priceCurrency
     * @param \Magento\Framework\Message\ManagerInterface                  $messageManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null           $resourceCollection
     * @param array                                                        $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \BrainActs\RewardPoints\Model\ResourceModel\Rule\Earning\CollectionFactory $collectionFactory,
        \Magento\Catalog\Helper\Data $catalogData,
        \BrainActs\RewardPoints\Model\Utility $utility,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->catalogData = $catalogData;
        $this->validatorUtility = $utility;
        $this->priceCurrency = $priceCurrency;
        $this->messageManager = $messageManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Init validator
     * Init process load collection of rules for specific website,
     * customer group
     *
     * @param  int $websiteId
     * @param  int $customerGroupId
     * @return $this
     */
    public function init($websiteId, $customerGroupId)
    {
        $this->setWebsiteId($websiteId)
            ->setCustomerGroupId($customerGroupId);

        return $this;
    }

    /**
     * Get rules collection for current object state
     *
     * @param  Address|null $address
     * @return \Magento\SalesRule\Model\ResourceModel\Rule\Collection
     */
    private function getRules(Address $address = null)
    {

        $addressId = $this->getAddressId($address);
        $key = $this->getWebsiteId() . '_' . $this->getCustomerGroupId() . '_' . $addressId;
        if (!isset($this->rules[$key])) {
            $this->rules[$key] = $this->collectionFactory->create()
                ->setValidationFilter(
                    $this->getWebsiteId(),
                    $this->getCustomerGroupId(),
                    null
                )
                ->addFieldToFilter('is_active', 1)
                ->load();
        }
        return $this->rules[$key];
    }

    /**
     * @param Address $address
     * @return string
     */
    private function getAddressId(Address $address)
    {
        if ($address == null) {
            return '';
        }
        if (!$address->hasData('address_sales_rule_id')) {
            if ($address->hasData('address_id')) {
                $address->setData('address_sales_rule_id', $address->getData('address_id'));
            } else {
                $type = $address->getAddressType();
                $tempId = $type . $this->counter++;
                $address->setData('address_sales_rule_id', $tempId);
            }
        }
        return $address->getData('address_sales_rule_id');
    }

    /**
     * Can apply rules check
     *
     * @param  AbstractItem $item
     * @return bool
     */
    public function canApplyRules(AbstractItem $item)
    {
        $address = $item->getAddress();
        $rules = $this->getRules($address);
        foreach ($rules as $rule) {
            if (!$this->validatorUtility->canProcessRule($rule, $address)) {
                return false;
            }
        }
        if ($rules->getSize() == 0) {
            return false;
        }
        return true;
    }

    /**
     * @param AbstractItem $item
     * @param $quote
     * @return array
     */
    public function process(AbstractItem $item, $quote)
    {
        $appliedRuleIds = $this->applyRules(
            $item,
            $this->getRules($item->getAddress()),
            $quote
        );

        return $appliedRuleIds;
    }

    public function applyRules($item, $rules, $quote)
    {

        $address = $item->getAddress();

        /**
 * @var \Magento\Quote\Model\Quote $quote
*/
        //        $quote = $item->getQuote();
        //        $quote->setTotalsCollectedFlag(false);
        //        $totals = $quote->collectTotals()->getTotals();
        //
        //
        $address = $quote->getShippingAddress();
        $appliedRuleIds = [];
        $address->setData('total_qty', $quote->getItemsQty());
        /**
 * @var $rule \BrainActs\RewardPoints\Model\Rule\Earning
*/
        foreach ($rules as $rule) {
            if (!$this->validatorUtility->canProcessRule($rule, $address)) {
                continue;
            }
            $appliedRuleIds[$rule->getRuleId()] = $rule->getRuleId();

            if ($rule->getStopRulesProcessing()) {
                break;
            }
        }

        return $appliedRuleIds;
    }
}

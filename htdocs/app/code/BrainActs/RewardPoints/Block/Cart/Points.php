<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Cart;

/**
 * Class Points
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Points extends \Magento\Checkout\Block\Cart\AbstractCart
{

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $historyCollectionFactory;

    /**
     * @var null
     */
    private $points = null;

    /**
     * @var null
     */
    private $money = null;

    private $moneyWithoutFormat = null;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    private $pricingHelper;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $pointsHelper;

    /**
     * Points constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context                      $context
     * @param \Magento\Customer\Model\Session                                       $customerSession
     * @param \Magento\Checkout\Model\Session                                       $checkoutSession
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory
     * @param \BrainActs\RewardPoints\Helper\Data                                   $pointsHelper
     * @param \Magento\Framework\Pricing\Helper\Data                                $pricingHelper
     * @param array                                                                 $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory,
        \BrainActs\RewardPoints\Helper\Data $pointsHelper,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $data);
        $this->_isScopePrivate = true;
        $this->historyCollectionFactory = $historyCollectionFactory;
        $this->pricingHelper = $pricingHelper;
        $this->pointsHelper = $pointsHelper;
    }

    /**
     * Return points from customer account
     *
     * @return mixed|null
     */
    public function getCustomerPoints()
    {
        if ($this->points == null) {
            $this->points = $this->pointsHelper->getCustomerPoints($this->_customerSession->getCustomerId());
            $this->convertToCurrency($this->points);
        }
        return $this->points;
    }

    /**
     * Convert points to
     *
     * @param  $points
     * @return bool|float|null|string
     */
    private function convertToCurrency($points)
    {
        $rule = $this->getConvertRule();
        if (!$rule) {
            $this->money = 0;
            return false;
        }

        $exchange = $rule->getPoints() / $rule->getAmount();

        $this->money = round($points / $exchange, 2);

        $this->moneyWithoutFormat = $this->money;

        $optionPrice = $this->pricingHelper->currency($this->money, true, false);
        $this->money = $optionPrice;

        return $this->money;
    }

    /**
     * @return null
     */
    public function getMoney()
    {
        if ($this->money == null) {
            $this->getCustomerPoints();
        }
        return $this->money;
    }

    private function getConvertRule()
    {
        $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();

        return $this->pointsHelper->getRule($this->_storeManager->getStore()->getId(), $customerGroupId);
    }

    public function isVisible()
    {
        if (!$this->getCustomerPoints()) {
            return false;
        }

        if (!$this->pointsHelper->isEnabled()) {
            return false;
        }

        //check rules for this store and customer group
        $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
        $rule = $this->pointsHelper->getRule($this->_storeManager->getStore()->getId(), $customerGroupId);
        if (!$rule) {
            return false;
        }

        return $rule;
    }

    public function getMaxPoints()
    {
        $subtotal = $this->_checkoutSession->getQuote()->getSubtotal();
        $rule = $this->getConvertRule();

        $exchange = $rule->getPoints() / $rule->getAmount();
        $maxPoints = $subtotal * $exchange;
        return $maxPoints;
    }

    public function getSelectedPoints()
    {
        $quote = $this->_checkoutSession->getQuote();
        $selectedPoints = $quote->getRewardPoints();
        return $selectedPoints ? $selectedPoints : 0;
    }
}

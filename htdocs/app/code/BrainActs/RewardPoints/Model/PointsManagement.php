<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model;

use BrainActs\RewardPoints\Api\PointsManagementInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\DB\Select;

/**
 * Class PointsManagement
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class PointsManagement implements PointsManagementInterface
{
    /**
     * Quote repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $historyCollectionFactory;

    /**
     * @var \BrainActs\RewardPoints\Helper\Data
     */
    private $pointsHelper;

    private $rule;

    /**
     * PointsManagement constructor.
     *
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \BrainActs\RewardPoints\Helper\Data        $pointsHelper
     * @param ResourceModel\History\CollectionFactory    $historyCollectionFactory
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \BrainActs\RewardPoints\Helper\Data $pointsHelper,
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->pointsHelper = $pointsHelper;
        $this->historyCollectionFactory = $historyCollectionFactory;
    }

    /**
     * @param int    $cartId
     * @param string $rewardPoints
     * @return bool
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function set($cartId, $rewardPoints)
    {

        /**
 * @var  \Magento\Quote\Model\Quote $quote
*/
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $quote->getShippingAddress()->setCollectShippingRates(true);

        try {
            $amount = $this->_validate($rewardPoints, $quote);
            $quote->setRewardPointsAmount($amount);
            $quote->setRewardPoints($rewardPoints);
            $quote->setRewardPointsRule($this->rule->getId());
            $this->quoteRepository->save($quote->collectTotals());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not apply reward points'));
        }

        return true;
    }

    /**
     * @param $points
     * @param $quote
     * @return float
     * @throws \Exception
     */
    private function _validate($points, $quote)
    {
        if ($points > $this->getAvailablePoints($quote)) {
            throw new \Exception(__('Could not apply reward points'));
        }

        $rule = $this->pointsHelper->getRule($quote->getStoreId(), $quote->getCustomerGroupId());

        $this->rule = $rule;

        $subtotal = $quote->getSubtotal();

        $exchange = $rule->getPoints() / $rule->getAmount();

        $amount = round($points / $exchange, 2);

        if ($amount > $subtotal) {
            throw new \Exception(__('Could not apply reward points'));
        }

        return $amount;
    }

    private function getAvailablePoints($quote)
    {
        /**
 * @var \BrainActs\RewardPoints\Model\ResourceModel\History\Collection $collection
*/
        $collection = $this->historyCollectionFactory->create();
        $collection->getSelect()->reset(Select::COLUMNS)
            ->columns(['total' => new \Zend_Db_Expr('SUM(points)')])->group('customer_id');
        $collection->addFieldToFilter('customer_id', ['eq' => $quote->getCustomerId()]);
        $collection->load();
        $item = $collection->fetchItem();
        return $item->getData('total');
    }
}

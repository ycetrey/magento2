<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Cron;

use Magento\Store\Model\ScopeInterface;
use BrainActs\RewardPoints\Model\History;

/**
 * Class ValidateExpirationPoints
 * @author BrainActs Core Team <support@brainacts.com>
 */
class ValidateExpirationPoints
{
    /**
     * @var \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ValidateExpirationPoints constructor.
     * @param \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \BrainActs\RewardPoints\Model\ResourceModel\History\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {

        $days = $this->getExpirationDay();

        if ($days) {
            /** @var \BrainActs\RewardPoints\Model\ResourceModel\History\Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addExpiredFilter($days);

            /** @var \BrainActs\RewardPoints\Model\History $item */
            foreach ($collection as $item) {
                $item->setData('is_expired', 1);

                try {
                    $item->save();

                } catch (\Exception $e) {

                }
            }
        }

    }

    /**
     * Check if need setup expiration for history table
     * @return bool|int
     */
    private function getExpirationDay()
    {
        $isActiveExpiration = (bool)$this->scopeConfig
            ->getValue(History::POINTS_EXPIRATION_XML, ScopeInterface::SCOPE_STORE);

        if (!$isActiveExpiration) {
            return false;
        }

        $expirationPeriod = $this->scopeConfig
            ->getValue(History::POINTS_EXPIRATION_PERIOD_XML, ScopeInterface::SCOPE_STORE);

        if (empty($expirationPeriod) || !$expirationPeriod) {
            return false;
        }

        return (int)$expirationPeriod;

    }
}

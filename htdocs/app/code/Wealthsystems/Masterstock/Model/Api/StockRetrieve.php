<?php

namespace Wealthsystems\Masterstock\Model\Api;

use Wealthsystems\Masterstock\Api\Retrieve;

class StockRetrieve implements Retrieve
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $modelStock = $objectManager->create('\Wealthsystems\Masterstock\Model\Productstock');

        $collection = $modelStock->getCollection();

        return $collection->getData();
    }
}

<?php

namespace Wealthsystems\Masterstock\Model\Api;

use Wealthsystems\Masterstock\Api\Fetch;

class StockFetch implements Fetch
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function execute($product)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $modelStock = $objectManager->create('\Wealthsystems\Masterstock\Model\Productstock');

        $collection = $modelStock->getCollection()->addFieldToFilter('product_id',$product);

        return $collection->getData();
    }
}

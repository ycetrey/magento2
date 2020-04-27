<?php

namespace Wealthsystems\Masterstock\Model\Api;

use Wealthsystems\Masterstock\Api\Refresh;

class StockRefresh implements Refresh
{
    public function execute($stock)
    {
        $ary_response = [];
        foreach ($stock as $value) {
            $productQty = $value->getQty();            
            
            $valid = [
                "code" => "200",
                "message" => "Record saved successfully.",
                "qty" => $productQty,
                "product_id" => $value->getProductId(),
            ];
            $ary_response[] = $valid;            
        }
        return $ary_response;
    }
}

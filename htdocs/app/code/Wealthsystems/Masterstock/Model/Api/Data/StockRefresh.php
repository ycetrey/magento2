<?php

namespace Wealthsystems\Masterstock\Model\Api\Data;


class StockRefresh implements \Wealthsystems\Masterstock\Api\Data\Refresh
{
    protected $warehouse_id;
    protected $product_id;
    protected $qty;

    //Warehouse ID
    public function setWarehouseId($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function getWarehouseId()
    {
        return $this->warehouse_id;
    }

    //Product ID
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    //Quantity
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    public function getQty()
    {
        return $this->qty;
    }
}

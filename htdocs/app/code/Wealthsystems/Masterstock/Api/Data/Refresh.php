<?php

namespace Wealthsystems\Masterstock\Api\Data;

interface Refresh
{
    const QTY = 'qty';
    const WAREHOUSE_ID = 'warehouse_id';
    const PRODUCT_ID = 'product_id';
    
    public function setQty($qty);
    public function getQty();

    public function setWarehouseId($warehouse_id);
    public function getWarehouseId();

    public function setProductId($product_id);
    public function getProductId();
}

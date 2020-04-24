<?php
namespace Wealthsystems\Masterstock\Model\ResourceModel;

class Productstock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_stock', 'id');
    }
}
?>
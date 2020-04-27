<?php
namespace Wealthsystems\Masterprice\Model\ResourceModel;

class Pricetablerule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_price_table_rule', 'id');
    }
}
?>
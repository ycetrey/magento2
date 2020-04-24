<?php
namespace Wealthsystems\Masterprice\Model\ResourceModel;

class Discountrule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_discount_rule', 'id');
    }
}
?>
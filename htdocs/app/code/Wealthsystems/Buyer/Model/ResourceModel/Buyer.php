<?php
namespace Wealthsystems\Buyer\Model\ResourceModel;

class Buyer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_buyer', 'id');
    }
}
?>
<?php
namespace Wealthsystems\Masterbargain\Model\ResourceModel;

class Bargain extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_bargain', 'id');
    }
}
?>
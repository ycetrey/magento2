<?php
namespace Wealthsystems\Mastercredit\Model\ResourceModel;

class Creditlimit extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_credit_limit', 'id');
    }
}
?>
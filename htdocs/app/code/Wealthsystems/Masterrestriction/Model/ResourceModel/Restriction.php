<?php
namespace Wealthsystems\Masterrestriction\Model\ResourceModel;

class Restriction extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_restriction', 'id');
    }
}
?>
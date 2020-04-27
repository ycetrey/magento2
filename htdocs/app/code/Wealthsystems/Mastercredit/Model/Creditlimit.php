<?php
namespace Wealthsystems\Mastercredit\Model;

class Creditlimit extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Mastercredit\Model\ResourceModel\Creditlimit');
    }
}
?>
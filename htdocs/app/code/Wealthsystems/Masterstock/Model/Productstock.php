<?php
namespace Wealthsystems\Masterstock\Model;

class Productstock extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterstock\Model\ResourceModel\Productstock');
    }
}
?>
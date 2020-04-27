<?php
namespace Wealthsystems\Masterprice\Model;

class Pricetable extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterprice\Model\ResourceModel\Pricetable');
    }
}
?>
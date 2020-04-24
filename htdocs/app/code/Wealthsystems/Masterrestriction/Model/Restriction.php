<?php
namespace Wealthsystems\Masterrestriction\Model;

class Restriction extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterrestriction\Model\ResourceModel\Restriction');
    }
}
?>
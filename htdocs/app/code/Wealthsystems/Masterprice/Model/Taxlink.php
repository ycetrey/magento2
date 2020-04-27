<?php
namespace Wealthsystems\Masterprice\Model;

class Taxlink extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterprice\Model\ResourceModel\Taxlink');
    }
}
?>
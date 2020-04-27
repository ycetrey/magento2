<?php
namespace Wealthsystems\Buyer\Model;

class Buyer extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Buyer\Model\ResourceModel\Buyer');
    }
}
?>
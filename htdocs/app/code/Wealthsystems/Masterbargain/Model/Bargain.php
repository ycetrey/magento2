<?php
namespace Wealthsystems\Masterbargain\Model;

class Bargain extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterbargain\Model\ResourceModel\Bargain');
    }
}
?>
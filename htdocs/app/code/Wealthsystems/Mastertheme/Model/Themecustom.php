<?php
namespace Wealthsystems\Mastertheme\Model;

class Themecustom extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Mastertheme\Model\ResourceModel\Themecustom');
    }
}
?>
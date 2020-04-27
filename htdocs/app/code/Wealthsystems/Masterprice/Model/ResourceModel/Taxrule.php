<?php
namespace Wealthsystems\Masterprice\Model\ResourceModel;

class Taxrule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_tax_rule', 'id');
    }
}
?>
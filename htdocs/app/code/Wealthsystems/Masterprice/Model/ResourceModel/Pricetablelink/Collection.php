<?php

namespace Wealthsystems\Masterprice\Model\ResourceModel\Pricetablelink;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterprice\Model\Pricetablelink', 'Wealthsystems\Masterprice\Model\ResourceModel\Pricetablelink');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
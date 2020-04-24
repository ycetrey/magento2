<?php

namespace Wealthsystems\Masterprice\Model\ResourceModel\Pricetable;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterprice\Model\Pricetable', 'Wealthsystems\Masterprice\Model\ResourceModel\Pricetable');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
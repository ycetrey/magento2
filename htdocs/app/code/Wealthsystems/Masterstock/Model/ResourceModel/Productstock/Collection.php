<?php

namespace Wealthsystems\Masterstock\Model\ResourceModel\Productstock;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterstock\Model\Productstock', 'Wealthsystems\Masterstock\Model\ResourceModel\Productstock');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
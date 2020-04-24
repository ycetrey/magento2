<?php

namespace Wealthsystems\Masterprice\Model\ResourceModel\Tax;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterprice\Model\Tax', 'Wealthsystems\Masterprice\Model\ResourceModel\Tax');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
<?php

namespace Wealthsystems\Buyer\Model\ResourceModel\Buyer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Buyer\Model\Buyer', 'Wealthsystems\Buyer\Model\ResourceModel\Buyer');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
<?php

namespace Wealthsystems\Mastercredit\Model\ResourceModel\Creditlimit;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Mastercredit\Model\Creditlimit', 'Wealthsystems\Mastercredit\Model\ResourceModel\Creditlimit');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
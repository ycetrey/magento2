<?php

namespace Wealthsystems\Masterbargain\Model\ResourceModel\Bargain;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterbargain\Model\Bargain', 'Wealthsystems\Masterbargain\Model\ResourceModel\Bargain');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
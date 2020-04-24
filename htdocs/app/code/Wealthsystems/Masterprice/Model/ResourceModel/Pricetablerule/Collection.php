<?php

namespace Wealthsystems\Masterprice\Model\ResourceModel\Pricetablerule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterprice\Model\Pricetablerule', 'Wealthsystems\Masterprice\Model\ResourceModel\Pricetablerule');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
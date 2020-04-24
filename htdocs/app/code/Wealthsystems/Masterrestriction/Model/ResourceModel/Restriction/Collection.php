<?php

namespace Wealthsystems\Masterrestriction\Model\ResourceModel\Restriction;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wealthsystems\Masterrestriction\Model\Restriction', 'Wealthsystems\Masterrestriction\Model\ResourceModel\Restriction');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
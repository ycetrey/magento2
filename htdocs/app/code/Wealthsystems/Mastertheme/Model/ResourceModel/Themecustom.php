<?php
namespace Wealthsystems\Mastertheme\Model\ResourceModel;

class Themecustom extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ws_theme_custom', 'id');
    }
}
?>
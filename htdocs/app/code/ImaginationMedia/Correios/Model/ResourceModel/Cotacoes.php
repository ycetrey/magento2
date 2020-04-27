<?php

/**
 * Correios
 *
 * Correios Shipping Method for Magento 2.
 *
 * @package ImaginationMedia\Correios
 * @author Igor Ludgero Miura <igor@imaginemage.com>
 * @copyright Copyright (c) 2017 Imagination Media (http://imaginemage.com/)
 * @license https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

namespace ImaginationMedia\Correios\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Cotacoes extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('correios_cotacoes', 'id');
    }
}

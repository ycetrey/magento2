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

namespace ImaginationMedia\Correios\Model\ResourceModel\Cotacoes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'ImaginationMedia\Correios\Model\Cotacoes',
            'ImaginationMedia\Correios\Model\ResourceModel\Cotacoes'
        );
    }
}

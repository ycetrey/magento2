<?php
namespace Magento\Customer\Api\Data;

/**
 * Extension class for @see \Magento\Customer\Api\Data\AddressInterface
 */
class AddressExtension extends \Magento\Framework\Api\AbstractSimpleObject implements AddressExtensionInterface
{
    /**
     * @return string|null
     */
    public function getCellphone()
    {
        return $this->_get('cellphone');
    }

    /**
     * @param string $cellphone
     * @return $this
     */
    public function setCellphone($cellphone)
    {
        $this->setData('cellphone', $cellphone);
        return $this;
    }
}

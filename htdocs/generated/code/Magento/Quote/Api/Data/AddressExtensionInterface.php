<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\AddressInterface
 */
interface AddressExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getCellphone();

    /**
     * @param string $cellphone
     * @return $this
     */
    public function setCellphone($cellphone);

    /**
     * @return \Magento\Framework\Api\AttributeInterface[]|null
     */
    public function getCheckoutFields();

    /**
     * @param \Magento\Framework\Api\AttributeInterface[] $checkoutFields
     * @return $this
     */
    public function setCheckoutFields($checkoutFields);
}

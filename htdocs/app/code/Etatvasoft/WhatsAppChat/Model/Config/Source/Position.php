<?php
namespace Etatvasoft\WhatsAppChat\Model\Config\Source;

/**
 * Class Position
 * @package Etatvasoft\WhatsAppChat\Model\Config\Source
 */
class Position implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
        ['value' => 'top-left', 'label' => __('Top-Left')],
        ['value' => 'top-right', 'label' => __('Top-Right')],
        ['value' => 'top-middle', 'label' => __('Top-Middle')],
        ['value' => 'left-middle', 'label' => __('Left-Middle')],
        ['value' => 'right-middle', 'label' => __('Right-Middle')],
        ['value' => 'bottom-middle', 'label' => __('Bottom-Middle')],
        ['value' => 'bottom-left', 'label' => __('Bottom-Left')],
        ['value' => 'bottom-right', 'label' => __('Bottom-Right')]
        ];
    }
}

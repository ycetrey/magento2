<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    MagemeCom
 * @package     MagemeCom_HidePrice
 * @author      MageMe Team <support@mageme.com>
 * @copyright   Copyright (c) MageMe (https://mageme.com)
 * @license     https://mageme.com/license
 */
namespace MagemeCom\HidePrice\Model\Config\Source\Alert;

use Magento\Framework\Option\ArrayInterface;

class Icon implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'none', 'label' => __('None')],
            ['value' => 'success', 'label' => __('Success')],
            ['value' => 'error', 'label' => __('Error')],
            ['value' => 'warning', 'label' => __('Warning')],
            ['value' => 'info', 'label' => __('Info')],
            ['value' => 'question', 'label' => __('Question')]
        ];
    }
}
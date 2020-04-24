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

namespace MagemeCom\HidePrice\Block\Adminhtml\Info;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Links
 * @package MagemeCom\HidePrice\Block\Adminhtml
 */
class Links extends AbstractInfo
{
    /**
     * @param AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $list = [];
        $info = $this->getInfo();
        if ($info &&
            !empty($info[self::MODULE_NAME]) &&
            isset($info[self::MODULE_NAME]['links']) &&
            is_array($info[self::MODULE_NAME]['links'])
        ) {
            $links = $info[self::MODULE_NAME]['links'];
            foreach ($links as $link)
                $list[] = __(
                    "<a href='%1' class='%2' style='%3' target='_blank'>%4</a>",
                    $link['url'],
                    $link['class'],
                    $link['style'],
                    $link['title']
                );
        }

        return '<div class="control-value special">' . implode('<br>', $list) . '</div>';
    }

}

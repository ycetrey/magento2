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
 * Class Version
 * @package MagemeCom\HidePrice\Block\Adminhtml
 */
class Version extends AbstractInfo
{
    /**
     * @param AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $moduleInfo = $this->_moduleList->getOne(self::MODULE_NAME);
        $version    = (string)$moduleInfo['setup_version'];
        $info       = $this->getInfo();
        if ($info &&
            !empty($info[self::MODULE_NAME]) &&
            version_compare($info[self::MODULE_NAME]['version'], $version, '>')) {
            $version .= ' | ' . __(
                    "<a href='%1' target='_blank'>%2 update available</a>",
                    $info['MagemeCom_HidePrice']['release_notes'],
                    $info['MagemeCom_HidePrice']['version']
                );
        }

        return '<div class="control-value special">' . $version . '</div>';
    }
}

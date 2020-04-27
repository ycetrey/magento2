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
namespace MagemeCom\HidePrice\Model;

class Feed extends \Magento\AdminNotification\Model\Feed
{
    public function getFeedUrl()
    {
        if ($this->_feedUrl === null) {
            $this->_feedUrl = 'https://mageme.com/feeds/hideprice/m2.rss';
        }
        return $this->_feedUrl;
    }

    public function observe()
    {
        $this->checkUpdate();
    }
}
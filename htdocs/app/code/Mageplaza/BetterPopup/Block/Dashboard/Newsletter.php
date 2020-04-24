<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_BetterPopup
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\BetterPopup\Block\Dashboard;

use Magento\Framework\Phrase;
use Mageplaza\BetterPopup\Block\Subscriber;

/**
 * Class Newsletter
 * @package Mageplaza\BetterPopup\Block\Dashboard
 */
class Newsletter extends Subscriber
{
    /**
     * path of template
     */
    protected $_template = 'dashboard/newsletter.phtml';

    /**
     * @return Phrase|string
     */
    public function getTitle()
    {
        return __('Subscribers');
    }
}

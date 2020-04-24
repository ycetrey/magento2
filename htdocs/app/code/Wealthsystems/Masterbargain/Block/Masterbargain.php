<?php

namespace Wealthsystems\Masterbargain\Block;

use Magento\Cms\Block\Page;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mageplaza\SocialShare\Helper\Data as HelperData;

class Masterbargain extends Template
{
    
    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * @var \Magento\Cms\Block\Page
     */
    protected $_page;

    public function __construct(
        Context $context,
        HelperData $helperData,
        Page $page,
        array $data = []
    ) {
        $this->_helperData = $helperData;
        $this->_page = $page;
        parent::__construct($context, $data);
    }

    /**
     * /////////////////////////////////////////////////////////////
     * General Configuration
     * ////////////////////////////////////////////////////////////
     */

    /**
     * @return bool
     */
    public function isEnable()
    {
        return true;
    }
    
}

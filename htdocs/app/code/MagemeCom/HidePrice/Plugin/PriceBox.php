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

namespace MagemeCom\HidePrice\Plugin;

use MagemeCom\HidePrice\Block\Button;
use MagemeCom\HidePrice\Helper\Data;
use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class FinalPriceBox
 * @package MagemeCom\HidePrice\Pricing\Renderer
 */
class PriceBox
{
    /** @var ScopeConfigInterface */
    private $config;
    /** @var Button */
    private $buttonBlock;
    /** @var Data */
    private $hidePriceHelper;

    /**
     * FinalPriceBox constructor.
     * @param ScopeConfigInterface $config
     * @param Button $buttonBlock
     * @param Data $hidePriceHelper
     */
    public function __construct(
        ScopeConfigInterface $config,
        Button $buttonBlock,
        Data $hidePriceHelper
    )
    {
        $this->config          = $config;
        $this->buttonBlock     = $buttonBlock;
        $this->hidePriceHelper = $hidePriceHelper;
    }

    /**
     * @param FinalPriceBox $finalPriceBox
     * @param $result
     * @return string
     */
    public function afterToHtml(FinalPriceBox $finalPriceBox, $result)
    {
        if (strstr($finalPriceBox->getTemplate(), 'final_price.phtml') ||
            strstr($finalPriceBox->getTemplate(),'configured_price.phtml')
        ) {
            $isHidePriceEnabled = $this->hidePriceHelper->hidePrice();
            $text               = $this->config->getValue('hideprice/general/text', ScopeInterface::SCOPE_STORE);
            $buttonText         = $this->config->getValue('hideprice/general/button_text', ScopeInterface::SCOPE_STORE);
            $alertIcon          = $this->config->getValue('hideprice/general/alert_icon', ScopeInterface::SCOPE_STORE);
            $alertTitleText     = $this->config->getValue('hideprice/general/alert_title_text', ScopeInterface::SCOPE_STORE);
            $alertText          = $this->config->getValue('hideprice/general/alert_text', ScopeInterface::SCOPE_STORE);
            $selectedElement    = $this->config->getValue('hideprice/general/replace_element', ScopeInterface::SCOPE_STORE);
            $alertButtonText    = $this->config->getValue('hideprice/general/alert_button_text', ScopeInterface::SCOPE_STORE);

            switch ($selectedElement) {
                case 'button_with_alert':
                    $template = 'button.phtml';
                    break;
                default:
                    $template = 'text.phtml';
                    break;
            }

            if ($isHidePriceEnabled) {
                return $this->buttonBlock
                    ->setData([
                        'text' => $text,
                        'button_text' => $buttonText ? __($buttonText) : __('Click for info'),
                        'alert_icon' => $alertIcon ?: 'info',
                        'alert_title_text' => $alertTitleText ? __($alertTitleText) : __('Info'),
                        'alert_text' => $alertText ? __($alertText) : __('MagemeCom HidePrice'),
                        'alert_button_text' => $alertButtonText ? __($alertButtonText) : __('Close')
                    ])
                    ->setTemplate('MagemeCom_HidePrice::' . $template)
                    ->toHtml();
            }
        }

        return $result;
    }
}

<?php
/**
 * Etatvasoft Productsattachment
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
namespace Etatvasoft\Productsattachment\Block\Adminhtml\Productsattachment\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class ResetButton
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
class ResetButton implements ButtonProviderInterface
{
    /**
     * ButtonData
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}

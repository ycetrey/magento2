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

namespace Etatvasoft\Productsattachment\Block\Adminhtml\Productsattachment;

/**
 * AssignProducts
 * PHP  7.1.7 and later:
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */

class AssignProducts extends \Magento\Backend\Block\Template
{
    /**
     * Blockgrid
     *
     * @var \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
     */
    protected $blockGrid;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * JsonEncoder
     *
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * AssignProducts constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context     context
     * @param \Magento\Framework\Registry              $registry    registry
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder jsonencoder
     * @param array                                    $data        dataarray
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->jsonEncoder = $jsonEncoder;
        $this->setTemplate('Etatvasoft_Productsattachment::edit/assign_products.phtml');

        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                \Etatvasoft\Productsattachment\Block\Adminhtml\Productsattachment\Tab\Product::class,
                'attachment.product.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * Return selected products json format
     *
     * @return string
     */
    public function getProductsJson()
    {
        
        if (!empty($this->getRequest()->getParam('id'))) {
            $finalproducts = $this->getAttachment()->getSelectedProducts($this->getRequest()->getParam('id'));
            $finalpids = [];
            foreach ($finalproducts as $key => $value) {
                $finalpids[$value] = 0;
            }
            if (!empty($finalpids)) {
                return $this->jsonEncoder->encode($finalpids);
            }
        }
        return '{}';
    }

    /**
     * Retrieve current attachment instance
     *
     * @return array|null
     */
    public function getAttachment()
    {
        return $this->registry->registry('currentAttachment');
    }
}

<?php
/**
 * Etatvasoft Productsattachment
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  http://tatvasoft.com  Open Software License (OSL 3.0)
 * @link     http://tatvasoft.com
 */
namespace Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid;

/**
 * Class Grid
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  http://tatvasoft.com  Open Software License (OSL 3.0)
 * @link     http://tatvasoft.com
 */
class Grid extends \Etatvasoft\Productsattachment\Controller\Adminhtml\Productsattachment
{
    /**
     * Rowfactory
     *
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * Layoutfactory
     *
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * CoreRegistry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Grid Class constructor
     *
     * @param \Magento\Backend\App\Action\Context             $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\View\LayoutFactory           $layoutFactory
     * @param \Magento\Framework\Registry                     $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Etatvasoft\Productsattachment\Model\Productsattachment $attachmentLoader,
        \Magento\Framework\Controller\Result\Json $resultJson
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context, $coreRegistry, $attachmentLoader, $resultJson);
    }

    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $productsattachment = $this->initAttachment();
        if (!$productsattachment) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('catalog/*/', ['_current' => true, 'id' => null]);
        }

        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                \Etatvasoft\Productsattachment\Block\Adminhtml\Productsattachment\Tab\Product::class,
                'attachment.product.grid'
            )->toHtml()
        );
    }
}

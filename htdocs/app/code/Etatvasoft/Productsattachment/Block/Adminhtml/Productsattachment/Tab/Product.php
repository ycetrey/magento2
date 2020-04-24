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
namespace Etatvasoft\Productsattachment\Block\Adminhtml\Productsattachment\Tab;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\ObjectManager;

/**
 * Class Product
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
class Product extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * Product Factory
     *
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    protected $status;

    /**
     * Product Visibility
     *
     * @var Visibility
     */
    protected $visibility;
    /**
     * ProductList constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context        Context
     * @param \Magento\Backend\Helper\Data            $backendHelper  BackendHelper
     * @param \Magento\Catalog\Model\ProductFactory   $productFactory ProductFactory
     * @param \Magento\Framework\Registry             $coreRegistry   Coreregistry
     * @param array                                   $data           Data
     * @param Visibility|null                         $visibility     Visibility
     * @param Status|null                             $status         status
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Model\Product\Visibility $visibility,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $status,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->coreRegistry = $coreRegistry;
        $this->visibility = $visibility;
        $this->status = $status;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Set Grid Id and Default Sort
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('etatvasoft_products_attachment');
        $this->setDefaultSort('auto_incr_id');
        $this->setUseAjax(true);
    }

    /**
     * Get Current Attachment
     *
     * @return array|null
     */
    public function getAttachment()
    {
        return $this->coreRegistry->registry('currentAttachment');
    }

    /**
     * Default Filter of Products on Page Load
     *
     * @param Column $column Columnnames
     *
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        
        if ($column->getId() == 'in_attachment') {
            $productIds = $this->getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        
        return $this;
    }

    /**
     * Grid Collection
     *
     * @return Grid
     */
    protected function _prepareCollection()
    {
        
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(['in_attachment' => 1]);
        }
        $collection = $this->productFactory->create()->getCollection()->addAttributeToSelect(
            'name'
        )->addAttributeToSelect(
            'sku'
        )->addAttributeToSelect(
            'visibility'
        )->addAttributeToSelect(
            'status'
        )->addAttributeToSelect(
            'price'
        )->joinField(
            'product_id',
            'etatvasoft_products_attachment',
            'product_id',
            'product_id=entity_id',
            'attachment_id=' . (int)$this->getRequest()->getParam('id', 0),
            'left'
        );
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Grid Columns
     *
     * @return Extended
     */
    protected function _prepareColumns()
    {
        
            $this->addColumn(
                'in_attachment',
                [
                    'type' => 'checkbox',
                    'name' => 'in_attachment',
                    'values' => $this->getSelectedProducts(),
                    'index' => 'entity_id',
                    'header_css_class' => 'col-select col-massaction',
                    'column_css_class' => 'col-select col-massaction'
                ]
            );
        
        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
        $this->addColumn('sku', ['header' => __('SKU'), 'index' => 'sku']);
        $this->addColumn(
            'visibility',
            [
                'header' => __('Visibility'),
                'index' => 'visibility',
                'type' => 'options',
                'options' => $this->visibility->getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility'
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->status->getOptionArray()
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'index' => 'price'
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * Reset Filter Url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('productsattachment/*/grid', ['_current' => true]);
    }

    /**
     * List of Selected Products array
     *
     * @return array
     */
    protected function getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('selected_products');
        if ($products === null && !empty($this->getRequest()->getParam('id'))) {
            $finalproducts = $this->getAttachment()->getSelectedProducts($this->getRequest()->getParam('id'));
            return $finalproducts;
        }
        return $products;
    }
}

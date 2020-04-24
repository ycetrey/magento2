<?php
namespace Wealthsystems\Masterstock\Model\Rewrite\IsProductSalableForRequestedQtyCondition;

use Magento\InventoryReservationsApi\Model\GetReservationsQuantityInterface;
use Magento\InventorySalesApi\Api\IsProductSalableForRequestedQtyInterface;
use Magento\InventorySalesApi\Model\GetStockItemDataInterface;
use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface;
use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory;
use Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory;
use Magento\InventoryConfigurationApi\Api\GetStockItemConfigurationInterface;
use Magento\InventoryConfigurationApi\Api\Data\StockItemConfigurationInterface;


class IsSalableWithReservationsCondition extends \Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsSalableWithReservationsCondition
{
    /**
     * @var GetStockItemDataInterface
     */
    private $getStockItemData;

    /**
     * @var GetReservationsQuantityInterface
     */
    private $getReservationsQuantity;

    /**
     * @var GetStockItemConfigurationInterface
     */
    private $getStockItemConfiguration;

    /**
     * @var ProductSalabilityErrorInterfaceFactory
     */
    private $productSalabilityErrorFactory;

    /**
     * @var ProductSalableResultInterfaceFactory
     */
    private $productSalableResultFactory;

    protected $_productRepository;

    /**
     * @param GetStockItemDataInterface $getStockItemData
     * @param GetReservationsQuantityInterface $getReservationsQuantity
     * @param GetStockItemConfigurationInterface $getStockItemConfiguration
     * @param ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory
     * @param ProductSalableResultInterfaceFactory $productSalableResultFactory
     */
    public function __construct(
        GetStockItemDataInterface $getStockItemData,
        GetReservationsQuantityInterface $getReservationsQuantity,
        GetStockItemConfigurationInterface $getStockItemConfiguration,
        ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory,
        ProductSalableResultInterfaceFactory $productSalableResultFactory,
        \Wealthsystems\Masterstock\Helper\Data $helperData,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->getStockItemData = $getStockItemData;
        $this->getReservationsQuantity = $getReservationsQuantity;
        $this->getStockItemConfiguration = $getStockItemConfiguration;
        $this->productSalabilityErrorFactory = $productSalabilityErrorFactory;
        $this->productSalableResultFactory = $productSalableResultFactory;
        $this->_helperData = $helperData;
        $this->_productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(string $sku, int $stockId, float $requestedQty): ProductSalableResultInterface
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $stockItemData = $this->getStockItemData->execute($sku, $stockId);
        if (null === $stockItemData) {
            $errors = [
                $this->productSalabilityErrorFactory->create([
                    'code' => 'is_salable_with_reservations-no_data',
                    'message' => __('The requested sku is not assigned to given stock')
                ])
            ];
            return $this->productSalableResultFactory->create(['errors' => $errors]);
        }

        /** @var StockItemConfigurationInterface $stockItemConfiguration */
        $stockItemConfiguration = $this->getStockItemConfiguration->execute($sku, $stockId);

        if($this->_helperData->StockEnable()){
            $modelStock = $objectManager->create('\Wealthsystems\Masterstock\Model\Productstock');	      
            
            $_product = $this->_productRepository->get($sku);

            if($this->_helperData->WarehouseEnable()){
                $productstock = $modelStock->getCollection()
                    ->addFieldToFilter('product_id', $_product->getId())
                    ->addFieldToFilter('warehouse_id', $_product->getWarehouseId())
                    ->getFirstItem();
            } else {
                $productstock = $modelStock->getCollection()
                    ->addFieldToFilter('product_id', $_product->getId())
                    ->getFirstItem();
            }

            $qtyWithReservation = $productstock->getQty();
        } else {
            $qtyWithReservation = $stockItemData[GetStockItemDataInterface::QUANTITY] + $this->getReservationsQuantity->execute($sku, $stockId);
        }
        
        $qtyLeftInStock = $qtyWithReservation - $stockItemConfiguration->getMinQty();
        //$isInStock = bccomp((string)$qtyLeftInStock, (string)$requestedQty, 4) >= 0;
        $isInStock = 1;
        $isEnoughQty = (bool)$stockItemData[GetStockItemDataInterface::IS_SALABLE] && $isInStock;

        if (!$isEnoughQty) {
            $errors = [
                $this->productSalabilityErrorFactory->create([
                    'code' => 'is_salable_with_reservations-not_enough_qty',
                    'message' => __('The requested qty is not available')
                ])
            ];
            return $this->productSalableResultFactory->create(['errors' => $errors]);
        }
        return $this->productSalableResultFactory->create(['errors' => []]);
    }
}

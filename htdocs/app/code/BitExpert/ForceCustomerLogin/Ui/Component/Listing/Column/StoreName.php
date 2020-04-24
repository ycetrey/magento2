<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManager;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class StoreName
 *
 * @package BitExpert\ForceCustomerLogin\Ui\Component\Listing\Column
 */
class StoreName extends Column
{
    /**
     * @var StoreManager
     */
    private $storeManager;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param StoreManager $storeManager
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        StoreManager $storeManager,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['store_id'])) {
                continue;
            }

            $fieldName = $this->getData('name');

            $store = $this->storeManager->getStore((int) $item['store_id']);
            if (!$store->getId()) {
                $item[$fieldName] = __('All Stores');
                continue;
            }

            $item[$fieldName] = $store->getName();
        }

        return $dataSource;
    }
}

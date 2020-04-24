<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

/**
 * Class HistoryActions
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class HistoryActions extends Column
{

    const REWARD_URL_PATH_EDIT = 'points/history/edit';

    const REWARD_URL_PATH_DELETE = 'points/history/delete';

    /**
     * @var UrlBuilder
     */
    public $actionUrlBuilder;

    /**
     * @var UrlInterface
     */
    public $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::REWARD_URL_PATH_EDIT
    ) {

        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param  array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['history_id'])) {
                    if (!$item['is_deleted']) {
                        $item[$name]['delete'] = [
                            'href' => $this->urlBuilder->getUrl(
                                self::REWARD_URL_PATH_DELETE,
                                ['history_id' => $item['history_id']]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete record for ${ $.$data.customer_name }'),
                                'message' => __('Are you sure you wan\'t to delete record for ${ $.$data.customer_name } ?')
                            ]
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}

<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Block\Adminhtml\Manage\Create;

use BitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface;
use BitExpert\ForceCustomerLogin\Helper\Strategy\StrategyManager;

/**
 * Class Form
 *
 * @package BitExpert\ForceCustomerLogin\Block\Adminhtml\Manage\Create
 * @codingStandardsIgnoreFile
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var WhitelistEntryFactoryInterface
     */
    private $entityFactory;
    /**
     * @var StrategyManager
     */
    private $strategyManager;

    /**
     * Form constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param WhitelistEntryFactoryInterface $entityFactory
     * @param StrategyManager $strategyManager
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        WhitelistEntryFactoryInterface $entityFactory,
        StrategyManager $strategyManager,
        array $data
    ) {
        $this->entityFactory = $entityFactory;
        $this->strategyManager = $strategyManager;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        // Try to fetch entity if id is provided
        $whitelistEntry = $this->entityFactory->create()->load($this->_request->getParam('id', 0));
        if (!$whitelistEntry->getId()) {
            $whitelistEntry->setLabel(\base64_decode($this->_request->getParam('label')));
            $whitelistEntry->setUrlRule(\base64_decode($this->_request->getParam('url_rule')));
            $whitelistEntry->setStrategy(\base64_decode($this->_request->getParam('strategy')));
            $whitelistEntry->setStoreId(\base64_decode($this->_request->getParam('store_id')));
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create([
            'data' => [
                'id' => 'create_manage_entry_form',
                'action' => $this->getUrl('ForceCustomerLogin/Manage/Save'),
                'method' => 'post'
            ]
        ]
        );
        $form->setHtmlIdPrefix('');

        $fieldsetBase = $form->addFieldset(
            'base_fieldset',
            [
                'class' => 'fieldset-wide'
            ]
        );

        if ($whitelistEntry->getId()) {
            $fieldsetBase->addField('whitelist_entry_id', 'hidden', [
                'name' => 'whitelist_entry_id',
                'value' => $whitelistEntry->getId()
            ]
            );
        }

        $fieldsetBase->addField('label', 'text', [
            'name' => 'label',
            'label' => __('Label'),
            'title' => __('Label'),
            'value' => $whitelistEntry->getLabel(),
            'required' => true
        ]
        );

        $fieldsetBase->addField('url_rule', 'text', [
            'name' => 'url_rule',
            'label' => __('Url Rule'),
            'title' => __('Url Rule'),
            'value' => $whitelistEntry->getUrlRule(),
            'required' => true
        ]
        );

        $fieldsetBase->addField('strategy', 'select', [
            'name' => 'strategy',
            'label' => __('Strategy'),
            'title' => __('Strategy'),
            'value' => $whitelistEntry->getStrategy(),
            'options' => $this->strategyManager->getStrategyNames(),
            'required' => true
        ]
        );

        $fieldsetBase->addField('store_id', 'select', [
            'name' => 'store_id',
            'label' => __('Store'),
            'title' => __('Store'),
            'value' => $whitelistEntry->getStoreId(),
            'options' => $this->getStoresAsArray(),
            'required' => true
        ]
        );
        $form->setData('store_id', $whitelistEntry->getStoreId());


        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return array
     */
    protected function getStoresAsArray()
    {
        $stores = $this->_storeManager->getStores();

        $storeSet = array(
            0 => __('All Stores')
        );
        foreach ($stores as $store) {
            $storeSet[(int) $store->getId()] = $store->getName();
        }

        return $storeSet;
    }
}
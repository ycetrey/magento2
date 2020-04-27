<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Block\Adminhtml\History\Dialog;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Add
 *
 * @author BrainActs Core Team <support@brainacts.com>
 */
class Edit extends Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * Edit constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param \Magento\Store\Model\System\Store       $systemStore
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
    
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Reward Points '), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'points',
            'text',
            [
                'name' => 'points',
                'label' => __('Points'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'customer_name',
            'text',
            [
                'name' => 'customer_name',
                'label' => __('Customer'),
                'required' => true,
                'placeholder' => __('Please fill email or name')
            ]
        );

        $fieldset->addField(
            'type_rule',
            'radios',
            [
                'name' => 'type_rule',
                'label' => __('Action'),
                'required' => true,
                'values' => [
                    ['value' => '1', 'label' => 'Add Points'],
                    ['value' => '2', 'label' => 'Remove Points']
                ],
                'value' => 1
            ]
        );

        $fieldset->addField(
            'reason',
            'textarea',
            [
                'name' => 'reason',
                'label' => __('Reason'),
                'required' => true,
            ]
        );


        $fieldset->addField(
            'customer_id',
            'hidden',
            [
                'name' => 'customer_id',
                'required' => true,
            ]
        );


        $this->setForm($form);
        return $this;
    }
}

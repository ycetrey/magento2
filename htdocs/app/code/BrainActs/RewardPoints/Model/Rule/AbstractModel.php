<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Model\Rule;

/**
 * Abstract Rule entity data model
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractModel extends \Magento\Framework\Model\AbstractExtensibleModel
{
    /**
     * Store rule combine conditions model
     *
     * @var \Magento\Rule\Model\Condition\Combine
     */
    public $conditions;

    /**
     * Store rule form instance
     *
     * @var \Magento\Framework\Data\Form
     */
    public $form;

    /**
     * Is model can be deleted flag
     *
     * @var bool
     */
    public $isDeleteable = true;

    /**
     * Is model readonly
     *
     * @var bool
     */
    public $isReadonly = false;

    /**
     * Getter for rule combine conditions instance
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    abstract public function getConditionsInstance();

    /**
     * Form factory
     *
     * @var \Magento\Framework\Data\FormFactory
     */
    public $formFactory;

    /**
     * Timezone instance
     *
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    public $localeDate;

    /**
     * AbstractModel constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->formFactory = $formFactory;
        $this->localeDate = $localeDate;
        parent::__construct(
            $context,
            $registry,
            $this->getExtensionFactory(),
            $this->getCustomAttributeFactory(),
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Prepare data before saving
     *
     * @return                                       $this
     * @throws                                       \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function beforeSave()
    {
        // Serialize conditions
        if ($this->getConditions()) {
            $this->setConditionsSerialized(serialize($this->getConditions()->asArray()));
            $this->conditions = null;
        }

        /**
         * Prepare website Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasWebsiteIds()) {
            $websiteIds = $this->getWebsiteIds();
            if (is_string($websiteIds) && !empty($websiteIds)) {
                $this->setWebsiteIds(explode(',', $websiteIds));
            }
        }

        /**
         * Prepare customer group Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasCustomerGroupIds()) {
            $groupIds = $this->getCustomerGroupIds();
            if (is_string($groupIds) && !empty($groupIds)) {
                $this->setCustomerGroupIds(explode(',', $groupIds));
            }
        }

        parent::beforeSave();
        return $this;
    }

    /**
     * Set rule combine conditions model
     *
     * @param  \Magento\Rule\Model\Condition\Combine $conditions
     * @return $this
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * Retrieve rule combine conditions model
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getConditions()
    {
        if (empty($this->conditions)) {
            $this->resetConditions();
        }

        // Load rule conditions if it is applicable
        if ($this->hasConditionsSerialized()) {
            $conditions = $this->getConditionsSerialized();
            if (!empty($conditions)) {
                try {
                    $conditions = unserialize($conditions);
                } catch (\Exception $e) {
                    $conditions = '';
                }

                if (is_array($conditions) && !empty($conditions)) {
                    $this->conditions->loadArray($conditions);
                }
            }
            $this->unsConditionsSerialized();
        }

        return $this->conditions;
    }

    /**
     * Reset rule combine conditions
     *
     * @param  null|\Magento\Rule\Model\Condition\Combine $conditions
     * @return $this
     */
    private function resetConditions($conditions = null)
    {
        if (null === $conditions) {
            $conditions = $this->getConditionsInstance();
        }
        $conditions->setRule($this)->setId('1')->setPrefix('conditions');
        $this->setConditions($conditions);

        return $this;
    }

    /**
     * Rule form getter
     *
     * @return \Magento\Framework\Data\Form
     */
    public function getForm()
    {
        if (!$this->form) {
            $this->form = $this->formFactory->create();
        }
        return $this->form;
    }

    /**
     * Initialize rule model data from array
     *
     * @param  array $data
     * @return $this
     */
    public function loadPost(array $data)
    {
        $arr = $this->_convertFlatToRecursive($data);
        if (isset($arr['conditions'])) {
            $this->getConditions()
                ->setConditions([])
                ->loadArray($arr['conditions'][1]);
        }

        return $this;
    }

    /**
     * Set specified data to current rule.
     * Set conditions and actions recursively.
     * Convert dates into \DateTime.
     *
     * @param                                        array $data
     * @return                                       array
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function _convertFlatToRecursive(array $data)
    {
        $arr = [];
        foreach ($data as $key => $value) {
            if (($key === 'conditions' || $key === 'actions') && is_array($value)) {
                foreach ($value as $id => $data) {
                    $path = explode('--', $id);
                    $node = &$arr;
                    for ($i = 0, $l = sizeof($path); $i < $l; $i++) {
                        if (!isset($node[$key][$path[$i]])) {
                            $node[$key][$path[$i]] = [];
                        }
                        $node = &$node[$key][$path[$i]];
                    }
                    foreach ($data as $k => $v) {
                        $node[$k] = $v;
                    }
                }
            } else {
                /**
                 * Convert dates into \DateTime
                 */
                if (in_array($key, ['from_date', 'to_date']) && $value) {
                    $value = new \DateTime($value);
                }
                $this->setData($key, $value);
            }
        }

        return $arr;
    }

    /**
     * Validate rule conditions to determine if rule can run
     *
     * @param  \Magento\Framework\DataObject $object
     * @return bool
     */
    public function validate(\Magento\Framework\DataObject $object)
    {
        return $this->getConditions()->validate($object);
    }

    /**
     * Validate rule data
     *
     * @param                                        \Magento\Framework\DataObject $dataObject
     * @return                                       bool|string[] - return true if validation passed successfully. Array with errors description otherwise
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function validateData(\Magento\Framework\DataObject $dataObject)
    {
        $result = [];
        $fromDate = $toDate = null;

        if ($dataObject->hasFromDate() && $dataObject->hasToDate()) {
            $fromDate = $dataObject->getFromDate();
            $toDate = $dataObject->getToDate();
        }

        if ($fromDate && $toDate) {
            $fromDate = new \DateTime($fromDate);
            $toDate = new \DateTime($toDate);

            if ($fromDate > $toDate) {
                $result[] = __('End Date must follow Start Date.');
            }
        }

        if ($dataObject->hasWebsiteIds()) {
            $websiteIds = $dataObject->getWebsiteIds();
            if (empty($websiteIds)) {
                $result[] = __('Please specify a website.');
            }
        }
        if ($dataObject->hasCustomerGroupIds()) {
            $customerGroupIds = $dataObject->getCustomerGroupIds();
            if (empty($customerGroupIds)) {
                $result[] = __('Please specify Customer Groups.');
            }
        }

        return !empty($result) ? $result : true;
    }

    /**
     * Check availability to delete rule
     *
     * @return bool
     */
    public function isDeleteable()
    {
        return $this->isDeleteable;
    }

    /**
     * Set is rule can be deleted flag
     *
     * @param  bool $value
     * @return $this
     */
    public function setIsDeleteable($value)
    {
        $this->isDeleteable = (bool)$value;
        return $this;
    }

    /**
     * Check if rule is readonly
     *
     * @return bool
     */
    public function isReadonly()
    {
        return $this->isReadonly;
    }

    /**
     * Set is readonly flag to rule
     *
     * @param  bool $value
     * @return $this
     */
    public function setIsReadonly($value)
    {
        $this->isReadonly = (bool)$value;
        return $this;
    }

    /**
     * Get rule associated website Ids
     *
     * @return array
     */
    public function getWebsiteIds()
    {
        if (!$this->hasWebsiteIds()) {
            $websiteIds = $this->_getResource()->getWebsiteIds($this->getId());
            $this->setData('website_ids', (array)$websiteIds);
        }
        return $this->_getData('website_ids');
    }

    /**
     * @return \Magento\Framework\Api\ExtensionAttributesFactory
     * @deprecated
     */
    private function getExtensionFactory()
    {
        return \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Api\ExtensionAttributesFactory::class);
    }

    /**
     * @return \Magento\Framework\Api\AttributeValueFactory
     * @deprecated
     */
    private function getCustomAttributeFactory()
    {
        return \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Api\AttributeValueFactory::class);
    }
}

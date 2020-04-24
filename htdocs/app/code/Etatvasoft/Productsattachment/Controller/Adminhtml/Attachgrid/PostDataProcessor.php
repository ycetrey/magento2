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
 * Class PostDataProcessor
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  http://tatvasoft.com  Open Software License (OSL 3.0)
 * @link     http://tatvasoft.com
 */
class PostDataProcessor
{
    /**
     * Date Filter
     *
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * Validation Factory
     *
     * @var \Magento\Framework\View\Model\Layout\Update\ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * Message Manager
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * PostDataProcessor Class constructor
     *
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date               $dateFilter
     * @param \Magento\Framework\Message\ManagerInterface                  $messageManager
     * @param \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Validate post data
     *
     * @param array $data Datapost
     *
     * @return bool
     */
    public function validate($data)
    {
        $errorNo = true;
        $errorNo = $this->validateRequireEntry($data);
        
        if ($errorNo) {
            if (!in_array($data['is_active'], [0,1]) || $data['is_active'] == '' || is_null($data['is_active'])) {
                $errorNo = false;
                $this->messageManager->addError(
                    __("Please enter valid value to status field.")
                );
            }
        }

        return $errorNo;
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data RequireFields
     *
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'title' => __('Title'),
            'is_active' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('To apply changes you should fill valid value to required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}

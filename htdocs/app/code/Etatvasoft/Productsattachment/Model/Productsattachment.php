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
namespace Etatvasoft\Productsattachment\Model;

/**
 * Class Productsattachment
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
class Productsattachment extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'etatvasoft_productsattachment';

    /**
     * Cache Tag
     *
     * @var string
     */
    protected $cacheTag = 'etatvasoft_productsattachment';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'etatvasoft_productsattachment';

    /**
     * Productsattachment Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Etatvasoft\Productsattachment\Model\ResourceModel\Productsattachment');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Prepare item's statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Return the Selected Products of Attachment
     *
     * @param int $attachmentid Current Attachment Id
     *
     * @return mixed
     */
    public function getSelectedProducts($attachmentid)
    {
        $productsids = $this->getResource()->getSelectedProducts($attachmentid);
        return $productsids;
    }
}

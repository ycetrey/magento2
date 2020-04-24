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
namespace Etatvasoft\Productsattachment\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;
use Etatvasoft\Productsattachment\Model\Productsattachment as Attachmentmodel;
use Magento\Framework\Event\ManagerInterface;

/**
 * Class Productsattachment
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
class Productsattachment extends AbstractDb
{
    /**
     * Eventmanager
     *
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * Productsattachment constructor.
     *
     * @param Context          $context
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Context $context,
        ManagerInterface $eventManager
    ) {
        
        $this->eventManager     = $eventManager;
        parent::__construct($context);
    }

    /**
     * Define Maintable and primarykey
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('etatvasoft_attachments', 'attachment_id');
    }

    /**
     * After Save Fucntion Call
     *
     * @param AbstractModel $object AttachmentObject
     *
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->saveAttachmentRelation($object);
        return parent::_afterSave($object);
    }

    /**
     * Get Productids with attachmennt
     *
     * @param int $attachmentId attachmentid
     *
     * @return array
     */
    protected function lookupProductIds($attachmentId)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()->from(
            $this->getTable('etatvasoft_products_attachment'),
            'product_id'
        )->where(
            'attachment_id = ?',
            (int)$attachmentId
        );
        return $adapter->fetchCol($select);
    }

    /**
     * Save New Selected productids to attachment
     *
     * @param Attachmentmodel $attachment Attachment
     *
     * @return $this
     */
    protected function saveAttachmentRelation(Attachmentmodel $attachment)
    {
        $oldProductIds = $this->lookupProductIds($attachment->getId());
        $attachProductIds = $attachment->getAttachmentProducts();
        if (isset($attachProductIds) && is_string($attachProductIds)) {
            $attachProductIds = (array)json_decode($attachment->getAttachmentProducts());
            $newProductIds = [];
            foreach ($attachProductIds as $key => $value) {
                if (!empty($key)) {
                    $newProductIds[] = $key;
                }
            }
        } else {
            return $this;
        }
        
        $table = $this->getTable('etatvasoft_products_attachment');

        $insert = array_diff($newProductIds, $oldProductIds);
        $delete = array_diff($oldProductIds, $newProductIds);

        if ($delete) {
            $where = [
                'attachment_id = ?' => (int)$attachment->getId(),
                'product_id IN (?)' => $delete
            ];
            $this->getConnection()->delete($table, $where);
        }

        if ($insert) {
            $data = [];
            foreach ($insert as $productId) {
                $data[] = [
                    'attachment_id' => (int)$attachment->getId(),
                    'product_id' => (int)$productId
                ];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }
       
        return $this;
    }

    /**
     * Get list of productids with Attachment
     *
     * @param int $attachmentId Attachmentid
     *
     * @return array
     */
    public function getSelectedProducts($attachmentId)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()->from(
            $this->getTable('etatvasoft_products_attachment'),
            'product_id'
        )->where(
            'attachment_id = ?',
            (int)$attachmentId
        );
        return $adapter->fetchCol($select);
    }
}

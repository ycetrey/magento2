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
namespace Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid;

use Etatvasoft\Productsattachment\Model\Productsattachment;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
class Save extends \Etatvasoft\Productsattachment\Controller\Adminhtml\Productsattachment
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Etatvasoft_Productsattachment::productsattachment';

    /**
     * Data Processor
     *
     * @var \Etatvasoft\Productsattachment\Controller\Adminhtml\Attachgrid\PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * Data Persostor
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Productsattachment Model
     *
     * @var \Etatvasoft\Productsattachment\Model\Productsattachment
     */
    protected $model;

    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param PostDataProcessor                   $dataProcessor
     * @param Productsattachment                   $model
     * @param DataPersistorInterface              $dataPersistor
     * @param \Magento\Framework\Registry         $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PostDataProcessor $dataProcessor,
        Productsattachment $model,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Registry $coreRegistry,
        \Etatvasoft\Productsattachment\Model\Productsattachment $attachmentLoader,
        \Magento\Framework\Controller\Result\Json $resultJson
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->model = $model;
        
        parent::__construct($context, $coreRegistry, $attachmentLoader, $resultJson);
    }

    /**
     * Save action execute
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $attachmentmodel = $this->initAttachment();

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $attachmentmodel->getId(), '_current' => true]);
            }
            
            try {
                $data = $this->filterFoodData($data);
                $attachmentmodel->setData($data);
                $attachmentmodel->save();
                $this->messageManager->addSuccess(__('Product Attachment details are saved successfully.'));
                $this->dataPersistor->clear('productsattachment');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $attachmentmodel->getId(),
                         '_current' => true]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Attachment.'));
            }

            $this->dataPersistor->set('productsattachment', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $attachmentmodel->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * FilterPoolData
     *
     * @param array $rawData Postdata
     *
     * @return array
     */
    public function filterFoodData(array $rawData)
    {

        $data = $rawData;
        
        if (isset($data['attach_file'][0]['name']) && isset($data['attach_file'][0]['tmp_name'])) {
            $data['attach_file'] =$data['attach_file'][0]['name'];
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get('Etatvasoft\Productsattachment\ProductAttachImageUpload');
            $this->imageUploader->moveFileFromTmp($data['attach_file']);
        } elseif (isset($data['attach_file'][0]['name'])) {
            $data['attach_file'] =$data['attach_file'][0]['name'];
        } else {
            $data['attach_file'] = null;
        }

        return $data;
    }
}

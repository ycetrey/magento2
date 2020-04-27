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

/**
 * Class Edit
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Attachment Model
     *
     * @param array
     */
    protected $model;

    /**
     * Edit Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Etatvasoft\Productsattachment\Model\Productsattachment $model
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Etatvasoft\Productsattachment\Model\Productsattachment $model
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->model = $model;
        $this->_coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('id');
        $this->model->load($id);
        $this->_coreRegistry->register('currentAttachment', $this->model);
        
        if ($this->getRequest()->getQuery('isAjax')) {
            return $this->ajaxRequestResponse($this->model, $resultPage);
        }

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__($this->model->getTitle()));
        return $resultPage;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
         $resultPage->setActiveMenu('Etatvasoft_Productsattachment::productsattachment')
             ->addBreadcrumb(__('ProductsAttachment'), __('Manage Products Attachment'))
             ->addBreadcrumb(__('ProductsAttachment'), __('Manage Products Attachment'));

         return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Etatvasoft_Productsattachment::productsattachment');
    }
}

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
namespace Etatvasoft\Productsattachment\Controller\Adminhtml;

/**
 * Class Productsattachment
 *
 * @category Etatvasoft
 * @package  Etatvasoft_Productsattachment
 * @author   Etatvasoft <magento@etatvasoft.com>
 * @license  https://www.etatvasoft.com  Open Software License (OSL 3.0)
 * @link     https://www.etatvasoft.com
 */
abstract class Productsattachment extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    protected $attachmentLoader;

    protected $resultJson;

    /**
     * Productsattachment constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry         $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Etatvasoft\Productsattachment\Model\Productsattachment $attachmentLoader,
        \Magento\Framework\Controller\Result\Json $resultJson
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->attachmentLoader = $attachmentLoader;
        $this->resultJson = $resultJson;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage Resultpage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Etatvasoft_Productsattachment::etatvasoft_productsattachment')
            ->addBreadcrumb(__('Productsattachment'), __('Productsattachment'))
            ->addBreadcrumb(__('Items'), __(''));
        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Etatvasoft_Productsattachment::etatvasoft_productsattachment');
    }

    /**
     * InitAttachment
     *
     * @return mixed Attachnebtobject
     */
    protected function initAttachment()
    {

        $attachmentId = (int)$this->getRequest()->getParam('id');

        $attachmentId = $attachmentId ? $attachmentId : (int)$this->getRequest()->getParam('attachment_id');

        $productsattachment = $this->attachmentLoader;

        if ($attachmentId) {
            $productsattachment->load($attachmentId);
        }

        $this->coreRegistry->register('currentAttachment', $productsattachment);

        return $productsattachment;
    }

    /**
     * Reset Filter Ajax response
     *
     * @param mixed $productsattachment Attachment object
     * @param mixed $resultPage        Resultpage
     *
     * @return mixed
     */
    protected function ajaxRequestResponse($productsattachment, $resultPage)
    {
        $eventResponse = new \Magento\Framework\DataObject(
            [
            'content' => $resultPage->getLayout()->getUiComponent('productsattachment_attachgrid_editing')->getFormHtml(),
            'messages' => $resultPage->getLayout()->getMessagesBlock()->getGroupedHtml(),
            'toolbar' => $resultPage->getLayout()->getBlock('page.actions.toolbar')->toHtml()
            ]
        );

        $this->_eventManager->dispatch(
            'attachment_prepare_ajax_response',
            ['response' => $eventResponse, 'controller' => $this]
        );

        $resultJson = $this->resultJson;
        $resultJson->setHeader('Content-type', 'application/json', true);
        $resultJson->setData($eventResponse->getData());
        return $resultJson;
    }
}

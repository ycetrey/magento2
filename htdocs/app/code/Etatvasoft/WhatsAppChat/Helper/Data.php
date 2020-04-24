<?php

namespace Etatvasoft\WhatsAppChat\Helper;

use Magento\Framework\View\Asset\Repository;
use Magento\Framework\App\RequestInterface;

 // for $this->result

/**
 * Class Data
 * @package Etatvasoft\WhatsAppChat\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Repository $assetRepo,
        RequestInterface $request
    ) {
        $this->_storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
        $this->request = $request;
        parent::__construct($context);
    }

    /**
     * Return module status
     *
     * @return string
     */

    public function getWAStatus()
    {
        return $this->scopeConfig->getValue(
            'wa_chat/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return phone number
     *
     * @return string
     */

    public function getWAPhone()
    {
        return $this->scopeConfig->getValue(
            'wa_chat/general/phone_number',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return message
     *
     * @return string
     */

    public function getWAMessage()
    {
        return $this->scopeConfig->getValue(
            'wa_chat/general/message',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return icon position
     *
     * @return string
     */

    public function getWAPosition()
    {
        return $this->scopeConfig->getValue(
            'wa_chat/general/position',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return icon image url
     *
     * @return string
     */

    public function getWAIconUrl()
    {
        $whatsAppIcon = $this->scopeConfig->getValue('wa_chat/general/whatsapp_icon', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$whatsAppIcon) {
            $params = ['_secure' => $this->request->isSecure()];
            return $this->assetRepo->getUrlWithParams('Etatvasoft_WhatsAppChat::images/whatsapp-chat-button.png', $params);
        }

        return $this->getMediaUrl(). 'whatsapp_icon/'.$whatsAppIcon;
    }

    /**
     * Return media path
     *
     * @return string
     */

    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}

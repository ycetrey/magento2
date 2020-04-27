<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    MagemeCom
 * @package     MagemeCom_HidePrice
 * @author      MageMe Team <support@mageme.com>
 * @copyright   Copyright (c) MageMe (https://mageme.com)
 * @license     https://mageme.com/license
 */
namespace MagemeCom\HidePrice\Block\Adminhtml\Info;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\ModuleListInterface;

/**
 * Class Version
 * @package MagemeCom\HidePrice\Block\Adminhtml
 */
class AbstractInfo extends Field
{
    /**
     * Cache group Tag
     */
    const CACHE_GROUP = Config::TYPE_IDENTIFIER;

    /**
     * Prefix for cache key of block
     */
    const CACHE_KEY_PREFIX = 'MAGEMECOM_';

    /**
     * Cache tag
     */
    const CACHE_TAG = 'extensions';

    /**
     * MagemeCom api url to get extension json
     */
    const API_URL = 'https://mageme.com/api/m2/info/modules.json';

    const MODULE_NAME = 'MagemeCom_HidePrice';

    /**
     * @var ModuleListInterface
     */
    protected $_moduleList;

    /**
     * @var ProductMetadataInterface
     */
    protected $_metadata;

    public function __construct(
        ModuleListInterface $moduleList,
        Context $context,
        ProductMetadataInterface $metadata,
        array $data = []
    ) {
        $this->_moduleList = $moduleList;
        $this->_metadata   = $metadata;
        parent::__construct($context, $data);
    }

    /**
     * @return bool|mixed|string
     */
    public function getInfo()
    {
        $result = $this->_loadCache();
        if (!$result) {
            try {
                $result = file_get_contents(self::API_URL);
                $this->_saveCache($result);
            } catch (Exception $e) {
                return false;
            }
        }

        $result = json_decode($result, true);

        return $result;
    }
}

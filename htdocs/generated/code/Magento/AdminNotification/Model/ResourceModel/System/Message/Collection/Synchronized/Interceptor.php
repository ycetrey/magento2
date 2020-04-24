<?php
namespace Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\Synchronized;

/**
 * Interceptor class for @see \Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\Synchronized
 */
class Interceptor extends \Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\Synchronized implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactory $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\Notification\MessageList $messageList, ?\Magento\Framework\DB\Adapter\AdapterInterface $connection = null, ?\Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null)
    {
        $this->___init();
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $messageList, $connection, $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($arrRequiredFields = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toArray');
        if (!$pluginInfo) {
            return parent::toArray($arrRequiredFields);
        } else {
            return $this->___callPlugins('toArray', func_get_args(), $pluginInfo);
        }
    }
}

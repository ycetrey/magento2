<?php
namespace ImaginationMedia\Correios\Model\ResourceModel;

/**
 * Factory class for @see \ImaginationMedia\Correios\Model\ResourceModel\Cotacoes
 */
class CotacoesFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\ImaginationMedia\\Correios\\Model\\ResourceModel\\Cotacoes')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \ImaginationMedia\Correios\Model\ResourceModel\Cotacoes
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}

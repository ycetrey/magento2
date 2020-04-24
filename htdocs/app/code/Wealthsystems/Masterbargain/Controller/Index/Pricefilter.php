<?php

namespace Wealthsystems\Masterbargain\Controller\Index;

use Wealthsystems\Masterbargain\Model\Bargain;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Pricefilter extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wealthsystems\Masterbargain\Model\BargainFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();    
        $_bargain_collection = $objectManager->create('\Wealthsystems\Masterbargain\Model\Bargain')->getCollection()
            ->addFieldToFilter('date', array('gteq' => $date_start.' 00:00:00'))
            ->addFieldToFilter('date', array('lteq' => $date_end.' 23:59:59'));
        ?>
        <div class="item-bargain">
            <div class="item-id">
                <span>ID</span>
            </div>
            <div class="item-product">
                <span>Produto</span>
            </div>
            <div class="item-price">
                <span>Preço</span>
            </div>
            <div class="item-customer">
                <span>Cliente</span>
            </div>
            <div class="item-date">                            
                <span>Data</span>
            </div>
            <div class="item-status">
                <span></span>
            </div>
        </div>
        <?php

        foreach($_bargain_collection as $_bargain){
            $_customer = $objectManager->create('Magento\Customer\Model\Customer')->load($_bargain->getCustomerId());
            $_product = $objectManager->get('Magento\Catalog\Model\Product')->load($_bargain->getProductId());

            if($_bargain->getStatus() == 1){
                $color = '#f2ffef';
            } else if($_bargain->getStatus() == 2){
                $color = '#ffefef';
            } else {
                $color = '#ffffff';
            }
            ?>
            <div class="item-bargain" style="background: <?= $color ?>" id="bargain-<?= $_bargain->getId() ?>">
                <div class="item-id">
                    <span><?= $_bargain->getId() ?></span>
                </div>
                <div class="item-product" title="ID: <?= $_bargain->getProductId() ?>">
                    <span><?= $_product->getName() ?></span>
                </div>
                <div class="item-price">
                    <span>R$ <?= number_format($_bargain->getPrice(), 2, ',', '.') ?></span>
                </div>
                <div class="item-customer" title="ID: <?= $_bargain->getCustomerId() ?>">
                    <span><?= $_customer->getName() ?></span>
                </div>
                <div class="item-date">                            
                    <span><?=  $_bargain->getDate() ?></span>
                </div>
                <div class="item-status">
                    <select class="status-<?= $_bargain->getId() ?>">
                        <option <?= $_bargain->getStatus() == 0 ? 'selected' : '' ?> value="0">Aguardando</option>
                        <option <?= $_bargain->getStatus() == 1 ? 'selected' : '' ?> value="1">Aprovado</option>
                        <option <?= $_bargain->getStatus() == 2 ? 'selected' : '' ?> value="2">Não Aprovado</option>
                    </select>
                    <button onclick="changeStatus('<?= $_bargain->getId() ?>',this)" type="button" class="save">Salvar</button>
                </div>
            </div>
            <?php
        }
    }
}

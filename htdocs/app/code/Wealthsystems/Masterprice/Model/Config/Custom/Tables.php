<?php
namespace Wealthsystems\Masterprice\Model\Config\Custom;
 
class Tables implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $option = array();
        array_push($option, array('value' => null, 'label'=>' '));

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pricetable = $objectManager->create('\Wealthsystems\Masterprice\Model\Pricetable');

        $priceTable = $pricetable->getCollection()
            ->addFieldToFilter('is_active', array('eq' => 1));

        foreach($priceTable as $table){
            array_push($option, array('value' => $table->getId(), 'label'=>$table->getDescription()));
        }

        return $option;
    }
}
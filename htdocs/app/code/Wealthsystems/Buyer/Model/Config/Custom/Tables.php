<?php
namespace Wealthsystems\Buyer\Model\Config\Custom;
 
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
        $customergroup = $objectManager->create('\Magento\Customer\Model\ResourceModel\Group\Collection');

        foreach($customergroup as $group){
            array_push($option, array('value' => $group->getId(), 'label'=>$group->getCustomerGroupCode()));
        }

        return $option;
    }
}
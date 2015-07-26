<?php
class Learn_Chartmap_Block_Adminhtml_Chartmap_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct() {
		$this->setTemplate('chartmap/chartmap.phtml');
	}
	
	public function getTotalOrdersByCountry() {
		$collection = Mage::getModel('sales/order')->getCollection();
		$collection->addFieldToSelect('customer_email');
		$collection->getSelect()->join(array('sub' => $collection->getTable('sales/order_address')),'main_table.entity_id = sub.parent_id', array('country_id'=>'LCASE(sub.country_id)', "total" => "COUNT(*)") );
		$collection->getSelect()->where("sub.address_type = 'billing' ");
		$collection->getSelect()->columns('SUM( grand_total ) AS amount');
		$collection->getSelect()->group(array('sub.country_id'));
		/* echo $collection->getSelect(); */
		$results = $collection->getData();
		foreach ($results as $result) {
			$json[strtolower($result['country_id'])] = array(
				'total'  => $result['total'],
				'amount' => Mage::helper('core')->currency($result['amount'], true, false),
			);
		}
		return json_encode($json);
	}	
	
}

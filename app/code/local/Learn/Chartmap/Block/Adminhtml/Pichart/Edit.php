<?php
class Learn_Chartmap_Block_Adminhtml_Pichart_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct() {
		$this->setTemplate('chartmap/pichart.phtml');
	}
	
	public function getTotalOrdersByStatus() {
		$collection = Mage::getModel('sales/order')->getCollection();
		$collection->addFieldToSelect('status');
		$collection->getSelect()->columns('SUM( grand_total ) AS amount, COUNT(*) as total');
		$collection->getSelect()->group(array('status'));
		/* echo $collection->getSelect(); */
		$results = $collection->getData();
		return $results;
	}	
	
}

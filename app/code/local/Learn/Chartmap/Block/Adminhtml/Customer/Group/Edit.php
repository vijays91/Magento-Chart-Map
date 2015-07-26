<?php
class Learn_Chartmap_Block_Adminhtml_Customer_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct() {
		$this->setTemplate('chartmap/customer_group.phtml');
	}
	
	public function getTotalOrdersByCustomerGroupName() {
		$collection = Mage::getModel('sales/order')->getCollection();
		/* $collection->addFieldToSelect('status'); */
		$collection->addFieldToSelect('customer_group_id');
		$collection->getSelect()->join(array('sub' => $collection->getTable('customer/customer_group')),'main_table.customer_group_id = sub.customer_group_id', array('customer_group_name' =>'sub.customer_group_code'));		
		$collection->getSelect()->columns('SUM( grand_total ) AS amount, COUNT(*) as total');
		$collection->getSelect()->group(array('customer_group_id'));
		/* echo $collection->getSelect(); */
		$results = $collection->getData();
		return $results;
	}
}

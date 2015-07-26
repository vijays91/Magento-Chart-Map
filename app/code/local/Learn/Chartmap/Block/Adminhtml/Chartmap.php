<?php
class Learn_Chartmap_Block_Adminhtml_Chartmap extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_chartmap';
		$this->_blockGroup = 'chartmap';
		$this->_headerText = Mage::helper('chartmap')->__('Chart Map');
		parent::__construct();
	}
}

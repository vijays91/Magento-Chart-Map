<?php
/*- http://en.herveguetin.com/another-way-to-add-a-color-picker-in-magento-system-configuration.html#.VZTwc8-qqkq -*/
class Learn_Chartmap_Adminhtml_ChartmapController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction() {	
		$this->__forward('map');
	}
	
	public function mapAction() {
		
		$this->_title($this->__('Chart Map'))->_title($this->__('Chart Map'));
		
		$this->loadLayout();
		$this->_setActiveMenu('chartmap/items');
		
		$breadcrumbTitle = Mage::helper('chartmap')->__('Chart Map');
		$breadcrumbLabel = Mage::helper('chartmap')->__('Chart Map');
		$this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);
		
		$this->_addContent($this->getLayout()->createBlock('chartmap/adminhtml_chartmap_edit'));		
		$this->renderLayout();
	}
	
	public function areachartAction()
	{		
		$this->_title($this->__('Chart Map'))->_title($this->__('Area Chart Map'));
		
		$this->loadLayout();
		$this->_setActiveMenu('chartmap/items');
	
		$breadcrumbTitle = Mage::helper('chartmap')->__('Chart Map');
		$breadcrumbLabel = Mage::helper('chartmap')->__('Chart Map');
		$this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);
		
		$this->_addContent($this->getLayout()->createBlock('chartmap/adminhtml_areachart_edit'));
		$this->renderLayout();
	}
	
	public function pichartAction()
	{		
		$this->_title($this->__('Chart Map'))->_title($this->__('Pie Chart Map'));		
		$this->loadLayout();
		$this->_setActiveMenu('chartmap/items');	
		$breadcrumbTitle = Mage::helper('chartmap')->__('Chart Map');
		$breadcrumbLabel = Mage::helper('chartmap')->__('Chart Map');
		$this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);
		
		$this->_addContent($this->getLayout()->createBlock('chartmap/adminhtml_pichart_edit'));
		$this->renderLayout();
	}
	
	public function customer_groupAction()
	{		
		$this->_title($this->__('Chart Map'))->_title($this->__('Customer Group Map'));		
		$this->loadLayout();
		$this->_setActiveMenu('chartmap/items');	
		$breadcrumbTitle = Mage::helper('chartmap')->__('Chart Map');
		$breadcrumbLabel = Mage::helper('chartmap')->__('Chart Map');
		$this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);
		
		$this->_addContent($this->getLayout()->createBlock('chartmap/adminhtml_customer_group_edit'));
		$this->renderLayout();
	}
		
}
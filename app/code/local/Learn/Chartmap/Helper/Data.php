<?php
class Learn_Chartmap_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_CMAP_BGCOLOR  		= 'chartmap_tab/chartmap_setting/chartmap_bgcolor';
    const XML_PATH_CMAP_BORDERCOLOR  	= 'chartmap_tab/chartmap_setting/chartmap_bordercolor';
    const XML_PATH_CMAP_COLOR  			= 'chartmap_tab/chartmap_setting/chartmap_color';
		
	public function conf($code, $store = null) {
        return Mage::getStoreConfig($code, $store);
    }
	
	public function cmap_bgcolor($store) {
		return $this->conf(self::XML_PATH_CMAP_BGCOLOR, $store);
	}
	
	public function cmap_bordercolor($store) {
		return $this->conf(self::XML_PATH_CMAP_BORDERCOLOR, $store);
	}

	public function cmap_color() {
		return $this->conf(self::XML_PATH_CMAP_COLOR, $store);
	}
	
	public function jqvmapCss() {
		return "chartmap/jqvmap.css";
	}
	
	public function jqvmapJs() {
		return "chartmap/jqvmap/jquery.vmap.js";
	}
	
	public function jqvmapWorldJs() {
		return "chartmap/jqvmap/maps/jquery.vmap.world.js";
	}
	
	public function jQueryJs() {
		return "chartmap/jquery-2.1.1.min.js";
	}
	public function jsapi() {
		return "chartmap/jsapi.js";
	}


}
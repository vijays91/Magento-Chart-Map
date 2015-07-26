<?php
class Learn_Chartmap_Block_Adminhtml_System_Config_Form_Field_Colorpicker extends Mage_Adminhtml_Block_System_Config_Form_Field
{  
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<script type="text/javascript" src="' . Mage::getBaseUrl('js') . 'chartmap/systemcolorpicker/procolor-1.0/procolor.compressed.js' .'"></script>';
        $input = new Varien_Data_Form_Element_Text();
        $input->setForm($element->getForm())
            ->setElement($element)
            ->setValue($element->getValue())
            ->setHtmlId($element->getHtmlId())
            ->setName($element->getName())
            ->setStyle('width: 100px')
            ->addClass('validate-hex'); 
        $html .= $input->getHtml();
        $html .= $this->_getProcolorJs($element->getHtmlId());
        $html .= $this->_addHexValidator();
        return $html;
    }

    protected function _getProcolorJs($htmlId)
    {
        return '<script type="text/javascript">ProColor.prototype.attachButton(\'' . $htmlId . '\', { imgPath:\'' . Mage::getBaseUrl('js') . 'chartmap/systemcolorpicker/procolor-1.0/' . 'img/procolor_win_\', showInField: true });</script>';
    }
	
    protected function _addHexValidator()
    {
        return '<script type="text/javascript">Validation.add(\'validate-hex\', \'' . Mage::helper('chartmap')->__('Please enter a valid hex color code') . '\', function(v) {
        return /^#(?:[0-9a-fA-F]{3}){1,2}$/.test(v);
        });</script>';
    }
}
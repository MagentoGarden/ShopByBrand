<?php
/**
 * MagentoGarden
 *
 * @category    block
 * @package     magentogarden_attributecategory
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */
class MagentoGarden_AttributeCategory_Block_Option extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
	public function getAttributeId() {
    	return $this->getRequest()->getParam('id');
    }
    
    public function getAttributeCode() {
    	return $this->getRequest()->getParam('code');
    }
    
    public function getOptionId() {
    	return $this->getRequest()->getParam('option');	
    }
    
	public function getProductListHtml()
    {
        return $this->getChildHtml('product_list');
    }
    
	public function getTitle() {
    	$_attribute_code = $this->getAttributeCode();
    	$_model = Mage::getModel('eav/config');
		$_attribute = $_model->getAttribute('catalog_product', $_attribute_code);
		$_options = $_attribute->getSource()->getAllOptions();
		$_option_id = $this->getOptionId();
		
		foreach ($_options as $_option) {
			if ($_option['value'] == $_option_id)
				break;
		}
		
		return $_option['label'];
    }
}
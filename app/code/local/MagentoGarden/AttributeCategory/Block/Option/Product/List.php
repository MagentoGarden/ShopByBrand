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
class MagentoGarden_AttributeCategory_Block_Option_Product_List extends Mage_Catalog_Block_Product_List
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
    
	public function getLayer()
    {
        $layer = Mage::registry('current_layer');
        if ($layer) {
            return $layer;
        }
        return Mage::getSingleton('attributecategory/layer');
    }
}
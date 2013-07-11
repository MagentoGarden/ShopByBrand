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
class MagentoGarden_AttributeCategory_Block_Option_Layer_View extends Mage_Catalog_Block_Layer_View {
	
	public function getAttributeCode() {
    	return $this->getRequest()->getParam('code');
    }
    
	public function getLayer()
    {
        return Mage::getSingleton('attributecategory/layer');
    }
	
	public function getFilters()
    {
    	$_current_attribute_code = $this->getAttributeCode();
    	
        $filters = array();
        if ($categoryFilter = $this->_getCategoryFilter()) {
            $filters[] = $categoryFilter;
        }

        $filterableAttributes = $this->_getFilterableAttributes();
        foreach ($filterableAttributes as $attribute) {
        	if ($attribute->getAttributeCode() == $_current_attribute_code) continue; 
            $filters[] = $this->getChild($attribute->getAttributeCode() . '_filter');
        }

        return $filters;
    }
	
}
<?php
/**
 * MagentoGarden
 *
 * @category    model
 * @package     magentogarden_attributecategory
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */

class MagentoGarden_AttributeCategory_Model_Attribute extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('attributecategory/attribute');
    }
    
    public function loadAttributeById($_attribute_id) {
    	$_collection = $this->getCollection()
    					->addFieldToFilter('attribute_id', $_attribute_id);
    					
    	if ($_collection->getSize() > 0) {
    		foreach ($_collection as $_attribute) {
    			return $this->load($_attribute->getData('entity_id'));
    		}
    	}
    	
    	return $this;
    }
}
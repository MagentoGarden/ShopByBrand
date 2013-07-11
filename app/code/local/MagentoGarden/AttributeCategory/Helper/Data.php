<?php
/**
 * MagentoGarden
 *
 * @category    controller
 * @package     magentogarden_data
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */

class MagentoGarden_AttributeCategory_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getProductCollection($_attribute_code, $_option_id) {
		$_collection = Mage::getModel('catalog/product')->getCollection();
       	$_collection->addAttributeToFilter($_attribute_code, $_option_id);
       	return $_collection;
	}
	
	public function get_rolling_interval() {
		return Mage::getStoreConfig('magentogarden_attributecategory/featured/attribute_rolling_interval');
	}
}
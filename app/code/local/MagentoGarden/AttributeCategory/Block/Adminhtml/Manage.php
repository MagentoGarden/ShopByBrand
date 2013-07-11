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

class MagentoGarden_AttributeCategory_Block_Adminhtml_Manage extends Mage_Core_Block_Template {
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function __construct() {
    	parent::__construct();
    }
    
	private function _isConfigurableAttribute($attribute) {
		//if (! $attribute['is_visible_on_front']) return false;
		if (! $attribute['is_configurable']) return false;
		if ($attribute['frontend_input'] != 'select') return false;
		if (! $attribute['is_user_defined']) return false;
		$_apply_to = $attribute['apply_to'];
		if ($_apply_to == NULL) return true;
		$_apply_to = explode(',', $_apply_to);
		foreach ($_apply_to as $product_type) {
			if ($product_type == 'configurable')
				return true;
		}
		return false;
	}
    
	public function getAttributes() {
		$_collection = Mage::getResourceModel('catalog/product_attribute_collection')
							->addVisibleFilter();				
		$_attributes = array();
		foreach($_collection as $_attribute) {
			$_data = $_attribute->getData();

			if ($this->_isConfigurableAttribute($_data)) {			
				$_code = $_data['attribute_code'];
				$_attributes[$_code] = array();
				$_attributes[$_code]['attribute_id'] = $_data['attribute_id'];
				$_attributes[$_code]['frontend_label'] = $_data['frontend_label'];
				
			}
		}
		
		return $_attributes;
	}
	
	public function getOptionsUrl() {
		$_route = '*/mgac/getOptions/';
		return Mage::helper('adminhtml')->getUrl($_route);
	}   
	
	public function getEnableUrl() {
		$_route = '*/mgac/mgenable/';
		return Mage::helper('adminhtml')->getUrl($_route);
	}
	
	public function getUploadImageUrl() {
		$_route = '*/mgac/mgacupload/';
		return Mage::helper('adminhtml')->getUrl($_route);
	}
	
	public function getFeatureEnableUrl() {
		$_route = '*/mgac/featureenable/';
		return Mage::helper('adminhtml')->getUrl($_route);
	}
	
	public function getPlaceHolder() {
		return Mage::getDesign()->getSkinUrl('images/placeholder/thumbnail.jpg');
	}
	
	public function getFormKey() {
    	$_form_key = Mage::getSingleton('core/session')->getFormKey();
    	return $_form_key;
    }
    
    public function getFrontendUrl($_attribute_id, $_attribute_code) {
    	$_base_url = Mage::app()->getStore(1)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
    	//$_base_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
    	
    	// TODO: change a common way to the front
    	$_url = $_base_url . 'tch/attributecategory/index/index';
    	$_url .= '/id/'.$_attribute_id.'/code/'.$_attribute_code;
    	
    	/*$_url = Mage::getUrl('attributecategory/index/index', 
    						  array('id'=>$_attribute_id,
    						  		'code'=>$_attribute_code)
    						 );*/
    	return $_url;
    }
}
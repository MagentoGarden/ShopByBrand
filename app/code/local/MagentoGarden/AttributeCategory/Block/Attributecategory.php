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
class MagentoGarden_AttributeCategory_Block_Attributecategory extends Mage_Core_Block_Template
{
	protected $_hasFeaturedAttribute = false;
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAttributeCategory()     
     { 
        if (!$this->hasData('attributecategory')) {
            $this->setData('attributecategory', Mage::registry('attributecategory'));
        }
        return $this->getData('attributecategory');
        
    }
    
    public function getAttributeId() {
    	return $this->getRequest()->getParam('id');
    }
    
    public function getAttributeCode() {
    	return $this->getRequest()->getParam('code');
    }
    
	private function _getImageUrl($_filename) {
		$_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'MagentoGarden'.DS.'AttributeCategory'.DS;
		return $_path.$_filename;
	}
	
	private function _groupOptions($_options) {
		$_result = array();
		
		foreach ($_options as $_key=>$_option) {
			$_option_label = $_option['label'];
			$_alpha = substr($_option_label, 0, 1);
			if (!preg_match("/^[a-z]$/i", $_alpha) <= 0) {
				if (! isset($_result[$_alpha]))
					$_result[$_alpha] = array();
				$_result[$_alpha][$_key] = $_option;
			} elseif (!preg_match("/^[0-9]$/i", $_alpha) <= 0) {
				if (! isset($_result['number']))
					$_result['number'] = array();
				$_result['number'][$_key] = $_option;
			} else {
				if (! isset($_result['other']))
					$_result['other'] = array();
				$_result['other'][$_key] = $_option;
			}
		}
		
		// TODO: sort intergroup
		return $_result;
	}
	
	private function _getOptionUrl($_attribute_id, $_attribute_code, $_option_id) {
		$_url = $this->getUrl('attributecategory/index/option');
		$_url .= 'id'.DS.$_attribute_id.DS.'code'.DS.$_attribute_code.DS.'option'.DS.$_option_id;
		return $_url;
	}
    
    public function getOptions() {
    	$_attribute_id = $this->getAttributeId();
    	$_attribute_code = $this->getAttributeCode();
    	
    	$_model = Mage::getModel('eav/config');
		$_attribute = $_model->getAttribute('catalog_product', $_attribute_code);
		$_options = $_attribute->getSource()->getAllOptions();
		$_images = array();
		
		foreach ($_options as $_option) {
			$_option_id = $_option['value'];
			if ($_option_id == '') continue;
			$_model = Mage::getModel('attributecategory/images')
						->loadEntity($_attribute_id, $_option_id);
			$_data = $_model->getData();
			$_images[$_option_id] = array(
				"option_id"=>$_option_id,
				"label"=>ucfirst($_option['label']),
				"url"=>$this->_getOptionUrl($_attribute_id, $_attribute_code, $_option_id)
			);
			
			if (isset($_data['entity_id'])) {
				$_images[$_option_id]['image'] = $this->_getImageUrl($_data['image']);
				if ($_data['enabled'] == 1) {
					$_images[$_option_id]['enabled'] = true;
					$this->_hasFeaturedAttribute = true;
				}
			} else {
				$_images[$_option_id]['image'] = null;
			}
		}
		return $this->_groupOptions($_images);
    }
    
    /**
     * @return boolean
     * Enter description here ...
     */
    public function hasFeaturedAttribute() {
    	return $this->_hasFeaturedAttribute;
    }
	
	/**
	 * @return int Default Feature Image Width
	 * 
	 */
	public function getAttributeImageWidth() {
		return Mage::getStoreConfig('magentogarden_attributecategory/featured/attribute_image_size_width');
	}
	
	/**
	 * @return int Default Feature Image Height
	 */
	public function getAttributeImageHeight() {
		return Mage::getStoreConfig('magentogarden_attributecategory/featured/attribute_image_size_height');
	}
	
	public function get_rolling_interval() {
		return Mage::helper('attributecategory')->get_rolling_interval();
	}
}
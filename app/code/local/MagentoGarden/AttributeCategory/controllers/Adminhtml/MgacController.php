<?php
/**
 * MagentoGarden
 *
 * @category    controller
 * @package     magentogarden_attributecategory
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */

class MagentoGarden_AttributeCategory_Adminhtml_MgacController extends Mage_Adminhtml_Controller_Action {
	
	public function manageAction() {
		$this->loadLayout();     
		$this->renderLayout();
	}
	
	private function _getImageUrl($_filename) {
		$_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'MagentoGarden'.DS.'AttributeCategory'.DS;
		return $_path.$_filename;
	}
	
	private function _isEnabled($_attribute_id) {
		$_model = Mage::getModel('attributecategory/attribute')
						->loadAttributeById($_attribute_id);
		$_data = $_model->getData();
		 
		if (isset($_data['enabled'])) {
			return ($_data['enabled'] == 1);
		} else {
			$_model->setData('attribute_id', $_attribute_id);
			$_model->setData('enabled', 0);
			$_model->setData('update_time', date('Y-m-d H:i:s', time()));
			$_model->save();
			return false;
		}
	}
	
	private function _getImages($_attribute_id, $_attribute_code) {
		// get options
		$_model = Mage::getModel('eav/config');
		$_attribute = $_model->getAttribute('catalog_product', $_attribute_code);
		$_options = $_attribute->getSource()->getAllOptions();
		$_images = array();
		
		foreach ($_options as $_option) {
			$_option_id = $_option['value'];
			$_model = Mage::getModel('attributecategory/images')
						->loadEntity($_attribute_id, $_option_id);
			$_data = $_model->getData();
			$_images[$_option_id] = array(
				"option_id"=>$_option_id,
				"label"=>$_option['label'],
			);
			if (isset($_data['entity_id'])) {
				$_images[$_option_id]['image'] = $this->_getImageUrl($_data['image']);
				$_images[$_option_id]['enabled'] = $_data['enabled'];
			} else {
				$_images[$_option_id]['image'] = null;
			}
		}
		return $_images;
	}
	
	public function getOptionsAction() {
		$_attribute_id = $this->getRequest()->getParam('id');
		$_attribute_code = $this->getRequest()->getParam('code');
		
		$_result = array();
		$_result['enabled'] = $this->_isEnabled($_attribute_id);
		$_result['images'] = $this->_getImages($_attribute_id, $_attribute_code);

		echo json_encode($_result);
	}
	
	public function mgenableAction() {
		$_attribute_id = $this->getRequest()->getParam('id');
		$_model = Mage::getModel('attributecategory/attribute')
						->loadAttributeById($_attribute_id);
		$_enabled = $_model->getData('enabled');
		$_model->setData('enabled', 1-$_enabled);
		$_model->save();
	}
	
	public function mgacuploadAction() {
		$_id = $this->getRequest()->getParam('id');
		$_option = $this->getRequest()->getParam('option');
		$_code = $this->getRequest()->getParam('code');
		$_uploadname = 'uploader-'.$_id.'-'.$_option;
		
		// Upload
		$_filename = rand(0, 10000).$_FILES[$_uploadname]['name'];
		$_uploader = new Varien_File_Uploader($_uploadname);
		$_path = Mage::getBaseDir('media').DS.'MagentoGarden'.DS.'AttributeCategory'.DS;
		$_uploader->save($_path, $_filename);
		
		// Database
		$_model = Mage::getModel('attributecategory/images')->loadEntity($_id, $_option);
		$_data = $_model->getData();
		if (! isset($_data['entity_id'])) {
			$_model->setData('attribute_id', $_id);
			$_model->setData('option_id', $_option);			
		}
		$_model->setData('image', $_filename);
		$_model->setData('update_time', date('Y-m-d H:i:s',time()));
		$_model->save();
		
		$_data = $_model->getData();
		$_data['image'] = $this->_getImageUrl($_data['image']);
		echo json_encode($_data);
	}
	
	public function featureenableAction() {
		$_id = $this->getRequest()->getParam('id');
		$_option = $this->getRequest()->getParam('option');
		
		$_model = Mage::getModel('attributecategory/images')->loadEntity($_id, $_option);
		$_enable = 1 - $_model->getData('enabled');
		$_model->setData('enabled', $_enable);
		$_model->save();
	}
	
}
<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * MagentoGarden
 *
 * @category    model
 * @package     magentogarden_attributecategory
 * @copyright   Copyright (c) 2012 MagentoGarden Inc. (http://www.magentogarden.com)
 * @version		1.0
 * @author		MagentoGarden (coder@magentogarden.com)
 */
class MagentoGarden_AttributeCategory_Model_Layer extends Mage_Catalog_Model_Layer
{
    private function _getKeyValue($_key, $_uri) {
    	$_uri = explode('/', $_uri);
    	$_count = count($_uri);
    	for ($_i = $_count-1; $_i > 0; $_i--) {
    		if ($_uri[$_i] == $_key) {
    			return $_uri[$_i+1];
    		}
    	}
    	return null;
    }
    
	public function getAttributeCode() {
		$_uri = Mage::getSingleton('core/app')->getRequest()->getRequestUri();
		//$_base_url = Mage::getSingleton('core/app')->getRequest()->getBaseUrl();
		return $this->_getKeyValue('code', $_uri);
    }
    
    public function getOptionId() {
    	$_uri = Mage::getSingleton('core/app')->getRequest()->getRequestUri();
    	return $this->_getKeyValue('option', $_uri);	
    }
    
    /**
     * Retrieve current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    public function getProductCollection() {
    	$_attribute_code = $this->getAttributeCode();
    	$_option_id = $this->getOptionId();
    	
    	$_index = $_attribute_code . '_' . $_option_id;
    	if (isset($this->_productCollections[$_index])) {
    		$_collection = $this->_productCollections[$_index];
    	} else {
    		$_helper = Mage::helper('attributecategory/data');
    		$_collection = $_helper->getProductCollection($_attribute_code, $_option_id);
    		$this->_productCollections[$_index] = $_collection;
    	}
    	return $_collection;
    }
}

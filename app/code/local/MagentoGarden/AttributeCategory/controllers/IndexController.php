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

class MagentoGarden_AttributeCategory_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
    
	public function optionAction() {
    	$this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('checkout/session');
        $this->loadLayout();
        $this->renderLayout();
    }
}
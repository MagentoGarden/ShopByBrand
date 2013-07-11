<?php
class MagentoGarden_Mgsys_Adminhtml_MgsysController extends Mage_Adminhtml_Controller_Action
{
	public function extensionAction() {
		$this->loadLayout();     
		$this->renderLayout();
	}
}
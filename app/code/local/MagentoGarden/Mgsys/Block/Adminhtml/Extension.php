<?php

class MagentoGarden_Mgsys_Block_Adminhtml_Extension extends Mage_Core_Block_Template {
	//const GET_VERSION_URL = 'http://www.magentogarden.com/mgserver/feed/version/';
	const GET_VERSION_URL = 'http://www.magentogarden.com/mgserver/feed/version/';
	
	public function getMgExtensions() {
		$_modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
		sort($_modules);
		$_extensions = array();

        foreach ($_modules as $_module_name) {
        	if (strstr($_module_name,'MagentoGarden_') === false) {
        		continue;
        	}
			
			if($_module_name == 'MagentoGarden_Mgsys'){
				continue;
			}
			
			$_extensions[] = $this->_getExtensionByName($_module_name);
        }
        return $_extensions;
	}
	
	private function _getLatestVersion($_id) {
		$_curl = curl_init();
		$_data['id'] = $_id;
		$_data_string = implode("&", $_data);
		$_url = self::GET_VERSION_URL . 'id/' . $_id;
		curl_setopt($_curl, CURLOPT_URL, $_url);
		curl_setopt($_curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($_curl, CURLOPT_POST, false);
		$_data = curl_exec($_curl);
		curl_close($_curl);
		
		if ($_data === false) {
			return false;
		}
		
		$_data = (array)json_decode($_data);
		return $_data['version'];
	}
	
	private function _getExtensionByName($_module_name) {
		$_config_data = $this->getConfigData();
		
		try {
            if($_platform = Mage::getConfig()->getNode("modules/$_module_name/platform")){
                $_platform = strtolower($_platform);
                $_ignore_platform = false;
            }else{
                throw new Exception();
            }
        } catch(Exception $e){
             $_platform="ce";
             $_ignore_platform = true;
        } 
		
		$_module_key = substr($_module_name, strpos($_module_name,'_')+1);
		$_ver = (string)(Mage::getConfig()->getModuleConfig($_module_name)->version);
		if (!$_name = Mage::getConfig()->getNode("modules/$_module_name/name")) {
			$_name = $_module_name;
		}
		if ($_id = Mage::getConfig()->getNode("modules/$_module_name/id")) {
			$_latest = $this->_getLatestVersion($_id);
		} else {
			$_latest = "";
		}
		
		if (! $_url = Mage::getConfig()->getNode("modules/$_module_name/url")) {
			$_url = "#";
		}
		
		return array(
			'name' => $_name,
			'ver' => $_ver,
			'latest' => $_latest, 
			'url' => $_url,
		);
	}

	public function getContactUrl() {
		//return "http://www.testmagento.com/mgtgd/mgserver/contact";
		return "http://www.magentogarden.com/mgserver/contact";
	}
}

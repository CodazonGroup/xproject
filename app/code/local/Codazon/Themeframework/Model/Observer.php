<?php
function pr($a){
	echo "<pre>";
	print_r($a);
	echo "</pre>";
}
class Codazon_Themeframework_Model_Observer
{
	const SECTION = 'codazon_settings';
	protected $_config;
	protected function _loadConfig(){
		if(empty($this->_config)){
			$config = array();
			$etcDir = Mage::getModuleDir("etc",'Codazon_Themeframework');
			$systemFile = $etcDir.DS.'system.xml';
			$xmlObj = new Varien_Simplexml_Config($systemFile);
			$xmlData = $xmlObj->getNode();
			$groups = get_object_vars($xmlData->sections->{self::SECTION}->groups);
			$section = self::SECTION;
			foreach($groups as $groupCode => $group){
				foreach(get_object_vars($group->fields) as $fieldCode => $field){
					if(isset($field->frontend_model) and ($field->frontend_model == 'adminhtml/system_config_form_field_heading')){
						continue;	
					}
					$config[$groupCode][$fieldCode] = Mage::getStoreConfig($section . '/' . $groupCode . '/' .$fieldCode);
				}
			}
			$this->_config = $config;
		}
		return $this->_config;
	}
	public function loadConfig(){
		Mage::register('theme_config', (object)$this->_loadConfig());
	}
}
?>
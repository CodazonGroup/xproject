<?php
class Codazon_Quickshop_Block_Quickshop extends Mage_Core_Block_Template{
	public $store;
    protected function _construct(){
		$this->store = Mage::app()->getStore();
		parent::_construct();
    }
    protected function _prepareLayout(){
		return parent::_prepareLayout();
    }
	public function quickshopEnabled(){
		$enabled = Mage::getStoreConfig('codazon_quickshop/general/quickshop_enabled',Mage::app()->getStore());
		if($enabled == 1){
			return true;	
		}else{
			return false;	
		}
	}
	public function getItemClass(){
		return Mage::getStoreConfig('codazon_quickshop/general/quickshop_itemclass',$this->store);
	}
	public function getQuickShopLabel(){
		return Mage::getStoreConfig('codazon_quickshop/general/quickshop_label',$this->store);	
	}
	public function canShowIframe(){
		$module = $this->getRequest()->getModuleName();
		$controller = $this->getRequest()->getControllerName();
		$action = $this->getRequest()->getActionName();
		$fullAction = $module.'_'.$controller.'_'.$action;
		if($fullAction != 'quickshop_index_view'){
			return true;
		}else{
			return false;
		}
	}
}
?>
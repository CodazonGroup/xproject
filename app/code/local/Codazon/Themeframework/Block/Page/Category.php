<?php
class Codazon_Themeframework_Block_Page_Category extends Mage_Core_Block_Template
{
	protected $_catId;
	protected $_catModel;
	const PAGE_VAR_NAME = 'cp';
	const DEFAULT_LIMIT = 12;
	
	public function _construct(){
		$this->_catModel = Mage::getModel('catalog/category');
		parent::_construct();
	}
	public function getCatId(){
		if(!$this->_catId){
			$this->_catId = $this->getRequest()->getParam('id');
		}
		return $this->_catId;
	}
	public function getCurrentCategory(){
		if (!$this->hasData('current_category')) {
            $this->setData('current_category', Mage::registry('current_category'));
        }
        return $this->getData('current_category');	
	}
	public function getChildren(){
		if (!$this->hasData('children')) {
			$limit = $this->getRequest()->getParam('limit');
			$limit = $limit?$limit:self::DEFAULT_LIMIT;
			$page = $this->getRequest()->getParam(self::PAGE_VAR_NAME);
			$page = $page?$page:1;
			$id = $this->getCatId();
			$children = Mage::getResourceModel('catalog/category_collection');
			$children->getSelect()->where("parent_id = $id");
			$children->addAttributeToSelect('e.entity_id')->setPageSize($limit,$page);
			$this->setData('children',$children);
		}
		return $this->getData('children');
	}
	public function getCollectionById($id){
		return $this->_catModel->setStoreId(Mage::app()->getStore()->getId())->load($id);
	}
}
?>
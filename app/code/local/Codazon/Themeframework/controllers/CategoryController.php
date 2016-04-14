<?php
class Codazon_Themeframework_CategoryController extends Mage_Core_Controller_Front_Action
{
	protected $_catId;
	
	public function indexAction(){
		 if ($category = $this->_initCatagory()) {
			$this->loadLayout();
			$root = $this->getLayout()->getBlock('root');
			$root->addBodyClass('categorypath-' . $category->getUrlPath())
				->addBodyClass('category-' . $category->getUrlKey());
			$this->getLayout()->getBlock('head')->setTitle($this->__('All categories of')." ".$category->getName());
			$this->renderLayout();
		 }
	}
	public function getCatId(){
		if(!$this->_catId){
			$this->_catId = $this->getRequest()->getParam('id');
		}
		return $this->_catId;
	}
	protected function _initCatagory()
    {
        $categoryId = (int) $this->getRequest()->getParam('id', false);
        if (!$categoryId) {
            return false;
        }

        $category = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($categoryId);

        if (!Mage::helper('catalog/category')->canShow($category)) {
            //return false;
        }
        Mage::getSingleton('catalog/session')->setLastVisitedCategoryId($category->getId());
        Mage::register('current_category', $category);
        Mage::register('current_entity_key', $category->getPath());
        return $category;
    }
}

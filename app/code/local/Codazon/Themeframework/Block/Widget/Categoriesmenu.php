<?php
class Codazon_Themeframework_Block_Widget_Categoriesmenu extends Mage_Page_Block_Html_Topmenu implements Mage_Widget_Block_Interface
{
	protected $_templateFile;
	
	public function _construct(){
		$this->_urlModel = Mage::getSingleton('core/url_rewrite')->getResource();
		$this->_catModel = Mage::getModel('catalog/category');
		parent::_construct();
		$this->addData(array(
			'cache_lifetime' => 3600,
			'cache_tags'     => array('CODAZON_FILTER'),
			'cache_key'      => 'codazon_categoriesmenu_'.md5(json_encode($this->getData())).$this->getStoreId(),
		));
	}
	
	public function getCategoryUrlById($id){
		$requestPath = $this->_urlModel->getRequestPathByIdPath('category/' . $id, Mage::app()->getStore()->getId());
		if(!empty($requestPath)){
			return Mage::getBaseUrl() . $requestPath;
		} else {
			return $this->_catModel->load($id)->getUrl();
		}
	}
	protected function _toHtml(){
		$default = array_replace( array(
			'id_path' => 'category/2',
			'template' => 'codazon_themeframework/widget/categoriesmenu.phtml',
			'children_wrap_class' => 'cdz-sub-cat',
			'has_wrap' => true,
			'parent_wrap_class' => 'cdz-nav-wrap'
		), $this->getData());
		$this->setData($default);
		
		$menuTree = $this->getMenuTree();
        $childrenWrapClass = $this->getChildrenWrapClass();
		if(is_null($this->getTemplate())){
			$this->setTemplate($this->getData('template'));
		}
		if (!$this->getData('template') || is_null($menuTree) || is_null($childrenWrapClass)) {
            throw new Exception("Top-menu renderer isn't fully configured.");
        }

        $includeFilePath = realpath(Mage::getBaseDir('design') . DS . $this->getTemplateFile());
        if (strpos($includeFilePath, realpath(Mage::getBaseDir('design'))) === 0) {
            $this->_templateFile = $includeFilePath;
        } else {
            throw new Exception('Not valid template file:' . $this->_templateFile);
        }
        $html = $this->render($menuTree, $childrenWrapClass,$this->getHasWrap(),$this->getParentWrapClass());
		return $html;
	}
	protected function getMenuTree(){
		$parentId = explode('/', $this->getData('id_path'));
		$parentId = $parentId[1];
		if($this->hasStoreId()) {
			$store = Mage::app()->getStore($this->getStoreId());
		} else {
			$store = Mage::app()->getStore();
		}
		$storeId = $store->getId();
		$tree = Mage::getResourceSingleton('catalog/category_tree')->load();
		$parent = $tree->getNodeById($parentId);
		
		$collection = $this->_catModel->getCollection()
			->setStoreId($storeId)
			->addAttributeToSelect('name')
			->addAttributeToSelect('is_active');
		
		$tree->addCollectionData($collection, true);
		return  $parent;
	}
	
	public function render(Varien_Data_Tree_Node $menuTree, $childrenWrapClass = '', $hasWrap = false, $parentWrapClass = 'nav-wrap', $options=null)
    {
        ob_start();
       	$html = include $this->_templateFile;
        $directOutput = ob_get_clean();

        if (is_string($html)) {
            return $html;
        } else {
            return $directOutput;
        }
    }
}
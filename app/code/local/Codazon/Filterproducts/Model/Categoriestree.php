<?php
class Codazon_Filterproducts_Model_Categoriestree extends Mage_Core_Model_Abstract{
	protected $_categoriesTree = '';
	public function toOptionArray(){
		$tree = $this->loadTree();
		$this->printTree($tree['children'],0);
		return $this->_categoriesTree;
	}
	function nodeToArray(Varien_Data_Tree_Node $node){
		$result = array();
		$result['category_id'] = $node->getId();
		$result['parent_id'] = $node->getParentId();
		$result['name'] = $node->getName();
		$result['is_active'] = $node->getIsActive();
		$result['position'] = $node->getPosition();
		$result['level'] = $node->getLevel();
		$result['children'] = array();

		foreach ($node->getChildren() as $child) {
			$result['children'][] = $this->nodeToArray($child);
		}
		return $result;
	}
	function printTree($tree, $level) {
		$level++;
		foreach($tree as $item) {
			$this->_categoriesTree[] = array('value' => $item['category_id'],'label' => str_repeat("–––", $level)." ".$item['name']);
			$this->printTree($item['children'],$level);
		}
	}
	public function loadTree(){
		$storeId = 1;
		$parentId = 1;
		$tree = Mage::getResourceSingleton('catalog/category_tree')->load();
		$root = $tree->getNodeById($parentId);
		if($root and $root->getId() == 1){
			$root->setName(Mage::helper('catalog')->__('Root'));	
		}
		$collection = Mage::getModel('catalog/category')->getCollection()
		->setStoreId($storeId)
		->addAttributeToSelect('name')
		->addAttributeToSelect('is_active');
		
		$tree->addCollectionData($collection, true);
		return $this->nodeToArray($root);
	}
}
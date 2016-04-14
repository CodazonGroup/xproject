<?php
class Codazon_Blogfeatures_Block_Codazonblogpostlist
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
	protected $_postCollection;
	protected $_dataArray;
	protected $_showInFront;
	public function setPostCollection($collection){
		$this->_postCollection = $collection;
	}
	public function getPostCollection(){
		if(!$this->_postCollection){
			$this->_postCollection = $this->_prepareCollection();
		}
		return $this->_postCollection;
	}
	public function _construct(){
		$this->_dataArray = array_replace( array(
			'blog_title' => '',
			'categories' => '',
			'orderby' => 'created_time',
			'order' => 'desc',
			'post_count' => 8,
			'desc_length' => 100,
			'use_slider' => true,
			'thumb_width' => 300,
			'thumb_height' => 200,
			'template' => 'codazon_blogfeatures/grid.phtml',
			'show_in_front' => 'post_image,title,short_content,created_time,user'
		),$this->getData());
		$this->addData($this->_dataArray);
		$this->_showInFront = explode(',',$this->getData('show_in_front'));
	}
    protected function _toHtml()
    {
		$template = $this->getData('template');
		$this->setTemplate($template);
		$html = parent::_toHtml();
		return $html;
    }
	protected function _prepareCollection(){
		$collection = Mage::getModel('blog/blog')->getCollection();
		
		if($this->getData('categories') !== ''){
			$postCatTable = Mage::getSingleton('core/resource')->getTableName('blog/post_cat');
			$collection->getSelect()->joinLeft(
				array('pc' => $postCatTable), 'pc.post_id = main_table.post_id',
				array('cat_id' => 'pc.cat_id')
			)->group('main_table.post_id');
			$collection->addFieldToFilter('pc.cat_id', array('in' => explode(',',trim( $this->getData('categories') ))) );
		}
		
		$collection->addPresentFilter()	
			->addEnableFilter(AW_Blog_Model_Status::STATUS_ENABLED)
			->addStoreFilter();	
			
		$collection->setOrder($this->getOrderby(),$this->getOrder());
		$collection->setPageSize($this->getPostCount())->setCurPage(1);
		
		return $collection;
	}
	public function show($field){
		return in_array($field, $this->_showInFront);
	}
}
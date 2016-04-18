<?php
class Codazon_Filterproducts_Block_Codazonfilterproducts
    extends Mage_Catalog_Block_Product_List
    implements Mage_Widget_Block_Interface
{
	protected $_dataArray;
	public function getDataArray(){
		return $this->_dataArray;	
	}
	protected function _construct()
	{
		$this->addData(array(
			'cache_lifetime' => 3600,
			'cache_tags'     => array('CODAZON_FILTER'),
			'cache_key'      => 'codazon_filterproducts_'.md5(json_encode($this->getData())),
		));
	}
	public function display($element){
		if( in_array($element,$this->_dataArray['display']) ){
			return true;
		}else{
			return false;
		}
	}
	protected function _toHtml(){
		$this->_dataArray = array_replace( array(
			'categories'	=> array(),
			'filtertype' 	=> '',
			'attribute'		=> '',
			'orderby'		=> 'price',
			'order'			=> 'asc',
			'limit'			=> 12,
			'use_ajax'		=> 0,
			'template'		=> 'codazon_filterproducts/grid.phtml',
			'custom_class'	=> '',
			'custom_template'=>'codazon_filterproducts/custom.phtml',
			'display'		=> 'name,image,price,description,addtocart_btn,wishlist_btn,compare_btn',
			'thumb_width'	=> 250,
			'thumb_height'	=> 250,
			'column_count'	=> 5,
			'use_slider'	=> 0,
			'auto_width'	=> 0,
			'margin'		=> 0,
			'items_1280'	=> 4,
			'items_1024'	=> 3,
			'items_768'		=> 3,
			'items_480'		=> 3,
			'items_320'		=> 2,
			'items_0'		=> 1,
			'auto_play'		=> 0,
			'show_dots'		=> 0,
			'show_nav'		=> 1,
			'lazy_load'		=> 0,
			'loop'			=> 0,
			'cur_page'		=> 1
		),$this->getData() );
		
		$data = $this->_dataArray;
		
		if( $this->getData('use_ajax') != 1){
			$this->_dataArray['display'] = explode(',',$data['display']);
		}
		if($data['categories'] != array()){
			$data['categories'] = array_unique(explode(',',trim($data['categories'])));
		}
		switch($data['filtertype']){
			case 0:
				$collection =  Mage::getResourceModel('catalog/product_collection')->addAttributeToSelect('*')->addStoreFilter();
				break;
			case 1:	//new
				$collection = $this->getNewProducts($data['categories']);
				$collection->setOrder($data['orderby'], $data['order']);
				break;
			case 2:	//best seller
				$collection = $this->getBestSellerProducts();
				break;
			case 3: //most viewed
				$collection = $this->getMostViewProducts();
				break;
			case 4:	//attribute
				$collection = $this->getProductsByAttribute($data['attribute']);
				$collection->setOrder($data['orderby'], $data['order']);
				break;
		}
		
		$this->addCategoriestoFilter($collection,$data['categories']);
		$collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		$collection->setPageSize($data['limit']);
		$collection->setCurPage($data['cur_page']);
		$this->setProductCollection($collection);		
		$collection->getSelect()->group('e.entity_id');
		//return $collection->getSelect();

		if($data['use_ajax'] == 0){
			if($data['template'] != 'custom'){
				$this->setTemplate($data['template']);
			}else{
				$this->setTemplate($data['custom_template']);
			}
		}else{
			$this->setTemplate('codazon_filterproducts/ajax.phtml');
		}
		$html = parent::_toHtml();
		return $html;
    }
	public function addCategoriestoFilter(&$collection,array $categories = null){
		
		if(count($categories) > 0){
			$collection->joinField('category_id',
				'catalog/category_product',
				'category_id',
				'product_id = entity_id',
				NULL,
				'left'
			);
			$collection->addAttributeToFilter('category_id', array('in' => $categories ));
		}
	}
	public function getNewProducts($categories){
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getResourceModel('catalog/product_collection');
		$collection = $this->_addProductAttributesAndPrices($collection)
			->addStoreFilter()
			->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
			->addAttributeToFilter('news_to_date', array('or'=> array(
				0 => array('date' => true, 'from' => $todayDate),
				1 => array('is' => new Zend_Db_Expr('null')))
			), 'left')
         ->addAttributeToSort('news_from_date', 'desc');
		return $collection;
	}
	public function getMostViewProducts(){
		$storeId = Mage::app()->getStore()->getId();
		$collection = Mage::getResourceModel('reports/product_collection')
			->addOrderedQty()
			->addAttributeToSelect('*')
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->addViewsCount();
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		return $collection; 
	}
	public function getBestSellerProducts(){
		$storeId = (int) Mage::app()->getStore()->getId();
        // Date
        $date = new Zend_Date();
        $toDate = $date->setDay(1)->getDate()->get('Y-MM-dd');
        $fromDate = $date->subMonth(1)->getDate()->get('Y-MM-dd');
 
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addStoreFilter($storeId)
            ->addPriceData()
            ->addTaxPercents()
            ->addUrlRewrite();
            //->setPageSize(6);
        $collection->getSelect()
            ->joinLeft(
                array('aggregation' => $collection->getResource()->getTable('sales/bestsellers_aggregated_monthly')),
                "e.entity_id = aggregation.product_id AND aggregation.store_id={$storeId} AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'",
                array('SUM(aggregation.qty_ordered) AS sold_quantity')
            )
			//->where('aggregation.qty_ordered > 0')
            //->group('e.entity_id')
            ->order(array('sold_quantity DESC', 'e.created_at'));
 
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
 
        return $collection;
	}
	public function getProductsByAttribute($attribute){
		$storeId = Mage::app()->getStore()->getId();
        $collection =  Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*')
			->addAttributeToFilter($attribute,true)
            ->load();
		return $collection;
	}
	public function getProductGalleryHtml($product, $template = 'codazon_filterproducts/view/media.phtml'){
		return $this->getLayout()->createBlock('catalog/product_view_media')->setProduct($product)->setTemplate($template)->toHtml();
	}
}
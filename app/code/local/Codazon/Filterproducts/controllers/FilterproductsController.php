<?php
class Codazon_Filterproducts_FilterproductsController extends Mage_Core_Controller_Front_Action
{
	public function loadProductsBlockAction(){
		$data = $this->getRequest()->getParams();
		$data['use_ajax'] = 0;
		$data['after_load'] = 1;
		$data['cache_key'] = md5(json_encode($data));
		
		$block = Mage::app()->getLayout()->createBlock('filterproducts/codazonfilterproducts','ajax_products_block',$data);
		$result['html'] = $block->toHtml();
		$this->getResponse()->setHeader('Content-type', 'application/json');
		$this->getResponse()->setBody(json_encode($result));
	}
	public function loadMoreItemsAction(){
		$data = $this->getRequest()->getParams();
		$data['added_item'] = true;
		$data['cache_key'] = md5(json_encode($data));
		$block = Mage::app()->getLayout()->createBlock('filterproducts/codazonfilterproducts','ajax_more_products_block',$data);
		$result['html'] = $block->toHtml();
		$this->getResponse()->setHeader('Content-type', 'application/json');
		$this->getResponse()->setBody(json_encode($result));	
	}
}
?>
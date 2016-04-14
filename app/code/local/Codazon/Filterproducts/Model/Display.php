<?php
class Codazon_Filterproducts_Model_Display extends Mage_Core_Model_Abstract{
	public function toOptionArray(){
		$display = array(
			array('value'=>'name', 'label' => 'Product name'),
			array('value'=>'image', 'label' => 'Product image'),
			array('value'=>'price', 'label' => 'Product price'),
			array('value'=>'rating', 'label' => 'Rating'),
			array('value'=>'description', 'label' => 'Description'),
			array('value'=>'addtocart_btn', 'label' => 'Add to cart button'),
			array('value'=>'wishlist_btn' , 'label'	=> 'Wishlist button'),
			array('value'=>'compare_btn', 'label' => 'Compare button')
		);
		return $display;
	}	
}
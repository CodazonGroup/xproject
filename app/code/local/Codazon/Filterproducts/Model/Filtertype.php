<?php
class Codazon_Filterproducts_Model_Filtertype extends Mage_Core_Model_Abstract{
	public function toOptionArray(){
		$filterType = array(
			'0'	=> 'Only filter by catgories',
			'1'	=> 'New',
			'2' => 'Best Seller',
			'3' => 'Most View',
			'4'	=> 'Attribute',
		);
		return $filterType;
	}	
}
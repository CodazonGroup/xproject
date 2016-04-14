<?php
class Codazon_Filterproducts_Model_Attributes extends Mage_Core_Model_Abstract{
	public function toOptionArray(){
		$filterType = array(
			'em_new'		 =>	$this->__('New'),
			'bestseller' => $this->__('Best Seller'),
			'recentview' => $this->__('Recent View'),
			'attribute'	 => $this->__('Attribute'),
		);
		return $filterType;
	}	
}
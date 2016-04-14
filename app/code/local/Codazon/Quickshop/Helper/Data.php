<?php
class Codazon_Quickshop_Helper_Data extends Mage_Core_Helper_Abstract
{
	function getQuickshopHtml($product){
		$quickshop = Mage::app()->getLayout()->createBlock('quickshop/quickshop');
		$quickshop->setProduct($product);
		$quickshop->setTemplate('codazon_quickshop/button.phtml');
		return $quickshop->toHtml();
	}
}
	 
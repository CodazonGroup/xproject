<?php


class Codazon_Slideshow_Block_Adminhtml_Slideshow extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

		$this->_controller = "adminhtml_slideshow";
		$this->_blockGroup = "slideshow";
		$this->_headerText = Mage::helper("slideshow")->__("slideshow Manager");
		$this->_addButtonLabel = Mage::helper("slideshow")->__("Add New Item");
		parent::__construct();
	
	}

}
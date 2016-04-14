<?php
class Codazon_Slideshow_Block_Adminhtml_Slideshow_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId("slideshow_tabs");
		$this->setDestElementId("edit_form");
		$this->setTitle(Mage::helper("slideshow")->__("Slideshow Information"));
	}
	protected function _beforeToHtml()
	{
		$this->addTab("form_settings", array(
			"label" => Mage::helper("slideshow")->__("Settings"),
			"title" => Mage::helper("slideshow")->__("Settings"),
			"content" => $this->getLayout()->createBlock("slideshow/adminhtml_slideshow_edit_tab_accordion")->toHtml(),
			));
		$this->addTab("form_slider", array(
			"label" => Mage::helper("slideshow")->__("Sliders"),
			"title" => Mage::helper("slideshow")->__("Sliders"),
			"content" => $this->getLayout()->createBlock("slideshow/adminhtml_slideshow_edit_tab_slider")->toHtml(),
			));

		return parent::_beforeToHtml();
	}

}

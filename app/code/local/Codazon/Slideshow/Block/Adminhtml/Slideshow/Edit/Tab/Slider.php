<?php
class Codazon_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Slider extends Mage_Adminhtml_Block_Widget_Form
{
	public function _construct()
    {


        parent::_construct();
        $this->_fieldSetCollection = array();
        $this->_titleFieldSet = '';
        $this->_comment = '';        
        $this->setTemplate('codazon_slideshow/edit/tab/slider.phtml');
    }

	protected function _prepareForm()
	{

		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset("slideshow_form", array("legend"=>Mage::helper("slideshow")->__("Item information")));




		if (Mage::getSingleton("adminhtml/session")->getslideshowData())
		{
			$form->setValues(Mage::getSingleton("adminhtml/session")->getslideshowData());
			Mage::getSingleton("adminhtml/session")->setslideshowData(null);
		} 
		elseif(Mage::registry("slideshow_data")) {			
			$form->setValues(json_decode(Mage::registry("slideshow_data")->getSlider(),true));
			$this->setData("slider",json_decode(Mage::registry("slideshow_data")->getSlider(),true));
		}
		return parent::_prepareForm();
	}


}

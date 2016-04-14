<?php
class Codazon_Slideshow_Block_slideshow extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
	protected function _construct()
	{
		parent::_construct();
        $this->setCacheTags(array(Mage_Cms_Model_Block::CACHE_TAG));
        $this->setCacheLifetime(false);

	}
	public function getCacheKeyInfo()
	{	
		$id	=	$this->getData('slideshow_id');			 
        if ($id) {
            $result = array(
               'cdz_slideshow',
				Mage::app()->getStore()->getId(),
				(int)Mage::app()->getStore()->isCurrentlySecure(),
				Mage::getDesign()->getPackageName(),
				Mage::getDesign()->getTheme('template'),
				serialize($this->getData())
            );
        } else {
            $result = parent::getCacheKeyInfo();
        }
        return $result;
	}
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

	public function _toHtml(){
		$this->setTemplate('codazon_slideshow/slideshow.phtml');
		return parent::_toHtml();
	}

	public function getSlider()
    {
		$id	=	$this->getData('slideshow_id');		
		$slider  = Mage::getModel('slideshow/slideshow')->load($id)->getData();
		
		$slider['parameters']=json_decode($slider['parameters'],JSON_HEX_TAG);		
		$slider['slider']=json_decode($slider['slider'],JSON_HEX_TAG);				
		return $slider;
    }
}
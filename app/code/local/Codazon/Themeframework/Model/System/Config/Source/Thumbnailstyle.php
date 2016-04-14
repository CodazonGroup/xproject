<?php
class Codazon_Themeframework_Model_System_Config_Source_Thumbnailstyle
{
	public function toOptionArray()
    {
		$helper = Mage::helper('themeframework');
        return array(
            array('value' => 0, 'label' => $helper->__('Horizontal')),
            array('value' => 1, 'label' => $helper->__('Vertical')),
        );
    }
}
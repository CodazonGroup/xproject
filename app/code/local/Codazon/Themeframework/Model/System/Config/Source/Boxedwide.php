<?php
class Codazon_Themeframework_Model_System_Config_Source_Boxedwide
{
	public function toOptionArray()
    {
		$helper = Mage::helper('themeframework');
        return array(
            array('value' => 0, 'label' => $helper->__('Boxed')),
            array('value' => 1, 'label' => $helper->__('Wide')),
        );
    }
}
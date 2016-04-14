<?php
class Codazon_Themeframework_Model_System_Config_Source_Columnsperrow
{
	public function toOptionArray()
    {
		$helper = Mage::helper('themeframework');
        return array(
            array('value' => 1, 'label' => $helper->__('1')),
            array('value' => 2, 'label' => $helper->__('2')),
			array('value' => 3, 'label' => $helper->__('3')),
            array('value' => 4, 'label' => $helper->__('4')),
			array('value' => 5, 'label' => $helper->__('5')),
            array('value' => 6, 'label' => $helper->__('6')),
        );
    }
}
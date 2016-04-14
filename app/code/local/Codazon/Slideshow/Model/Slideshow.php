<?php

class Codazon_Slideshow_Model_Slideshow extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("slideshow/slideshow");

    }

    public function toOptionArray()
    {
        $collection = $this->getCollection()->addFieldToFilter("is_active",1);
		$data	=	$collection->getData();
		$result	= array();
		$result[] = array('value' => '0','label' => 'Please choose slideshow');
		foreach($data as $value)
			$result[] = array('value' => $value['slideshow_id'],'label' => $value['title']);
		return $result;
    }

}
	 
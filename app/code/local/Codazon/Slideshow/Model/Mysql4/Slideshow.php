<?php
class Codazon_Slideshow_Model_Mysql4_slideshow extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("slideshow/slideshow", "slideshow_id");
    }
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getId()) {
            $object->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());
        return $this;
    }
}
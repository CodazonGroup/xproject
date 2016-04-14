<?php
class Codazon_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Accordion_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();        
        $fieldset = $form->addFieldset("slideshow_form", null);
        $fieldset->addField("title", "text", array(
            "label" => Mage::helper("slideshow")->__("Title"),                   
            "class" => "required-entry",
            "required" => true,
            "name" => "title",
            ));

        $fieldset->addField("identifier", "text", array(
            "label" => Mage::helper("slideshow")->__("Identifier"),                  
            "class" => "required-entry",
            "required" => true,
            "name" => "identifier",
            ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('slideshow')->__('Status'),
            'title'     => Mage::helper('slideshow')->__('Status'),
            'name'      => 'is_active',
            'required'  => true,
            'values'   => array(
                '1' => Mage::helper('slideshow')->__('Enabled'),
                '0' => Mage::helper('slideshow')->__('Disabled'),
                ),
            ));
        $is_duplicate = Mage::app()->getFrontController()->getRequest()->getParam('type',false);
        if($is_duplicate)
        {
            $fieldset->addField('duplicate', 'hidden', array(
                'name'  => 'duplicate',
                'value' => 'duplicate'
            ));
        }
        if (!Mage::registry("slideshow_data")->getId()) {
            Mage::registry("slideshow_data")->setData('is_active', '1');
        }

        if (Mage::getSingleton("adminhtml/session")->getslideshowData())
        {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getslideshowData());
            Mage::getSingleton("adminhtml/session")->setslideshowData(null);
        } 
        elseif(Mage::registry("slideshow_data") && !$is_duplicate) {
            $form->setValues(Mage::registry("slideshow_data")->getData());
        }
        $this->setForm($form);        
        return parent::_prepareForm();

    }
}
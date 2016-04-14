<?php 
class Codazon_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Accordion
    extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function _construct()
    {


        parent::_construct();
        $this->_fieldSetCollection = array();
        $this->_titleFieldSet = '';
        $this->_comment = '';        
        $this->setTemplate('codazon_slideshow/edit/tab/accordion.phtml');
    }



    public function getTabLabel()
    {
        return $this->_titleFieldSet;
    }

    public function getTabTitle()
    {
        return $this->_titleFieldSet;
    }


    public function canShowTab()
    {
        return true;
    }


    public function isHidden()
    {
        return false;
    }


    protected function _toHtml()
    {
        
        $this->_titleFieldSet = "General Information";
        $accordion = $this->getLayout()->createBlock('adminhtml/widget_accordion')
            ->setId("general_information");
            $this->setChild('accordion_general_information', $accordion);
        $accordion->addItem("general_information", array(
            'title'   => "Genral Information",
            'content' => $this->getLayout()
                    ->createBlock('slideshow/adminhtml_slideshow_edit_tab_accordion_form')                    
                    ->toHtml(),            
        ));
        $this->setChild('accordion_general_settings', $accordion);
        $accordion->addItem("general_settings", array(
            'title'   => "Genral Settings",
            'content' => $this->getLayout()
                    ->createBlock('slideshow/adminhtml_slideshow_edit_tab_accordion_general')                    
                    ->toHtml(),            
        ));
        
        return parent::_toHtml();
    }

}
<?php
class Codazon_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Accordion_General extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		$form = new Varien_Data_Form();
		$this->setForm($form);
		$form->setFieldNameSuffix('parameters');
		$fieldset = $form->addFieldset("slideshow_general", array("legend"=>Mage::helper("slideshow")->__("")));		

		$trueFalse = array(
            array(
                'value' => 0,
                'label' => Mage::helper('slideshow')->__('False')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('slideshow')->__('True')
            ));

		$fieldset->addField(
            'width',
            'text',
            [
                'name' => 'width',
                'label' => Mage::helper('slideshow')->__('Width'),
                'title' => Mage::helper('slideshow')->__('Width'),                                     
            ]
        );
        $fieldset->addField(
            'height',
            'text',
            [
                'name' => 'height',
                'label' => Mage::helper('slideshow')->__('Height'),
                'title' => Mage::helper('slideshow')->__('Height'),                                     
            ]
        );

        $fieldset->addField(
            'animateIn',
            'select',
            [
                'name' => 'animateIn', 
                'label' => Mage::helper('slideshow')->__('Animate In'), 
                'title' => Mage::helper('slideshow')->__('Animate In'),
                'values' => Mage::getSingleton('slideshow/listeffect')->toOptionArray(),         
                'note'  => Mage::helper('slideshow')->__('The CSS3 animation type applied when the background animates into view')
            ]
        );


        $fieldset->addField(
            'animateOut',
            'select',
            [
                'name' => 'animateOut', 
                'label' => Mage::helper('slideshow')->__('Animate Out'), 
                'title' => Mage::helper('slideshow')->__('Animate Out'),
                'values' => Mage::getSingleton('slideshow/listeffect')->toOptionArray(),                
                'note'  => Mage::helper('slideshow')->__('The CSS3 animation type applied when the background animates out of view')
            ]
        );
        $fieldset->addField(
            'startPosition',
            'text',
            [
                'name' => 'startPosition',
                'label' => Mage::helper('slideshow')->__('Start Slide'),
                'title' => Mage::helper('slideshow')->__('Start Slide'),
                'note' => Mage::helper('slideshow')->__('Start position. For example: value 0 starts first slide, value 1 starts second slide')                        
            ]
        );
        $fieldset->addField(
            'autoplay',
            'select',
            [
                'name' => 'autoplay', 
                'label' => Mage::helper('slideshow')->__('Autoplay'), 
                'title' => Mage::helper('slideshow')->__('Autoplay'),
                'values' =>  $trueFalse,
                'value' => '0'
            ]
        );
		
        $fieldset->addField(
            'autoplayHoverPause',
            'select',
            [
                'name' => 'autoplayHoverPause',
                'label' => Mage::helper('slideshow')->__('Pause on mouse over'),
                'title' => Mage::helper('slideshow')->__('Pause on mouse over'),
                'values' =>  $trueFalse,
                'value' => '0'                        
            ]
        );

		$fieldset->addField(
            'autoplaySpeed',
            'select',
            [
                'name' => 'autoplaySpeed',
                'label' => Mage::helper('slideshow')->__('Autoplay Speed'),
                'title' => Mage::helper('slideshow')->__('Autoplay Speed'),
                'values' =>  $trueFalse,
                'value' => '0'                      
            ]
        );
        $fieldset->addField(
            'smartSpeed',
            'text',
            [
                'name' => 'smartSpeed',
                'label' => Mage::helper('slideshow')->__('Smart Speed'),
                'title' => Mage::helper('slideshow')->__('Smart Speed'),                
                'value' => '250'                      
            ]
        );
        $fieldset->addField(
            'lazyLoad',
            'select',
            [
                'label' => Mage::helper('slideshow')->__('Lazy Load'),
                'title' => Mage::helper('slideshow')->__('Lazy Load'),
                'name' => 'lazyLoad',                
                'values' =>  $trueFalse,
                'value' => '0'
            ]
        );
        $fieldset->addField(
            'loop',
            'select',
            [
                'name' => 'loop',
                'label' => Mage::helper('slideshow')->__('Loop'),
                'title' => Mage::helper('slideshow')->__('Loop'),
                'values' =>  $trueFalse,
                'value' => '0',
                'note' => Mage::helper('slideshow')->__('Inifnity loop. Duplicate last and first items to get loop illusion.')

            ]
        );
        
        $fieldset->addField(
            'nav',
            'select',
            [
                'label' => Mage::helper('slideshow')->__('Next & Prev navigation'),
                'title' => Mage::helper('slideshow')->__('Next & Prev navigation'),
                'name' => 'nav',                
                'values' =>  $trueFalse,
                'value' => '0'
            ]
        );
        $fieldset->addField(
            'dots',
            'select',
            [
                'label' => Mage::helper('slideshow')->__('Paging navigation'),
                'title' => Mage::helper('slideshow')->__('Paging navigation'),
                'name' => 'dots',                
                'values' =>  $trueFalse,
                'value' => '1'
            ]
        );
        $thumbNav = $fieldset->addField(
            'controlNavThumbs',
            'select',
            [
                'label' => Mage::helper('slideshow')->__('Show Thumbnails'),
                'title' => Mage::helper('slideshow')->__('Show Thumbnails'),
                'name' => 'controlNavThumbs',                
                'values' =>  $trueFalse,
                'value' => '0'
            ]
        );
        $thumbWidth = $fieldset->addField(
            'thumbWidth',
            'text',
            [
                'label' => Mage::helper('slideshow')->__('Thumbnail Width'),
                'title' => Mage::helper('slideshow')->__('Thumbnail Width'),
                'name' => 'thumbWidth',                                                            
            ]
        );
        $thumbHeight = $fieldset->addField(
            'thumbHeight',
            'text',
            [
                'label' => Mage::helper('slideshow')->__('Thumbnail Height'),
                'title' => Mage::helper('slideshow')->__('Thumbnail Height'),
                'name' => 'thumbHeight',                                                            
            ]
        );
                
		 $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($thumbNav->getHtmlId(), $thumbNav->getName())
            ->addFieldMap($thumbWidth->getHtmlId(), $thumbWidth->getName())
            ->addFieldMap($thumbHeight->getHtmlId(), $thumbHeight->getName())
            ->addFieldDependence(
                $thumbWidth->getName(),
                $thumbNav->getName(),
                1
            )
            ->addFieldDependence(
                $thumbHeight->getName(),
                $thumbNav->getName(),
                1
            )
        );
		

		if (Mage::getSingleton("adminhtml/session")->getslideshowData())
		{
			$form->setValues(Mage::getSingleton("adminhtml/session")->getslideshowData());
			Mage::getSingleton("adminhtml/session")->setslideshowData(null);
		} 
		elseif(Mage::registry("slideshow_data")) {		
			$form->setValues(json_decode(Mage::registry("slideshow_data")->getParameters(),true));
		}


		return parent::_prepareForm();
	}
}

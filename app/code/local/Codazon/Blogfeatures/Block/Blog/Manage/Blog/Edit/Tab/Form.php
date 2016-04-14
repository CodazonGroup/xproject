<?php
class Codazon_Blogfeatures_Block_Blog_Manage_Blog_Edit_Tab_Form extends AW_Blog_Block_Manage_Blog_Edit_Tab_Form
{
	protected function _prepareForm()
    {
       parent::_prepareForm();
		$form = parent::getForm(); 
        $this->setForm($form);
        $fieldset = $form->addFieldset('image_fieldset', array('legend' => Mage::helper('blog')->__('Post Addition')));

       
		
		$fieldset->addField(
            'post_image',
            'image',
            array(
                 'name'   => 'post_image',
                 'label'  => Mage::helper('blog')->__('Post Image'),
                 'title'  => Mage::helper('blog')->__('Post Image')
            )
        );
		if (Mage::getSingleton('adminhtml/session')->getBlogData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBlogData());
            Mage::getSingleton('adminhtml/session')->setBlogData(null);
        } elseif (Mage::registry('blog_data')) {
            Mage::registry('blog_data')->setTags(
                Mage::helper('blog')->convertSlashes(Mage::registry('blog_data')->getTags())
            );
            $form->setValues(Mage::registry('blog_data')->getData());
        }
    }
}
			
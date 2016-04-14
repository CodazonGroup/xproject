<?php
class Codazon_Blogfeatures_Model_Showinfront extends Mage_Core_Model_Abstract{
	public function toOptionArray()
	{
		return array(
        	array( 'value' => 'post_image', 'label' => __('Thumbnail') ),
        	array( 'value' => 'title', 'label' => __('Title') ),
        	array( 'value' => 'short_content', 'label' => __('Short Content') ),
        	array( 'value' => 'created_time', 'label' => __('Create Date') ),
			array( 'value' => 'user', 'label' => __('Poster') )
         );
	}
}
?>
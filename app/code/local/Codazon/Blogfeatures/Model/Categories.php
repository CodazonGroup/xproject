<?php
class Codazon_Blogfeatures_Model_Categories extends Mage_Core_Model_Abstract
{
	public function toOptionArray()
	{
		$categories = array();
        $collection = Mage::getModel('blog/cat')->getCollection()->setOrder('sort_order', 'asc');
        foreach ($collection as $cat) {
            $categories[] = (array(
                'label' => (string)$cat->getTitle(),
                'value' => $cat->getCatId()
            ));
        }
		return $categories;
	}


}
?>
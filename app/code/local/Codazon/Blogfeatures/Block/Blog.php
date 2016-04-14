<?php
class Codazon_Blogfeatures_Block_Blog
    extends AW_Blog_Block_Blog
{
	protected function _prepareCollection()
    {
        $collection = parent::_prepareCollection();
		$collection->getSelect()->group('main_table.post_id');
		$this->setData('cached_collection', $collection);
		return $this->getData('cached_collection'); 
    }
	
}
?>
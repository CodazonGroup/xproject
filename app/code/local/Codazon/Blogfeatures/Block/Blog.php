<?php
class Codazon_Blogfeatures_Block_Blog extends AW_Blog_Block_Blog
{
	protected function _prepareCollection()
    {
        if (!$this->getData('cached_collection')) {
            $sortOrder = $this->getRequest()->getParam('order', self::DEFAULT_SORT_ORDER);
            $sortDirection = $this->getCurrentDirection();
            $collection = Mage::getModel('blog/blog')->getCollection()
                ->addPresentFilter()
                ->addEnableFilter(AW_Blog_Model_Status::STATUS_ENABLED)
                ->addStoreFilter()
                ->joinComments()
            ;
            $collection->setOrder($collection->getConnection()->quote($sortOrder), $sortDirection);
            $collection->setPageSize((int)self::$_helper->postsPerPage());
			$collection->getSelect()->group('main_table.post_id');
			
            $this->setData('cached_collection', $collection);
        }
        return $this->getData('cached_collection');
    }
}
?>

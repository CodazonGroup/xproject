<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Blog
 * @version    1.3.16
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class Codazon_Blogfeatures_Block_Menu_Sidebar extends AW_Blog_Block_Menu_Sidebar
{
    protected function _prepareCollection()
    {
        if (!$this->getData('cached_collection')) {
            $sortOrder = self::DEFAULT_SORT_ORDER;
            $sortDirection = Mage::helper('blog')->defaultPostSort(Mage::app()->getStore()->getId());
            $collection = Mage::getModel('blog/blog')->getCollection()
                ->addPresentFilter()
                ->addEnableFilter(AW_Blog_Model_Status::STATUS_ENABLED)
                ->addStoreFilter()
                ->joinComments()
                ->setOrder($sortOrder, $sortDirection);

            $collection->setPageSize((int)self::$_helper->postsPerPage());
			$collection->getSelect()->group('main_table.post_id');
            $this->setData('cached_collection', $collection);
        }
        return $this->getData('cached_collection');
    }
}

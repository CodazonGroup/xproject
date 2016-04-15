<?php
class Codazon_Themeframework_Block_Page_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
	public function getLimit()
    {
		$limit = $this->getRequest()->getParam($this->getLimitVarName());
        return $limit?$limit:Codazon_Themeframework_Block_Page_Category::DEFAULT_LIMIT;
    }	
	public function isExpanded(){
		return false;	
	}
	/*public function getPagerHtml()
    {
        $pagerBlock = $this->getLayout()
                    ->createBlock('catalog/product_widget_html_pager', 'category_list_toolbar');

        if ($pagerBlock instanceof Mage_Core_Block_Abstract) {
            $pagerBlock->setUseContainer(false)
                 ->setShowAmounts(true)
				->setShowPerPage(false)
				->setPageVarName(Codazon_Themeframework_Block_Page_Category::PAGE_VAR_NAME)
				->setLimit($this->getLimit())
				->setTotalLimit($this->getTotalNum())
				->setCollection($this->getCollection());
            //return $pagerBlock->toHtml();
        }

        return '';
    }*/
}
?>

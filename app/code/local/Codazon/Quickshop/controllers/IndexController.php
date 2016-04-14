<?php
class Codazon_Quickshop_IndexController extends Mage_Core_Controller_Front_Action
{
	protected $_cacheTags = array(Mage_Core_Block_Abstract::CACHE_GROUP);
	protected $_cacheLifetime = 86400;
	
	protected function _getCacheLifetime(){
		return $this->_cacheLifetime;
	}
	
	protected function _getSidPlaceholder($cacheKey = null)
    {
        if (is_null($cacheKey)) {
            $cacheKey = $this->getCacheKey();
        }

        return '<!--SID=' . $cacheKey . '-->';
    }
	protected function _getCacheTags(){
		return $this->_cacheTags;
	}
	
	public function getCacheKey(){
		$key = implode('|',array(
			'codazon_quickshop',
			Mage::app()->getStore()->getId(),
			(int)Mage::app()->getStore()->isCurrentlySecure(),
			Mage::app()->getStore()->getCurrentCurrencyCode(),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),
			(int) $this->getRequest()->getParam('category', false),
			(int) $this->getRequest()->getParam('id'),
		));
		return $key;
	}
	
	
	
	protected function _loadCache()
    {
		if (is_null($this->_getCacheLifetime()) || !Mage::app()->useCache(Mage_Core_Block_Abstract::CACHE_GROUP)) {
            return false;
        }
        $cacheKey = $this->getCacheKey();
        /** @var $session Mage_Core_Model_Session */
        $session = Mage::getSingleton('core/session');
        $cacheData = Mage::app()->loadCache($cacheKey);
        if ($cacheData) {
			$cacheData = str_replace(
                $this->_getSidPlaceholder($cacheKey),
                $session->getSessionIdQueryParam() . '=' . $session->getEncryptedSessionId(),
                $cacheData
            );
        }
        return $cacheData;
    }
	
	
	protected function _saveCache($data)
    {
		if (is_null($this->_getCacheLifetime()) || !Mage::app()->useCache(Mage_Core_Block_Abstract::CACHE_GROUP)) {
            return false;
        }
        $cacheKey = $this->getCacheKey();
        /** @var $session Mage_Core_Model_Session */
        $session = Mage::getSingleton('core/session');
        $data = str_replace(
            $session->getSessionIdQueryParam() . '=' . $session->getEncryptedSessionId(),
            $this->_getSidPlaceholder($cacheKey),
            $data
        );

        Mage::app()->saveCache($data, $cacheKey, $this->_getCacheTags(), $this->_getCacheLifetime());
        return $this;
    }
	
	
	
	public function viewAction(){
		
		$html = $this->_loadCache();
		
		if ($html === false) {
		
			$categoryId = (int) $this->getRequest()->getParam('category', false);
			$productId = $this->getRequest()->getParam('id');
			$specifyOptions = $this->getRequest()->getParam('options');
	
			// Prepare helper and params
			$viewHelper = Mage::helper('catalog/product_view');
	
			$params = new Varien_Object();
			$params->setCategoryId($categoryId);
			$params->setSpecifyOptions($specifyOptions);
			//$this->loadLayout();
			//$this->renderLayout();
			try {
				$viewHelper->prepareAndRender($productId, $this, $params);
				$this->loadLayout();
				$html = $this->getLayout()->getBlock('root')->toHtml();
				$this->_saveCache($html);
				$this->getResponse()->setBody($html);
			} catch (Exception $e) {
				if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
					if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
						$this->_redirect('');
					} elseif (!$this->getResponse()->isRedirect()) {
						$this->_forward('noRoute');
					}
				} else {
					Mage::logException($e);
					$this->_forward('noRoute');
				}
			}
		}else{
			$this->getResponse()->setBody($html);
		}
	}
}
?>
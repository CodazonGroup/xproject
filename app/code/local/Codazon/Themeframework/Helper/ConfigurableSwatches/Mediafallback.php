<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_ConfigurableSwatches
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Class implementing the media fallback layer for swatches
 */
class Codazon_Themeframework_Helper_ConfigurableSwatches_Mediafallback extends Mage_ConfigurableSwatches_Helper_Mediafallback
{
	protected $_size = null;
    public function addSize(array $size){
		$this->_size = $size;
	}
	
	protected function _resizeProductImage($product, $type, $keepFrame, $image = null, $placeholder = false)
    {
        $hasTypeData = $product->hasData($type) && $product->getData($type) != 'no_selection';
        if ($image == 'no_selection') {
            $image = null;
        }
        if ($hasTypeData || $placeholder || $image) {
            $helper = Mage::helper('catalog/image')
                ->init($product, $type, $image)
                ->keepFrame(($hasTypeData || $image) ? $keepFrame : false)  // don't keep frame if placeholder
            ;

            $helper->keepFrame(true,array('center', 'middle'))->keepAspectRatio(true)->constrainOnly(true);
			if($this->_size == null){
				if ($type == 'small_image') {
					//$size = Mage::getStoreConfig(Mage_Catalog_Helper_Image::XML_NODE_PRODUCT_SMALL_IMAGE_WIDTH);
					$width = Mage::getStoreConfig('codazon_settings/category_view/image_width');
					$height = Mage::getStoreConfig('codazon_settings/category_view/image_height');
					if (is_numeric($width) && is_numeric($height)) {
						$helper->resize($width, $height);
					}
				}else{
					//$size = Mage::getStoreConfig(Mage_Catalog_Helper_Image::XML_NODE_PRODUCT_BASE_IMAGE_WIDTH);
					$width = Mage::getStoreConfig('codazon_settings/product_view/base_image_width');
					$height = Mage::getStoreConfig('codazon_settings/product_view/base_image_height');
					if (is_numeric($width) && is_numeric($height)) {
						$helper->resize($width, $height);
					}
				}	
			}else{
            	$helper->resize($this->_size[0],$this->_size[1]);
			}
            
            return (string)$helper;
        }
        return false;
    }
	public function attachGallerySetToCollection(array $products, $storeId)
    {
        $productIds = array();
        /* @var $product Mage_Catalog_Model_Product */
        foreach ($products as $product) {
            $productIds[] = $product->getId();
            if (!is_array($product->getChildrenProducts())) {
                continue;
            }
            /* @var $childProduct Mage_Catalog_Model_Product */
            foreach ($product->getChildrenProducts() as $childProduct) {
                $productIds[] = $childProduct->getId();
            }
        }

        $attrCode = self::MEDIA_GALLERY_ATTRIBUTE_CODE;

        /* @var $resourceModel Mage_Catalog_Model_Resource_Product_Attribute_Backend_Media */
        $resourceModel = Mage::getResourceModel('catalog/product_attribute_backend_media');

        $images = $resourceModel->loadGallerySet($productIds, $storeId);

        $relationship = array();
        foreach ($products as $product) {
            $relationship[$product->getId()] = $product->getId();

            if (!is_array($product->getChildrenProducts())) {
                continue;
            }

            /* @var $childProduct Mage_Catalog_Model_Product */
            foreach ($product->getChildrenProducts() as $childProduct) {
                $relationship[$childProduct->getId()] = $product->getId();
            }
        }

        foreach ($images as $image) {
            $productId = $image['product_id'];
            $realProductId = $relationship[$productId];
            $product = $products[$realProductId];

            if (is_null($image['label'])) {
                $image['label'] = $image['label_default'];
            }
            if (is_null($image['position'])) {
                $image['position'] = $image['position_default'];
            }
            if (is_null($image['disabled'])) {
                $image['disabled'] = $image['disabled_default'];
            }

            $value = $product->getData($attrCode);
            if (!$value) {
                $value = array(
                    'images' => array(),
                    'value' => array()
                );
            }
			if(is_array($value)){
				$value['images'][] = $image;
			}
            

            $product->setData($attrCode, $value);
        }
    }
}

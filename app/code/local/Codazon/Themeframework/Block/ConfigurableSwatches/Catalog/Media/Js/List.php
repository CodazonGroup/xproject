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
class Codazon_Themeframework_Block_ConfigurableSwatches_Catalog_Media_Js_List extends Mage_ConfigurableSwatches_Block_Catalog_Media_Js_List
{
    public function getProductImageFallbacks($keepFrame = null) {
        /* @var $helper Mage_ConfigurableSwatches_Helper_Mediafallback */
        //$helper = Mage::helper('configurableswatches/mediafallback');
		$helper = Mage::helper('themeframework/configurableSwatches_mediafallback');
        $fallbacks = array();

        $products = $this->getProducts();
		if($size = $this->getImageSize()){
			$helper->addSize($size);
		}

        if ($keepFrame === null) {
            $keepFrame = $this->isKeepFrame();
        }

        /* @var $product Mage_Catalog_Model_Product */
        foreach ($products as $product) {
            $imageFallback = $helper->getConfigurableImagesFallbackArray($product, $this->_getImageSizes(), $keepFrame);

            $fallbacks[$product->getId()] = array(
                'product' => $product,
                'image_fallback' => $this->_getJsImageFallbackString($imageFallback)
            );
        }

        return $fallbacks;
    }
}

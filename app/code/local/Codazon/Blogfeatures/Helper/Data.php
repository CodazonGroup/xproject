<?php
class Codazon_Blogfeatures_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getPlaceholderUrl($params){
		return $this->getImage(null,$params);
	}
	public function getImage($post,$params){
		$mediaDir = Mage::getBaseDir('media');
		$fileName = null;
		if(is_object($post)){
			$fileName = $post->getPostImage();
		}
		if(empty($fileName)){
			$fileName = 'codazon_blog/default-placeholder.png';
		}
		$filePath = $mediaDir . DS . $fileName;
		$width = $params['width'];
		$height = $params['height'];
		$newFileName = explode('/',$fileName);
		$newFileName = $newFileName[1];
		$newFilePath = $mediaDir . DS . 'codazon_blog' . DS . 'cache' . DS . $width .'x'. $height . DS . $newFileName;
		if(!file_exists($newFilePath)){
			if(file_exists($filePath)){
				$imageObj = new Varien_Image($filePath);
				$imageObj->constrainOnly(true);
				$imageObj->keepAspectRatio(true);
				$imageObj->keepFrame(true,array('center', 'middle'));
				$imageObj->backgroundColor(array(255,255,255));
				$imageObj->resize( $width, $height );
				$imageObj->save($newFilePath);
			}
		}
		return $this->getUrl($newFilePath);
	}
	protected function getUrl($filePath)
    {
        $baseDir = Mage::getBaseDir('media');
        $path = str_replace($baseDir . DS, "", $filePath);
        return Mage::getBaseUrl('media') . str_replace(DS, '/', $path);
    }
}
	 
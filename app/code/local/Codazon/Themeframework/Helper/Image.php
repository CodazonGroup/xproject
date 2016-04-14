<?php
class Codazon_Themeframework_Helper_Image extends Mage_Core_Helper_Abstract
{
	public function getPlaceholderUrl($params){
		return $this->getImage(null,$params);
	}
	public function getImage($cat,$params){
		$mediaDir = Mage::getBaseDir('media');
		$fileName = null;
		if(is_object($cat)){
			$fileName = $cat->getThumbnail();
		}
		if(empty($fileName)){
			$fileName = 'codazon_blog/default-placeholder.png';
		}
		
		$filePath = $mediaDir .DS. 'catalog'. DS .'category'. DS . $fileName;

		$width = $params['width'];
		$height = $params['height'];
		$newFileName = $fileName;
		$newFilePath = $mediaDir . DS . 'codazon_themeframework' . DS . 'cache' . DS . $width .'x'. $height . DS . $newFileName;
		if(!file_exists($newFilePath)){
			if(file_exists($filePath)){
				$imageObj = new Varien_Image($filePath);
				$originalWidth = $imageObj->getOriginalWidth();
				$originalHeight = $imageObj->getOriginalHeight();
				$imageObj->constrainOnly(true);
				$imageObj->keepAspectRatio(true);
				$imageObj->keepFrame(true,array('center', 'middle'));
				$imageObj->backgroundColor(array(255,255,255));
				$crop = ( round($originalHeight*$width/$originalWidth) == $height )?false:true;
				if( (($width < $originalWidth) and ($height < $originalHeight)) and $crop){				
					if($width < $originalWidth){
						$cr = ($originalWidth - $width)/2;
						$imageObj->crop(0,$cr,$cr,0);
					}
					if($height < $originalHeight){
						$cr = ($originalHeight - $height)/2;
						$imageObj->crop($cr,0,0,$cr);
					}
				}else{
					$imageObj->resize( $width, $height );
				}
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
	 
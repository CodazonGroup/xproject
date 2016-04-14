<?php
class Codazon_Slideshow_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function replaceFileName($filename) {        
        $ext = explode('.',$filename);
        $ext = end($ext);
        // Replace all weird characters
        $replacer = preg_replace('/[^a-zA-Z0-9-_.]/','-', substr($filename, 0, -(strlen($ext)+1)));
        // Replace dots inside filename
        $replacer = str_replace('.','-', $replacer);
        return strtolower($replacer.'.'.$ext);
    }

    public function getImageUrl($imageName)
    {
        return str_replace('index.php/','',Mage::getBaseUrl()).'media/codazon/slideshow/images'."/". $imageName;
    }

    public function resizeImage($image,$width = 255, $height = 255){        
        if(!$image) return;		
        $imagePathFull = Mage::getBaseDir('media').DS.'codazon' . DS .'slideshow'.DS.'images'.DS.$image;
        $resizePath = $width . 'x' . $height;
        $resizePathFull = Mage::getBaseDir('media'). DS .'codazon' . DS .'slideshow'. DS . 'resize' . DS . $resizePath . DS . $image;        
        if (file_exists($imagePathFull) && !file_exists($resizePathFull)) {  
        	            
            $imageObj = new Varien_Image($imagePathFull);            
            $originalWidth = $imageObj->getOriginalWidth();
			$originalHeight = $imageObj->getOriginalHeight();				
            $imageObj->constrainOnly(true);
			$imageObj->keepAspectRatio(true);
			$imageObj->keepFrame(true,array('center', 'middle'));
			$imageObj->backgroundColor(array(255,255,255));
			$imageObj->quality(100);
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
			$imageObj->save($resizePathFull);
        }      												        
        return str_replace('index.php/','',Mage::getBaseUrl('media')). 'codazon/slideshow/resize/' . $resizePath . "/"  . $image;
    }   

    function checkYoutubeLink($url)
    {
        return (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url));
    }
    function checkVimeoLink($url)
    {
        return (preg_match('/vimeo\.com/i', $url));
    }
    function getYoutubeVideoId($url)
    {
        if($this->checkYoutubeLink($url))
        {
            $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
            preg_match($pattern, $url, $matches);
            if (count($matches) && strlen($matches[7]) == 11)
            {
              return $matches[7];
            }            
        }

        return '';
    }
    function getVimeoVideoId($url)
    {
        if($this->checkVimeoLink($url))
        {
            $pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
            preg_match($pattern, $url, $matches);
            if (count($matches))
            {
                return $matches[2];
            }
        }

        return '';
    }
    function getExtension($url)
    {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        if($ext)
            return $ext;
        return '';
    }

    function checkVideoUrl($url)
    {
        if($this->checkYoutubeLink($url))
            return 'youtube';
        else if($this->checkVimeoLink($url))
            return 'vimeo';
        else
            return $this->getExtension($url);
    }
}	 

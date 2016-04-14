<?php
require_once "AW/Blog/controllers/Adminhtml/Awblog/Manage/BlogController.php";  
class Codazon_Blogfeatures_Adminhtml_Awblog_Manage_BlogController extends AW_Blog_Adminhtml_Awblog_Manage_BlogController{
	public function saveAction()
    {		
		
		try { 
			$mediaDir = Mage::getBaseDir('media');
			$model = Mage::getModel('blog/post');
			$request = $this->getRequest();
			if ($request->getParam('id')) {
				$model->load($request->getParam('id'));	
			}
			
			if(isset($_FILES['post_image']['name']) && $_FILES['post_image']['name'] != ''){
				
				try{
					$fileName = $mediaDir.DS.$model->getData('post_image');
					if(file_exists($fileName)){
						unlink($fileName);
					}
				}catch(Exception $e){
					 echo $e->getMessage();
				}
				$uploader = new Varien_File_Uploader('post_image');  
				$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));  
				$uploader->setAllowRenameFiles(false);  
				$uploader->setFilesDispersion(false); 
				
				$mediaPath  = $mediaDir . DS . 'codazon_blog' . DS;
				$randFileName = 'codazon_blog_'. $this->getRandFilename($_FILES['post_image']['name']);
				$uploader->save($mediaPath, $randFileName);
				$data['post_image'] = 'codazon_blog' . '/' . $randFileName;  
				
			}else {  
                $data = $request->getPost();  
                if(isset($data['post_image']['delete']) && $data['post_image']['delete']== 1) {  
					$fileName = $mediaDir . DS . $model->getData('post_image');
					unlink($fileName);
					$data['post_image'] = '';  
                } else {  
					$data['post_image'] = $model->getData('post_image');
                }  
            }  
			$request->setPost('post_image',$data['post_image']);
		}catch (Exception $e) {  
            echo $e->getMessage();
        }
		$stores = $request->getPost('stores');
		if($stores[0] == 0){
			$last = count($stores);
			$stores[0] = -1;
			$stores[$last] = 0;
			$request->setPost('stores',$stores);
		}
		parent::saveAction();
		
	}
	public function getRandFilename($baseFileName) {   
        $ext = pathinfo($baseFileName, PATHINFO_EXTENSION);
		//$fileName = pathinfo($baseFileName, PATHINFO_FILENAME);
        return Mage::getModel('core/date')->timestamp(time()) . '.' . $ext;  
    }
}
				
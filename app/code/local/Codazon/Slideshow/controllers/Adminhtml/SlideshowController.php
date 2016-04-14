<?php

class Codazon_Slideshow_Adminhtml_SlideshowController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu("slideshow/slideshow")->_addBreadcrumb(Mage::helper("adminhtml")->__("slideshow  Manager"),Mage::helper("adminhtml")->__("slideshow Manager"));
		return $this;
	}
	public function indexAction() 
	{
	    $this->_title($this->__("Slideshow"));
	    $this->_title($this->__("Manager slideshow"));

		$this->_initAction();
		$this->renderLayout();
	}
	public function editAction()
	{			    
	    $this->_title($this->__("Slideshow"));
		$this->_title($this->__("slideshow"));
	    $this->_title($this->__("Edit Item"));
		
		$id = $this->getRequest()->getParam("id");
		$model = Mage::getModel("slideshow/slideshow")->load($id);
		if ($model->getId()) {
			Mage::register("slideshow_data", $model);
			$this->loadLayout();
			$this->_setActiveMenu("slideshow/slideshow");
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("slideshow Manager"), Mage::helper("adminhtml")->__("slideshow Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("slideshow Description"), Mage::helper("adminhtml")->__("slideshow Description"));
			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock("slideshow/adminhtml_slideshow_edit"))->_addLeft($this->getLayout()->createBlock("slideshow/adminhtml_slideshow_edit_tabs"));
			$this->renderLayout();
		} 
		else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("slideshow")->__("Item does not exist."));
			$this->_redirect("*/*/");
		}
	}

	public function newAction()
	{

		$this->_title($this->__("Slideshow"));
		$this->_title($this->__("slideshow"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("slideshow/slideshow")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("slideshow_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("slideshow/slideshow");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("slideshow Manager"), Mage::helper("adminhtml")->__("slideshow Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("slideshow Description"), Mage::helper("adminhtml")->__("slideshow Description"));


		$this->_addContent($this->getLayout()->createBlock("slideshow/adminhtml_slideshow_edit"))->_addLeft($this->getLayout()->createBlock("slideshow/adminhtml_slideshow_edit_tabs"));

		$this->renderLayout();

	}
	public function saveAction()
	{

			$post_data=$this->getRequest()->getPost();
				if ($post_data) {					
					try {							
						$path = Mage::getBaseDir('media').DS.'codazon'.DS.'slideshow'.DS.'images';
						foreach($_FILES as $key => $value)
			            {	
			            	
			            	$temp = explode("_", $key);			            	
					        if (!empty($value['tmp_name'])) {
					            try {
					                $uploader = new Varien_File_Uploader($value);
					                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					                $uploader->setFilesDispersion(false);
					                $uploader->setFilenamesCaseSensitivity(false);
					                $uploader->setAllowRenameFiles(true);
					                $imageName = Mage::helper('slideshow')->replaceFileName($value['name']);
					                $uploader->save($path, $imageName);
					                $fileName = $uploader->getUploadedFileName();
					                $post_data['slider'][$temp[1]]['image'] = $fileName;
					            } catch (Exception $e) {
					                Mage::logException($e);
					                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
					            }
					        }					            				                             			              
			            }
			            foreach ($post_data['slider'] as $key => $value) {
		            		if(!$post_data['slider'][$key]['image'])
			            		$post_data['slider'][$key]['image'] = $value[$key]['image'];	
			            	
			            }
						
						$model = Mage::getModel("slideshow/slideshow");						
						if(isset($post_data["duplicate"]))
							$model->setId();
						else
							$model->setId($this->getRequest()->getParam("id"));
						
						$post_data['parameters']=json_encode($post_data['parameters'],JSON_HEX_TAG);						
						$post_data['slider']=json_encode($post_data['slider'],JSON_HEX_TAG);						
						$model->addData($post_data);
						$model->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("slideshow was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setslideshowData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setslideshowData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}

		public function validateAction()
	    {
	        $postData = $this->getRequest()->getPost();
	        $response = new Varien_Object();
	        $slideshow_id = Mage::app()->getFrontController()->getRequest()->getParam("slideshow_id",0);
	        if(isset($postData['identifier']))
	        {
	            $identifier = $postData['identifier'];
	            $model = Mage::getModel('slideshow/slideshow')->load($identifier,'identifier');

	            if($model->getId())
	            {
	                if($model->getId()!=$slideshow_id)
	                {
	                    $response->setError(true);
	                    $response->setAttribute("info_identifier");
	                    $response->setMessage(Mage::helper('slideshow')->__("The value of identifier is unique"));
	                } else {
	                    $response->setError(false);
	                }
	            }
	            else
	                $response->setError(false);
	        }
	        else
	            $response->setError(false);
	        $this->getResponse()->setBody($response->toJson());
	    }

		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("slideshow/slideshow");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('slideshow_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("slideshow/slideshow");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'slideshow.csv';
			$grid       = $this->getLayout()->createBlock('slideshow/adminhtml_slideshow_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'slideshow.xml';
			$grid       = $this->getLayout()->createBlock('slideshow/adminhtml_slideshow_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}

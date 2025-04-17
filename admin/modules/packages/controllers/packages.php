<?php

 	class packages extends Controller{

 		public function __construct(){
 			parent::__construct();
 			if(!$this->session->gets('adminuser_id')){
 				$this->redirect('index');
 			}

 			$this->LoadHelper('ImageUpload');
 		}


 		public function news($cat_id){
 			try{   
 				if(!isset($cat_id) || $cat_id == '') {
        			$this->redirect('dashboard');
      			}
      			$this->view->cat_id = $cat_id;
      			$categoryDetails = $this->model->getCategoryDetails(base64_decode($cat_id)); 
      			$this->view->categoryDetails =  $categoryDetails->categories;
 				$this->view->packagesList = $this->model->getAllPackages();
 				$this->set_logs($this->session->gets('adminuser_id'),'packages','news','error_logs','Packages','ACTS');
 				$this->view->LoadView('managePackages','packages');
 			}catch(Exception $e){
 				$this->set_logs($this->session->gets('adminuser_id'),'packages','news','error_logs',$e->getMessage(),'ERR');
 			}
 		}

 		  

 		public function addPackage($cat_id){
 			try{ 
				$this->view->cat_id = $cat_id;
	  			$this->view->categoryDetails = $this->model->getCategoryDetails(base64_decode($cat_id)); 
	  			$this->view->inExs = $this->model->getGeneralItems(); 
		  		$this->set_logs($this->session->gets('adminuser_id'),'packages','addPackage','error_logs','Add Packages','ACTS');
		     	$this->view->LoadView('addPackage', 'packages');
  			}
	  		catch (Exception $e) {
		      $this->set_logs($this->session->gets('adminuser_id'),'packages','addPackage','error_logs',$e->getMessage(),'ERR');
		    }  
 		}

 		public function videoDetailsVerification(){
		    $video_url = $_POST['video_url'];
		    $y = explode('=',$video_url);
		    $url = $y[0];
		    if($url=='https://www.youtube.com/watch?v'){
		      echo "true";

		    }
		    else {
		      echo "false";
		    }
	  	}

 		public function addPackageDetails(){
	  		try{	  			 
	  			if(!empty($_FILES['package_images']['name'])){
			        $filedir = FRONTUPLOADPATH."packages/";
			        $randName = rand(10101010, 9090909090);
			        $filename = $_FILES['package_images']['name'];
			        $filename = explode(".",$filename);
			        $newName = $filename[0].'_' . $randName; 
			        $ext = substr($_FILES['package_images']['name'], strrpos($_FILES['package_images']['name'], '.') + 1);
			        $this->ImageUpload->File = $_FILES['package_images'];
			        $this->ImageUpload->method = 1;
			        $this->ImageUpload->SavePath = $filedir;
			        $this->ImageUpload->NewName = $newName;
			        $this->ImageUpload->OverWrite = true;
			        $err = $this->ImageUpload->UploadFile();  
			        $_POST['package_images'] = $newName.".".strtolower($ext);                  
			    }else $_POST['package_images'] = ''; 
	  			$result = $this->model->addPackageDetails($_POST); 
		      	if($result->status == "200") {
		        	$this->session->sets('success_msg','Added Successfully.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'packages','addPackageDetails'.implode('~', $_POST),'error_logs','Packages-add','ACTS');
		        	
		      	} else {
		      		$this->session->sets('error_msg','Not Added.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'packages','addPackageDetails'.implode('~', $_POST),'error_logs','Packages not Added','ERR');
		        	 
		      	}
	      		$this->redirect('packages/news/'.base64_encode($_POST['category_id'])); 
	  		}
	  		catch (Exception $e) {
		        $this->set_logs($this->session->gets('adminuser_id'),'packages','addPackageDetails','error_logs',$e->getMessage(),'ERR');
		    }  
		}

	  	public function packageGallery($package_id){
	  		try{ 
	  			$this->view->package_id = $package_id ;
	  			$this->view->gallery = $this->model->getPackageGallery($package_id);	 
	  			// var_dump($this->view->gallery);die();
	  			$this->set_logs($this->session->gets('adminuser_id'),'packages','packageGallery'.$package_id,'error_logs',' Package Gallery','ACTS');
	  			$this->view->LoadView('packageGallery', 'packages');
		      	
	  		} catch(Exception $e)  {
	      		$data = implode('~',$_POST);
	      		$this->set_logs($this->session->gets('user_id'),'packages','packageGallery'.$data,'error_logs',$e->getMessage(),'ERR');
	    	}
	  	}

	  	public function uploadPackageImages($id){
	  		try {
	  			 
		      $filedir = UPLOADPATH . "packages/gallery/";
		      $randName = rand(101010, 909090);
		              
		      $newName1 = "package_" . $id . "_" . $randName; 
		      $ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
		      $filedir1 = $filedir;
		      $size = getimagesize($_FILES['file']['tmp_name']);
		      $newwidth = $size[0];
		      $newhight = $size[1];                
		      $this->ImageUpload->File = $_FILES['file'];
		      $this->ImageUpload->method = 0;
		      $this->ImageUpload->NewWidth = $newwidth;
		      $this->ImageUpload->NewHeight = $newhight;
		      $this->ImageUpload->SavePath = $filedir1;       
		      $this->ImageUpload->NewName = $newName1;
		      $this->ImageUpload->OverWrite = true;
		      $err = $this->ImageUpload->UploadFile();
		      $this->ImageUpload->File = $_FILES['file'];
		      $this->ImageUpload->method = 0;
		      $this->ImageUpload->SavePath = $filedir1;
		      if($size[0] > $size[1]){
		        $this->ImageUpload->NewWidth = '280';
		      }else if($size[0] < $size[1]){
		        $this->ImageUpload->NewWidth = '280';
		      }
		      $this->ImageUpload->NewName = $newName1;
		      $this->ImageUpload->OverWrite = true;
		      $err = $this->ImageUpload->UploadFile();                
		      $data = array(
		        'package_id' => $id,
		        'image_url' => $newName1.".".strtolower($ext),
		        'image_added_by' => $this->session->gets('adminuser_id')
		      );        
		      $result = $this->model->uploadPackageImages($data);
		      if($result){
		        $this->session->sets('success_msg','Added Successfully.');
		        $this->set_logs($this->session->gets('adminuser_id'),'packages','uploadPackageImages'.implode('~', $data),'error_logs','Gallery Images uploaded Successfully','ACTS');
		      } else {
		        $this->session->sets('error_msg','Image Not Added.');
		         $this->set_logs($this->session->gets('adminuser_id'),'packages','uploadPackageImages'.implode('~', $_POST),'error_logs', 'Gallery Not uploaded','ERR');
		      }
		    $this->redirect('packages/packageGallery/'.$id);
		    }catch (Exception $e) {
		      $this->set_logs($this->session->gets('adminuser_id'),'packages','uploadPackageImages','error_logs',$e->getMessage(),'ERR');
		    }  
	  	}

		 
	  	public function editPackage($package_id){
	  		try{ 
	  			$result = $this->model->getPackageDetails($package_id);
	  			$this->view->cat_id = $result->packages->category_id;
	  			$this->view->categoryDetails = $this->model->getCategoryDetails($result->packages->category_id); 	  			 
	  			$this->view->packages = $result->packages;  
	  			$this->set_logs($this->session->gets('adminuser_id'),'packages','editPackage'.$package_id,'error_logs','Edit Package','ACTS');
	  			$this->view->LoadView('editPackage', 'packages');
		      	
	  		}
	  		catch (Exception $e) {
		        $this->set_logs($this->session->gets('adminuser_id'),'packages','editPackage','error_logs',$e->getMessage(),'ERR');
		    }  
	  	}
	  	
	  	public function updatePackageDetails(){
	  		try{	
	  			if(!empty($_FILES['package_images']['name'])){
			        $filedir = FRONTUPLOADPATH."pages/";
			        $randName = rand(10101010, 9090909090);
			        $filename = $_FILES['package_images']['name'];
			        $filename = explode(".",$filename);
			        $newName = $filename[0].'_' . $randName; 
			        $ext = substr($_FILES['package_images']['name'], strrpos($_FILES['package_images']['name'], '.') + 1);
			        $this->ImageUpload->File = $_FILES['package_images'];
			        $this->ImageUpload->method = 1;
			        $this->ImageUpload->SavePath = $filedir;
			        $this->ImageUpload->NewName = $newName;
			        $this->ImageUpload->OverWrite = true;
			        $err = $this->ImageUpload->UploadFile();  
			        $_POST['package_images'] = $newName.".".strtolower($ext);                  
			    }else {
			    	$_POST['package_images'] = $_POST['package_images_old'] ;
			    } 			
	  			$result = $this->model->updatePackageDetails($_POST);
		      	if($result->status = "200") {
		        	$this->session->sets('success_msg','Updated Successfully.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'packages','updatePackageDetails'.implode('~', $_POST),'error_logs','Package Updated','ACTS');
		      	} else {
		      		$this->session->sets('error_msg','Not Updated.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'packages','updatePackageDetails'.implode('~', $_POST),'error_logs','Package Not Updated','ERR');
		        	// echo "1";
		      	}
		      	$this->redirect('packages/news/'.base64_encode($_POST['category_id'])); 
	  		}
	  		catch (Exception $e) {
		        $this->set_logs($this->session->gets('adminuser_id'),'packages','updatePackageDetails','error_logs',$e->getMessage(),'ERR');
		    }  
	  	}

	  	public function deletePackage() {
	    	try{
	      		if(!empty($_POST)) {
	        		$result = $this->model->deletePackage($_POST);
	        		if($result) {
		          		$this->session->sets('success_msg','Package Deleted Successfully.');
		          		$this->set_logs($this->session->gets('adminuser_id'),'packages','deletePackage'.implode('~', $_POST),'error_logs','Delete SLider','ACTS');
			        } else {
			          	$this->set_logs($this->session->gets('user_id'),'packages','deletePackage','error_logs','Package not Deleted','ACTS');    
			          	$this->session->sets('error_msg','Packages not Deleted.');
		        	}                
		      	}else {
		        	$this->session->sets('error_msg','Packages not Deleted.');
		      	}
	    	} catch(Exception $e)  {
	      		$data = implode('~',$_POST);
	      		$this->set_logs($this->session->gets('user_id'),'packages','deletePackage'.$data,'error_logs',$e->getMessage(),'ERR');
	    	}
	  	}

















 	}
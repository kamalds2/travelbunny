<?php


	class packages_model extends Model {

		public function __construct() {
		    parent::__construct();
		}

		public function getCategoryDetails($cat_id) {		     
		    $url = RESTURL."packages/getcategorydetails/".$cat_id; 
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}

		public function getAllPackages() {		     
		    $url = RESTURL."packages/getallpackages";  
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		} 
		
		public function getGeneralItems() {		     
		    $url = RESTURL."packages/getgeneralitems";  
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		} 
		
		public function getPackageDetails($package_id) {		     
		    $url = RESTURL."packages/getpackagedetails/".$package_id; 
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}

		public function addPackageDetails($data) {
		    $data['created_date'] = date('Y-m-d H:i:s');
		    $data['created_by'] = $this->session->gets('adminuser_id');
		    $url = RESTURL."packages/addpackagedetails";  
		    // echo $url;var_dump(json_encode($data));die();
		    $res = $this->CallAPI("POST",$url,$data);  
		    return $res;
		}

		public function getPackageGallery($package_id) {
		    $url = RESTURL."packages/getpackagegallery/".$package_id; 
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}
		
		public function updatePackageDetails($data) {
		    $data['modified_date'] = date('Y-m-d H:i:s');
		    $data['modified_by'] = $this->session->gets('adminuser_id');
		    $url = RESTURL."packages/updatepackagedetails"; 
		    // echo $url;var_dump(json_encode($data));die(); 
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}

		public function deletePackage($data) { 
		    $data['modified_date'] = date('Y-m-d H:i:s');
		    $data['modified_by'] = $this->session->gets('adminuser_id');
		    $url = RESTURL."packages/deletepackage";  
		    // echo $url;var_dump(json_encode($data));die();
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}

		public function uploadPackageImages($data){
			$data['created_date'] = date('Y-m-d H:i:s');
		    $data['created_by'] = $data['image_added_by'];
		    $url = RESTURL."packages/uploadpackageimages";  
		    // echo $url;var_dump(json_encode($data));die();
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}










	}
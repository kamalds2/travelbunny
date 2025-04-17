<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  class packages_model extends Model {
    /*
     * construct
     */
    public function __construct() { 
      parent::__construct();
    } 
 

    public function getAllDomesticPackages(){
      $url = RESTURL."travelbunny/getalldomesticpackages"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
 
    public function getPackageDetails($package_id){ 
      $url = RESTURL."travelbunny/getpackagedetails/".$package_id; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
 
    public function getPackageGallery($package_id){ 
      $url = RESTURL."travelbunny/getpackagegallery/".$package_id; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
    
    public function getHomePageDetails(){
      $url = RESTURL."travelbunny/gethomepagedetails"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
    
    public function sendEnquiry($data){ 
      $data['created_date'] = date('Y-m-d H:i:s');
      $data['created_by'] = 1;
      $url = RESTURL."travelbunny/sendenquiry";  
      $res = $this->CallAPI("POST",$url,$data); 
      return $res;
    }
 
     

  }



  
?>
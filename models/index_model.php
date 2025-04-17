<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  class index_model extends Model {
    /*
     * construct
     */
    public function __construct() { 
      parent::__construct();
    } 

    public function getAllMenus(){
      $url = RESTURL."travelbunny/getallmenus"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }

    public function getAllSliders(){
      $url = RESTURL."travelbunny/getallsliders";  
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }

    public function getDomesticPackages(){
      $url = RESTURL."travelbunny/getdomesticpackages"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }

    public function getAllPackagess(){
      $url = RESTURL."travelbunny/getallpackages"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
    
    public function getFeaturedPackages(){ 
      $url = RESTURL."travelbunny/getfeaturedpackages"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
 
    public function getAllTestimonials(){
      $url = RESTURL."travelbunny/getalltestimonials"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }

    
    public function getHomePageDetails(){
      $url = RESTURL."travelbunny/gethomepagedetails"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
 

  }



  
?>
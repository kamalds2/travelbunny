<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  class testimonials_model extends Model {
    /*
     * construct
     */
    public function __construct() { 
      parent::__construct();
    } 
 

    public function getAllTestimonials(){
      //var_dump("hello");
      //die();
      $url = RESTURL."travelbunny/getalltestimonials"; 
      $res = $this->CallAPI("GET",$url); 
      return $res;
    }
  
 
     

  }



  
?>
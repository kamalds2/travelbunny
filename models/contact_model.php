<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  class contact_model extends Model {
    /*
     * construct
     */
    public function __construct() { 
      parent::__construct();
    } 
 
  public function addContactDetails($data){ 
    $data['created_date'] = date('Y-m-d H:i:s');
    $data['created_by'] = 1;
    $url = RESTURL."travelbunny/addcontactdetails";
    // echo $url;var_dump(json_encode($data));die();  
    $res = $this->CallAPI("POST",$url,$data); 
    return $res;
  }
 
     

  }



  
?>
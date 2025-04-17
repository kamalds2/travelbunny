<?php


	class tales_model extends Model {

		public function __construct() {
		    parent::__construct();
		}

		public function getAllTales() {		     
		    $url = RESTURL."tales/getalltales";  
		    $res = $this->CallAPI("GET",$url);
		    return $res;
		}
		public function getTaleDetails($tale_id){
			$url = RESTURL."tales/gettaledetails/".$tale_id; 

		    $res = $this->CallAPI("GET",$url); 
		    
		    return $res;
		}

		public function updateTale($data) {
		    $url = RESTURL."tales/updatetale";   
		    // echo $url;var_dump(json_encode($data));die();
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}
		public function createTale($data){
		    $url = RESTURL."tales/addtale"; 
		    // echo $url;var_dump(json_encode($data));die();
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;


		}
		public function deleteTale($tale_id){
			$url = RESTURL."tales/deletetale/".$tale_id; 
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}
		

	}
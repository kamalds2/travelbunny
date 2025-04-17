<?php


	class pages_model extends Model {

		public function __construct() {
		    parent::__construct();
		}

		public function getPageDetails($slug) {		     
		    $url = RESTURL."travelbunny/getpagedetails/".$slug; 
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}
 






	}
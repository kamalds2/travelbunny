<?php


	class enquiries_model extends Model {

		public function __construct() {
		    parent::__construct();
		}

		public function getAllEnquiries() {		     
		    $url = RESTURL."enquiries/getallenquiries";
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}









	}
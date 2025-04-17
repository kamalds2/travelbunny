<?php


	class testimonials_model extends Model {

		public function __construct() {
		    parent::__construct();
		}

		public function getAllTestimonials() {		     
		    $url = RESTURL."testimonials/getalltestimonials";  
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		} 

		public function getTestimonialDetails($testimonial_id) {		     
		    $url = RESTURL."testimonials/gettestimonialdetails/".$testimonial_id; 
		    $res = $this->CallAPI("GET",$url); 
		    return $res;
		}

		public function addTestimonialDetails($data) {
		    $data['created_date'] = date('Y-m-d H:i:s');
		    $data['created_by'] = $this->session->gets('adminuser_id');
		    $url = RESTURL."testimonials/addtestimonialdetails";  
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}

		public function updateTestimonialDetails($data) {
		    $data['modified_date'] = date('Y-m-d H:i:s');
		    $data['modified_by'] = $this->session->gets('adminuser_id');
		    $url = RESTURL."testimonials/updatetestimonialdetails";  
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}

		public function deleteTestimonial($data) { 
		    $data['modified_date'] = date('Y-m-d H:i:s');
		    $data['modified_by'] = $this->session->gets('adminuser_id');
		    $url = RESTURL."testimonials/deletetestimonial";  
		    // echo $url;var_dump(json_encode($data));die();
		    $res = $this->CallAPI("POST",$url,$data); 
		    return $res;
		}










	}
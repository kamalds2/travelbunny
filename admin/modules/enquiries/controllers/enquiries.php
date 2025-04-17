<?php 
	
	class enquiries extends Controller {
		/** * Constructor */
	  	public function __construct() {
	    	parent::__construct();	
	    	if(!$this->session->gets('adminuser_id')){
	    		$this->redirect ('index');
	    	}    
	  	}

	  	public function index() { 
		    try{ 
		      	$this->view->enquiriesList = $this->model->getAllEnquiries(); 
		      	 $this->set_logs($this->session->gets('adminuser_id'),'enquiries','index','error_logs','Enquiries','ACTS');  
      			$this->view->LoadView('manageEnquiries', 'enquiries');
		    }          
		    catch (Exception $e) {
		        $this->set_logs($this->session->gets('adminuser_id'),'enquiries','index','error_logs',$e->getMessage(),'ERR');
		    }         
	  	}


	  	public function deleteEnquiry() {
	    	try{
	    		var_dump($_POST);die();
	      		if(!empty($_POST)) {
	        		$result = $this->model->deleteEnquiry($_POST);
	        		if($result) {
		          		$this->session->sets('success_msg','Enquiry Deleted Successfully.');
			        } else {
			          	$this->set_logs($this->session->gets('user_id'),'enquiries','deleteEnquiry'.implode('~',$_POST),'error_logs','Enquiry not Deleted','ACTS');    
			          	$this->session->sets('error_msg','Enquiry not Deleted.');
		        	}                
		      	}else {
		        	$this->session->sets('error_msg','Enquiry not Deleted.');
		      	}
	    	} catch(Exception $e)  {
	      		$data = implode('~',$_POST);
	      		$this->set_logs($this->session->gets('adminuser_id'),'enquiries','deleteEnquiry'.$data,'error_logs',$e->getMessage(),'ERR');
	    	}
	  	}

	  	 
		 









	}







?>
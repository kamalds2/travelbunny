<?php

class Tales extends Controller {
	
	public function __construct() {
		parent::__construct();	
	    	if(!$this->session->gets('adminuser_id')){
	    		$this->redirect ('index');
	    	}
    		$this->LoadHelper('ImageUpload'); 
	}

	public function index() {
		try{
			$this->view->talesList = $this->model->getAllTales();
			$this->set_logs($this->session->gets('adminuser_id'),'tales','index','error_logs','Tales','ACTS');
			$this->view->LoadView('manageTales', 'tales');
		}
		catch(Exception $e){
			$this->set_logs($this->session->gets('adminuser_id'),'tales','index','error_logs',$e->getMessage(),'ERR');
		}	
	}

	public function editTale($tale_id) {

		try{
			$res = $this->model->getTaleDetails($tale_id);
			
			$this->view->tales = $res->tales;
			$this->set_logs($this->session->gets('adminuser_id'),'tales','editTales'.$tale_id,'error_logs','Edit Tales','ACTS');
			$this->view->LoadView('editTale','tales');
		}
		catch(Exception $e){
		$this->set_logs($this->session->gets('adminuser_id'),'tales','editTales','error_logs',$e->getMessage(),'ERR');	
		}

	}

	public function updateTale()
	{

			try{
				$res = $this->model->updateTale($_POST);

				if($result) {
		        	$this->session->sets('success_msg','Updated Successfully.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'tales','editTales'.implode('~',$_POST),'error_logs','Update Tales','ACTS');
		        	
		      	} else {
		      		$this->session->sets('error_msg','Not Updated.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'tales','updateTale'.implode('~', $_POST),'error_logs','Update Tales','ERR');
		        	// echo "1";
		      	}
		      	$this->redirect('tales'); 
		      	// $this->redirect('pages/editPage/'.$_POST['page_id']); 
	  		}
	  		catch (Exception $e) {
		        $this->set_logs($this->session->gets('adminuser_id'),'tales','updateTale','error_logs',$e->getMessage(),'ERR');
		      
			}
	}

	public function addTale() {
		$this->view->LoadView('addTale', 'tales');
	}

	public function createTale(){
		try{ 	  
	  			$result = $this->model->createTale($_POST);
	  			
		      	if($result) {
		        	$this->session->sets('success_msg','Added Successfully.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'tales','createTale'.implode('~',$_POST),'error_logs','Add Tales','ACTS');
		        	
		      	} else {
		      		$this->session->sets('error_msg','Not Added.');
		        	$this->set_logs($this->session->gets('adminuser_id'),'tales','createTale'.implode('~', $_POST),'error_logs','Add Tales','ERR');
		        	// echo "1";
		      	}
		      	$this->redirect('tales'); 
	  		}
	  		catch (Exception $e) {
		        $this->set_logs($this->session->gets('adminuser_id'),'tales','createTale','error_logs',$e->getMessage(),'ERR');
		    } 
	}

	public function deleteTale($tale_id) {
	    	try{
	      		
	    
	        		$result = $this->model->deleteTale($tale_id);
	        		if($result) {
		          		$this->session->sets('success_msg','Tales Deleted Successfully.');
		          		$this->set_logs($this->session->gets('adminuser_id'),'tales','deleteTale'.implode('~',$_POST),'error_logs','Delete Tales','ACTS');
			        } else {
			          	$this->session->sets('error_msg','Tales not Deleted.');
			          	$this->set_logs($this->session->gets('user_id'),'tales','deleteTale'.implode('~',$_POST),'error_logs','Tale not Deleted','ACTS');    
		        	}                
		      	
		      	$this->redirect('tales'); 
	    	} catch(Exception $e)  {
	      		$data = implode('~',$_POST);
	      		$this->set_logs($this->session->gets('user_id'),'tales','deleteTale'.$data,'error_logs',$e->getMessage(),'ERR');
	    	}
	  	}


	
}
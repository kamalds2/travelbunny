<?php
/**
 * Index
 * This is main default controller 
 * PHP version 5
 * @author siriinnovations.com
 * @version 1.0
 * @license http://URL name 
 * @access public
 */
  class pages extends Controller {
    /**
    * Constructor 
    */
    public function __construct() {
      parent::__construct();
    }
     
    public function index(){
      
    }
    public function  ($slug) { 
      try{  
        $pageDetails = $this->model->getPageDetails($slug[0]); 
        $this->view->pageDetails = $pageDetails;
        $this->view->metaDetails = (array)$pageDetails->res; 
        $this->view->LoadView('pages');
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'pages','pageDisplay','error_logs',$e->getMessage(),'ERR');
      } 
    }

     
     
  }
?>
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
  class contact extends Controller {
    /**
    * Constructor 
    */
    public function __construct() {
      parent::__construct();
    }
     
    public function index() { 
      try{        
        $this->view->LoadView('contact');
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'contact','contact','error_logs',$e->getMessage(),'ERR');
      } 
    }

    

    public function addContactDetails() { 
      try{ 
        $res = $this->model->addContactDetails($_POST);
        if($res->status == "200") {
          $this->session->sets('success_msg','Added Successfully.');
          $this->set_logs($this->session->gets('user_id'),'packages','addContactDetails'.implode('~', $_POST),'error_logs','Packages-add','ACTS');              
        } else {
          $this->session->sets('error_msg','Not Added.');
          $this->set_logs($this->session->gets('user_id'),'contact','addContactDetails'.implode('~', $_POST),'error_logs','Packages not Added','ERR');
           
        }
        $this->redirect('contact'); 
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'packages','addContactDetails','error_logs',$e->getMessage(),'ERR');
      } 
    }

     
  }
?>
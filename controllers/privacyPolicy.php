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
  class privacyPolicy extends Controller {
    /**
    * Constructor 
    */
    public function __construct() {
      parent::__construct();
    }
     
    public function index() { 
      try{ 
        $this->view->LoadView('privacyPolicy');
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'privacyPolicy','privacyPolicy','error_logs',$e->getMessage(),'ERR');
      } 
    }

     
     
  }
?>
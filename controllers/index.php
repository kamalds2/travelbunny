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
class index extends Controller {
  /**
  * Constructor 
  */
  public function __construct() {
    parent::__construct();
  }
  /**
  * Login page 
  */
  public function index() { 
    try{

      $this->view->menus = $this->model->getAllMenus();

      $this->view->sliders = $this->model->getAllSliders();
      $this->view->featuresPackages = $this->model->getFeaturedPackages();

      $this->view->packages = $this->model->getDomesticPackages();

      $this->view->testimonials = $this->model->getAllTestimonials();
     // var_dump($this->view->menus);
       //                      die();

      $pageDetails = $this->model->getHomePageDetails();
      $this->view->metaDetails = (array)$pageDetails->res;
       
      $this->view->LoadView('index');
    }        
    catch (Exception $e) {
      $this->set_logs($this->session->gets('user_id'),'index','index','error_logs',$e->getMessage(),'ERR');
    } 
  }

   
}
?>
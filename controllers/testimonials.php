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
  class testimonials extends Controller {
    /**
    * Constructor 
    */
    public function __construct() {
      parent::__construct();
    }
     
    public function index(){
      // var_dump($_GET);die();
      $this->view->testimonials = $this->model->getAllTestimonials(); 
      $this->view->metaDetails  = [
        'page_title' => 'Testimonials',
        'meta_title' => 'Testimonials',
        'meta_description' => 'Travel Bunny Offers A Wide Variety Of Travel Related Solutions To Fulfils All Your Travel Requirements. Our Services: Flight Bookings And Domestic - International  Holiday Packages And Visa Services & Forex Exchange.',
        'meta_keywords' => 'travel bunny, travelbunny, travel bunny hyderabad, Kerela Honeymoon, Kashmir Honeymoon, Maldives Honeymoon, Amarnath yatra.'
      ]; 
      $this->view->LoadView('testimonials');
    }
     

     
     
  }
?>
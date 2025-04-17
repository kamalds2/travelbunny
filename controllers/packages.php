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
  class packages extends Controller {
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
        $this->view->packages = $this->model->getAllDomesticPackages(); 
         $this->view->metaDetails  = [
        'page_title' => 'Packages',
        'meta_title' => 'Packages',
        'meta_description' => 'Travel Bunny Offers A Wide Variety Of Travel Related Solutions To Fulfils All Your Travel Requirements. Our Services: Flight Bookings And Domestic - International  Holiday Packages And Visa Services & Forex Exchange.',
        'meta_keywords' => 'travel bunny, travelbunny, travel bunny hyderabad, Kerela Honeymoon, Kashmir Honeymoon, Maldives Honeymoon, Amarnath yatra.'
      ]; 
        $this->view->LoadView('packagesListing');
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'packages','packages','error_logs',$e->getMessage(),'ERR');
      } 
    }

    public function packageDetails($package_id) { 
      try{  
        $this->view->packageDetails = $this->model->getPackageDetails($package_id);   
        $this->view->packageGallery = $this->model->getPackageGallery($package_id);  
        $this->view->metaDetails  = [
        'page_title' => $this->view->packageDetails->res->package_title,
        'meta_title' => $this->view->packageDetails->res->package_title,
        'meta_description' => 'Travel Bunny Offers A Wide Variety Of Travel Related Solutions To Fulfils All Your Travel Requirements. Our Services: Flight Bookings And Domestic - International  Holiday Packages And Visa Services & Forex Exchange.',
        'meta_keywords' => 'travel bunny, travelbunny, travel bunny hyderabad, Kerela Honeymoon, Kashmir Honeymoon, Maldives Honeymoon, Amarnath yatra.'
      ]; 
        $this->view->LoadView('packageDetails');
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'packages','packageDetails','error_logs',$e->getMessage(),'ERR');
      } 
    }

    public function sendEnquiry() { 
      try{
        $res = $this->model->sendEnquiry($_POST);
        if($res->status == "200") {
          $this->session->sets('success_msg','Added Successfully.');
          $this->set_logs($this->session->gets('user_id'),'packages','sendEnquiry'.implode('~', $_POST),'error_logs','Packages-add','ACTS');              
        } else {
          $this->session->sets('error_msg','Not Added.');
          $this->set_logs($this->session->gets('user_id'),'packages','sendEnquiry'.implode('~', $_POST),'error_logs','Packages not Added','ERR');
           
        }
        $this->redirect('packages/packageDetails/'.$_POST['package_id']); 
      }        
      catch (Exception $e) {
        $this->set_logs($this->session->gets('user_id'),'packages','sendEnquiry','error_logs',$e->getMessage(),'ERR');
      } 
    }

    public function luxuryHoneymoon(){
      $this->view->metaDetails  = [
        'page_title' => 'Luxury Honeymoon',
        'meta_title' => 'Luxury Honeymoon',
        'meta_description' => 'Travel Bunny Offers A Wide Variety Of Travel Related Solutions To Fulfils All Your Travel Requirements. Our Services: Flight Bookings And Domestic - International  Holiday Packages And Visa Services & Forex Exchange.',
        'meta_keywords' => 'travel bunny, travelbunny, travel bunny hyderabad, Kerela Honeymoon, Kashmir Honeymoon, Maldives Honeymoon, Amarnath yatra.'
      ]; 
        $this->view->pageDetails = $this->model->getHomePageDetails();
      $this->view->LoadView('luxuryHoneymoon');
    }

    public function destinationWedding(){
      $this->view->metaDetails  = [
        'page_title' => 'Destination Wedding',
        'meta_title' => 'Destination Wedding',
        'meta_description' => 'Travel Bunny Offers A Wide Variety Of Travel Related Solutions To Fulfils All Your Travel Requirements. Our Services: Flight Bookings And Domestic - International  Holiday Packages And Visa Services & Forex Exchange.',
        'meta_keywords' => 'travel bunny, travelbunny, travel bunny hyderabad, Kerela Honeymoon, Kashmir Honeymoon, Maldives Honeymoon, Amarnath yatra.'
      ]; 
        $this->view->pageDetails = $this->model->getHomePageDetails();
      $this->view->LoadView('destinationWedding');
    }

     
  }
?>
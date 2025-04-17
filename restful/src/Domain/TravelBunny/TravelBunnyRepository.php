<?php
namespace App\Domain\TravelBunny;
use PDO;
/** 
* Repository.
*/
class TravelBunnyRepository
{ 
  /*** @var PDO The database connection  */
  private $connection;
 
  public function __construct(PDO $connection)
  { 
    $this->connection = $connection;
  }
   
   
  public function getAllMenus($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."menus where menu_parentid = 0 and menu_status = 'y'";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $menus = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($menus)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $menus
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;    

    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 
  public function getAllSliders($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."sliders where slider_status = '0'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $sliders = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($sliders)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $sliders
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;    

    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
    
  public function getAllPackages($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."packages where package_status = 0";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $packages = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $packages
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;    

    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 
  public function getDomesticPackages($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."packages where package_status = 0 AND category_id = (SELECT category_id from tbl_package_categories WHERE category_name = 'Domestic') LIMIT 0,4";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $packages = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $packages
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;    

    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 
  public function getAllTestimonials($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."testimonials where testimonial_status = 0 ";      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $testimonials = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($testimonials)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $testimonials
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;    

    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }

  
  public function getFeaturedPackages($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."packages where package_status = 0 AND featured = 1";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $packages = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $packages
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  
  
  public function getAllDomesticPackages($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."packages where package_status = 0 AND category_id = (SELECT category_id from tbl_package_categories WHERE category_name = 'Domestic')";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $packages = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $packages
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 
  public function getPackageDetails($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."packages   WHERE  package_id = :package_id ";
      // $sql = "SELECT p.*,pg.image_url FROM ".DB_PREFIX."packages p INNER JOIN `tbl_package_gallery` pg ON p.package_id = pg.package_id WHERE p.package_id = :package_id and pg.status = 0 ";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->execute();
      $packages = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $packages
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }

  public function getPackageGallery($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."package_gallery WHERE package_id = :package_id and status = 0 ";      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->execute();
      $packages = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $packages
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }

  public function sendEnquiry($data){ 
    try{
      extract($data);
      $sql = "INSERT INTO ".DB_PREFIX."enquiries (name,email,mobile_no,package_id,destination,message,created_date,created_by) VALUES(:name,:email,:mobile_no,:package_id,:destination,:message,:created_date,:created_by) ";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":name",$name);
      $stmt->bindParam(":email",$email);
      $stmt->bindParam(":mobile_no",$mobile_no);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->bindParam(":destination",$destination);
      $stmt->bindParam(":message",$message);
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by",$created_by);
      $stmt->execute();
      $enquiry_id = $this->connection->lastInsertId();
      if($enquiry_id > 0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $enquiry_id
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 
  public function addContactDetails($data){ 
    try{
      extract($data); 
      $sql = "INSERT INTO ".DB_PREFIX."contacts (name,email,mobile_no,subject,message,created_date,created_by) VALUES(:name,:email,:mobile_no,:subject,:message,:created_date,:created_by) ";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":name",$name);
      $stmt->bindParam(":email",$email);
      $stmt->bindParam(":mobile_no",$mobile_no);  
      $stmt->bindParam(":subject",$subject);  
      $stmt->bindParam(":message",$message);
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by",$created_by);
      $stmt->execute();
      $contact_id = $this->connection->lastInsertId();
      if($contact_id > 0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $contact_id
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 
  public function getPageDetails($data){ 
    try{
      extract($data); 
      $sql = "SELECT * FROM `tbl_pages` WHERE page_id = (SELECT menu_pageid FROM tbl_menus WHERE menu_slug =  :slug)";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":slug",$slug); 
      $stmt->execute(); 
      $page = $stmt->fetch(PDO::FETCH_OBJ); 
      if(!empty($page)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $page
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  
  public function getModuleDetails($data){ 
    try{
      extract($data); 
      $sql = "SELECT * FROM ".DB_PREFIX."modules WHERE module_id = :module_id";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":module_id",$module_id); 
      $stmt->execute(); 
      $modules = $stmt->fetch(PDO::FETCH_OBJ); 
      if(!empty($modules)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $modules
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  } 
   
  public function getSettingsData($data){ 
    try{
      extract($data); 
      $sql = "SELECT * FROM ".DB_PREFIX."settings WHERE settings_id = 1";
      
      $stmt = $this->connection->prepare($sql); 
      $stmt->execute(); 
      $modules = $stmt->fetch(PDO::FETCH_OBJ); 
      if(!empty($modules)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $modules
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  } 

  public function getHomePageDetails($data){ 
    try{
      extract($data); 
      $sql = "SELECT * FROM `tbl_pages` WHERE page_id = 1";
      
      $stmt = $this->connection->prepare($sql); 
      $stmt->execute(); 
      $page = $stmt->fetch(PDO::FETCH_OBJ); 
      if(!empty($page)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $page
        );
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
 

}

  
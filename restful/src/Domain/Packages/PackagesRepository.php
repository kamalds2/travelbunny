<?php
namespace App\Domain\Packages;
use PDO;
/** 
* Repository.
*/
class PackagesRepository
{ 
  /*** @var PDO The database connection  */
  private $connection;
 
  public function __construct(PDO $connection)
  { 
    $this->connection = $connection;
  }
   
  public function getCategoryDetails($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."package_categories where category_id = :category_id ";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":category_id",$category_id);
      $stmt->execute();
      $categories = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($categories)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'categories' => $categories
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
         'packages' => $packages
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

  public function getGeneralItems($data){ 
    try{
      extract($data);
      $sql = "SELECT item_id,item_name,category FROM ".DB_PREFIX."general_items where category  IN ('includes','excludes') AND status = 0";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $items = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($items)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'items' => $items
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

  
  public function addPackageDetails($data){ 
    try{ 
      extract($data); 
      if(!isset($featured)){
        $featured = 0;
      } 
      // $includes_excludes = implode(',',$includes_excludes);
      $sql = "INSERT INTO ".DB_PREFIX."packages (category_id,package_title,description,package_images,location,reviews, no_of_days, no_of_nights, min_age, package_price,includes,excludes,package_status,featured, meta_title, meta_description, meta_keywords,created_date,created_by) VALUES(:category_id,:package_title,:description, :package_images,:location, :reviews, :no_of_days, :no_of_nights, :min_age, :package_price,:includes,:excludes,:package_status, :featured,:meta_title, :meta_description, :meta_keywords,:created_date,:created_by)";
       
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_title",$package_title);
      $stmt->bindParam(":description",$description);  
      $stmt->bindParam(":package_images",$package_images);  
      $stmt->bindParam(":location",$location);  
      $stmt->bindParam(":reviews",$reviews);  
      $stmt->bindParam(":no_of_days",$no_of_days);  
      $stmt->bindParam(":no_of_nights",$no_of_nights);  
      $stmt->bindParam(":min_age",$min_age);  
      $stmt->bindParam(":package_price",$package_price);  
      $stmt->bindParam(":includes",$includes);  
      $stmt->bindParam(":excludes",$excludes);  
      $stmt->bindParam(":category_id",$category_id);  
      $stmt->bindParam(":package_status",$package_status); 
      $stmt->bindParam(":featured",$featured);  
      $stmt->bindParam(":meta_title",$meta_title); 
      $stmt->bindParam(":meta_description",$meta_description); 
      $stmt->bindParam(":meta_keywords",$meta_keywords);       
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by",$created_by);
      $stmt->execute();
      $package_id = $this->connection->lastInsertId();

      if($package_id >0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'package_id' => $package_id
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No data Added"
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
      $sql = "SELECT * FROM ".DB_PREFIX."packages where package_id = :package_id";
      $package_status = '0';
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->execute();
      $packages = $stmt->fetch(PDO::FETCH_OBJ); 
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'packages' => $packages
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

  public function getPackageGallery ($data){ 
    try{ 
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."package_gallery where package_id = :package_id";
      $package_status = '0';
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->execute();
      $packages = $stmt->fetchAll(PDO::FETCH_OBJ); 
      if(!empty($packages)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'packages' => $packages
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

  public function updatePackageDetails($data){ 
    try{
      extract($data);
      if(!isset($featured)){
        $featured = 0;
      }
      $sql = "UPDATE ".DB_PREFIX."packages SET package_title = :package_title,  video_url=:video_url,featured=:featured,location=:location,no_of_days=:no_of_days,no_of_nights=:no_of_nights,min_age=:min_age,package_price=:package_price,package_status=:package_status,includes=:includes,excludes=:excludes,meta_title = :meta_title, meta_description =:meta_description,
      meta_keywords=:meta_keywords, modified_date = :modified_date,modified_by = :modified_by WHERE package_id = :package_id";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->bindParam(":package_title",$package_title); 
      $stmt->bindParam(":video_url",$video_url); 
      $stmt->bindParam(":featured",$featured); 
      $stmt->bindParam(":location",$location); 
      $stmt->bindParam(":no_of_days",$no_of_days); 
      $stmt->bindParam(":no_of_nights",$no_of_nights); 
      $stmt->bindParam(":min_age",$min_age); 
      $stmt->bindParam(":package_price",$package_price); 
      $stmt->bindParam(":package_status",$package_status);
      $stmt->bindParam(":includes",$includes);
      $stmt->bindParam(":excludes",$excludes);
      $stmt->bindParam(":meta_title",$meta_title); 
      $stmt->bindParam(":meta_description",$meta_description); 
      $stmt->bindParam(":meta_keywords",$meta_keywords); 
      $stmt->bindParam(":modified_date",$modified_date);
      $stmt->bindParam(":modified_by",$modified_by);
      $res = $stmt->execute();
      
      if($res) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $res
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
   
  public function deletePackage($data){ 
    try{
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."packages SET package_status = '9',modified_date = :modified_date,modified_by = :modified_by WHERE package_id = :package_id";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->bindParam(":modified_date",$modified_date);
      $stmt->bindParam(":modified_by",$modified_by);
      $res = $stmt->execute();
      
      if($res) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $res
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

  public function uploadPackageImages($data){
    try{
      extract($data);
      $status = 0;
      $sql = "INSERT INTO ".DB_PREFIX."package_gallery (package_id,image_url,status,created_date,created_by) VALUES (:package_id,:image_url,:status,:created_date,:created_by)";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":package_id",$package_id);
      $stmt->bindParam(":image_url",$image_url);
      $stmt->bindParam(":status",$status);
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by",$created_by);
      $stmt->execute();
      $gallery_id = $this->connection->lastInsertId();
      if($gallery_id > 0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $gallery_id
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

  
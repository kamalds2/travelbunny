<?php
namespace App\Domain\Testimonials;
use PDO;
/** 
* Repository.
*/
class TestimonialsRepository
{ 
  /*** @var PDO The database connection  */
  private $connection;
 
  public function __construct(PDO $connection)
  { 
    $this->connection = $connection;
  }
   
  public function getAllTestimonials($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."testimonials where testimonial_status = '0'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $testimonials = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($testimonials)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'testimonials' => $testimonials
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

  
  public function addTestimonialDetails($data){ 
    try{
      extract($data);
      $sql = "INSERT INTO ".DB_PREFIX."testimonials (testimonial_title,video_url,testimonial_status,created_date,created_by) VALUES(:testimonial_title,:video_url,:testimonial_status,:created_date,:created_by)";
       
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":testimonial_title",$testimonial_title);
      $stmt->bindParam(":video_url",$video_url);  
      $stmt->bindParam(":testimonial_status",$testimonial_status); 
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by",$created_by);
      $stmt->execute();
      $testimonial_id = $this->connection->lastInsertId();

      if($testimonial_id >0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'testimonial_id' => $testimonial_id
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
  
  public function getTestimonialDetails($data){ 
    try{ 
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."testimonials where testimonial_id = :testimonial_id";
      $testimonial_status = '0';
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":testimonial_id",$testimonial_id);
      $stmt->execute();
      $testimonials = $stmt->fetch(PDO::FETCH_OBJ); 
      if(!empty($testimonials)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'testimonials' => $testimonials
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

  public function updateTestimonialDetails($data){ 
    try{
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."testimonials SET testimonial_title = :testimonial_title,  video_url=:video_url,testimonial_status = :testimonial_status,modified_date = :modified_date,modified_by = :modified_by WHERE testimonial_id = :testimonial_id";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":testimonial_id",$testimonial_id);
      $stmt->bindParam(":testimonial_title",$testimonial_title); 
      $stmt->bindParam(":video_url",$video_url); 
      $stmt->bindParam(":testimonial_status",$testimonial_status);
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
   
  public function deleteTestimonial($data){ 
    try{
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."testimonials SET testimonial_status = '9',modified_date = :modified_date,modified_by = :modified_by WHERE testimonial_id = :testimonial_id";
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":testimonial_id",$testimonial_id);
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
   


}

  
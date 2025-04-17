<?php
namespace App\Domain\Enquiries;
use PDO;
/** 
* Repository.
*/
class EnquiriesRepository
{ 
  /**
   * @var PDO The database connection
   */
  private $connection;
  /**  
   * Constructor.
   *
   * @param PDO $connection The database connection
   */
  public function __construct(PDO $connection)
  { 
    $this->connection = $connection;
  }
   
  
  public function getAllEnquiries($data){ 
    try{
      extract($data);
      
      $sql = "SELECT * FROM ".DB_PREFIX."enquiries  ";
      $stmt = $this->connection->prepare($sql);  
       
      $stmt->execute();
      $enquiries = $stmt->fetchAll(PDO::FETCH_OBJ);

      if(!empty($enquiries)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'enquiries' => $enquiries
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

  
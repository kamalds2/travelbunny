<?php

namespace App\Domain\Tales;

use PDO;

class TalesRepository{
	
	public function __construct(PDO $con) {
	$this->con = $con;
	}

	public function getAllTales() {
		$stmt = $this->con->query("SELECT * FROM tbl_tales");
		$tales = $stmt->fetchAll();
		if(!empty($tales)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'tales' => $tales
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit; 
	}

  public function getTaleDetails($data){
    extract($data);
    $stmt = $this->con->prepare("SELECT * FROM tbl_tales where tale_id=:tale_id;");
    $stmt->bindParam(':tale_id', $tale_id);
    $stmt->execute();
    $tales = $stmt->fetchAll();
    if(!empty($tales)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'tales' => $tales
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit; 
  
  }

  public function updateTale($data) {
    extract($data);
    $stmt = $this->con->prepare("UPDATE tbl_tales set tale_title = :tale_title, tale_status = :tale_status where tale_id = :tale_id; ");
    $stmt->bindParam(':tale_title', $tale_title);
    $stmt->bindParam(':tale_status', $tale_status);
    $stmt->bindParam(':tale_id', $tale_id);
    $res = $stmt->execute();
  

    if($res){
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

  }

  public function addTale($data) {
    extract($data);
    $stmt = $this->con->prepare("INSERT INTO tbl_tales(tale_title,tale_status) values(:tale_title,:tale_status)");
    $stmt->bindParam(':tale_title', $tale_title);
    $stmt->bindParam(':tale_status', $tale_status);
    $stmt->execute();
      $tale_id = $this->con->lastInsertId();
      if($tale_id > 0){
      $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'tales' => $tales
        ); 
      }else{
        $status = array(
         'status' =>"204",
         'message' =>"No Data Found"
        );
      }
     return $status;exit;

  }

  public function deleteTale($data){
    extract($data);
    $stmt = $this->con->prepare("DELETE from tbl_tales where tale_id = :tale_id ;");
     $stmt->bindParam(':tale_id', $tale_id);
    $res = $stmt->execute();
    
    if($res){
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

  }
}
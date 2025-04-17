<?php
namespace App\Domain\Menus;
use PDO;
/** 
* Repository.
*/
class MenusRepository
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
      $sql = "SELECT * FROM ".DB_PREFIX."menus ORDER BY menu_position,menu_parentid";      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'menus' => $res
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

  public function getAllPages($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."pages WHERE page_status= '0'";      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'pages' => $res
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

  public function getAllModules($data){ 
    try{
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."modules WHERE module_status ='0' ORDER BY module_id";      
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'modules' => $res
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

  public function addMenuDetails($data){ 
    try{ 
      extract($data);
      if(!isset($menu_pageid)){
        $menu_pageid = NULL;
      }if(!isset($menu_moduleid)){
        $menu_moduleid = NULL;
      }if(!isset($menu_link)){
        $menu_link = '';
      }
      $sql = "INSERT INTO ".DB_PREFIX."menus(menu_name,menu_slug,menu_icon,menu_parentid,menu_pageid,menu_moduleid,menu_link,menu_contenttype,menu_status,created_date,created_by) VALUES (:menu_name,:menu_slug,:menu_icon,:menu_parentid,:menu_pageid,:menu_moduleid,:menu_link,:menu_contenttype,:menu_status,:created_date,:created_by)";
       
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":menu_name",$menu_name);
      $stmt->bindParam(":menu_slug",$menu_slug);
      $stmt->bindParam(":menu_icon",$menu_icon);
      $stmt->bindParam(":menu_parentid",$menu_parentid);
      $stmt->bindParam(":menu_pageid",$menu_pageid);
      $stmt->bindParam(":menu_moduleid",$menu_moduleid);
      $stmt->bindParam(":menu_link",$menu_moduleid);
      $stmt->bindParam(":menu_contenttype",$menu_contenttype);
      $stmt->bindParam(":menu_status",$menu_status);
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by",$created_by);
      $stmt->execute();
      $menu_id = $this->connection->lastInsertId();
      if($menu_id > 0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $menu_id
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

  public function updateMenuDetails($data){ 
    try{ 
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."menus set  menu_name = :menu_name,menu_slug=:menu_slug,menu_icon=:menu_icon,menu_parentid = :menu_parentid,menu_contenttype=:menu_contenttype,menu_status = :menu_status, modified_date = :modified_date,modified_by = :modified_by WHERE menu_id = :menu_id";
      // echo "UPDATE".DB_PREFIX."menus set  menu_name = '".$menu_name."',menu_slug='".$menu_slug."',menu_icon='".$menu_icon."',menu_parentid = ".$menu_parentid.",menu_contenttype='".$menu_contenttype."',menu_status = '".$menu_status."', modified_date = '".$modified_date."',modified_by = ".$modified_by." WHERE menu_id = ".$menu_id;die();
      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":menu_name",$menu_name);
      $stmt->bindParam(":menu_slug",$menu_slug);
      $stmt->bindParam(":menu_icon",$menu_icon);
      $stmt->bindParam(":menu_parentid",$menu_parentid);
      $stmt->bindParam(":menu_contenttype",$menu_contenttype);
      $stmt->bindParam(":menu_status",$menu_status);
      $stmt->bindParam(":modified_date",$modified_date);
      $stmt->bindParam(":modified_by",$modified_by);
      $stmt->bindParam(":menu_id",$menu_id);
      $res = $stmt->execute();
       
      if($res) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $menu_id
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

  public function getMenuDetails($data){ 
    try{ 
      extract($data);
      $sql = "SELECT * FROM ".DB_PREFIX."menus WHERE `menu_id` = :menu_id";      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":menu_id",$menu_id);
      $stmt->execute();
      $menu = $stmt->fetch(PDO::FETCH_OBJ);
      if($menu_id > 0) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $menu
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

  public function deleteMenuItems($data){ 
    try{ 
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."menus SET menu_status = '9' WHERE `menu_id` = :menu_id";      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":menu_id",$menu_id);
      $res =  $stmt->execute();
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

  public function getSubMenus($data){ 
    try{ 
      extract($data);
      $sql = "SELECT menu_id FROM ".DB_PREFIX."menus WHERE `menu_parentid` = :menu_id";      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":menu_id",$menu_id);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($data)) {
        $status = array(
         'status' =>"200",
         'message' =>"Success", 
         'res' => $data
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

  public function deleteSubMenuItems($data){ 
    try{ 
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."menus SET menu_status = '9' WHERE `menu_id` = :menu_id";      
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":menu_id",$menu_id);
      $res =  $stmt->execute();
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
  
  public function updateMenuById($data){ 
    try{ 
      extract($data);
      $sql = "UPDATE ".DB_PREFIX."menus SET menu_parentid = :menu_parentid, menu_position = :menu_position,modified_date = :modified_date,modified_by = :modified_by WHERE menu_id = :menu_id"; 
      
      $stmt = $this->connection->prepare($sql); 
      $stmt->bindParam(":menu_parentid",$menu_parentid);
      $stmt->bindParam(":menu_position",$menu_position); 
      $stmt->bindParam(":modified_date",$modified_date);
      $stmt->bindParam(":modified_by",$modified_by);
      $stmt->bindParam(":menu_id",$menu_id);
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
         'message' =>"No Data Updated"
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

  
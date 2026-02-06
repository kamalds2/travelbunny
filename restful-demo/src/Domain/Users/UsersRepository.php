<?php
  namespace App\Domain\Users;
  use PDO;
  /**
  * Repository. 
  */
  class UsersRepository
  {
    private $connection;
    public function __construct(PDO $connection)
    {
      $this->connection = $connection;
    }
    public function checkLogin($data)  {
      try{
        extract($data); 
        $passwordEn = $this->PassHash($password);   
        // $passwordEn = "AES_ENCRYPT('".$password."','".$PASSKEY."')";
        if(empty($email) || empty($password)) {
          $status = array(
            'status' => ERR_PARTIAL_CONT,
            'message' => "Failure! user name is required"
          );
        }
        else{
          $sql = "CALL `check_login` (:email,:password,@p2,@p3,@p4)"; 
          $stmt = $this->connection->prepare($sql);  
          $stmt->bindParam(":email",$email);
          $stmt->bindParam(":password",$passwordEn);
          $stmt->execute();
          $users = $this->connection->query("SELECT @p2 AS `p_result`, @p3 AS `p_userid`, @p4 AS `p_role_id`;")->fetch(PDO::FETCH_OBJ);
          if($users!=''){
            $status = array('status' => ERR_OK,
                    'message' => "Success",
                    'users' => $users);      
          }
          else{
            $status = array(
              'status' => ERR_NO_DATA,
              'message' => "Failure Please enter correct email & password"
            );    
          }
        }
        return $status;  
      } catch(PDOException $e) {
        $status = array(
                'status' => "500",
                'message' => $e->getMessage()
            );
        return $status;
      }
    }
    function PassHash($password = NULL) {
      if(isset($password)) {
        if($password != NULL) {
          return hash('sha256', $password);
        }else {
          echo "Wrong way to call method";
        }
      }
    }
    public function getUserDetails($data) {
      try {
        extract($data);
        $query = "SELECT user_id, user_email, user_status, role_id,first_name, last_name, getRole(role_id) AS role_name FROM ".DB_PREFIX."users WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam("user_id", $user_id); 
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_OBJ);
        if($results!=''){
          $status = array( 
          'status' => ERR_OK,
          'message' => "Success",
          'user' => $results);
        }else{
           $status = array(
          'status' => ERR_NO_DATA,
          'message' => "Failure");
        }
        return $status;
      } catch(PDOException $e) {        
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
          );
        return $status;       
      }
    }
    public function checkUserEmail($data) {
      try {
        extract($data);
        $sql = "SELECT count(`user_id`) as cnt FROM " . DB_PREFIX . "users where `user_email`=:user_email and `user_id`!=:user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_email',$user_email);
        $stmt->bindParam(':user_id',$edit_user_id);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        $cnt = $count->cnt;
        return $cnt;
      } catch(PDOException $e) {        
        $status = array(
                  'status' => "500",
                  'message' => $e->getMessage() 
                  );
        return $status;       
      }
    }
    public function addUser($data) {
      try {
        extract($data);      
        $sql = "CALL `add_user`(:role_id, :first_name,:user_password, :user_email, :user_status, :user_photo, :created_date, :created_by, @result, :pass_key, :last_name)";
        $stmt = $this->connection->prepare($sql);   
        $passwordEn = $this->PassHash($user_password); 
        $user_photo = '';
        $stmt->bindParam(":role_id", $update->role_id);
        $stmt->bindParam(":first_name", $update->first_name);
        $stmt->bindParam(":user_password", $update->user_password);
        $stmt->bindParam(":user_email", $update->user_email);
        $stmt->bindParam(":user_status", $update->user_status);
        $stmt->bindParam(":user_photo", $user_photo);
        $stmt->bindParam(":created_date", $update->created_date);
        $stmt->bindParam(":created_by", $update->created_by);
        $stmt->bindParam(":pass_key", $update->password_key);
        $stmt->bindParam(":last_name", $update->last_name);
        $e_res=$stmt->execute();
        $res = $db->query("select @result as result")->fetch(PDO::FETCH_ASSOC);
        $user_id = $res['result']; 
          if($user_id){
            $status = array(
              'status' => "200",
              'message' => "User Added Successfully",
              'id' => $user_id);
          }
          else{
            $status = array(
              'status' => "304",
              'message' => "User Not Added Successfully");
          } 
        return $status;
      } catch(PDOException $e) {        
        $status = array(
                  'status' => "500",
                  'message' => $e->getMessage()
                  );
        return $status;       
      }
    }
    public function editUser($data){
  try {
    extract($data);

    $sql = "CALL `edit_user`(:edit_user_id, :role_id, :first_name, :last_name, :user_email, :modified_date, :modified_by, @result)";
    $stmt = $this->connection->prepare($sql);

    $stmt->bindParam(":edit_user_id", $edit_user_id);
    $stmt->bindParam(":role_id", $role_id);
    $stmt->bindParam(":first_name", $first_name);
    $stmt->bindParam(":last_name", $last_name);
    $stmt->bindParam(":user_email", $user_email);
    $stmt->bindParam(":modified_date", $modified_date);
    $stmt->bindParam(":modified_by", $modified_by);

    $stmt->execute();

    $res = $this->connection->query("SELECT @result AS result")->fetch(PDO::FETCH_ASSOC);
    $message = $res['result'];

    $status = array(
      "status" => "200",
      "message" => $message,
      "id" => $edit_user_id
    );
    return $status;

  } catch (PDOException $e) {
    return array(
      'status' => "500",
      'message' => $e->getMessage()
    );
  }
}
    public function checkUserEmail($data)    {     
      try {
        $sql = "SELECT count(`user_id`) as cnt FROM " . DB_PREFIX . "users where `user_email`='$email'and user_id!='$userid'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        $cnt = $count->cnt;
        return $cnt;
      } catch(PDOException $e) {        
        $status = array(
                  'status' => "500",
                  'message' => $e->getMessage()
                  );
        return $status;       
      }
    }
    public function getUser($data) {
      try {
        extract($data);
        $query = "SELECT user_id as user_id, role_id,first_name,last_name,`user_mobile`, gender,user_email, user_status FROM tbl_users WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $adminuserdetails = $stmt->fetch(PDO::FETCH_OBJ);
        if($adminuserdetails!=''){
          $status = array(
          'status' => "200",
          'message' => "Success",
          'user' => $adminuserdetails);
          return $status;
        }else{
         $status = array(
        'status' => "204",
        'message' => "Failure");
        return $status;
        }   
      } catch(PDOException $e) {
          $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
          return $status; 
      }
    }
    public function deleteUser($data) {
      try {
        extract($data);
        $query = "UPDATE  tbl_users SET user_status = '9',modified_date = :modified_date,modified_by=:modified_by WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id',$del_user_id);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        if($stmt->execute()){
          $status = array(
          'status' => "200",
          'message' => "Success user deleted Successfully");
          return $status;
        }else{
          $status = array(
          'status' => "304",
          'message' => "Failure user Not deleted Successfully");
          return $status;
        }
      }
      catch(PDOException $e) {
        $status = array(
                'status' => "500",
                'message' => $e->getMessage()
            );
        return $status; 
      }
    }
    public function updateUserPassword($data) {
      try {
        extract($data);      
        $query = "UPDATE ".DB_PREFIX."users SET `user_password`= :new_pass,modified_by=:modified_by,modified_date=:modified_date where user_id=:user_id";
        $stmt2 = $this->connection->prepare($query);
        $passwordEn = $this->PassHash($user_password);
        $stmt2->bindParam(':new_pass',$passwordEn);
        $stmt2->bindParam(':user_id',$ch_user_id);
        $stmt2->bindParam(':modified_date',$modified_date);
        $stmt2->bindParam(':modified_by',$modified_by);
        $stmt2->execute();
        $status = array(
                    'status' => "200",
                    'message' => "password updated Successfully");
        return $status; 
      }catch(PDOException $e) {
        $status = array(
                'status' => "500",
                'message' => $e->getMessage()
            );
        return $status; 
      }
    }
    public function UpdateUserProfile($data){
      try{
        $query = "UPDATE ".DB_PREFIX."users SET `first_name`=:first_name,last_name=:last_name,modified_by=:modified_by,modified_date=:modified_date";

      }
      catch(PDOException $e) {
        $status = array(
                'status' => "500",
                'message' => $e->getMessage()
            );
        return $status; 
      }
    }
    public function resetUserPassword($data) {
      try {
        extract($data);      
        $query = "UPDATE ".DB_PREFIX."users SET `user_password`= :new_pass,modified_by=:modified_by,modified_date=:modified_date where user_id=:user_id";
        $stmt2 = $this->connection->prepare($query);
        $passwordEn = $this->PassHash($new_password);
        $stmt2->bindParam(':new_pass',$passwordEn);
        $stmt2->bindParam(':user_id',$ch_user_id);
        $stmt2->bindParam(':modified_date',$modified_date);
        $stmt2->bindParam(':modified_by',$ch_user_id);
        $stmt2->execute();
        $status = array(
                    'status' => "200",
                    'message' => "password updated Successfully");
        return $status; 
      }catch(PDOException $e) {
        $status = array(
                'status' => "500",
                'message' => $e->getMessage()
            );
        return $status; 
      }
    }
    public function checkPassword($data) {
      try {
        extract($data);
        $old_passwordEn = $this->PassHash($old_password);
        $sql = "SELECT count(`user_id`) as cnt FROM " . DB_PREFIX . "users where `user_password`=:user_password and `user_id`= :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_password',$old_passwordEn);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        $cnt = $count->cnt;
        return $cnt;
      } catch(PDOException $e) {        
        $status = array(
                  'status' => "500",
                  'message' => $e->getMessage() 
                  );
        return $status;       
      }
    }
  }
?>
<?php
  namespace App\Domain\Mobileapp;
  use PDO;
  use App\Utilities\ImageUpload;
  /**
  * Repository.
  */
  class MobileappRepository {
    /**
     * @var PDO The database connection
     */
    private $connection;
    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
    */
    public function __construct(PDO $connection) {
      $this->connection = $connection;
    }
    /**
     * Get Admin Roles rows.
     *
     * @return array 
    */
    public function getAttendanceData($data): array {
      try { 
        extract($data); 
        $where = "";
        if(isset($site_id) && $site_id != 0){
          $where .= " AND site =".$site_id;
        }
        if(isset($from_date) && $from_date != ''){
          $where .= " AND attn_date >= '".$from_date."' AND attn_date <= '".$to_date."' ";
        }
        $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(":user_id",$user_id);
        $stmt1->execute(); 
        $emp_data = $stmt1->fetch(PDO::FETCH_OBJ);  
        if($emp_data->emp_id == 0){
          $sql = "SELECT attendance_id,get_siteName(site_id) sitename, DATE_FORMAT(attn_date, '%d %b, %Y') AS attn_date,total_present,total_absent,staff_weekoff,total_leave,grmng_badstaff,ot_hours,in_out_time,total_staff,grmng_remarks FROM ".DB_PREFIX."attendance WHERE status != 9 ".$where." order by attendance_id desc"; 
        }else{
          $sql = "SELECT attendance_id,get_siteName(site_id) sitename, DATE_FORMAT(attn_date, '%d %b, %Y') AS attn_date,total_present,total_absent,staff_weekoff,total_leave,grmng_badstaff,ot_hours,in_out_time,total_staff,grmng_remarks FROM ".DB_PREFIX."attendance WHERE site_id IN (select site_id from tbl_sites where unit_mgr = $emp_data->emp_id OR operations_mgr = $emp_data->emp_id)  AND status != 9 ".$where." order by attendance_id desc"; //echo $sql;die();
        } 
        $stmt = $this->connection->prepare($sql);
          $stmt->execute(); 
          $attendanceData = $stmt->fetchAll(PDO::FETCH_OBJ); 
        if(!empty($attendanceData)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'attendanceData' => $attendanceData
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addAttendance($data){
      try {
        extract($data);
        print_r($_FILES);exit;
        $sql = "CALL add_attendance(:attn_date,:attn_time,:attn_daytype,:unit_manager,:site_id,:hkoperator_present,:supervisor_present,:um_present,:fm_present,:afm_present,:exec_present,:ofcboys_present,:gardenstaff_present,:others_present,:total_present,:staff_weekoff,:total_absent,:total_leave,:total_staff,:grmng_remarks,:grmng_badstaff,:ot,:ot_hours,:in_out_time,:area_deployment,:device,:ip_address,:created_date,:created_by,:status,@result)";
         $device = 'Mobile';
         $ImageUpload = new ImageUpload();
         $status = 0;
         $created_date = date('Y-m-d H:i:s');
         if($grmng_badstaff == ''){
          $grmng_badstaff = 0 ;
         } if($ot_hours == ''){
          $ot_hours = 0;
         }
        /* file uploads */
        $gr_attachments = [];
        if (isset($_FILES['g_gr_attachments'])) {
          $filedir = IMGUPLOAD . "attendance/gr_attachments/"; 
          foreach ($_FILES['g_gr_attachments']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
              $randName = rand(10101010, 9090909090);
              $result = 'grattn_';  
              $newName = $result . $randName;
              $ext = pathinfo($fileName, PATHINFO_EXTENSION);
              $file = [
                  'name' => $fileName,
                  'type' => $_FILES['g_gr_attachments']['type'][$key],
                  'tmp_name' => $_FILES['g_gr_attachments']['tmp_name'][$key],
                  'error' => $_FILES['g_gr_attachments']['error'][$key],
                  'size' => $_FILES['g_gr_attachments']['size'][$key],
              ];
              $ImageUpload->File = $file;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '283';
              $ImageUpload->NewHeight = '319';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $gr_attachments[] = $newName.".".$ext; // Collect new image name
            }
          }
          $_POST['gr_attachments'] = $gr_attachments;
        }
        $ot_attachments = [];
        if (isset($_FILES['g_ot_attachments'])) {
          $filedir = IMGUPLOAD . "attendance/ot_attachments/"; 
          foreach ($_FILES['g_ot_attachments']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
              $randName = rand(10101010, 9090909090);
              $result = 'attnot_';  
              $newName = $result . $randName;
              $ext = pathinfo($fileName, PATHINFO_EXTENSION);
              $file = [
                  'name' => $fileName,
                  'type' => $_FILES['g_ot_attachments']['type'][$key],
                  'tmp_name' => $_FILES['g_ot_attachments']['tmp_name'][$key],
                  'error' => $_FILES['g_ot_attachments']['error'][$key],
                  'size' => $_FILES['g_ot_attachments']['size'][$key],
              ];
              $ImageUpload->File = $file;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '283';
              $ImageUpload->NewHeight = '319';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $ot_attachments[] = $newName.".".$ext; // Collect new image name
            }
          }
          $_POST['ot_attachments'] = $ot_attachments;
        }
        $itot_attachments = [];
        if (isset($_FILES['g_itot_attachments'])) {
          $filedir = IMGUPLOAD . "attendance/itot_attachments/"; 
          foreach ($_FILES['g_itot_attachments']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
              $randName = rand(10101010, 9090909090);
              $result = 'attnitot_';  
              $newName = $result . $randName;
              $ext = pathinfo($fileName, PATHINFO_EXTENSION);
              $file = [
                  'name' => $fileName,
                  'type' => $_FILES['g_itot_attachments']['type'][$key],
                  'tmp_name' => $_FILES['g_itot_attachments']['tmp_name'][$key],
                  'error' => $_FILES['g_itot_attachments']['error'][$key],
                  'size' => $_FILES['g_itot_attachments']['size'][$key],
              ];
              $ImageUpload->File = $file;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '283';
              $ImageUpload->NewHeight = '319';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $itot_attachments[] = $newName.".".$ext; // Collect new image name
            }
          }
          $_POST['itot_attachments'] = $itot_attachments;
        }
        $ad_attachments = [];
        if (isset($_FILES['g_ad_attachments'])) {
          $filedir = IMGUPLOAD . "attendance/ad_attachments/"; 
          foreach ($_FILES['g_ad_attachments']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
              $randName = rand(10101010, 9090909090);
              $result = 'areadeploy_';  
              $newName = $result . $randName;
              $ext = pathinfo($fileName, PATHINFO_EXTENSION);
              $file = [
                  'name' => $fileName,
                  'type' => $_FILES['g_ad_attachments']['type'][$key],
                  'tmp_name' => $_FILES['g_ad_attachments']['tmp_name'][$key],
                  'error' => $_FILES['g_ad_attachments']['error'][$key],
                  'size' => $_FILES['g_ad_attachments']['size'][$key],
              ];
              $ImageUpload->File = $file;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '283';
              $ImageUpload->NewHeight = '319';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $ad_attachments[] = $newName.".".$ext; // Collect new image name
            }
          }
          $_POST['ad_attachments'] = $ad_attachments;
        }
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':attn_date', $attn_date);
        $stmt->bindParam(':attn_time', $attn_time);
        $stmt->bindParam(':attn_daytype', $attn_daytype);
        $stmt->bindParam(':unit_manager', $unit_manager);
        $stmt->bindParam(':site_id', $site_id);
        $stmt->bindParam(':hkoperator_present', $hkoperator_present);
        $stmt->bindParam(':supervisor_present', $supervisor_present);
        $stmt->bindParam(':um_present', $um_present);
        $stmt->bindParam(':fm_present', $fm_present);
        $stmt->bindParam(':afm_present', $afm_present);
        $stmt->bindParam(':exec_present', $exec_present);
        $stmt->bindParam(':ofcboys_present', $ofcboys_present); 
        $stmt->bindParam(':gardenstaff_present', $gardenstaff_present);
        $stmt->bindParam(':others_present', $others_present);
        $stmt->bindParam(':total_present', $total_present);
        $stmt->bindParam(':staff_weekoff', $staff_weekoff);
        $stmt->bindParam(':total_absent', $total_absent);
        $stmt->bindParam(':total_leave', $total_leave);
        $stmt->bindParam(':total_staff', $total_staff);
        $stmt->bindParam(':grmng_remarks', $grmng_remarks);
        $stmt->bindParam(':grmng_badstaff', $grmng_badstaff);
        $stmt->bindParam(':ot', $ot);
        $stmt->bindParam(':ot_hours', $ot_hours);
        $stmt->bindParam(':in_out_time', $in_out_time);
        $stmt->bindParam(':area_deployment', $area_deployment);
        $stmt->bindParam(':device', $device);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $res = $this->connection->query("select @result as result")->fetch(PDO::FETCH_ASSOC); 
        if($res['result'] > 0){
          $attn_id = $res['result'];
          if (isset($gr_attachments) && is_array($gr_attachments)) {
            foreach ($gr_attachments as $gr_attachment) {
              $sql2 = "INSERT INTO ".DB_PREFIX."attngroomattachments(file_name,attn_id,status,created_date,created_by) values(:file_name,:attn_id,:status,:created_date,:created_by)";
              $stmt2 = $this->connection->prepare($sql2);
              $stmt2->bindParam(':file_name',$gr_attachment);
              $stmt2->bindParam(':attn_id',$attn_id);
              $stmt2->bindParam(':created_date', $created_date);
              $stmt2->bindParam(':created_by', $created_by);
              $stmt2->bindParam(':status', $status);
              $stmt2->execute();
            }
          }
          if (isset($ot_attachments) && is_array($ot_attachments)) {
            foreach ($ot_attachments as $ot_attachment) {
              $sql3 = "INSERT INTO ".DB_PREFIX."attnotattachments(attachment_name,attn_id,status,created_date,created_by) values(:ot_attachment,:attn_id,:status,:created_date,:created_by)";
              $stmt3 = $this->connection->prepare($sql3);
              $stmt3->bindParam(':ot_attachment',$ot_attachment);
              $stmt3->bindParam(':attn_id',$attn_id);
              $stmt3->bindParam(':created_date', $created_date);
              $stmt3->bindParam(':created_by', $created_by);
              $stmt3->bindParam(':status', $status);
              $stmt3->execute();
            }
          }
          if (isset($itot_attachments) && is_array($itot_attachments)) {
            foreach ($itot_attachments as $itot_attachment) {
              $sql4 = "INSERT INTO ".DB_PREFIX."attnintimeotattachments(attachment_name,attn_id,status,created_date,created_by) values(:itot_attachment,:attn_id,:status,:created_date,:created_by)";
              $stmt4 = $this->connection->prepare($sql4);
              $stmt4->bindParam(':itot_attachment',$itot_attachment);
              $stmt4->bindParam(':attn_id',$attn_id);
              $stmt4->bindParam(':created_date', $created_date);
              $stmt4->bindParam(':created_by', $created_by);
              $stmt4->bindParam(':status', $status);
              $stmt4->execute();
            }
          }
          if (isset($ad_attachments) && is_array($ad_attachments)) {
            foreach ($ad_attachments as $ad_attachment) {
              $sql5 = "INSERT INTO ".DB_PREFIX."attnareadeplattachments(attachment_name,attn_id,status,created_date,created_by) values(:itot_attachment,:attn_id,:status,:created_date,:created_by)";
              $stmt5 = $this->connection->prepare($sql5);
              $stmt5->bindParam(':itot_attachment',$ad_attachment);
              $stmt5->bindParam(':attn_id',$attn_id);
              $stmt5->bindParam(':created_date', $created_date);
              $stmt5->bindParam(':created_by', $created_by);
              $stmt5->bindParam(':status', $status);
              $stmt5->execute();
            }
          }
          $status = array(
           'status' =>"200",
           'message' =>"Attendance Added Successfully",
           'atten_id' => $res['result']); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Added"
          );
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
    public function getAttendanceDetails($data): array {
      try {
        extract($data);
        $sql = "SELECT a.*, DATE_FORMAT(a.attn_date, '%d %b, %Y') AS formatted_attn_date 
              FROM " . DB_PREFIX . "attendance a 
              WHERE a.attendance_id = :attendance_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':attendance_id', $attendance_id, PDO::PARAM_INT);
        $stmt->execute();
        $attendancedetails = $stmt->fetch(PDO::FETCH_OBJ);
       $attachmentQueries = [
    'groom_attachments' => "SELECT attngrmatachm_id, CONCAT('" . IMGURL . "/attendance/gr_attachments/', file_name) AS file_name
                            FROM " . DB_PREFIX . "attngroomattachments 
                            WHERE status = '0' AND attn_id = :attn_id",
    'ot_attachments' => "SELECT attnotattachment_id, CONCAT('" . IMGURL . "/attendance/ot_attachments/', attachment_name) AS attachment_name
                         FROM " . DB_PREFIX . "attnotattachments 
                         WHERE status = '0' AND attn_id = :attn_id",
    'itot_attachments' => "SELECT attnitotatach_id, CONCAT('" . IMGURL . "/attendance/itot_attachments/', attachment_name) AS attachment_name
                           FROM " . DB_PREFIX . "attnintimeotattachments 
                           WHERE status = '0' AND attn_id = :attn_id",
    'ad_attachments' => "SELECT attnareadeplattach_id, CONCAT('" . IMGURL . "/attendance/ad_attachments/', attachment_name) AS attachment_name
                         FROM " . DB_PREFIX . "attnareadeplattachments 
                         WHERE status = '0' AND attn_id = :attn_id"
];
        $attachments = [];
        foreach ($attachmentQueries as $key => $query) {
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':attn_id', $attendance_id, PDO::PARAM_INT);
            $stmt->execute();
            $attachments[$key] = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        $attendancedetails->attachments = $attachments;
        if(!empty($attendancedetails)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'attn' => $attendancedetails
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function updateAttendance($data){
      try {
        extract($data);
        $sql = "CALL update_attendance(:attn_id,:attn_date,:attn_time,:attn_daytype,:unit_manager,:site_id,:hkoperator_present,:supervisor_present,:um_present,:fm_present,:afm_present,:exec_present,:ofcboys_present,:gardenstaff_present,:others_present,:total_present,:staff_weekoff,:total_absent,:total_leave,:total_staff,:grmng_remarks,:grmng_badstaff,:ot,:ot_hours,:in_out_time,:area_deployment,:modified_date,:modified_by,@result,@result_flag)";
        if($grmng_badstaff == ''){
          $grmng_badstaff = 0 ;
        } 
        if($ot_hours == ''){
          $ot_hours = 0;
        }
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':attn_id', $attendance_id);
        $stmt->bindParam(':attn_date', $attn_date);
        $stmt->bindParam(':attn_time', $attn_time);
        $stmt->bindParam(':attn_daytype', $attn_daytype);
        $stmt->bindParam(':unit_manager', $unit_manager);
        $stmt->bindParam(':site_id', $site_id);
        $stmt->bindParam(':hkoperator_present', $hkoperator_present);
        $stmt->bindParam(':supervisor_present', $supervisor_present);
        $stmt->bindParam(':um_present', $um_present);
        $stmt->bindParam(':fm_present', $fm_present);
        $stmt->bindParam(':afm_present', $afm_present);
        $stmt->bindParam(':exec_present', $exec_present);
        $stmt->bindParam(':ofcboys_present', $ofcboys_present); 
        $stmt->bindParam(':gardenstaff_present', $gardenstaff_present);
        $stmt->bindParam(':others_present', $others_present);
        $stmt->bindParam(':total_present', $total_present);
        $stmt->bindParam(':staff_weekoff', $staff_weekoff);
        $stmt->bindParam(':total_absent', $total_absent);
        $stmt->bindParam(':total_leave', $total_leave);
        $stmt->bindParam(':total_staff', $total_staff);
        $stmt->bindParam(':grmng_remarks', $grmng_remarks);
        $stmt->bindParam(':grmng_badstaff', $grmng_badstaff);
        $stmt->bindParam(':ot', $ot);
        $stmt->bindParam(':ot_hours', $ot_hours);
        $stmt->bindParam(':in_out_time', $in_out_time);
        $stmt->bindParam(':area_deployment', $area_deployment); 
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->execute();
        $res = $this->connection->query("select @result as result,@result_flag as result_flag")->fetch(PDO::FETCH_ASSOC);  
        if($res['result_flag'] == 1){
          $status = 0;
          if (isset($gr_attachments) && is_array($gr_attachments)) {
            foreach ($gr_attachments as $gr_attachment) {
              $sql2 = "INSERT INTO ".DB_PREFIX."attngroomattachments(file_name,attn_id,status,created_date,created_by) values(:file_name,:attn_id,:status,:created_date,:created_by)";
              $stmt2 = $this->connection->prepare($sql2);
              $stmt2->bindParam(':file_name',$gr_attachment);
              $stmt2->bindParam(':attn_id',$attendance_id);
              $stmt2->bindParam(':created_date', $created_date);
              $stmt2->bindParam(':created_by', $created_by);
              $stmt2->bindParam(':status', $status);
              $stmt2->execute();
            }
          }
          if (isset($ot_attachments) && is_array($ot_attachments)) {
            foreach ($ot_attachments as $ot_attachment) {
              $sql3 = "INSERT INTO ".DB_PREFIX."attnotattachments(attachment_name,attn_id,status,created_date,created_by) values(:ot_attachment,:attn_id,:status,:created_date,:created_by)";
              $stmt3 = $this->connection->prepare($sql3);
              $stmt3->bindParam(':ot_attachment',$ot_attachment);
              $stmt3->bindParam(':attn_id',$attendance_id);
              $stmt3->bindParam(':created_date', $created_date);
              $stmt3->bindParam(':created_by', $created_by);
              $stmt3->bindParam(':status', $status);
              $stmt3->execute();
            }
          }
          if (isset($itot_attachments) && is_array($itot_attachments)) {
            foreach ($itot_attachments as $itot_attachment) {
              $sql4 = "INSERT INTO ".DB_PREFIX."attnintimeotattachments(attachment_name,attn_id,status,created_date,created_by) values(:itot_attachment,:attn_id,:status,:created_date,:created_by)";
              $stmt4 = $this->connection->prepare($sql4);
              $stmt4->bindParam(':itot_attachment',$itot_attachment);
              $stmt4->bindParam(':attn_id',$attendance_id);
              $stmt4->bindParam(':created_date', $created_date);
              $stmt4->bindParam(':created_by', $created_by);
              $stmt4->bindParam(':status', $status);
              $stmt4->execute();
            }
          }
          if (isset($ad_attachments) && is_array($ad_attachments)) {
            foreach ($ad_attachments as $ad_attachment) {
              $sql5 = "INSERT INTO ".DB_PREFIX."attnareadeplattachments(attachment_name,attn_id,status,created_date,created_by) values(:itot_attachment,:attn_id,:status,:created_date,:created_by)";
              $stmt5 = $this->connection->prepare($sql5);
              $stmt5->bindParam(':itot_attachment',$ad_attachment);
              $stmt5->bindParam(':attn_id',$attendance_id);
              $stmt5->bindParam(':created_date', $created_date);
              $stmt5->bindParam(':created_by', $created_by);
              $stmt5->bindParam(':status', $status);
              $stmt5->execute();
            }
          }
          $status = array(
           'status' =>"200",
           'message' =>"Attendance Updated Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Updated"
          );
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
    public function deleteAttendance($data){
      try {
        extract($data);
        $sql = "UPDATE ".DB_PREFIX."attendance SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where attendance_id = :attendance_id";
        $modified_date = date('Y-m-d H:i:s');   
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':attendance_id', $attendance_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Attendance Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Attendance Deleted"
          );
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
    public function checkAttnSiteDate($data){
      try {
        extract($data); 
        $where = '';
        if(isset($attendance_id)) {
          $where = " AND attendance_id != '".$attendance_id."'";
        }
        $sql = "SELECT count(*) AS attn_count FROM ".DB_PREFIX."attendance WHERE site_id = :site AND attn_date = :attn_date AND status = 0 ". $where;      
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':attn_date', $attn_date); 
        $stmt->execute(); 
        $res =  $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
           'status' =>"200",
           'message' =>"Attn Count",
           'count' => $res->attn_count ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
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
    /* BMS */
    public function getBmsList($data): array {
      try {
        extract($data);
        $where = "";
        if(isset($site_id) && $site_id != 0){
          $where .= " AND site =".$site_id;
        }
        if(isset($from_date) && $from_date != ''  || isset($to_date) && $to_date != '' ){
          $where .= " AND bms_date >= '".$from_date."' AND bms_date <= '".$to_date."' ";
        }
        $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(":user_id",$user_id);
        $stmt1->execute(); 
        $emp_data = $stmt1->fetch(PDO::FETCH_OBJ); 
        if($emp_data->emp_id == '0'){
          $sql = "SELECT b.bms_id,b.bms_date,b.time,b.unit_mgr,get_siteName(b.site) AS siteName,b.bms_done,b.total_services,b.status,get_PendingBMSCount(b.bms_id) AS pending_bms  FROM ".DB_PREFIX."bms b WHERE status != 9 ".$where;
          $stmt = $this->connection->prepare($sql);
          $stmt->execute();
          $bms = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        else{
          $sql = "SELECT b.bms_id,b.bms_date,b.time,b.unit_mgr,get_siteName(b.site) AS siteName,b.bms_done,b.total_services,b.status  FROM ".DB_PREFIX."bms b WHERE status != 9 ".$where." AND b.site IN (select site_id from tbl_sites where unit_mgr = :unit_mgr or operations_mgr = :unit_mgr)";  
          $stmt = $this->connection->prepare($sql);
          $stmt->bindParam(':unit_mgr', $emp_data->emp_id);
          $stmt->execute();
          $bms = $stmt->fetchAll(PDO::FETCH_OBJ);
        } 
        if(!empty($bms)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'bms' => $bms
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getPendingBms($data): array {
      try {
        extract($data);
        $sql = "SELECT bmsdservice_id,bms_id,date_format(report_date,'%d %b,%Y') report_date,snag_status,get_BMSNatureofComplaint(work) AS nature_of_complaint,concat(get_FloorName(floor),' | ',get_SubareaName(sub_area)) AS floor FROM ".DB_PREFIX."bmsdailyservice WHERE snag_status = 'Open' AND status = 0 AND bms_id = :bms_id "; 
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":bms_id",$bms_id);
        $stmt->execute();
        $bms = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($bms)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'bms' => $bms
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function updatePendingBms($data){
      try{
        extract($data);
        for ($i=0; $i < count($bmsdservice_id) ; $i++) { 
          $closed_date[$i] = date('Y-m-d', strtotime($closed_date[$i])); 
          $sql = "UPDATE ".DB_PREFIX."bmsdailyservice SET snag_status = :snag_status,closed_date=:closed_date WHERE bmsdservice_id = :bmsdservice_id";
          $stmt = $this->connection->prepare($sql);
          $stmt->bindParam(':snag_status', $snag_status[$i]);
          $stmt->bindParam(':closed_date', $closed_date[$i]);
          $stmt->bindParam(':bmsdservice_id', $bmsdservice_id[$i]);
          $res = $stmt->execute();
        }
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"BMS Updated Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No BMS Updated"
          );
         }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getBmsDetails($data): array {
      try {
        extract($data);
        $bms = array();
        $sql = "SELECT b.bms_id, b.bms_date, b.time, b.unit_mgr, b.site, get_siteName(b.site) AS siteName, get_empName(b.unit_mgr) unitManagerName,get_siteBuildingCode(b.site) AS building_code, b.bms_done, b.total_services, b.status, case b.status when 0 then 'Active' else 'In Active' end as statusName, b.device FROM tbl_bms b   WHERE b.bms_id = :bms_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':bms_id', $bms_id);
        $stmt->execute();
        $bms['data'] = $stmt->fetch(PDO::FETCH_OBJ);
        $sql1 = "SELECT bmsdservice_id,bms_id,floor,get_FloorName(floor) floor_name,sub_area,get_SubareaName(sub_area) subAreaname,get_BMSNatureofComplaint(work) natureofcomplaint,work,comments,report_date,snag_status,case snag_status when 1 then 'Open' when 2 then 'Pending' end as snagStatusname,closed_date,status,device,created_date,created_by,modified_date FROM tbl_bmsdailyservice where bms_id = :bms_id and status = 0";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(':bms_id', $bms_id);
        $stmt1->execute();
        $bms['services'] = $stmt1->fetchAll(PDO::FETCH_OBJ);
        if(!empty($bms)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'bms' => $bms
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addBms($data) {
      try { 
          extract($data);
          $created_date = date('Y-m-d H:i:s');
          $time =date('H:i:s');  
          $status = 0;
          $device = 'Mobile';
          $total_service = ($bms_done == 1) ? 0 : count($services);
          $sql = "INSERT INTO tbl_bms 
                  (bms_date, time, unit_mgr, site, bms_done, device, total_services, status, created_date, created_by) 
                  VALUES (:bms_date, :time, :unit_mgr, :site, :bms_done, :device, :total_services, :status, :created_date, :created_by)";
          $stmt = $this->connection->prepare($sql);
          $stmt->bindParam(':bms_date', $bms_date);
          $stmt->bindParam(':time', $time);
          $stmt->bindParam(':unit_mgr', $unit_mgr);
          $stmt->bindParam(':site', $site);
          $stmt->bindParam(':bms_done', $bms_done);
          $stmt->bindParam(':device', $device);
          $stmt->bindParam(':total_services', $total_service);
          $stmt->bindParam(':status', $status);
          $stmt->bindParam(':created_date', $created_date);
          $stmt->bindParam(':created_by', $created_by);
          $stmt->execute();
          $bms_id = $this->connection->lastInsertId();
          if ($bms_id > 0) {
              if ($bms_done == 0 && !empty($services)) {
                  foreach ($services as $service) {
                      $report_date = !empty($service->report_date) ? date('Y-m-d', strtotime($service->report_date)) : NULL;
                      $closed_date = !empty($service->closed_date) ? date('Y-m-d', strtotime($service->closed_date)) : NULL;
                      $sql1 = "INSERT INTO tbl_bmsdailyservice 
                              (bms_id, floor, sub_area, work, comments, report_date, snag_status, closed_date, status, device, created_date, created_by) 
                              VALUES (:bms_id, :floor, :sub_area, :work, :comments, :report_date, :snag_status, :closed_date, :status, :device, :created_date, :created_by)";
                      $stmt1 = $this->connection->prepare($sql1);
                      $stmt1->bindParam(':bms_id', $bms_id);
                      $stmt1->bindParam(':floor', $service->floor);
                      $stmt1->bindParam(':sub_area', $service->sub_area);
                      $stmt1->bindParam(':work', $service->work);
                      $stmt1->bindParam(':comments', $service->comments);
                      $stmt1->bindParam(':report_date', $report_date);
                      $stmt1->bindParam(':snag_status', $service->status);
                      $stmt1->bindParam(':closed_date', $closed_date);
                      $stmt1->bindParam(':device', $device);
                      $stmt1->bindParam(':status', $status);
                      $stmt1->bindParam(':created_date', $created_date);
                      $stmt1->bindParam(':created_by', $created_by);
                      $stmt1->execute();
                  }
              }
              $response = [
                  'status' => "200",
                  'message' => "Bms Added Successfully",
                  'bms_id' => $bms_id
              ];
          } else {
              $response = [
                  'status' => "204",
                  'message' => "No Data Added"
              ];
          }
          return $response;
      } catch (PDOException $e) {
          return [
              'status' => "500",
              'message' => $e->getMessage()
          ];
      }
    }
    public function updateBms($data) {
      try {
        extract($data);    
        $sql = "UPDATE tbl_bms SET bms_date = :bms_date,  `time` = :time, unit_mgr = :unit_mgr, 
              site = :site, bms_done = :bms_done, device = :device, total_services = :total_services, status = :status, modified_date = :modified_date, modified_by = :modified_by WHERE bms_id = :bms_id";
        $device = 'Mobile';
        $total_cleaning_work = ($bms_done == 1) ? 0 : count($services); // Adjusted to reflect the new data structure
        $modified_date = date('Y-m-d H:i:s');
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':bms_id', $bms_id);
        $stmt->bindParam(':bms_date', $bms_date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':bms_done', $bms_done);
        $stmt->bindParam(':total_services', $total_service);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':device', $device);
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $res = $stmt->execute();
        if ($res) {
          if ($bms_done == 0) {  
            foreach ($services as $service) {
              $bmsdservice_id = $service->bmsdservice_id; 
              $floor = $service->floor;
              $sub_area = $service->sub_area;
              $work = $service->work;
              $comments = $service->comments;
              $snag_status = $service->snag_status;
              $report_date = !empty($service->report_date) ? date('Y-m-d', strtotime($service->report_date)) : null;
              $closed_date = !empty($service->closed_date) ? date('Y-m-d', strtotime($service->closed_date)) : null;
              $status = $status; // Ensure status is passed correctly
              $modified_date = $modified_date;
              $modified_by = $modified_by;
              // Check if bmsdservice_id exists for updating
              if (isset($bmsdservice_id) && $bmsdservice_id != "-1") {
                $sql1 = "UPDATE tbl_bmsdailyservice SET floor = :floor, sub_area = :sub_area, work = :work, comments = :comments, report_date = :report_date, snag_status = :snag_status, closed_date = :closed_date, status = :status, device = :device, modified_date = :modified_date, modified_by = :modified_by WHERE bmsdservice_id = :bmsdservice_id";
                $stmt1 = $this->connection->prepare($sql1);
                $stmt1->bindParam(':floor', $floor); 
                $stmt1->bindParam(':sub_area', $sub_area); 
                $stmt1->bindParam(':work', $work); 
                $stmt1->bindParam(':comments', $comments);  
                $stmt1->bindParam(':report_date', $report_date);
                $stmt1->bindParam(':snag_status', $snag_status);
                $stmt1->bindParam(':closed_date', $closed_date);
                $stmt1->bindParam(':status', $status);
                $stmt1->bindParam(':device', $device);
                $stmt1->bindParam(':bmsdservice_id', $bmsdservice_id);  
                $stmt1->bindParam(':modified_date', $modified_date);
                $stmt1->bindParam(':modified_by', $modified_by);
                $stmt1->execute();
              } else {
                // If no bmsdservice_id, insert a new entry 
                $sql1 = "INSERT INTO tbl_bmsdailyservice (bms_id, floor, sub_area, work, comments, report_date, snag_status, closed_date, status, device, created_date, created_by) VALUES (:bms_id, :floor, :sub_area, :work, :comments, :report_date, :snag_status, :closed_date, :status, :device, :created_date, :created_by)";
                $stmt1 = $this->connection->prepare($sql1);
                $stmt1->bindParam(':bms_id', $bms_id);
                $stmt1->bindParam(':floor', $floor);
                $stmt1->bindParam(':sub_area', $sub_area);
                $stmt1->bindParam(':work', $work);
                $stmt1->bindParam(':comments', $comments);
                $stmt1->bindParam(':report_date', $report_date);
                $stmt1->bindParam(':snag_status', $snag_status);
                $stmt1->bindParam(':closed_date', $closed_date);
                $stmt1->bindParam(':status', $status);
                $stmt1->bindParam(':device', $device);
                $stmt1->bindParam(':created_date', $modified_date);
                $stmt1->bindParam(':created_by', $modified_by);
                $stmt1->execute(); 
              }
            }
          }
          $status = array(
            'status' => "200",
            'message' => "BMS Updated Successfully"
          );
        } else {
          $status = array(
          'status' => "204",
          'message' => "No Data Updated"
          );
        }
        return $status;
      } catch (PDOException $e) {
          return ['status' => "500", 'message' => $e->getMessage()];
      }
    }
    public function deleteBms($data){
      try {
        extract($data);
        $sql = "UPDATE ".DB_PREFIX."bms SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where bms_id = :bms_id";
        $modified_date = date('Y-m-d H:i:s');          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':bms_id', $bms_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Bms Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Bms Deleted"
          );
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
    public function checkBmsSiteDate($data){
      try {
        extract($data); 
        $where = '';
        if(isset($bms_id)) {
          $where = " AND bms_id != ".$bms_id;  
        }
        $sql = "SELECT count(*) AS bms_count FROM ".DB_PREFIX."bms WHERE site = :site AND bms_date = :bms_date AND status = 0 ". $where;           
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':bms_date', $bms_date); 
        $stmt->execute(); 
        $res =  $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
           'status' =>"200",
           'message' =>"Bms Count",
           'count' => $res->bms_count ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Bms Deleted"
          );
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
    public function deleteBmsService($data){
      try {
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."bmsdailyservice SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where bmsdservice_id = :bmsdservice_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':bmsdservice_id', $bmsdservice_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Bms Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Bms Deleted"
          );
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
    /* ECW */
    public function getEcwList($data): array {
      try {
        extract($data);
         $where = "";
        if(isset($site_id) && $site_id != 0){
          $where .= " AND site =".$site_id;
        }
        if(isset($from_date) && $from_date != '' || isset($to_date) && $to_date != '' ){
          $where .= " AND ecwdate >= '".$from_date."' AND ecwdate <= '".$to_date."' ";
        }
        $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(":user_id",$user_id);
        $stmt1->execute(); 
        $emp_data = $stmt1->fetch(PDO::FETCH_OBJ); 
        if($emp_data->emp_id == '0'){
          $sql = "SELECT ecw_id,date_format(ecwdate,'%d %b,%Y') ecwdate,ecwtime,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,ecwdone,total_cleaning_works,`status`  FROM ".DB_PREFIX."extracleaningworks WHERE `status` != 9 ".$where." order by ecw_id desc";
          $stmt = $this->connection->prepare($sql);
          $stmt->execute();
          $ecw = $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
          $sql = "SELECT ecw_id,date_format(ecwdate,'%d %b,%Y') ecwdate,ecwtime,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,ecwdone,total_cleaning_works,`status`  FROM ".DB_PREFIX."extracleaningworks WHERE `status` != 9 and site IN (select site_id from tbl_sites where unit_mgr = :unit_mgr or operations_mgr = :unit_mgr)".$where." order by ecw_id desc"; 
          $stmt = $this->connection->prepare($sql);
          $stmt->bindParam(':unit_mgr', $emp_data->emp_id);
          $stmt->execute();
          $ecw = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if(!empty($ecw)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'ecw' => $ecw
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getEcwDetails($data): array {
      try {
        extract($data);
        $sql = "SELECT e.ecw_id,e.ecwdate,e.ecwtime,e.unit_mgr,get_empName(e.unit_mgr) unitManagerName,e.site,get_siteName(e.site) AS siteName,get_siteBuildingCode(e.site) AS building_code,
              e.ecwdone,e.total_cleaning_works,e.status,es.ecwds_id,es.floor,get_FloorName(es.floor) floor_name,es.sub_area,get_SubareaName(es.sub_area) subAreaname,es.work,get_ECWNatureWork(work) natureofwork,es.comments FROM 
            ".DB_PREFIX."extracleaningworks e LEFT JOIN tbl_ecwdailyservice es ON e.ecw_id = es.ecw_id WHERE e.ecw_id = :ecw_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ecw_id', $ecw_id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array
        $ecw = null;
        $ecwdailyservices = [];
        foreach ($data as $row) {
          if ($ecw === null) {
              $ecw = (object) [
                  'ecw_id' => $row['ecw_id'],
                  'ecwdate' => $row['ecwdate'],
                  'ecwtime' => $row['ecwtime'],
                  'unit_mgr' => $row['unit_mgr'],
                  'unit_mgrName' => $row['unitManagerName'],
                  'site' => $row['site'],
                  'siteName' => $row['siteName'],
                  'building_code' => $row['building_code'],
                  'ecwdone' => $row['ecwdone'],
                  'total_cleaning_works' => $row['total_cleaning_works'],
                  'status' => $row['status'],
                  'ecwdailyservices' => [] // Initialize the nested list
              ];
          }
          // Add daily service details if they exist
          if (!empty($row['ecwds_id'])) {
              $ecwdailyservices[] = (object) [
                  'ecwds_id' => $row['ecwds_id'],
                  'floor' => $row['floor'],
                  'floor_name' => $row['floor_name'],
                  'sub_area' => $row['sub_area'],
                  'subAreaname' => $row['subAreaname'],
                  'work' => $row['work'],
                  'natureofwork' => $row['natureofwork'],
                  'comments' => $row['comments']
              ];
          }
        }
        if ($ecw !== null) {
          $ecw->ecwdailyservices = $ecwdailyservices;
        }
        if(!empty($ecw)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'ecw' => $ecw
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addEcw($data){
      try {
        extract($data);
        $created_date = date('Y-m-d H:i:s');
        $status = 0;
        $device = 'Mobile'; 
        $total_cleaning_work = ($ecwdone == 1) ? 0 : count($ecwdailyservices);
        $sql = "INSERT INTO tbl_extracleaningworks 
            (ecwdate, ecwtime, unit_mgr, site, ecwdone, device, total_cleaning_works, status, created_date, created_by) 
            VALUES (:ecwdate, :ecwtime, :unit_mgr, :site, :ecwdone, :device, :total_cleaning_works, :status, :created_date, :created_by)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ecwdate', $ecwdate);
        $stmt->bindParam(':ecwtime', $ecwtime); // Ensure this value exists in the payload or allow NULL
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':ecwdone', $ecwdone);
        $stmt->bindParam(':device', $device);
        $stmt->bindParam(':total_cleaning_works', $total_cleaning_work);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->execute();
        $ecw_id = $this->connection->lastInsertId();
        if ($ecw_id > 0) {
          if ($ecwdone == 0 && !empty($ecwdailyservices)) {
            foreach ($ecwdailyservices as $service) {
              $floor = $service->floor;
              $sub_area = $service->sub_area; // Assuming 'floor_name' corresponds to sub_area
              $work = $service->work;
              $comments = $service->comments;
              $sql1 = "INSERT INTO tbl_ecwdailyservice 
                      (ecw_id, floor, sub_area, work, comments, status, created_date, created_by) 
                      VALUES (:ecw_id, :floor, :sub_area, :work, :comments, :status, :created_date, :created_by)";
              $stmt1 = $this->connection->prepare($sql1);
              $stmt1->bindParam(':ecw_id', $ecw_id);
              $stmt1->bindParam(':floor', $floor);
              $stmt1->bindParam(':sub_area', $sub_area);
              $stmt1->bindParam(':work', $work);
              $stmt1->bindParam(':comments', $comments);
              $stmt1->bindParam(':status', $status);
              $stmt1->bindParam(':created_date', $created_date);
              $stmt1->bindParam(':created_by', $created_by);
              $stmt1->execute();
            }
          }
          $response = [
              'status' => "200",
              'message' => "Schedule Activities Added Successfully",
              'ecw_id' => $ecw_id
          ];
        } else {
          $response = [
              'status' => "204",
              'message' => "No Data Added"
          ];
        }
        return $response;
      } 
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }   
    public function updateEcw($data){
      try {
        extract($data);    
        $sql = "UPDATE tbl_extracleaningworks SET ecwdate = :ecwdate, ecwtime = :ecwtime, unit_mgr = :unit_mgr, site = :site,  ecwdone = :ecwdone, device = :device,total_cleaning_works = :total_cleaning_works, status = :status,modified_date = :modified_date, modified_by = :modified_by WHERE ecw_id = :ecw_id";
        $device = 'Mobile';
        $total_cleaning_work = ($ecwdone == 1) ? 0 : count($ecwdailyservices); // Adjusted to reflect the new data structure
        $modified_date = date('Y-m-d H:i:s');
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':ecw_id', $ecw_id);
        $stmt->bindParam(':ecwdate', $ecwdate);
        $stmt->bindParam(':ecwtime', $ecwtime);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':ecwdone', $ecwdone);
        $stmt->bindParam(':total_cleaning_works', $total_cleaning_work); 
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':device', $device);
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $res = $stmt->execute();
        if ($res) {
          if ($ecwdone == 0) {  
            foreach ($ecwdailyservices as $service) {
              $ecwds_id = $service->ecwds_id; 
              $floor = $service->floor;
              $sub_area = $service->sub_area;
              $work = $service->work;
              $comments = $service->comments;
              $status = $status; // Ensure status is passed correctly
              $modified_date = $modified_date;
              $modified_by = $modified_by;
              // Check if ecwds_id exists for updating
              if (isset($ecwds_id) && $ecwds_id != "-1") {
                $sql1 = "UPDATE tbl_ecwdailyservice SET floor = :floor,sub_area = :sub_area,work = :work,comments = :comments,
                                 status = :status,modified_date = :modified_date,modified_by = :modified_by WHERE ecwds_id = :ecwds_id";
                $stmt1 = $this->connection->prepare($sql1);
                $stmt1->bindParam(':floor', $floor); 
                $stmt1->bindParam(':sub_area', $sub_area); 
                $stmt1->bindParam(':work', $work); 
                $stmt1->bindParam(':comments', $comments);  
                $stmt1->bindParam(':ecwds_id', $ecwds_id);  
                $stmt1->bindParam(':status', $status); 
                $stmt1->bindParam(':modified_date', $modified_date);
                $stmt1->bindParam(':modified_by', $modified_by);
                $stmt1->execute();
              } else {
                // If no ecwds_id, insert a new entry
                $sql1 = "INSERT INTO tbl_ecwdailyservice 
                         (ecw_id, floor, sub_area, work, comments, status, created_date, created_by)
                         VALUES (:ecw_id, :floor, :sub_area, :work, :comments, :status, :created_date, :created_by)";
                $stmt1 = $this->connection->prepare($sql1);
                $stmt1->bindParam(':ecw_id', $ecw_id);
                $stmt1->bindParam(':floor', $floor);
                $stmt1->bindParam(':sub_area', $sub_area);
                $stmt1->bindParam(':work', $work);
                $stmt1->bindParam(':comments', $comments);
                $stmt1->bindParam(':status', $status);
                $stmt1->bindParam(':created_date', $modified_date);
                $stmt1->bindParam(':created_by', $modified_by);
                $stmt1->execute(); 
              }
            }
          }
          $status = array(
            'status' => "200",
            'message' => "Schedule Activities Updated Successfully"
          );
        } else {
          $status = array(
          'status' => "204",
          'message' => "No Data Updated"
          );
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
    public function deleteEcw($data){
      try {
        extract($data);
        $modified_date  = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."extracleaningworks SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where ecw_id = :ecw_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':ecw_id', $ecw_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Schedule Activities Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Schedule Activities Deleted"
          );
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
    public function checkEcwSiteDate($data){
      try {
        extract($data);
        $where = '';
        if(isset($ecw_id)) {
          $where = " AND ecw_id != ".$ecw_id;
        } 
        $sql = "SELECT count(*) AS ecw_count FROM ".DB_PREFIX."extracleaningworks WHERE site = :site AND ecwdate = :ecwdate AND status  = 0 ". $where;       
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':ecwdate', $ecwdate); 
        $stmt->execute(); 
        $res =  $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
           'status' =>"200",
           'message' =>"Ecw Count",
           'count' => $res->ecw_count ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data"
          );
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
    public function deleteEcwService($data){
      try {
        extract($data);
        $modified_date  = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."ecwdailyservice SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where ecwds_id = :ecwds_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':ecwds_id', $ecwds_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>" Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
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
    /* NRW */
    public function getNrwList($data): array {
      try {
        extract($data);
        $where = "";
        if(isset($site_id) && $site_id != 0){
          $where .= " AND site = ".$site_id;
        }
        if(isset($from_date) && $from_date != '' || isset($to_date) && $to_date != '' ){
          $where .= " AND nrwdate >= '".$from_date."' AND nrwdate <= '".$to_date."' ";
        }
        $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(":user_id",$user_id);
        $stmt1->execute(); 
        $emp_data = $stmt1->fetch(PDO::FETCH_OBJ); 
        if($emp_data->emp_id == '0'){
          $sql = "SELECT nrw_id,date_format(nrwdate,'%d %b,%Y') nrwdate,nrwtime,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,nrwdone,total_works,status  FROM ".DB_PREFIX."nonroutineworks WHERE status != 9 ".$where." order by nrw_id desc"; 
          $stmt = $this->connection->prepare($sql);
          $stmt->execute();
          $nrw = $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
          $sql = "SELECT nrw_id,date_format(nrwdate,'%d %b,%Y') nrwdate,nrwtime,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,nrwdone,total_works,status  FROM ".DB_PREFIX."nonroutineworks WHERE status != 9  and site IN (select site_id from tbl_sites where unit_mgr = :unit_mgr or operations_mgr = :unit_mgr)".$where." order by nrw_id desc"; 
          $stmt = $this->connection->prepare($sql);
          $stmt->bindParam(':unit_mgr', $emp_data->emp_id);
          $stmt->execute();
          $nrw = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if(!empty($nrw)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'nrw' => $nrw
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getNrwDetails($data): array {
      try {
        extract($data);
        $sql = "SELECT n.nrw_id,n.nrwdate,n.nrwtime,n.unit_mgr,n.site,get_siteName(n.site) AS siteName,get_empName(n.unit_mgr) unitManagerName,get_siteBuildingCode(n.site) building_code,n.nrwdone,n.total_works,n.status,ns.nrwdailyservice_id,ns.floor,get_FloorName(ns.floor) floor_name,ns.sub_area,get_SubareaName(ns.sub_area) subAreaname,ns.work,get_nrwnatureofwork(work) natureofwork,ns.comments FROM ".DB_PREFIX."nonroutineworks n LEFT JOIN tbl_nrwdailyservices ns ON n.nrw_id = ns.nrw_id WHERE n.nrw_id = :nrw_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':nrw_id', $nrw_id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);  //var_dump($data);die;
        $nrw = null;
        $nrwdailyservices = [];
        foreach ($data as $row) {
          if ($nrw === null) {
              $nrw = (object) [
                  'nrw_id' => $row['nrw_id'],
                  'nrwdate' => $row['nrwdate'],
                  'nrwtime' => $row['nrwtime'],
                  'unit_mgr' => $row['unit_mgr'],
                  'unit_mgrName' => $row['unitManagerName'],
                  'site' => $row['site'],
                  'siteName' => $row['siteName'],
                  'building_code' => $row['building_code'],
                  'nrwdone' => $row['nrwdone'],
                  'total_works' => $row['total_works'],
                  'status' => $row['status'],
                  'nrwdailyservices' => [] // Initialize the nested list
              ];
          }
          // Add daily service details if they exist
          if (!empty($row['nrwdailyservice_id'])) {
              $nrwdailyservices[] = (object) [
                  'nrwdailyservice_id' => $row['nrwdailyservice_id'],
                  'floor' => $row['floor'],
                  'floor_name' => $row['floor_name'],
                  'sub_area' => $row['sub_area'],
                  'subAreaname' => $row['subAreaname'],
                  'work' => $row['work'],
                  'natureofwork' => $row['natureofwork'],
                  'comments' => $row['comments']
              ];
          }
        }
        if ($nrw !== null) {
          $nrw->nrwdailyservices = $nrwdailyservices;
        }
        if(!empty($nrw)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'nrw' => $nrw
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addNrw($data){
      try {
        extract($data);
        $created_date = date('Y-m-d H:i:s');
        $status = 0;
        $device = 'Mobile'; 
        $total_work = ($nrwdone == 1) ? 0 : count($nrwdailyservices);
        $sql = "INSERT INTO ".DB_PREFIX."nonroutineworks (nrwdate , nrwtime, unit_mgr, site,  nrwdone, device, total_works, status,created_date, created_by ) values (:nrwdate , :nrwtime, :unit_mgr, :site,:nrwdone, :device, :total_works, :status,:created_date, :created_by )";
        $stmt->bindParam(':nrwdate', $nrwdate);
        $stmt->bindParam(':nrwtime', $nrwtime);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':nrwdone', $nrwdone);
        $stmt->bindParam(':device', $device);
        $stmt->bindParam(':total_works', $total_work); 
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->execute();  
        $nrw_id = $this->connection->lastInsertId();
        if ($nrw_id > 0) {
          if ($nrwdone == 0 && !empty($nrwdailyservices)) {
            foreach ($nrwdailyservices as $service) {
              $floor = $service->floor;
              $sub_area = $service->sub_area; // Assuming 'floor_name' corresponds to sub_area
              $work = $service->work;
              $comments = $service->comments;
              $sql1 = "INSERT INTO tbl_nrwdailyservices (nrw_id,floor,sub_area,work,comments,status,created_date,created_by)  values(:nrw_id,:floor,:sub_area,:work,:comments,:status,:created_date, :created_by) ";
              $stmt1 = $this->connection->prepare($sql1);
              $stmt1->bindParam(':nrw_id', $nrw_id);
              $stmt1->bindParam(':floor', $floor);
              $stmt1->bindParam(':sub_area', $sub_area);
              $stmt1->bindParam(':work', $work);
              $stmt1->bindParam(':comments', $comments);
              $stmt1->bindParam(':status', $status);
              $stmt1->bindParam(':created_date', $created_date);
              $stmt1->bindParam(':created_by', $created_by);
              $stmt1->execute();
            }
          }
          $response = [
              'status' => "200",
              'message' => "Non Routine Works Added Successfully",
              'nrw_id' => $nrw_id
          ];
        } else {
          $response = [
              'status' => "204",
              'message' => "No Data Added"
          ];
        }
        return $response;
      } 
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    } 
    public function updateNrw($data){
    try {
      extract($data);
      $modified_date = date('Y-m-d H:i:s');
      $total_work = ($nrwdone == 1) ? 0 : count($nrwdailyservices);
      $sql = "UPDATE ".DB_PREFIX."nonroutineworks SET nrwdate = :nrwdate, nrwtime = :nrwtime, unit_mgr = :unit_mgr, site = :site, nrwdone = :nrwdone, total_works = :total_works, status = :status, modified_date = :modified_date, modified_by = :modified_by WHERE nrw_id = :nrw_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':nrw_id', $nrw_id);
      $stmt->bindParam(':nrwdate', $nrwdate);
      $stmt->bindParam(':nrwtime', $nrwtime);
      $stmt->bindParam(':unit_mgr', $unit_mgr);
      $stmt->bindParam(':site', $site);
      $stmt->bindParam(':nrwdone', $nrwdone);
      $stmt->bindParam(':total_works', $total_work);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $modified_by);
      $stmt->execute();
      if ($nrwdone == 0 && !empty($nrwdailyservices)) {
        foreach ($nrwdailyservices as $service) {
          if (!empty($service->nrwdailyservice_id) && $service->nrwdailyservice_id!=-1) {
            $sql1 = "UPDATE tbl_nrwdailyservices SET floor = :floor, sub_area = :sub_area, work = :work, comments = :comments, status = :status, modified_date = :modified_date, modified_by = :modified_by WHERE nrwdailyservice_id = :nrwdailyservice_id";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bindParam(':nrwdailyservice_id', $service->nrwdailyservice_id);
          } else {
            $sql1 = "INSERT INTO tbl_nrwdailyservices (nrw_id, floor, sub_area, work, comments, status, created_date, created_by) VALUES (:nrw_id, :floor, :sub_area, :work, :comments, :status, :created_date, :created_by)";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bindParam(':nrw_id', $nrw_id);
            $stmt1->bindParam(':created_date', $modified_date);
            $stmt1->bindParam(':created_by', $modified_by);
          }
          $stmt1->bindParam(':floor', $service->floor);
          $stmt1->bindParam(':sub_area', $service->sub_area);
          $stmt1->bindParam(':work', $service->work);
          $stmt1->bindParam(':comments', $service->comments);
          $stmt1->bindParam(':status', $status);
          $stmt1->bindParam(':modified_date', $modified_date);
          $stmt1->bindParam(':modified_by', $modified_by);
          $stmt1->execute();
        }
      }
      return [
          'status' => "200",
          'message' => "Non Routine Works Updated Successfully",
          'nrw_id' => $nrw_id
      ];
    } catch (PDOException $e) {
        return [
            'status' => "500",
            'message' => $e->getMessage()
        ];
    }
  }
  public function deleteNrw($data){
    try {
      extract($data);
      $modified_date  = date('Y-m-d H:i:s');
      $sql = "UPDATE ".DB_PREFIX."nonroutineworks SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where nrw_id = :nrw_id";          
      $stmt = $this->connection->prepare($sql);   
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $modified_by);
      $stmt->bindParam(':nrw_id', $nrw_id);
      $res =  $stmt->execute(); 
      if($res){
        $status = array(
         'status' =>"200",
         'message' =>"Nrw Deleted Successfully" ); 
       }else{
        $status = array(
          'status' => "204",
          'message' => "No Nrw Deleted"
        );
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
  public function checkNrwSiteDate($data){
    try {
      extract($data);  
      $where = '';
      if(isset($nrw_id)) {
        $where = " AND nrw_id != ".$nrw_id;
      }
      $sql = "SELECT count(*) AS nrw_count FROM ".DB_PREFIX."nonroutineworks WHERE site = :site AND nrwdate = :nrwdate AND status = 0 ". $where;             
      $stmt = $this->connection->prepare($sql);   
      $stmt->bindParam(':site', $site);
      $stmt->bindParam(':nrwdate', $nrwdate); 
      $stmt->execute(); 
      $res =  $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($res)){
        $status = array(
         'status' =>"200",
         'message' =>"Nrw Count",
         'count' => $res->nrw_count ); 
       }else{
        $status = array(
          'status' => "204",
          'message' => "No Data"
        );
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
  public function deleteNrwService($data){
    try {
      extract($data);
      $modified_date  = date('Y-m-d H:i:s');
      $sql = "UPDATE ".DB_PREFIX."nrwdailyservices SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where nrwdailyservice_id = :nrwdailyservice_id";          
      $stmt = $this->connection->prepare($sql);   
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $modified_by);
      $stmt->bindParam(':nrwdailyservice_id', $nrwdailyservice_id);
      $res =  $stmt->execute(); 
      if($res){
        $status = array(
         'status' =>"200",
         'message' =>" Deleted Successfully" ); 
       }else{
        $status = array(
          'status' => "204",
          'message' => "No Data Deleted"
        );
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
    /* MU */
  public function getMuList($data) {
    try {
      extract($data);  
       $where = "";
      if(isset($site_id) && $site_id != 0){
        $where = " AND site =".$site_id;
      }
      if(isset($from_date) && $from_date != '' || isset($to_date) && $to_date != '' ){
        $where = " AND mcudate >= '".$from_date."' AND mcudate <= '".$to_date."' ";
      }
      $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
      $stmt1 = $this->connection->prepare($sql1);
      $stmt1->bindParam(":user_id",$user_id);
      $stmt1->execute(); 
      $emp_data = $stmt1->fetch(PDO::FETCH_OBJ); 
      $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
      $stmt1 = $this->connection->prepare($sql1);
      $stmt1->bindParam(":user_id",$user_id);
      $stmt1->execute(); 
      $emp_data = $stmt1->fetch(PDO::FETCH_OBJ); 
      if($emp_data->emp_id == '0'){
        $sql = "SELECT mcupdate_id,date_format(mcudate,'%d %b,%Y') mcudate,mcutime,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,mcudone,total_mc_updates,status  FROM ".DB_PREFIX."machineryupdates WHERE status != 9 ".$where." order by mcupdate_id desc";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $mu = $stmt->fetchAll(PDO::FETCH_OBJ);
      }else{
        $sql = "SELECT mcupdate_id,date_format(mcudate,'%d %b,%Y') mcudate,mcutime,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,mcudone,total_mc_updates,status  FROM ".DB_PREFIX."machineryupdates WHERE status != 9 and site IN (select site_id from tbl_sites where unit_mgr = :unit_mgr or operations_mgr = :unit_mgr)".$where." order by mcupdate_id desc";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':unit_mgr', $emp_data->emp_id);
        $stmt->execute();
        $mu = $stmt->fetchAll(PDO::FETCH_OBJ);          
      }
      if(!empty($mu)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success.",
          'mu' => $mu
        );          
      }else{
        $status = array(
          'status' => "204",
          'message' => "No Data Found"
        );
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
  public function getMuDetails($data): array {
    try {
      extract($data);
      $sql = "SELECT m.mcupdate_id,m.mcudate,m.mcutime,m.unit_mgr,get_empName(m.unit_mgr) unitManagerName,m.site,get_siteName(m.site) AS siteName,get_siteBuildingCode(m.site) AS building_code,
            m.mcudone,m.total_mc_updates,m.status,ms.mcudailyservice_id,ms.machine_name,get_MachineryName(machine_name) machineName,ms.comments,ms.service_date,ms.next_service_date,ms.machine_condition, CASE when ms.machine_condition = 0 THEN 'Working' ELSE 'Non Working' END AS mc_condition,ms.provided_by,CASE  WHEN provided_by = 0 THEN 'Client' ELSE 'Mclean' END AS provided_by_name,ms.machine_count FROM 
          ".DB_PREFIX."machineryupdates m LEFT JOIN ".DB_PREFIX."mcudailyservice ms ON m.mcupdate_id = ms.mcupdate_id WHERE m.mcupdate_id = :mcupdate_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':mcupdate_id', $mu_id);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);  
      $mcu = null;
      $mcudailyservices = [];
      foreach ($data as $row) {
        if ($mcu === null) {
            $mcu = (object) [
                'mcupdate_id' => $row['mcupdate_id'],
                'mcudate' => $row['mcudate'],
                'mcutime' => $row['mcutime'],
                'unit_mgr' => $row['unit_mgr'],
                'unit_mgrName' => $row['unitManagerName'],
                'site' => $row['site'],
                'siteName' => $row['siteName'],
                'building_code' => $row['building_code'],
                'mcudone' => $row['mcudone'],
                'total_mc_updates' => $row['total_mc_updates'],
                'status' => $row['status'],
                'mcudailyservices' => [] // Initialize the nested list
            ];
        }
        // Add daily service details if they exist
        if (!empty($row['mcudailyservice_id'])) {
            $mcudailyservices[] = (object) [
                'mcudailyservice_id' => $row['mcudailyservice_id'],
                'machine_name' => $row['machine_name'],                   
                'machineName' => $row['machineName'],                   
                'machine_condition' => $row['machine_condition'],                   
                'mc_condition' => $row['mc_condition'],                   
                'provided_by' => $row['provided_by'],
                'provided_by_name' => $row['provided_by_name'],
                'service_date' => $row['service_date'],
                'next_service_date' => $row['next_service_date'],
                'machine_count' => $row['machine_count'],
                'comments' => $row['comments']
            ];
        }
      }
      if ($mcu !== null) {
        $mcu->mcudailyservices = $mcudailyservices;
      }
      if(!empty($mcu)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success.",
          'mu' => $mcu
        );          
      }else{
        $status = array(
          'status' => "204",
          'message' => "No Data Found"
        );
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
  public function addMu($data){
    try {
      extract($data);
      $created_date = date('Y-m-d H:i:s');
      $status = 0;
      $device = 'Mobile';
      $total_mc_update = ($mcudone == 1) ? 0 : count($mcudailyservices);
      $sql = "INSERT INTO tbl_machineryupdates 
              (mcudate, mcutime, unit_mgr, site, mcudone, device, status, total_mc_updates, created_date, created_by) 
              VALUES 
              (:mcudate, :mcutime, :unit_mgr, :site, :mcudone, :device, :status, :total_mc_updates, :created_date, :created_by)";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':mcudate', $mcudate);
      $stmt->bindParam(':mcutime', $mcutime);
      $stmt->bindParam(':unit_mgr', $unit_mgr);
      $stmt->bindParam(':site', $site);
      $stmt->bindParam(':mcudone', $mcudone);
      $stmt->bindParam(':device', $device);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':total_mc_updates', $total_mc_update);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':created_by', $created_by);
      $stmt->execute();
      $mcupdate_id = $this->connection->lastInsertId();
      if ($mcupdate_id > 0) {
        if ($mcudone == 0 && !empty($mcudailyservices)) {
          foreach ($mcudailyservices as $service) {
            $service_date = !empty($service->service_date) ? date('Y-m-d', strtotime($service->service_date)) : NULL;
            $next_service_date = !empty($service->next_service_date) ? date('Y-m-d', strtotime($service->next_service_date)) : NULL;
            $sql1 = "INSERT INTO tbl_mcudailyservice 
                            (mcupdate_id, machine_name, machine_condition, provided_by, machine_count, service_date, next_service_date, comments, status, created_date, created_by) 
                            VALUES 
                            (:mcupdate_id, :machine_name, :machine_condition, :provided_by, :machine_count, :service_date, :next_service_date, :comments, :status, :created_date, :created_by)";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bindParam(':mcupdate_id', $mcupdate_id);
            $stmt1->bindParam(':machine_name', $service->machine_name);
            $stmt1->bindParam(':machine_condition', $service->machine_condition);
            $stmt1->bindParam(':provided_by', $service->provided_by);
            $stmt1->bindParam(':machine_count', $service->machine_count);
            $stmt1->bindParam(':service_date', $service_date);
            $stmt1->bindParam(':next_service_date', $next_service_date);
            $stmt1->bindParam(':comments', $service->comments);
            $stmt1->bindParam(':status', $status);
            $stmt1->bindParam(':created_date', $created_date);
            $stmt1->bindParam(':created_by', $created_by);
            $stmt1->execute();
          }
        }
        $response = [
          'status' => "200",
          'message' => "Machinery Update Added Successfully",
          'mcupdate_id' => $mcupdate_id
        ];
      } else {
        $response = [
            'status' => "204",
            'message' => "No Data Added"
        ];
      }
      return $response;
    } catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
    }
  }      
  public function updateMu($data) {
    try {
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $status = 0;
        $total_mc_update = ($mcudone == 1) ? 0 : count($mcudailyservices ?? []);
        // Update tbl_machineryupdates
        $sql = "UPDATE tbl_machineryupdates 
                SET mcudate = :mcudate, 
                    mcutime = :mcutime, 
                    unit_mgr = :unit_mgr, 
                    site = :site,  
                    mcudone = :mcudone,  
                    total_mc_updates = :total_mc_updates, 
                    status = :status,
                    modified_date = :modified_date, 
                    modified_by = :modified_by 
                WHERE mcupdate_id = :mcupdate_id"; 
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':mcupdate_id', $mcupdate_id);
        $stmt->bindParam(':mcudate', $mcudate);
        $stmt->bindParam(':mcutime', $mcutime);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':mcudone', $mcudone);
        $stmt->bindParam(':total_mc_updates', $total_mc_update);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $updateResult = $stmt->execute();
        if ($updateResult && $mcudone == 0 && !empty($mcudailyservices)) {
            foreach ($mcudailyservices as $service) {
                $service_date = !empty($service->service_date) ? date('Y-m-d', strtotime($service->service_date)) : NULL;
                $next_service_date = !empty($service->next_service_date) ? date('Y-m-d', strtotime($service->next_service_date)) : NULL;
                if (!empty($service->mcudailyservice_id) && $service->mcudailyservice_id!=-1) {
                    // Update existing record
                    $sql1 = "UPDATE tbl_mcudailyservice 
                             SET machine_name = :machine_name, 
                                 machine_condition = :machine_condition, 
                                 provided_by = :provided_by, 
                                 machine_count = :machine_count, 
                                 service_date = :service_date, 
                                 next_service_date = :next_service_date, 
                                 comments = :comments, 
                                 status = :status, 
                                 modified_date = :modified_date, 
                                 modified_by = :modified_by  
                             WHERE mcudailyservice_id = :mcudailyservice_id";
                    $stmt1 = $this->connection->prepare($sql1);
                    $stmt1->bindParam(':mcudailyservice_id', $service->mcudailyservice_id);
                $stmt1->bindParam(':modified_date', $modified_date);
                $stmt1->bindParam(':modified_by', $modified_by);
                } else {
                    // Insert new record
                    $sql1 = "INSERT INTO tbl_mcudailyservice 
                             (mcupdate_id, machine_name, machine_condition, provided_by, machine_count, service_date, next_service_date, comments, status, created_date, created_by)  
                             VALUES 
                             (:mcupdate_id, :machine_name, :machine_condition, :provided_by, :machine_count, :service_date, :next_service_date, :comments, :status, :created_date, :created_by)";
                    $stmt1 = $this->connection->prepare($sql1);
                    $stmt1->bindParam(':mcupdate_id', $mcupdate_id);
                    $stmt1->bindParam(':created_date', $modified_date);
                    $stmt1->bindParam(':created_by', $modified_by);
                }
                $stmt1->bindParam(':machine_name', $service->machine_name);
                $stmt1->bindParam(':machine_condition', $service->machine_condition);
                $stmt1->bindParam(':provided_by', $service->provided_by);
                $stmt1->bindParam(':machine_count', $service->machine_count);
                $stmt1->bindParam(':service_date', $service_date);
                $stmt1->bindParam(':next_service_date', $next_service_date);
                $stmt1->bindParam(':comments', $service->comments);
                $stmt1->bindParam(':status', $status);
                $stmt1->execute();
            }
        }
        return [
            'status' => "200",
            'message' => "Machinery Update Updated Successfully"
        ];
    } catch (PDOException $e) {
        return [
            'status' => "500",
            'message' => $e->getMessage()
        ];
    }
}
    public function deleteMu($data){
      try {
        extract($data);
        $modified_date  = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."machineryupdates SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where mcupdate_id = :mcupdate_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':mcupdate_id', $mcupdate_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Mu Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Mu Deleted"
          );
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
    public function checkMuSiteDate($data){
      try {
        extract($data); 
        $where = '';
        if(isset($mcupdate_id)) {
          $where = " AND mcupdate_id != ".$mcupdate_id;
        } 
        $sql = "SELECT count(*) AS mu_count FROM ".DB_PREFIX."machineryupdates WHERE site = :site AND mcudate = :mcudate AND status = 0 ". $where;             
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':mcudate', $mcudate); 
        $stmt->execute(); 
        $res =  $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
           'status' =>"200",
           'message' =>"Mu Count",
           'count' => $res->mu_count ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data"
          );
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
    public function deleteMuService($data){
      try {
        extract($data);
        $modified_date  = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mcudailyservice SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where mcudailyservice_id = :mcudailyservice_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':mcudailyservice_id', $mcudailyservice_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>" Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
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
     /* LMW */
    public function getLmwList($data): array {
      try {
        extract($data);
         $where = "";
        if(isset($site_id) && $site_id != 0){
          $where = " AND site =".$site_id;
        }
        if(isset($from_date) && $from_date != '' || isset($to_date) && $to_date != '' ){
          $where = " AND logmsgdate >= '".$from_date."' AND logmsgdate <= '".$to_date."' ";
        }
        $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(":user_id",$user_id);
        $stmt1->execute(); 
        $emp_data = $stmt1->fetch(PDO::FETCH_OBJ); 
        if($emp_data->emp_id == '0'){
          $sql = "SELECT logmessage_id,date_format(logmsgdate,'%d %b,%Y') logmsgdate,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,logmsgdone,`status`,`total_services`  FROM ".DB_PREFIX."logmessages WHERE status != 9 ".$where." order by logmessage_id desc";
          $stmt = $this->connection->prepare($sql);
          $stmt->execute();
          $lmw = $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
          $sql = "SELECT logmessage_id,date_format(logmsgdate,'%d %b,%Y') logmsgdate,unit_mgr,get_siteName(site) AS siteName,get_siteBuildingCode(site) building_code,logmsgdone,`status`,`total_services`  FROM ".DB_PREFIX."logmessages WHERE status != 9 and site IN (select site_id from tbl_sites where unit_mgr = :unit_mgr or operations_mgr = :unit_mgr)".$where." order by logmessage_id desc";
          $stmt = $this->connection->prepare($sql);
          $stmt->bindParam(':unit_mgr', $emp_data->emp_id);
          $stmt->execute();
          $lmw = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if(!empty($lmw)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success",
            'lmw' => $lmw
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getLmwDetails($data): array {
      try {
        extract($data);
         $sql = "SELECT m.logmessage_id,m.logmsgdate,m.logmsgtime,m.total_services,m.unit_mgr,get_empName(m.unit_mgr) unitManagerName,m.site,get_siteName(m.site) AS siteName,get_siteBuildingCode(m.site) building_code,m.logmsgdone,m.status,ms.logmsgdservice_id,ms.floor,get_FloorName(ms.floor) floor_name,ms.sub_area,get_SubareaName(ms.sub_area) subAreaname,ms.work,getLogmessagework(ms.work) natureofwork,ms.comments FROM ".DB_PREFIX."logmessages m LEFT JOIN tbl_logmsgdailyservice ms ON m.logmessage_id = ms.logmessage_id WHERE m.logmessage_id = :logmessage_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':logmessage_id', $lmw_id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $lmw = null;
        $lmwdailyservices = [];
        foreach ($data as $row) {
          if ($lmw === null) {
              $lmw = (object) [
                  'logmessage_id' => $row['logmessage_id'],
                  'logmsgdate' => $row['logmsgdate'],
                  'logmsgtime' => $row['logmsgtime'],
                  'unit_mgr' => $row['unit_mgr'],
                  'unit_mgrName' => $row['unitManagerName'],
                  'site' => $row['site'],
                  'siteName' => $row['siteName'],
                  'building_code' => $row['building_code'],
                  'logmsgdone' => $row['logmsgdone'],
                  'total_services' => $row['total_services'],
                  'status' => $row['status'],
                  'lmwdailyservices' => [] // Initialize the nested list
              ];
          }
          // Add daily service details if they exist
          if (!empty($row['logmsgdservice_id'])) {
              $lmwdailyservices[] = (object) [
                  'logmsgdservice_id' => $row['logmsgdservice_id'],
                  'floor' => $row['floor'],
                  'floor_name' => $row['floor_name'],
                  'sub_area' => $row['sub_area'],
                  'subAreaname' => $row['subAreaname'],
                  'work' => $row['work'],
                  'natureofwork' => $row['natureofwork'],
                  'comments' => $row['comments']
              ];
          }
        }
        if ($lmw !== null) {
          $lmw->lmwdailyservices = $lmwdailyservices;
        }
        if(!empty($lmw)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'lmw' => $lmw
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addLmw($data) {
    try {
        extract($data);
        $sql = "INSERT INTO tbl_logmessages (logmsgdate, logmsgtime, unit_mgr, site, logmsgdone, device, total_services, status, created_date, created_by)
                VALUES (:logmsgdate, :logmsgtime, :unit_mgr, :site, :logmsgdone, :device, :total_services, :status, :created_date, :created_by)";
        $device = 'Mobile';
        $status = 0;
        $created_date = date('Y-m-d H:i:s');
        $total_services = ($logmsgdone == "1") ? 0 : count($lmwdailyservices);
        $logmsgtime = date('H:i:s');
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':logmsgdate', $logmsgdate);
        $stmt->bindParam(':logmsgtime', $logmsgtime);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':logmsgdone', $logmsgdone);
        $stmt->bindParam(':device', $device);
        $stmt->bindParam(':total_services', $total_services);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->execute();
        $logmessage_id = $this->connection->lastInsertId();
        if ($logmessage_id > 0 && $logmsgdone == "0") {
            $sql1 = "INSERT INTO tbl_logmsgdailyservice (logmessage_id, floor, sub_area, work, comments, log_status, status, created_date, created_by)
                     VALUES (:logmessage_id, :floor, :sub_area, :work, :comments, :log_status, :status, :created_date, :created_by)";
            $stmt1 = $this->connection->prepare($sql1);
            foreach ($lmwdailyservices as $service) {
                $stmt1->bindParam(':logmessage_id', $logmessage_id);
                $stmt1->bindParam(':floor', $service->floor);
                $stmt1->bindParam(':sub_area', $service->sub_area);
                $stmt1->bindParam(':work', $service->work);
                $stmt1->bindParam(':comments', $service->comments);
                $log_status = 0; // Assuming default log status
                $stmt1->bindParam(':log_status', $log_status);
                $stmt1->bindParam(':status', $status);
                $stmt1->bindParam(':created_date', $created_date);
                $stmt1->bindParam(':created_by', $created_by);
                $stmt1->execute();
            }
        }
        return [
            'status' => "200",
            'message' => "Lmw Added Successfully",
            'logmessage_id' => $logmessage_id
        ];
    } catch (PDOException $e) {
        return [
            'status' => "500",
            'message' => $e->getMessage()
        ];
    }
}
  public function updateLmw($data) {
    try {
      extract($data);
      $modified_date = date('Y-m-d H:i:s');
      $total_services = ($logmsgdone == 1) ? 0 : count($lmwdailyservices);
      $sql = "UPDATE tbl_logmessages SET logmsgdate = :logmsgdate, total_services = :total_services, 
                    unit_mgr = :unit_mgr, site = :site, logmsgdone = :logmsgdone, 
                    modified_date = :modified_date, modified_by = :modified_by 
                WHERE logmessage_id = :logmessage_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute([
            ':logmsgdate' => $logmsgdate,
            ':total_services' => $total_services,
            ':unit_mgr' => $unit_mgr,
            ':site' => $site,
            ':logmsgdone' => $logmsgdone,
            ':modified_date' => $modified_date,
            ':modified_by' => $modified_by,
            ':logmessage_id' => $logmessage_id
      ]);
      if ($stmt->rowCount() > 0 && $logmsgdone == 0) {
        foreach ($lmwdailyservices as $service) {
          if (!empty($service->logmsgdservice_id) && $service->logmsgdservice_id!=-1) {
            // Update existing log message daily service
            $sql1 = "UPDATE tbl_logmsgdailyservice SET floor = :floor, sub_area = :sub_area, work = :work, comments = :comments,modified_date = :modified_date, modified_by = :modified_by  WHERE logmsgdservice_id = :logmsgdservice_id";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->execute([
                        ':floor' => $service->floor,
                        ':sub_area' => $service->sub_area,
                        ':work' => $service->work,
                        ':comments' => $service->comments,
                        ':modified_date' => $modified_date,
                        ':modified_by' => $modified_by,
                        ':logmsgdservice_id' => $service->logmsgdservice_id
            ]);
          } else {
            // Insert new log message daily service
            $sql2 = "INSERT INTO tbl_logmsgdailyservice (logmessage_id, floor, sub_area, work, comments, created_date, created_by) VALUES (:logmessage_id, :floor, :sub_area, :work, :comments, :created_date, :created_by)";
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->execute([
                        ':logmessage_id' => $logmessage_id,
                        ':floor' => $service->floor,
                        ':sub_area' => $service->sub_area,
                        ':work' => $service->work,
                        ':comments' => $service->comments,
                        ':created_date' => $modified_date,
                        ':created_by' => $modified_by
            ]);
          }
        }
      }
      return [
            'status' => "200",
            'message' => "Lmw Updated Successfully"
      ];
    } catch (PDOException $e) {
      return [
          'status' => "500",
          'message' => $e->getMessage()
      ];
    }
  }
  public function deleteLmw($data){
      try {
        extract($data);
        $modified_date  = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."logmsgdailyservice SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where logmessage_id = :logmessage_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':logmessage_id', $logmessage_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Lmw Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Lmw Deleted"
          );
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
    public function checkLmwSiteDate($data){
      try {
        extract($data); 
        $sql = "SELECT count(*) AS lmw_count FROM ".DB_PREFIX."logmessages WHERE status = 0 and site = :site AND logmsgdate = :logmsgdate";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':logmsgdate', $logmsgdate); 
        $stmt->execute(); 
        $res =  $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
           'status' =>"200",
           'message' =>"Lmw Count",
           'count' => $res->lmw_count ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data"
          );
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
    public function deleteLmwService($data){
      try {
        extract($data);
        $modified_date  = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."logmsgdailyservice SET status = 9 , modified_date = :modified_date , modified_by = :modified_by where logmsgdservice_id = :logmsgdservice_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':logmsgdservice_id', $logmsgdservice_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>" Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
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
    public function getEmpSitesList($data): array {
      try {
        extract($data);
        $sql = "SELECT  site_name,site_id FROM tbl_sites where site_status != 9 and (unit_mgr = :unit_mgr or operations_mgr = :unit_mgr) ";
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':unit_mgr', $emp_id);
        $stmt->execute();
        $sites = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($sites)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'sites' => $sites
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getUnitMngrs(): array {
      try { 
        $sql = "SELECT emp_id,concat(emp_fname,'',emp_lname) emp_name,get_Empdesignation(designation) AS designationName FROM tbl_emp where emp_status != 9 ";
        $stmt = $this->connection->prepare($sql); 
        $stmt->execute();
        $um = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($um)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'um' => $um
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getSiteUm($data): array {
      try {
        extract($data);
        $sql = "SELECT emp_id,concat(emp_fname,' ',emp_lname)emp_name,get_Empdesignation(designation) AS designationName FROM tbl_emp where emp_id = :emp_id ";
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->execute();
        $um = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($um)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'um' => $um
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getOperationMngrs(): array {
      try { 
        $sql = "SELECT concat(emp_fname,' ',emp_lname)emp_name,emp_id,designation,get_Empdesignation(designation) AS designationName FROM `tbl_emp` WHERE designation = 7 and emp_status != 9 ";   
        $stmt = $this->connection->prepare($sql); 
        $stmt->execute();
        $um = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($um)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'um' => $um
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getSiteUnitMngrs($data) {
      try { 
        extract($data);
        $sql = "SELECT emp_id, concat(emp_fname,' ',emp_lname) emp_name FROM `tbl_emp` WHERE emp_id IN (SELECT unit_mgr FROM tbl_sites WHERE site_id = :site_id)";  
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':site_id', $site_id);
        $stmt->execute();
        $um = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($um)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'um' => $um
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getEmpUm($data): array {
      try {
        extract($data);
        $sql = "SELECT emp_id,concat(emp_fname,' ',emp_lname)emp_name,get_Empdesignation(designation) AS designationName FROM tbl_emp where emp_id = :emp_id ";
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->execute();
        $um = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($um)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'um' => $um
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function deleteGrattachments($data){
      extract($data);
      try{
        $sql = "UPDATE ".DB_PREFIX."attngroomattachments set status='9',modified_date=:modified_date,modified_by=:modified_by where attngrmatachm_id=:attngrmatachm_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':attngrmatachm_id',$attngrmatachm_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteOtattachments($data){
      extract($data);
      try{
        $sql = "UPDATE ".DB_PREFIX."attnotattachments set status='9',modified_date=:modified_date,modified_by=:modified_by where attnotattachment_id=:attnotattachment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':attnotattachment_id',$attnotattachment_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteItotattachments($data){
      extract($data);
      try{
        $sql = "UPDATE ".DB_PREFIX."attnintimeotattachments set status='9',modified_date=:modified_date,modified_by=:modified_by where attnitotatach_id=:attnitotatach_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':attnitotatach_id',$attnitotatach_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteAdattachments($data){
      extract($data);
      try{
        $sql = "UPDATE ".DB_PREFIX."attnareadeplattachments set status='9',modified_date=:modified_date,modified_by=:modified_by where attnareadeplattach_id=:attnareadeplattach_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':attnareadeplattach_id',$attnareadeplattach_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    /* USERS */
    public function checkLogin($data)  {
      try{
        extract($data); 
        $passwordEn = $this->PassHash($user_password);
        if(empty($user_name) || empty($user_password)) {
          $status = array(
            'status' => ERR_PARTIAL_CONT,
            'message' => "Failure! user name is required"
          );
        }
        else{ 
          $sql ="SELECT user_id,  role_id,first_name,last_name,user_name, login_id ,user_email AS email, gender, DATE_FORMAT(user_dob, '%d %M %Y') AS dob,  user_photo, user_status AS status,emp_id FROM tbl_users WHERE (user_name = '". $user_name ."' || user_email = '".$user_name."') AND  user_password = '". $passwordEn ."' AND user_status = '0'"; 
          $stmt = $this->connection->prepare($sql);  
          $stmt->execute();
          $users = $stmt->fetch(PDO::FETCH_OBJ);
          if($users!=''){
            $status = array('status' => ERR_OK,
                    'message' => "Success",
                    'userDetails' => $users);      
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
    public function getUsers(): array {
      try {
        $query = "SELECT `user_id` as user_id,getRole(role_id) user_role, first_name,last_name,user_name, user_email as email, `user_mobile`,gender,user_status,`created_date` as createdOn, created_by AS createdBy  FROM tbl_users where user_status != '9'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($results!=''){
          $status = array( 
          'status' => ERR_OK,
          'message' => "Success",
          'users' => $results);
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
        $where = '';
        if(isset($edit_user_id) && $edit_user_id != ''){
          $where = " AND `user_id` != ".$edit_user_id;
        }
        $sql = "SELECT count(`user_id`) as cnt FROM " . DB_PREFIX . "users where `user_email`=:user_email ".$where;  
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_email',$user_email);
        // $stmt->bindParam(':user_id',$edit_user_id);
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
        $sql = "INSERT INTO tbl_users SET first_name=:first_name,last_name=:last_name,user_name=:user_name,login_id =:login_id, user_mobile=:user_mobile, user_email = :user_email, user_password = :user_password, role_id=:role_id, gender = :user_gender,user_status = :user_status,created_date = :created_date, created_by=:created_by";
        $stmt = $this->connection->prepare($sql);  
        $created_date = date("Y-m-d H:i:s"); $user_photo = '';
        $passwordEn = $this->PassHash($user_password);
        $user_name = $first_name." ".$last_name;
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(":user_name",$user_name);
        $stmt->bindParam(":user_mobile",  $user_mobile);
        $stmt->bindParam(":login_id",  $user_email);
        $stmt->bindParam(":user_email",  $user_email);
        $stmt->bindParam(":user_password", $passwordEn);  
        $stmt->bindParam(":role_id",$role_id);
        $stmt->bindParam(":user_gender",  $user_gender);
        $stmt->bindParam(":user_status",  $user_status);
        $stmt->bindParam(":created_date", $created_date); 
        $stmt->bindParam(":created_by", $created_by); 
        $res = $stmt->execute();
        $user_id = $this->connection->lastInsertId();
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
    public function updateUser($data) {
      try{
        extract($data);
        if(empty($user_email)){
           $status = array(
          'status' => "206",
          'message' => "Failure email is required"
          );
        }else{          
          $userExist = $this->checkemail($user_email,$edit_user_id);
          if ($userExist == '0'){            
            $sql  = "UPDATE tbl_users SET first_name=:first_name,last_name=:last_name,user_name=:user_name,user_email=:user_email, user_mobile = :user_mobile, role_id=:role_id,gender = :user_gender,user_status = :user_status,modified_date = :modified_date,modified_by=:modified_by where user_id=:user_id";
            $user_name = $first_name." ".$last_name;
            $modified_date = date("Y-m-d H:i:s");
            $stmt = $this->connection->prepare($sql);   
            $stmt->bindParam(':first_name',$first_name);
            $stmt->bindParam(':last_name',$last_name);
            $stmt->bindParam(":user_name", $user_name);
            $stmt->bindParam(":user_email", $user_email);
            $stmt->bindParam(":user_mobile", $user_mobile);
            $stmt->bindParam(":role_id", $user_role);
            $stmt->bindParam(":user_gender", $user_gender);
            $stmt->bindParam(":user_status",$user_status);
            $stmt->bindParam(":user_id", $edit_user_id);
            $stmt->bindParam(":modified_date",$modified_date); 
            $stmt->bindParam(":modified_by",$modified_by); 
            $res = $stmt->execute();
            if($res){
              $status = array(
                'status' => "200",
              'message' => "User Details Updated Successfully");
            }else{
              $status = array(
              'status' => "304",
              'message' => "Sorry,User Details Not Updated ");
            }
          }
          else {
            $status = array(
              'status' => "208",
              'message' => "Failure user email already existed"
            );
          }
        }
        return $status;  
      } 
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function checkEmail($email,$userid)    {     
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
    public function getUserDetails($data) {
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
        $modified_date = date("Y-m-d H:i:s");
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
        $modified_date = date("Y-m-d H:i:s");     
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
    public function updateUserProfile($data){
      try{
        extract($data);
        $modified_date = date("Y-m-d H:i:s");
        $sql = "UPDATE ".DB_PREFIX."users SET `first_name`=:first_name, last_name=:last_name, modified_by=:modified_by, modified_date=:modified_date where user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':user_id',$ch_user_id);
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
            $modified_date = date("Y-m-d H:i:s");    
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
    /* EMPLOOYEES */
    public function getEmployees(): array {
      try {
        $sql = "SELECT emp_id,emp_code,emp_fname,emp_lname,email,mobile_no,get_empdesignation(designation) as designation,emp_status, get_empShifts(emp_shift) emp_shift FROM ".DB_PREFIX."emp WHERE emp_status !=9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $employees = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($employees)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'employees' => $employees
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getEmployeeDetails($data): array {
      try {
        extract($data);
        $sql = "SELECT * FROM ".DB_PREFIX."emp WHERE emp_id = :emp_id ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->execute();
        $employees = $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($employees)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'employees' => $employees
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addEmployee($data){
      try {
        extract($data);
        $created_date = date("Y-m-d H:i:s"); 
        $sql = "INSERT INTO ".DB_PREFIX."emp (emp_code,emp_fname,emp_lname,email,mobile_no,designation,gender,emp_status,emp_shift,created_date,created_by) VALUES(:emp_code,:emp_fname,:emp_lname,:email,:mobile_no,:designation,:gender,:emp_status, :emp_shift,:created_date,:created_by)";
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':emp_code', $emp_code);
        $stmt->bindParam(':emp_fname', $emp_fname);
        $stmt->bindParam(':emp_lname', $emp_lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile_no', $mobile_no);
        $stmt->bindParam(':designation', $designation);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':emp_status', $emp_status);
        $stmt->bindParam(':emp_shift', $emp_shift);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->execute();
        $emp_id= $this->connection->lastInsertId();
        if($emp_id > 0){
          $sql2 = "INSERT INTO ".DB_PREFIX."users (first_name,last_name,user_name,login_id,user_password,user_mobile,user_email,gender,emp_id,role_id,user_status,created_date,created_by) VALUES(:first_name,:last_name,:user_name,:login_id,:user_password,:user_mobile,:user_email,:gender,:emp_id,:role_id,:user_status,:created_date,:created_by)";
          $stmt2 = $this->connection->prepare($sql2);
          $role_id=3;
          $user_name = $emp_fname." ".$emp_lname;
          $stmt2->bindParam(':user_name',$user_name);
          $stmt2->bindParam(':first_name', $emp_fname);
          $stmt2->bindParam(':last_name', $emp_lname);
          $stmt2->bindParam(':user_mobile', $mobile_no);
          $stmt2->bindParam(':login_id',$email);
          $stmt2->bindParam(':gender',$gender);
          $stmt2->bindParam(':user_password',$user_password);
          $stmt2->bindParam(':user_email',$email);
          $stmt2->bindParam(':user_status',$emp_status);
          $stmt2->bindParam(':emp_id',$emp_id);
          $stmt2->bindParam(':role_id',$role_id);
          $stmt2->bindParam(':created_date',$created_date);
          $stmt2->bindParam(':created_by',$created_by);
          $stmt2->execute();
          $status = array(
            'status' =>"200",
            'message' =>"Employee Added Successfully",
            'emp_id' => $emp_id); 
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Added"
          );
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
    public function updateEmployee($data){
      try {
        extract($data);
        $modified_date = date("Y-m-d H:i:s"); 
        $sql = "UPDATE " . DB_PREFIX . "emp AS e JOIN " . DB_PREFIX . "users AS u ON e.emp_id = u.emp_id SET 
            e.emp_code = :emp_code,e.emp_fname = :emp_fname,e.emp_lname = :emp_lname,e.email = :email,e.mobile_no = :mobile_no,u.user_mobile=:mobile_no,e.designation = :designation,e.gender=:gender,u.gender=:gender,e.emp_status = :emp_status,e.emp_shift = :emp_shift,e.modified_date = :modified_date, 
                e.modified_by = :modified_by,u.first_name=:emp_fname,u.last_name=:emp_lname,u.user_email = :user_email,u.login_id = :user_email,u.user_status = :emp_status,u.modified_date = :modified_date,u.modified_by = :modified_by WHERE 
              e.emp_id = :emp_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':emp_code', $emp_code);
        $stmt->bindParam(':emp_fname', $emp_fname);
        $stmt->bindParam(':emp_lname', $emp_lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':mobile_no', $mobile_no);
        $stmt->bindParam(':designation', $designation);
        $stmt->bindParam(':emp_status', $emp_status);
        $stmt->bindParam(':emp_shift', $emp_shift);
        $stmt->bindParam(':user_email', $email);
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':emp_id', $emp_id);
        $res =  $stmt->execute(); 
        if($res){
          if($emp_status == 1){
            $sql1 = "UPDATE ".DB_PREFIX."users SET user_status = '1' WHERE emp_id=:emp_id"; 
            $stmt1 = $this->connection->prepare($sql1);  
            $stmt1->bindParam(":emp_id", $emp_id);
            $stmt1->execute();
          }
          $status = array(
            'status' =>"200",
            'message' =>"Employee Info Updated Successfully"); 
        } else{
          $status = array(
            'status' => "204",
            'message' => "No Data Updated"
          );
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
    public function deleteEmployee($data){
      try {
        extract($data);
        $modified_date = date("Y-m-d H:i:s");
        $sql = "UPDATE ".DB_PREFIX."emp SET emp_status = 9 , modified_date = :modified_date , modified_by = :modified_by where emp_id = :emp_id";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':emp_id', $emp_id);
        $res =  $stmt->execute();
        if($res){
          //user deletion
          $sql1 = "UPDATE ".DB_PREFIX."users SET user_status = '9' WHERE emp_id=:emp_id";
          $stmt1 = $this->connection->prepare($sql1);  
          $stmt1->bindParam(":emp_id", $emp_id);
          $stmt1->execute();
          $status = array(
           'status' =>"200",
           'message' =>"Employee Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Employee Deleted"
          );
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
    public function getEmpDesignations(){
      try{
        $sql = "SELECT designation_id,designation_name from ".DB_PREFIX."emp_designations where status='0'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $desingationlist = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($desingationlist)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'designations' => $desingationlist
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getEmpShifts(){
      try{
        $sql = "SELECT shift_id,shift_name from ".DB_PREFIX."jobshifts where status='0'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $shiftslist = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($shiftslist)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'shifts' => $shiftslist
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function checkEmpEmail($data){
      try {
        extract($data); 
        $where = '';
        if(isset($user_id)) {
          $where = " AND user_id != '".$user_id."'";
        }
        $sql = "SELECT count(*) AS users_count FROM ".DB_PREFIX."users WHERE user_email = :email AND user_status != '9' ". $where;          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':email', $email); 
        $stmt->execute(); 
        $res =  $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
           'status' =>"200",
           'message' =>"Users Count",
           'count' => $res->users_count ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Bms Deleted"
          );
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
    /* Sites */
    public function getSitesList(): array {
      try {
        $sql = "SELECT * FROM ".DB_PREFIX."sites WHERE site_status !=9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $sites = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($sites)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'sites' => $sites
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getStateCities($data): array {
      try {
        extract($data);
        $sql = "SELECT * FROM ".DB_PREFIX."cities WHERE state_id  = :state_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':state_id', $state_id);
        $stmt->execute();
        $cities = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($cities)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'cities' => $cities
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addSite($data){
      try {  
        extract($data);
        $site_logo = ''; 
        $building_image = '';
        $ImageUpload = new ImageUpload();
        if( (isset($_FILES['site_logo'])) && (!empty($_FILES['site_logo']['name'])) ){
          $filedir = IMGUPLOAD."sites/"; 
          $randName = rand(10101010, 9090909090);
          $newName = 'sitelogo'.'_'.$randName;
          $ext = substr($_FILES['site_logo']['name'], strrpos($_FILES['site_logo']['name'], '.') + 1); 
          $ImageUpload->File = $_FILES['site_logo'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewWidth = '283';
          $ImageUpload->NewHeight = '319';
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $site_logo = $newName.".".$ext;  
          $_POST['site_logo'] = $site_logo;             
          $_POST['ext'] = "webp";             
        } else{
          $_POST['site_logo'] = $site_logo;    
        }
        if( (isset($_FILES['building_image'])) && (!empty($_FILES['building_image']['name'])) ){
          $filedir = IMGUPLOAD."sites/";  
          $randName = rand(10101010, 9090909090);
          $newName = 'buildingimg'.'_'.$randName;
          $ext = substr($_FILES['building_image']['name'], strrpos($_FILES['building_image']['name'], '.') + 1); 
          $ImageUpload->File = $_FILES['building_image'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewWidth = '283';
          $ImageUpload->NewHeight = '319';
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $building_image = $newName.".".$ext;  
          $_POST['building_image'] = $building_image;             
          $_POST['ext'] = "webp";             
        } else{
          $_POST['building_image'] = $building_image;    
        }
        $created_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO ".DB_PREFIX."sites (site_logo,building_name,building_image,building_code,site_name,operations_mgr,unit_mgr,city,state,weekly_off,site_address,staff,supervisors,unit_mgrs,facility_mgrs,asst_facility_mgrs,executives,office_boys,stewards,pantry_boys,washroom_maintanence,kitchen_staff,others,approved_staff,site_status,created_date,created_by) VALUES(:site_logo, :building_name,:building_image,:building_code,:site_name,:operations_mgr,:unit_mgr,:city,:state,:weekly_off,:site_address,:staff,:supervisors,:unit_mgrs,:facility_mgrs,:asst_facility_mgrs,:executives,:office_boys,:stewards,:pantry_boys,:washroom_maintanence,:kitchen_staff,:others, :approved_staff,:site_status, :created_date, :created_by)"; 
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':site_logo', $site_logo);
        $stmt->bindParam(':building_name', $building_name);
        $stmt->bindParam(':building_image', $building_image);
        $stmt->bindParam(':building_code', $building_code);
        $stmt->bindParam(':site_name', $site_name);
        $stmt->bindParam(':operations_mgr', $operations_mgr);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':weekly_off', $weekly_off);
        $stmt->bindParam(':site_address', $site_address);
        $stmt->bindParam(':staff', $staff);
        $stmt->bindParam(':supervisors', $supervisors);
        $stmt->bindParam(':unit_mgrs', $unit_mgrs);
        $stmt->bindParam(':facility_mgrs', $facility_mgrs);
        $stmt->bindParam(':asst_facility_mgrs', $asst_facility_mgrs);
        $stmt->bindParam(':executives', $executives);
        $stmt->bindParam(':office_boys', $office_boys);
        $stmt->bindParam(':stewards', $stewards);
        $stmt->bindParam(':pantry_boys', $pantry_boys);
        $stmt->bindParam(':washroom_maintanence', $washroom_maintanence);
        $stmt->bindParam(':kitchen_staff', $kitchen_staff);
        $stmt->bindParam(':others', $others);
        $stmt->bindParam(':approved_staff', $approved_staff);
        $stmt->bindParam(':site_status', $site_status);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $created_by);
         $stmt->execute();
        $site_id = $this->connection->lastInsertId();
        if($site_id  > 0){
          $status = array(
           'status' =>"200",
           'message' =>"Sites Added Successfully",
           'site_id' => $site_id ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Added"
          );
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
    public function getSiteDetails($data): array {
      try {
        extract($data);
        $sql = "SELECT * FROM ".DB_PREFIX."sites WHERE site_id  = :site_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':site_id', $site_id);
        $stmt->execute();
        $sites = $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($sites)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'sites' => $sites
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function updateSite($data){
      try {
        extract($data);
          $site_logo = ''; $building_image = '';
           $ImageUpload = new ImageUpload();
        if(!empty($_FILES['site_logo']['name'])){
          $filedir = IMGUPLOAD."sites/"; 
          $randName = rand(10101010, 9090909090);
          $newName = 'sitelogo'.'_'.$randName;
          $ext = substr($_FILES['site_logo']['name'], strrpos($_FILES['site_logo']['name'], '.') + 1); 
           $ImageUpload->File = $_FILES['site_logo'];
           $ImageUpload->method = 1;
           $ImageUpload->SavePath = $filedir;
           $ImageUpload->NewWidth = '283';
           $ImageUpload->NewHeight = '319';
           $ImageUpload->NewName = $newName;
           $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $site_logo = $newName.".".$ext;  
          $_POST['site_logo'] = $site_logo;             
          $_POST['ext'] = "webp";             
        } else{
          if(isset($_POST['site_logo'])){
            $_POST['site_logo'] = $_POST['site_logo'];
          }else{            
            $_POST['site_logo'] = $site_logo;    
          }    
        }
        if(!empty($_FILES['building_image']['name'])){
          $filedir = IMGUPLOAD."sites/"; 
          $randName = rand(10101010, 9090909090);
          $newName = 'buildingimg'.'_'.$randName;
          $ext = substr($_FILES['building_image']['name'], strrpos($_FILES['building_image']['name'], '.') + 1); 
          $ImageUpload->File = $_FILES['building_image'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewWidth = '283';
          $ImageUpload->NewHeight = '319';
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $building_image = $newName.".".$ext;  
          $_POST['building_image'] = $building_image;             
          $_POST['ext'] = "webp";             
        } else{
          if(isset($_POST['building_image'])){
            $_POST['building_image'] = $_POST['building_image'];
          }else{            
            $_POST['building_image'] = $building_image;    
          }    
        }
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."sites SET site_logo = :site_logo,building_name = :building_name,building_image = :building_image,building_code = :building_code,site_name =:site_name,operations_mgr =:operations_mgr,unit_mgr = :unit_mgr,city =:city,state =:state,weekly_off = :weekly_off,site_address = :site_address,staff = :staff,supervisors = :supervisors,unit_mgrs = :unit_mgrs,facility_mgrs = :facility_mgrs,asst_facility_mgrs = :asst_facility_mgrs,executives = :executives, office_boys = :office_boys,stewards = :stewards,washroom_maintanence = :washroom_maintanence,kitchen_staff = :kitchen_staff,others = :others,approved_staff=:approved_staff, site_status = :site_status, modified_date = :modified_date , modified_by = :modified_by where site_id  = :site_id "; 
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':site_logo', $site_logo);
        $stmt->bindParam(':building_name', $building_name);
        $stmt->bindParam(':building_image', $building_image);
        $stmt->bindParam(':building_code', $building_code);
        $stmt->bindParam(':site_name', $site_name);
        $stmt->bindParam(':operations_mgr', $operations_mgr);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':weekly_off', $weekly_off);
        $stmt->bindParam(':site_address', $site_address);
        $stmt->bindParam(':staff', $staff);
        $stmt->bindParam(':supervisors', $supervisors);
        $stmt->bindParam(':unit_mgrs', $unit_mgrs);
        $stmt->bindParam(':facility_mgrs', $facility_mgrs);
        $stmt->bindParam(':asst_facility_mgrs', $asst_facility_mgrs);
        $stmt->bindParam(':executives', $executives);
        $stmt->bindParam(':office_boys', $office_boys);
        $stmt->bindParam(':stewards', $stewards);
        $stmt->bindParam(':washroom_maintanence', $washroom_maintanence);
        $stmt->bindParam(':kitchen_staff', $kitchen_staff);
        $stmt->bindParam(':others', $others);
        $stmt->bindParam(':approved_staff', $approved_staff);
        $stmt->bindParam(':site_status', $site_status);
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':site_id', $site_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Sites Updated Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Updated"
          );
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
    public function deleteSite($data){
      try {
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."sites SET site_status = 9 , modified_date = :modified_date , modified_by = :modified_by where site_id  = :site_id ";          
        $stmt = $this->connection->prepare($sql);   
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':site_id', $site_id);
        $res =  $stmt->execute(); 
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Sites Deleted Successfully" ); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Sites Deleted"
          );
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
    public function getEmpCriteria(): array {
      try {
        $sql = "SELECT empcriteria_id,criteria_name FROM ".DB_PREFIX."bestempcriteria WHERE status=0";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $sites = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($sites)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'data' => $sites
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getGeneralItems($data): array {
      try {
        extract($data);
        $sql = "SELECT item_id,item_name,category FROM ".DB_PREFIX."general_items WHERE category=:category_name and status=0";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':category_name',$category_name);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($items)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'items' => $items
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    /* Reports */
    public function getReporttypes(): array {
      try {
        $sql = "SELECT type_id,report_name  FROM ".DB_PREFIX."reporttypes where module_name='Reports' and status='0'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $reporttypes = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($reporttypes)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'reporttypes' => $reporttypes
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getReportentries(): array {
      try {
        $sql = "SELECT 
        rl.reportlog_id,
        rl.type_id,
        rt.report_name,
        rl.site_id,
        rl.report_date,
        rl.from_date,
        rl.to_date,
        rl.month,
        rl.year,
        rl.created_date,
        get_username(rl.created_by) created_by,
        CONCAT_WS(',', rl.email1, 
                        NULLIF(rl.email2, ''), 
                        NULLIF(rl.email3, '')
        )AS emails_combined FROM 
        ".DB_PREFIX."reportlogs rl LEFT JOIN  tbl_reporttypes rt ON rl.type_id = rt.type_id ORDER BY 
        rl.reportlog_id DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($data)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'data' => $data
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function addReportentry($data){
      try{
        extract($data);
        $created_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO ".DB_PREFIX."reportlogs(type_id,report_date,site_id,from_date,to_date,month,year,email1,email2,email3,created_date,created_by)values(:type_id,:report_date,:site_id,:from_date,:to_date,:month,:year,:email1,:email2,:email3,:created_date,:created_by)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':type_id',$type_id);
        $stmt->bindParam(':report_date',$report_date);
        $stmt->bindParam(':site_id',$site_id);
        $stmt->bindParam(':from_date',$from_date);
        $stmt->bindParam(':to_date',$to_date);
        $stmt->bindParam(':month',$month);
        $stmt->bindParam(':year',$year);
        $stmt->bindParam(':email1',$email1);
        $stmt->bindParam(':email2',$email2);
        $stmt->bindParam(':email3',$email3);
        $stmt->bindParam(':created_date',$created_date);
        $stmt->bindParam(':created_by',$created_by);
        $stmt->execute();
        $reportlog_id = $this->connection->lastInsertId();
          if($reportlog_id){
            $status = array(
              'status' => "200",
              'message' => "Report Entry Added Successfully",
              'reportlog_id' => $reportlog_id);
          }
          else{
            $status = array(
              'status' => "304",
              'message' => "Report Entry Not Added Successfully");
          } 
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getAllSiteReports($data){
      try{
        extract($data);
        $sites = array();
        $sql = "SELECT * FROM ".DB_PREFIX."sites where site_status != 9";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $sites_data = $stmt->fetchAll(PDO::FETCH_OBJ); 
        if(!empty($sites_data)){
          foreach ($sites_data as $k => $val) {          
            $sql1 = "SELECT site_name,get_StateName(state) AS state_name,get_cityName(city) city_name FROM ".DB_PREFIX."sites where site_id =:site_id AND site_status != 9"; 
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bindParam(":site_id",$val->site_id);
            $stmt1->execute();
            $sites[$k]['sites_data'] = $stmt1->fetch(PDO::FETCH_OBJ); 
            $sql_at = "SELECT * FROM ".DB_PREFIX."attendance WHERE site_id =:site_id AND attn_date = :attn_date AND status != 9";
            $stmt_at = $this->connection->prepare($sql_at);
            $stmt_at->bindParam(":attn_date",$report_date);
            $stmt_at->bindParam(":site_id",$val->site_id);
            $stmt_at->execute();
            $sites[$k]['attn_data'] = $stmt_at->fetch(PDO::FETCH_OBJ);
            $sql_b = "SELECT bms_date,bms_done,total_services FROM ".DB_PREFIX."bms WHERE site =:site_id AND bms_date = :bms_date AND status != 9";
            $stmt_b = $this->connection->prepare($sql_b);
            $stmt_b->bindParam(":bms_date",$report_date);
            $stmt_b->bindParam(":site_id",$val->site_id);
            $stmt_b->execute();
            $sites[$k]['bms_data'] = $stmt_b->fetch(PDO::FETCH_OBJ);
            $sql_e = "SELECT ecwdate,ecwdone,total_cleaning_works FROM ".DB_PREFIX."extracleaningworks WHERE site =:site_id AND  ecwdate = :ecwdate AND status != 9";
            $stmt_e = $this->connection->prepare($sql_e);
            $stmt_e->bindParam(":ecwdate",$report_date);
            $stmt_e->bindParam(":site_id",$val->site_id);
            $stmt_e->execute();
            $sites[$k]['ecw_data'] = $stmt_e->fetch(PDO::FETCH_OBJ);
            $sql_n = "SELECT nrwdate,nrwdone,total_works FROM ".DB_PREFIX."nonroutineworks WHERE site =:site_id AND  nrwdate = :nrwdate AND status != 9";
            $stmt_n = $this->connection->prepare($sql_n);
            $stmt_n->bindParam(":nrwdate",$report_date);
            $stmt_n->bindParam(":site_id",$val->site_id);
            $stmt_n->execute();
            $sites[$k]['nrw_data'] = $stmt_n->fetch(PDO::FETCH_OBJ);
            $sql_m = "SELECT mcudate,mcudone,total_mc_updates FROM ".DB_PREFIX."machineryupdates WHERE site =:site_id AND mcudate = :mcudate AND status != 9";
            $stmt_m = $this->connection->prepare($sql_m);
            $stmt_m->bindParam(":mcudate",$report_date);
            $stmt_m->bindParam(":site_id",$val->site_id);
            $stmt_m->execute();
            $sites[$k]['mcu_data'] = $stmt_m->fetch(PDO::FETCH_OBJ);
            $sql_l = "SELECT logmsgdate,logmsgdone,total_services FROM ".DB_PREFIX."logmessages WHERE site =:site_id AND logmsgdate = :logmsgdate AND status != 9";
            $stmt_l = $this->connection->prepare($sql_l);
            $stmt_l->bindParam(":logmsgdate",$report_date);
            $stmt_l->bindParam(":site_id",$val->site_id);
            $stmt_l->execute();
            $sites[$k]['logmsg_data'] = $stmt_l->fetch(PDO::FETCH_OBJ);
          }
        }
        if(!empty($sites)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'sites_reports' => $sites
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    /* MMR */
    public function addMmr($data){
      extract($data);
      $created_date = date('Y-m-d H:i:s');
      $emp_picture1 = '';
        if( (isset($_FILES['emp_picture1'])) && (!empty($_FILES['emp_picture1']['name'])) ){
          $filedir = IMGUPLOAD."mmr/emp"; 
          $randName = rand(10101010, 9090909090);
          $newName = 'emp_pic1_'.$randName;
          $ext = substr($_FILES['emp_picture1']['name'], strrpos($_FILES['emp_picture1']['name'], '.') + 1); 
          $ImageUpload->File = $_FILES['emp_picture1'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewWidth = '283';
          $ImageUpload->NewHeight = '319';
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $emp_picture1 = $newName.".".$ext;                  
        } 
        $_POST['emp_picture1'] = $emp_picture1;
        $emp_picture2 = '';
        if( (isset($_FILES['emp_picture2'])) && (!empty($_FILES['emp_picture2']['name'])) ){
          $filedir = IMGUPLOAD."mmr/emp/"; 
          $randName = rand(10101010, 9090909090);
          $fileName = $_FILES['emp_picture2']['name'];  
          $position = strpos($fileName, '.');                  
          $result = 'emp_pic2_';  
          $newName = $result.$randName;
          $ext = substr($_FILES['emp_picture2']['name'], strrpos($_FILES['emp_picture2']['name'], '.') + 1); 
          $ImageUpload->File = $_FILES['emp_picture2'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewWidth = '283';
          $ImageUpload->NewHeight = '319';
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $emp_picture2 = $newName.".".$ext;                  
        } 
        $_POST['emp_picture2'] = $emp_picture2;
        $ec_attachments = [];
        if (isset($_FILES['g_ec_attachments'])) {
          $filedir = IMGUPLOAD . "mmr/ecw/"; 
          foreach ($_FILES['g_ec_attachments']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
              $randName = rand(10101010, 9090909090);
              $result = 'ecw_';  
              $newName = $result . $randName;
              $ext = pathinfo($fileName, PATHINFO_EXTENSION);
              $file = [
                  'name' => $fileName,
                  'type' => $_FILES['g_ec_attachments']['type'][$key],
                  'tmp_name' => $_FILES['g_ec_attachments']['tmp_name'][$key],
                  'error' => $_FILES['g_ec_attachments']['error'][$key],
                  'size' => $_FILES['g_ec_attachments']['size'][$key],
              ];
              $ImageUpload->File = $file;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '283';
              $ImageUpload->NewHeight = '319';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $ec_attachments[] = $newName.".".$ext; // Collect new image name
            }
          }
          $_POST['ec_attachments'] = $ec_attachments;
        }
        $training_attachments = [];
        if (isset($_FILES['g_training_pics'])) {
          $filedir = IMGUPLOAD . "mmr/trainings/"; 
          foreach ($_FILES['g_training_pics']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
              $randName = rand(10101010, 9090909090);
              $result = 'training_';  
              $newName = $result . $randName;
              $ext = pathinfo($fileName, PATHINFO_EXTENSION);
              $file = [
                  'name' => $fileName,
                  'type' => $_FILES['g_training_pics']['type'][$key],
                  'tmp_name' => $_FILES['g_training_pics']['tmp_name'][$key],
                  'error' => $_FILES['g_training_pics']['error'][$key],
                  'size' => $_FILES['g_training_pics']['size'][$key],
              ];
              $ImageUpload->File = $file;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '283';
              $ImageUpload->NewHeight = '319';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $training_attachments[] = $newName.".".$ext; // Collect new image name
            }
          }
          $_POST['training_attachments'] = $training_attachments;
        }
        $attendance_sheet1 = '';
        if(!empty($_FILES['attendance_sheet1']['name'])){
          $filedir = IMGUPLOAD . "mmr/trainings/"; 
          $randName = strtotime('now');
          $newName = "attndancesheet1".'_'. $randName;
          $ext = substr($_FILES['attendance_sheet1']['name'], strrpos($_FILES['attendance_sheet1']['name'], '.') + 1);
          $ImageUpload->File = $_FILES['attendance_sheet1'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $attendance_sheet1 = $newName.".".strtolower($ext);
        }
        $_POST['training1_attendance'] = $attendance_sheet1;
        $attendance_sheet2 = '';
        if(!empty($_FILES['attendance_sheet2']['name'])){
          $filedir = IMGUPLOAD . "mmr/trainings/"; 
          $randName = strtotime('now');
          $newName = "attndancesheet2".'_'. $randName;
          $ext = substr($_FILES['attendance_sheet2']['name'], strrpos($_FILES['attendance_sheet2']['name'], '.') + 1);
          $ImageUpload->File = $_FILES['attendance_sheet2'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $attendance_sheet2 = $newName.".".strtolower($ext);
        }
        $_POST['training2_attendance'] = $attendance_sheet2;
        $attendance_sheet3 = '';
        if(!empty($_FILES['attendance_sheet3']['name'])){
          $filedir = IMGUPLOAD . "mmr/trainings/"; 
          $randName = strtotime('now');
          $newName = "attndancesheet3".'_'. $randName;
          $ext = substr($_FILES['attendance_sheet3']['name'], strrpos($_FILES['attendance_sheet3']['name'], '.') + 1);
          $ImageUpload->File = $_FILES['attendance_sheet3'];
          $ImageUpload->method = 1;
          $ImageUpload->SavePath = $filedir;
          $ImageUpload->NewName = $newName;
          $ImageUpload->OverWrite = true;
          $err = $ImageUpload->UploadFile();
          $attendance_sheet3 = $newName.".".strtolower($ext);
        }
        $_POST['training3_attendance'] = $attendance_sheet3;
      $sql = "INSERT INTO ".DB_PREFIX."mmr(mmr_date,mmr_month,mmr_year,unit_mgr,site,ops_mgr,ops_mgremail,city,state,mmr_status,site_address,device,status,created_date,created_by) VALUES(:mmr_date,:mmr_month,:mmr_year,:unit_mgr,:site,:ops_mgr,:ops_mgremail,:city,:state,:mmr_status,:site_address,:device,:status,:created_date,:created_by)";
      $device = 'Web'; 
      $status = 0;
      $stmt = $this->connection->prepare($sql); 
      $stmt->bindParam(':mmr_date', $mmr_date);
      $stmt->bindParam(':mmr_month', $mmr_month);
      $stmt->bindParam(':mmr_year', $mmr_year);
      $stmt->bindParam(':unit_mgr', $unit_mgr);
      $stmt->bindParam(':site', $site);
      $stmt->bindParam(':ops_mgr', $ops_mgr);
      $stmt->bindParam(':ops_mgremail', $ops_mgremail);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state', $state);
      $stmt->bindParam(':mmr_status', $mmr_status);
      $stmt->bindParam(':site_address', $site_address);
      $stmt->bindParam(':device', $device);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':created_by', $created_by);
      $stmt->execute();
      $mmr_id = $this->connection->lastInsertId();
      if($mmr_id > 0){
        for ($i=0; $i < count($staff) ; $i++) {
          $sql2 = "INSERT INTO ".DB_PREFIX."mmrattendance(mmr_id,staff,staff_approved,no_of_days,budget,actual_present,percentage,odc,status,created_date,created_by) VALUES(:mmr_id, :staff, :staff_approved, :no_of_days, :budget, :actual_present, :percentage, :odc, :status, :created_date, :created_by)";
           $status = 0;
          $stmt2 = $this->connection->prepare($sql2); 
          $stmt2->bindParam(':mmr_id', $mmr_id); 
          $stmt2->bindParam(':staff', $staff[$i]); 
          $stmt2->bindParam(':staff_approved', $staff_approved[$i]); 
          $stmt2->bindParam(':no_of_days', $no_of_days[$i]); 
          $stmt2->bindParam(':budget', $budget[$i]); 
          $stmt2->bindParam(':actual_present', $actual_present[$i]); 
          $stmt2->bindParam(':percentage', $percentage[$i]); 
          $stmt2->bindParam(':odc', $odc[$i]); 
          $stmt2->bindParam(':status', $status);
          $stmt2->bindParam(':created_date', $created_date);
          $stmt2->bindParam(':created_by', $created_by);
          $stmt2->execute();
        }
        if(isset($month)){
          for ($j=0; $j < count($month); $j++) {
            $sql3 = "INSERT INTO ".DB_PREFIX."mmrattnprevmonths(mmr_id,month,year,hkstaff,hksupervisor,status,created_date,created_by) VALUES(:mmr_id,:month,:year,:hkstaff,:hksupervisor,:status,:created_date,:created_by)";
             $status = 0;      
            $stmt3 = $this->connection->prepare($sql3); 
            $stmt3->bindParam(':mmr_id', $mmr_id); 
            $stmt3->bindParam(':month', $month[$j]); 
            $stmt3->bindParam(':year', $year[$j]); 
            $stmt3->bindParam(':hkstaff', $hkstaff[$j]); 
            $stmt3->bindParam(':hksupervisor', $hksupervisor[$j]);  
            $stmt3->bindParam(':status', $status);
            $stmt3->bindParam(':created_date', $created_date);
            $stmt3->bindParam(':created_by', $created_by);
            $stmt3->execute();
          }
        }
        if(isset($ecw_date)){
          for ($k=0; $k < count($schedule_type) ; $k++) {
            $sql4 = "INSERT INTO ".DB_PREFIX."mmrecworks(mmr_id,schedule_type,ecw_date,floor,area,complaint,status,created_date,created_by) VALUES(:mmr_id, :schedule_type, :ecw_date, :ecwfloor, :ecwarea, :ecwcomplaint, :status, :created_date, :created_by)";
             $status = 0;      
            $stmt4 = $this->connection->prepare($sql4);
            $ecwdate = ''; 
            $ecwdate = date("Y-m-d",strtotime(($ecw_date[$k])));
            $stmt4->bindParam(':mmr_id', $mmr_id); 
            $stmt4->bindParam(':schedule_type', $schedule_type[$k]); 
            $stmt4->bindParam(':ecw_date', $ecwdate); 
            $stmt4->bindParam(':ecwfloor', $ecwfloor[$k]); 
            $stmt4->bindParam(':ecwarea', $ecwarea[$k]); 
            $stmt4->bindParam(':ecwcomplaint', $ecwcomplaint[$k]);  
            $stmt4->bindParam(':status', $status);
            $stmt4->bindParam(':created_date', $created_date);
            $stmt4->bindParam(':created_by', $created_by);
            $stmt4->execute();
          }
        }
        if(isset($material_id)){
          for ($m=0; $m < count($quantity) ; $m++) {
            $sql5 = "INSERT INTO ".DB_PREFIX."mmrmaterialsupply(mmr_id,material_id,quantity,measuring_units,provided_by,status,created_date,created_by) VALUES(:mmr_id,:material_id,:quantity,:measuring_units,:provided_by,:status,:created_date, :created_by)";
             $status = 0;      
            $stmt5 = $this->connection->prepare($sql5); 
            $stmt5->bindParam(':mmr_id', $mmr_id); 
            $stmt5->bindParam(':material_id', $material_id[$m]);  
            $stmt5->bindParam(':quantity', $quantity[$m]); 
            $stmt5->bindParam(':measuring_units', $measuring_units[$m]); 
            $stmt5->bindParam(':provided_by', $provided_by[$m]);  
            $stmt5->bindParam(':status', $status);
            $stmt5->bindParam(':created_date', $created_date);
            $stmt5->bindParam(':created_by', $created_by);
            $stmt5->execute();
          }
        }
        if(isset($item_id)){
          for ($n=0; $n < count(@$item_id) ; $n++) {
            $sql6 = "INSERT INTO ".DB_PREFIX."mmrlostfound(mmr_id,item_id,floor,area,found_by,handover_to,status,created_date,created_by) VALUES(:mmr_id,:item_id,:lffloor,:lfarea,:found_by,:handover_to,:status,:created_date,:created_by)";
            $status = 0; 
            $stmt6 = $this->connection->prepare($sql6); 
            $stmt6->bindParam(':mmr_id', $mmr_id); 
            $stmt6->bindParam(':item_id', $item_id[$n]);  
            $stmt6->bindParam(':lffloor', $lffloor[$n]); 
            $stmt6->bindParam(':lfarea', $lfarea[$n]); 
            $stmt6->bindParam(':found_by', $found_by[$n]);  
            $stmt6->bindParam(':handover_to', $handover_to[$n]);  
            $stmt6->bindParam(':status', $status);
            $stmt6->bindParam(':created_date', $created_date);
            $stmt6->bindParam(':created_by', $created_by);
            $stmt6->execute();
          }
        }
        if(isset($audit_id)){
          for($ad=0; $ad < count(@$audit_id) ; $ad++) {
            $audit_date[$ad] = date("Y-m-d H:i:s",strtotime($audit_date[$ad]));
            $sql_ad = "INSERT INTO ".DB_PREFIX."mmrauditdetails(mmr_id,month_id,audit_date,audit_count,audit_id,status,created_date,created_by) VALUES(:mmr_id, :month_id, :audit_date, :audit_count,:audit_id,:status,:created_date,:created_by)";
            $status = 0;
            $stm_ad = $this->connection->prepare($sql_ad); 
            $stm_ad->bindParam(':mmr_id', $mmr_id); 
            $stm_ad->bindParam(':month_id', $month_id[$ad]); 
            $stm_ad->bindParam(':audit_date', $audit_date[$ad]); 
            $stm_ad->bindParam(':audit_count', $audit_count[$ad]); 
            $stm_ad->bindParam(':audit_id', $audit_id[$ad]); 
            $stm_ad->bindParam(':status', $status); 
            $stm_ad->bindParam(':created_date', $created_date); 
            $stm_ad->bindParam(':created_by', $created_by); 
            $stm_ad->execute();
          }
        }
        if(isset($register_id)){
          for($rg=0; $rg < count(@$register_id) ; $rg++) {
            $sql_rg = "INSERT INTO ".DB_PREFIX."mmrrecord_details(mmr_id,register_id,file_id,status,created_date,created_by) VALUES(:mmr_id, :register_id, :file_id,:status,:created_date,:created_by)";
            $status = 0;
            $stm_rg = $this->connection->prepare($sql_rg); 
            $stm_rg->bindParam(':mmr_id', $mmr_id); 
            $stm_rg->bindParam(':register_id', $register_id[$rg]); 
            $stm_rg->bindParam(':file_id', $file_id[$rg]);  
            $stm_rg->bindParam(':status', $status); 
            $stm_rg->bindParam(':created_date', $created_date); 
            $stm_rg->bindParam(':created_by', $created_by); 
            $stm_rg->execute();
          }
        }
        if($new_staff != ''){
          $sql7 = "INSERT INTO ".DB_PREFIX."mmrstaff(mmr_id,new_staff,left_staff, status,created_date,created_by) VALUES(:mmr_id, :new_staff, :left_staff,  :status,:created_date,:created_by)";
          $status = 0;
          $stmt7 = $this->connection->prepare($sql7); 
          $stmt7->bindParam(':mmr_id', $mmr_id); 
          $stmt7->bindParam(':new_staff', $new_staff); 
          $stmt7->bindParam(':left_staff', $left_staff); 
          // $stmt7->bindParam(':total_staff', $total_staff); 
          $stmt7->bindParam(':status', $status); 
          $stmt7->bindParam(':created_date', $created_date); 
          $stmt7->bindParam(':created_by', $created_by); 
          $stmt7->execute();
        }
        if(isset($machine_id)){
          for($mc=0; $mc < count(@$machine_id) ; $mc++) {   
            $service_date[$mc] = date("Y-m-d H:i:s",strtotime($service_date[$mc])); 
            if($provided_by[$mc] == 0) {
              $provided_by[$mc] = 5;
            }
            if($provided_by[$mc] == 1) {
              $provided_by[$mc] = 6;
            } 
            $sql_mc = "INSERT INTO ".DB_PREFIX."mmrmachinery(mmr_id,machine_id,company_id,mc_count,condition_id,service_date,provided_by,status,created_date,created_by) VALUES(:mmr_id, :machine_id, :company_id, :mc_count,:condition_id,:service_date,:provided_by,:status,:created_date,:created_by)";
            $status = 0;
            $stm_mc = $this->connection->prepare($sql_mc); 
            $stm_mc->bindParam(':mmr_id', $mmr_id); 
            $stm_mc->bindParam(':machine_id', $machine_id[$mc]); 
            $stm_mc->bindParam(':company_id', $company_id[$mc]);  
            $stm_mc->bindParam(':mc_count', $mc_count[$mc]);  
            $stm_mc->bindParam(':condition_id', $condition_id[$mc]);  
            $stm_mc->bindParam(':service_date', $service_date[$mc]);  
            $stm_mc->bindParam(':provided_by', $provided_by[$mc]);  
            $stm_mc->bindParam(':status', $status); 
            $stm_mc->bindParam(':created_date', $created_date); 
            $stm_mc->bindParam(':created_by', $created_by); 
            $stm_mc->execute();
          }
        }
        if($requirement_id != ''){
          for($rq=0; $rq < count(@$requirement_id) ; $rq++) {  
            $sql_rq = "INSERT INTO ".DB_PREFIX."mmrrequirements(mmr_id,requirement_id,status,created_date,created_by) VALUES(:mmr_id, :requirement_id, :status,:created_date,:created_by)";
            $status = 0;
            $stm_rq = $this->connection->prepare($sql_rq); 
            $stm_rq->bindParam(':mmr_id', $mmr_id); 
            $stm_rq->bindParam(':requirement_id', $requirement_id[$rq]); 
            $stm_rq->bindParam(':status', $status); 
            $stm_rq->bindParam(':created_date', $created_date); 
            $stm_rq->bindParam(':created_by', $created_by); 
            $stm_rq->execute();
          }
        }
        if($emp_name1 !=''){
          $sql7 = "INSERT INTO ".DB_PREFIX."mmremployees(mmr_id,emp_name,emp_picture,emp_criteria,status,created_date,created_by) VALUES(:mmr_id, :emp_name,  :emp_picture, :emp_criteria, :status, :created_date, :created_by)";
           $status = 0;
           $empCriteria1 = '';   
           $empCriteria1 = implode(",",$emp_criteria1);
          $stmt7 = $this->connection->prepare($sql7); 
          $stmt7->bindParam(':mmr_id', $mmr_id); 
          $stmt7->bindParam(':emp_name', $emp_name1);  
          $stmt7->bindParam(':emp_picture', $emp_picture1); 
          $stmt7->bindParam(':emp_criteria', $empCriteria1);  
          $stmt7->bindParam(':status', $status);
          $stmt7->bindParam(':created_date', $created_date);
          $stmt7->bindParam(':created_by', $created_by);
          $stmt7->execute();
        }
        if($emp_name2 !=''){
          $sql77 = "INSERT INTO ".DB_PREFIX."mmremployees(mmr_id,emp_name,emp_picture,emp_criteria,status,created_date,created_by) VALUES(:mmr_id, :emp_name,  :emp_picture, :emp_criteria, :status, :created_date, :created_by)";
           $status = 0;      
          $empCriteria2 = '';   
          $empCriteria2 = implode(",",$emp_criteria2);
          $stmt77 = $this->connection->prepare($sql77); 
          $stmt77->bindParam(':mmr_id', $mmr_id); 
          $stmt77->bindParam(':emp_name', $emp_name2);  
          $stmt77->bindParam(':emp_picture', $emp_picture2); 
          $stmt77->bindParam(':emp_criteria', $empCriteria2);  
          $stmt77->bindParam(':status', $status);
          $stmt77->bindParam(':created_date', $created_date);
          $stmt77->bindParam(':created_by', $created_by);
          $stmt77->execute();
        }
        if(isset($reported_on)){
          for ($b=0; $b < count($reported_on) ; $b++) {
            $sql8 = "INSERT INTO ".DB_PREFIX."mmrbmssnag(mmr_id,reported_on,floor,area,complaint,status,created_date,created_by) VALUES(:mmr_id, :reported_on,  :bmsfloor, :bmsarea, :bmscomplaint,:status, :created_date, :created_by)";
            $status = 0;      
            $reporteddate = '';
            $reporteddate = date("Y-m-d",strtotime($reported_on[$b]));
            $stmt8 = $this->connection->prepare($sql8); 
            $stmt8->bindParam(':mmr_id', $mmr_id); 
            $stmt8->bindParam(':reported_on', $reporteddate);  
            $stmt8->bindParam(':bmsfloor', $bmsfloor[$b]); 
            $stmt8->bindParam(':bmsarea', $bmsarea[$b]);  
            $stmt8->bindParam(':bmscomplaint', $bmscomplaint[$b]);  
            $stmt8->bindParam(':status', $status);
            $stmt8->bindParam(':created_date', $created_date);
            $stmt8->bindParam(':created_by', $created_by);
            $stmt8->execute();
          }
        }
        if(isset($training_date)){
          for ($t=0; $t < count($trainer_name) ; $t++) {
            $sql9 = "INSERT INTO ".DB_PREFIX."mmrtrainings(mmr_id,trainer_name,training_date,topics,people_cnt,designation, status,created_date,created_by) VALUES(:mmr_id, :trainer_name,  :training_date, :topics, :people_cnt,:designation,:status, :created_date, :created_by)";
            $status = 0;  
            $trainingDate = '';
            $trainingDate = date("Y-m-d",strtotime($training_date[$t]));
            $stmt9 = $this->connection->prepare($sql9); 
            $stmt9->bindParam(':mmr_id', $mmr_id); 
            $stmt9->bindParam(':trainer_name', $trainer_name[$t]);  
            $stmt9->bindParam(':training_date', $trainingDate); 
            $stmt9->bindParam(':topics', $topics[$t]);  
            $stmt9->bindParam(':people_cnt', $people_cnt[$t]);  
            $stmt9->bindParam(':designation', $designation[$t]);  
            $stmt9->bindParam(':status', $status);
            $stmt9->bindParam(':created_date', $created_date);
            $stmt9->bindParam(':created_by', $created_by);
            $stmt9->execute();
          }
        }
        if(isset($training1_attendance) || isset($training2_attendance) || isset($training3_attendance)){
          $sql_att = "INSERT INTO ".DB_PREFIX."mmr_training_attn_attachments(mmr_id,training1_attendance,training2_attendance,training3_attendance , status,created_date,created_by) VALUES(:mmr_id, :training1_attendance,:training2_attendance,:training3_attendance ,:status, :created_date, :created_by)";
            $status = 0;  
            $stmt_att = $this->connection->prepare($sql_att); 
            $stmt_att->bindParam(':mmr_id', $mmr_id);   
            $stmt_att->bindParam(':training1_attendance', $training1_attendance);
            $stmt_att->bindParam(':training2_attendance', $training2_attendance);
            $stmt_att->bindParam(':training3_attendance', $training3_attendance);
            $stmt_att->bindParam(':status', $status);
            $stmt_att->bindParam(':created_date', $created_date);
            $stmt_att->bindParam(':created_by', $created_by);
            $stmt_att->execute();
        }
        if(isset($event_month)){
          for ($c=0; $c < count($event_month) ; $c++) {
            $sql10 = "INSERT INTO ".DB_PREFIX."mmrevents(mmr_id,event_month,event_date,events_no,event,status,created_date,created_by) VALUES(:mmr_id, :event_month,  :event_date, :events_no, :event,:status, :created_date, :created_by)";
            $status = 0;  
            $eventdate='';
            $eventdate = date("Y-m-d",strtotime($event_date[$c]));    
            $stmt10 = $this->connection->prepare($sql10); 
            $stmt10->bindParam(':mmr_id', $mmr_id); 
            $stmt10->bindParam(':event_month', $event_month[$c]);  
            $stmt10->bindParam(':event_date', $eventdate); 
            $stmt10->bindParam(':events_no', $events_no[$c]);  
            $stmt10->bindParam(':event', $event[$c]);   
            $stmt10->bindParam(':status', $status);
            $stmt10->bindParam(':created_date', $created_date);
            $stmt10->bindParam(':created_by', $created_by);
            $stmt10->execute();
          }
        }
        if (isset($ec_attachments) && is_array($ec_attachments)) {
          foreach ($ec_attachments as $attachment) {
            $sqlAttachment = "INSERT INTO tbl_mmrecwattachments (mmr_id, attachment_name, status,created_date,created_by) VALUES (:mmr_id, :attachment_name, :status,:created_date,:created_by)";
            $stmtAttachment = $this->connection->prepare($sqlAttachment);
            $status = 0; // Assuming a default status of 0
            $stmtAttachment->bindParam(':mmr_id', $mmr_id, PDO::PARAM_INT);
            $stmtAttachment->bindParam(':attachment_name', $attachment, PDO::PARAM_STR);
            $stmtAttachment->bindParam(':status', $status, PDO::PARAM_INT);
            $stmtAttachment->bindParam(':created_date', $created_date);
            $stmtAttachment->bindParam(':created_by', $created_by);
            $stmtAttachment->execute();
          }
        }
        if (isset($training_attachments) && is_array($training_attachments)) {
          foreach ($training_attachments as $attachment) {
            $sql12 = "INSERT INTO tbl_mmrtraining_attachments (mmr_id,attachment_name,status,created_date,created_by) VALUES (:mmr_id,:attachment_name,:status,:created_date,:created_by)";
            $stmt12 = $this->connection->prepare($sql12);
            $status = 0; // Assuming a default status of 0
            $stmt12->bindParam(':mmr_id', $mmr_id, PDO::PARAM_INT);
            $stmt12->bindParam(':attachment_name', $attachment, PDO::PARAM_STR);
            $stmt12->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt12->bindParam(':created_date', $created_date);
            $stmt12->bindParam(':created_by', $created_by);
            $stmt12->execute();
          }
        }
        $status = array(
         'status' =>"200",
         'message' =>"MMR Added Successfully",
         'mmr_id' => $mmr_id); 
       }else{
        $status = array(
          'status' => "204",
          'message' => "No Data Added"
        );
       }
      return $status;
    }
    public function getMmrSitedetails($data){
      extract($data);
      try{
        $sql = "SELECT site_id,concat('".IMGURL."sites/',site_logo) site_logo,building_name,building_image,building_code,site_name,operations_mgr,get_empName(operations_mgr) operations_manager,get_empEmail(operations_mgr) operations_mgremail,get_empName(unit_mgr) unit_manager,unit_mgr,get_cityName(`city`) city,city as city_id,state as state_id,get_stateName(state)state,weekly_off,site_address,staff,supervisors,unit_mgrs,facility_mgrs,asst_facility_mgrs,executives,office_boys,stewards,pantry_boys,washroom_maintanence,kitchen_staff,others,approved_staff from ".DB_PREFIX."sites where site_status='0' and unit_mgr=:unit_mgr";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':unit_mgr',$emp_id);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'site_details' => $res
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getMmrBms($data){
      extract($data);
      try{
        $bms_month = date("Y-m",strtotime($month));  
        $bms_date = $bms_month . "-01";
        $sql = "SELECT b.site,b.bms_id,b.bms_date,bs.floor,bs.sub_area,bs.work,date_format(bs.report_date,'%d %b,%Y') AS report_date FROM `tbl_bms` b INNER JOIN tbl_bmsdailyservice bs ON b.bms_id = bs.bms_id WHERE b.bms_date >= :bms_date AND b.bms_date <= LAST_DAY(:bms_date)  AND b.site = :site_id AND b.status != 9 AND bs.status != 9 AND bs.snag_status = 'Open' ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindParam(':bms_date', $bms_date, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success",
            'bms' => $res, );
        }else {
          $status = array(
            'status' => "204",
             'message' => "No Data Found"); 
        }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getMmrEcw($data){
      extract($data);
      try{
        $ecw_month = date("Y-m",strtotime($month));
        $ecw_date = $ecw_month . "-01";
        $sql = "SELECT e.site,date_format(e.ecwdate,'%d %b,%Y') AS ecwdate,es.floor,es.sub_area,es.work FROM `tbl_extracleaningworks` e INNER JOIN `tbl_ecwdailyservice` es ON e.ecw_id = es.ecw_id WHERE e.ecwdate >= :ecw_date AND e.ecwdate <= LAST_DAY(:ecw_date)  AND e.site = :site_id AND e.status !=9 AND es.status !=9 ";  
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindParam(':ecw_date', $ecw_date, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success",
            'ecw' => $res, );
        }else {
          $status = array(
            'status' => "204",
             'message' => "No Data Found"); 
        }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getMmrMcu($data){
      extract($data);
      try{
        $mcu_month = date("Y-m",strtotime($month));
        $mcu_date = $mcu_month . "-01";
        $sql = "SELECT m.site,m.mcudate,ms.machine_name,ms.machine_condition,ms.provided_by,ms.machine_count,date_format(ms.service_date,'%d %b,%Y') AS service_date FROM `tbl_machineryupdates` m INNER JOIN `tbl_mcudailyservice` ms ON m.mcupdate_id = ms.mcupdate_id WHERE m.mcudate >= :mcu_date AND m.mcudate <= LAST_DAY(:mcu_date)  AND m.site = :site_id AND m.status !=9 AND ms.status !=9 ";  
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindParam(':mcu_date', $mcu_date, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($res)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success",
            'mcu' => $res, );
        }else {
          $status = array(
            'status' => "204",
            'message' => "No Data Found"); 
        }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getMmrattendance($data){
      extract($data);
      try{
        $attn_month = date("Y-m",strtotime($month));  
        $attn_date = $attn_month . "-01";
        $monthlyData = [];
        $sql = "SELECT get_hkstaffcnt(site_id) hkstaffcnt,get_hksupervisorcnt(site_id) hksupervisorscnt,   
                get_unitmanagerscnt(site_id) unit_mngrscnt ,get_facility_mgrscnt(site_id) facility_mngrscnt , get_asstfacility_mgrscnt(site_id) asst_facility_mngrscnt , get_executivescnt(site_id) executviescnt ,     
              SUM(hkoperator_present+ofcboys_present+gardenstaff_present+others_present) hkstaff_present,
              SUM(supervisor_present) hksuprvsr_present, sum(um_present) unit_mngrs_present, sum(fm_present) facility_mngrs_present, sum(afm_present) asst_fac_mngrs_present,sum(exec_present) exec_present,  DAY(LAST_DAY(:attn_date)) AS days_in_month
          FROM " . DB_PREFIX . "attendance WHERE attn_date >= :attn_date AND attn_date <= LAST_DAY(:attn_date) 
          AND site_id = :site_id";  
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindParam(':attn_date', $attn_date, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        if ($res) {
          $hkstaff_percentage = ($res->hkstaff_present / ($res->hkstaffcnt * $res->days_in_month)) * 100;
          $hksupervisor_percentage = ($res->hksuprvsr_present / ($res->hksupervisorscnt * $res->days_in_month)) * 100;
          $unit_mngrs_percentage = ($res->unit_mngrs_present / ($res->unit_mngrscnt * $res->days_in_month)) * 100;
          $facility_mngrs_percentage = ($res->facility_mngrs_present / ($res->facility_mngrscnt * $res->days_in_month)) * 100;
          $asst_fac_mngrs_percentage = ($res->asst_fac_mngrs_present / ($res->asst_facility_mngrscnt * $res->days_in_month)) * 100;
          $executives_percentage = ($res->exec_present / ($res->executviescnt * $res->days_in_month)) * 100;
          $monthlyData[] = [
            'monthName' => date("m", strtotime($attn_date)),
            'year' => date("Y", strtotime($attn_date)),
            'hkstaff_percentage' => number_format($hkstaff_percentage, 2),
            'hksupervisor_percentage' => number_format($hksupervisor_percentage, 2)
          ];
        }
        for ($i = 1; $i <= 2; $i++) {
          $previous_month_date = date("Y-m-01", strtotime("-$i month", strtotime($attn_date)));
          $this->addMonthlyData($stmt, $previous_month_date, $monthlyData);
        }
        if(!empty($res)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success",
            'attendance' => $res,
            'monthlyData' => $monthlyData);
        }else {
          $status = array(
            'status' => "204",
             'message' => "No Data Found"); 
        }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    function addMonthlyData($stmt, $date, &$monthlyData) {
      $stmt->bindParam(':attn_date', $date, PDO::PARAM_STR);
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      if ($res && $res->hkstaffcnt > 0 && $res->hksupervisorscnt > 0) {
        $hkstaff_percentage = ($res->hkstaff_present / ($res->hkstaffcnt * $res->days_in_month)) * 100;
        $hksupervisor_percentage = ($res->hksuprvsr_present / ($res->hksupervisorscnt * $res->days_in_month)) * 100;
        $monthlyData[] = [
            'monthName' => date("m", strtotime($date)),
            'year' => date("Y", strtotime($date)),
            'hkstaff_percentage' => number_format($hkstaff_percentage, 2),
            'hksupervisor_percentage' => number_format($hksupervisor_percentage, 2)
        ];
      }
    }
    public function getMmrlist(){
      try{
        $sql1 = "SELECT IFNULL(emp_id,0) emp_id FROM tbl_users WHERE user_id = :user_id";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(":user_id",$user_id);
        $stmt1->execute(); 
        $emp_data = $stmt1->fetch(PDO::FETCH_OBJ);  
        if($emp_data->emp_id == 0){
          $sql = "SELECT mmr_id,mmr_year,MONTHNAME(STR_TO_DATE(CONCAT(mmr_year, '-', mmr_month, '-01'), '%Y-%m-%d')) AS month,get_siteName(site) site,get_empName(unit_mgr) unit_mgr,get_cityName(city) city,get_stateName(state) state,
        mmr_status,site_address from ".DB_PREFIX."mmr where status!='9' order by mmr_id desc"; 
        }else{
          $sql = "SELECT mmr_id,mmr_year,MONTHNAME(STR_TO_DATE(CONCAT(mmr_year, '-', mmr_month, '-01'), '%Y-%m-%d')) AS month,get_siteName(site) site,get_empName(unit_mgr) unit_mgr,get_cityName(city) city,get_stateName(state) state,
        mmr_status,site_address from ".DB_PREFIX."mmr WHERE site_id IN (select site_id from tbl_sites where unit_mgr = :emp_id OR operations_mgr = :emp_id)  AND status != 9  order by mmr_id desc"; //echo $sql;die();
        } 
        $stmt = $this->connection->prepare($sql);
        if($emp_data->emp_id != 0){
          $stmt->bindParam(':emp_id',$emp_data->emp_id);
        }
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        $this->connection = null;
        if(!empty($res)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success",
            'mmrlist' => $res
          );
        }else {
          $status = array(
            'status' => "204",
             'message' => "No Data Found"); 
        }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getMmrDetails($data){
      try{
        extract($data);
        $mmr = array();
        $sql1 = "SELECT *,date_format(mmr_date,'%d %b,%Y') mmr_date,get_siteName(site) siteName,(select site_logo from tbl_sites where site_id=m.site) site_logo,get_cityName(city) city,city as city_id,get_stateName(state) state,state as state_id,DATE_FORMAT(STR_TO_DATE(CONCAT(mmr_year, '-', mmr_month, '-01'), '%Y-%m-%d'), '%M %Y') AS mmrmonth FROM tbl_mmr m where mmr_id = :mmr_id ";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(':mmr_id', $mmr_id);
        $stmt1->execute();
        $mmr['data'] = $stmt1->fetch(PDO::FETCH_OBJ);
        $sql2 = "SELECT * from tbl_mmrattendance where mmr_id = :mmr_id";
        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bindParam(':mmr_id', $mmr_id);
        $stmt2->execute();
        $mmr['attn'] = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $sql4 = "SELECT * FROM tbl_mmrattnprevmonths where mmr_id = :mmr_id ";
        $stmt4 = $this->connection->prepare($sql4);
        $stmt4->bindParam(':mmr_id', $mmr_id);
        $stmt4->execute();
        $mmr['prev_mnt'] = $stmt4->fetchAll(PDO::FETCH_OBJ);
        $sql5 = "SELECT * FROM tbl_mmrecworks where mmr_id = :mmr_id ";
        $stmt5 = $this->connection->prepare($sql5);
        $stmt5->bindParam(':mmr_id', $mmr_id);
        $stmt5->execute();
        $mmr['ecw'] = $stmt5->fetchAll(PDO::FETCH_OBJ);
        $sql6 = "SELECT * FROM tbl_mmrecwattachments where mmr_id = :mmr_id ";
        $stmt6 = $this->connection->prepare($sql6);
        $stmt6->bindParam(':mmr_id', $mmr_id);
        $stmt6->execute();
        $mmr['ecwattachments'] = $stmt6->fetchAll(PDO::FETCH_OBJ);
        $sql7 = "SELECT * FROM tbl_mmrmaterialsupply where mmr_id = :mmr_id ";
        $stmt7 = $this->connection->prepare($sql7);
        $stmt7->bindParam(':mmr_id', $mmr_id);
        $stmt7->execute();
        $mmr['ms'] = $stmt7->fetchAll(PDO::FETCH_OBJ);
        $sql9 = "SELECT * FROM tbl_mmrlostfound where mmr_id = :mmr_id ";
        $stmt9 = $this->connection->prepare($sql9);
        $stmt9->bindParam(':mmr_id', $mmr_id);
        $stmt9->execute();
        $mmr['mlf'] = $stmt9->fetchAll(PDO::FETCH_OBJ);
        $sql11 = "SELECT * FROM tbl_mmremployees where mmr_id = :mmr_id ";
        $stmt11 = $this->connection->prepare($sql11);
        $stmt11->bindParam(':mmr_id', $mmr_id);
        $stmt11->execute();
        $mmr['emp'] = $stmt11->fetchAll(PDO::FETCH_OBJ);
        $sql12 = "SELECT *  ,date_format(reported_on,'%d %b, %Y') reported_on FROM tbl_mmrbmssnag where mmr_id = :mmr_id ";
        $stmt12 = $this->connection->prepare($sql12);
        $stmt12->bindParam(':mmr_id', $mmr_id);
        $stmt12->execute();
        $mmr['bms'] = $stmt12->fetchAll(PDO::FETCH_OBJ);
        $sql_ad = "SELECT * ,date_format(audit_date,'%d %b, %Y') audit_date FROM tbl_mmrauditdetails where mmr_id = :mmr_id";
        $stmt_ad = $this->connection->prepare($sql_ad);
        $stmt_ad->bindParam(':mmr_id', $mmr_id);
        $stmt_ad->execute();
        $mmr['audit_details'] = $stmt_ad->fetchAll(PDO::FETCH_OBJ);
        $sql_rc = "SELECT * FROM tbl_mmrrecord_details where mmr_id = :mmr_id";
        $stmt_rc = $this->connection->prepare($sql_rc);
        $stmt_rc->bindParam(':mmr_id', $mmr_id);
        $stmt_rc->execute();
        $mmr['record_details'] = $stmt_rc->fetchAll(PDO::FETCH_OBJ);
        $sql_st = "SELECT * FROM tbl_mmrstaff where mmr_id = :mmr_id";
        $stmt_st = $this->connection->prepare($sql_st);
        $stmt_st->bindParam(':mmr_id', $mmr_id);
        $stmt_st->execute();
        $mmr['staff'] = $stmt_st->fetch(PDO::FETCH_OBJ);
        $sql_mc = "SELECT *,date_format(service_date,'%d %b, %Y') service_date FROM tbl_mmrmachinery where mmr_id = :mmr_id";
        $stmt_mc = $this->connection->prepare($sql_mc);
        $stmt_mc->bindParam(':mmr_id', $mmr_id);
        $stmt_mc->execute();
        $mmr['machines'] = $stmt_mc->fetchAll(PDO::FETCH_OBJ);
        $sql_rq = "SELECT * FROM tbl_mmrrequirements where mmr_id = :mmr_id";
        $stmt_rq = $this->connection->prepare($sql_rq);
        $stmt_rq->bindParam(':mmr_id', $mmr_id);
        $stmt_rq->execute();
        $mmr['requirements'] = $stmt_rq->fetchAll(PDO::FETCH_OBJ);
        $sql14 = "SELECT * FROM tbl_mmrtrainings where mmr_id = :mmr_id ";
        $stmt14 = $this->connection->prepare($sql14);
        $stmt14->bindParam(':mmr_id', $mmr_id);
        $stmt14->execute();
        $mmr['trainings'] = $stmt14->fetchAll(PDO::FETCH_OBJ);
        $sql14 = "SELECT * FROM tbl_mmrtraining_attachments where mmr_id = :mmr_id ";
        $stmt14 = $this->connection->prepare($sql14);
        $stmt14->bindParam(':mmr_id', $mmr_id);
        $stmt14->execute();
        $mmr['trainingattachaments'] = $stmt14->fetchAll(PDO::FETCH_OBJ);
        $sql16 = "SELECT * FROM tbl_mmrevents where mmr_id = :mmr_id ";
        $stmt16 = $this->connection->prepare($sql16);
        $stmt16->bindParam(':mmr_id', $mmr_id);
        $stmt16->execute();
        $mmr['events'] = $stmt16->fetchAll(PDO::FETCH_OBJ);
        $sql17 = "SELECT * FROM tbl_mmrpendingbills where mmr_id = :mmr_id ";
        $stmt17 = $this->connection->prepare($sql17);
        $stmt17->bindParam(':mmr_id', $mmr_id);
        $stmt17->execute();
        $mmr['pending_bills'] = $stmt17->fetchAll(PDO::FETCH_OBJ);
        if(!empty($mmr)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'mmr' => $mmr
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
        }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function updateMmr($data){
      try{  
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_mmr set mmr_date=:mmr_date,mmr_month=:mmr_month,mmr_year=:mmr_year,unit_mgr=:unit_mgr,site=:site,ops_mgr=:ops_mgr,ops_mgremail = :ops_mgremail,city =:city,state = :state,mmr_status = :mmr_status,site_address =:site_address,modified_date = :modified_date,modified_by = :modified_by where mmr_id =:mmr_id";
        $stmt = $this->connection->prepare($sql); 
        $stmt->bindParam(':mmr_date', $mmr_date);
        $stmt->bindParam(':mmr_month', $mmr_month);
        $stmt->bindParam(':mmr_year', $mmr_year);
        $stmt->bindParam(':unit_mgr', $unit_mgr);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':ops_mgr', $ops_mgr);
        $stmt->bindParam(':ops_mgremail', $ops_mgremail); 
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':mmr_status', $mmr_status);
        $stmt->bindParam(':site_address', $site_address);
        $stmt->bindParam(':modified_date', $modified_date);
        $stmt->bindParam(':modified_by', $modified_by);
        $stmt->bindParam(':mmr_id', $mmr_id);
        $res =  $stmt->execute();
        for ($i=0; $i < count($staff) ; $i++) {
          if(isset($mmrattn_id [$i]) && ($mmrattn_id [$i] != "")){
            $sql2 = "UPDATE tbl_mmrattendance set staff = :staff, staff_approved = :staff_approved, no_of_days = :no_of_days, budget = :budget, actual_present = :actual_present, percentage = :percentage, odc = :odc, modified_date = :modified_date, modified_by = :modified_by  where mmrattn_id = :mmrattn_id" ;
            $stmt2 =  $this->connection->prepare($sql2);
            $stmt2->bindParam(':staff', $staff[$i]);
            $stmt2->bindParam(':staff_approved', $staff_approved[$i]);
            $stmt2->bindParam(':no_of_days', $no_of_days[$i]);
            $stmt2->bindParam(':budget', $budget[$i]);
            $stmt2->bindParam(':actual_present', $actual_present[$i]);
            $stmt2->bindParam(':percentage', $percentage[$i]);
            $stmt2->bindParam(':odc', $odc[$i]);
            $stmt2->bindParam(':mmrattn_id', $mmrattn_id[$i]);
            $stmt2->bindParam(':modified_date', $modified_date);
            $stmt2->bindParam(':modified_by', $modified_by);
            $res2 = $stmt2->execute();
          }else{
            $sql2 = "INSERT INTO ".DB_PREFIX."mmrattendance(mmr_id,staff,staff_approved,no_of_days,budget,actual_present,percentage,odc,status,created_date,created_by) VALUES(:mmr_id, :staff, :staff_approved, :no_of_days, :budget, :actual_present, :percentage, :odc, :status, :created_date, :created_by)";
            $status = 0;        
            $stmt2 = $this->connection->prepare($sql2); 
            $stmt2->bindParam(':mmr_id', $mmr_id); 
            $stmt2->bindParam(':staff', $staff[$i]); 
            $stmt2->bindParam(':staff_approved', $staff_approved[$i]); 
            $stmt2->bindParam(':no_of_days', $no_of_days[$i]); 
            $stmt2->bindParam(':budget', $budget[$i]); 
            $stmt2->bindParam(':actual_present', $actual_present[$i]); 
            $stmt2->bindParam(':percentage', $percentage[$i]); 
            $stmt2->bindParam(':odc', $odc[$i]); 
            $stmt2->bindParam(':status', $status);
            $stmt2->bindParam(':created_date', $modified_date);
            $stmt2->bindParam(':created_by', $modified_by);
            $res2 = $stmt2->execute();
          }
        }
        for($j=0; $j < count($month) ; $j++) {
          if(isset($mmrattnmonths_id[$j]) && ($mmrattnmonths_id[$j] != "")){
            $sql3 = "UPDATE ".DB_PREFIX."mmrattnprevmonths set month = :month, year = :year, hkstaff =:hkstaff,  hksupervisor = :hksupervisor, modified_date = :modified_date, modified_by = :modified_by  where mmrattnmonths_id = :mmrattnmonths_id  ";
            $stmt3 = $this->connection->prepare($sql3); 
            $stmt3->bindParam(':month', $month[$j]); 
            $stmt3->bindParam(':year', $year[$j]); 
            $stmt3->bindParam(':hkstaff', $hkstaff[$j]); 
            $stmt3->bindParam(':hksupervisor', $hksupervisor[$j]);   
            $stmt3->bindParam(':modified_date', $modified_date);
            $stmt3->bindParam(':modified_by', $modified_by);
            $stmt3->bindParam(':mmrattnmonths_id', $mmrattnmonths_id[$j]);
            $res3 = $stmt3->execute();
          }else{
            $sql3 = "INSERT INTO ".DB_PREFIX."mmrattnprevmonths(mmr_id,month,year,hkstaff,hksupervisor,status,created_date,created_by) VALUES(:mmr_id, :month, :year, :hkstaff, :hksupervisor, :status, :created_date, :created_by)";
            $status = 0;      
            $stmt3 = $this->connection->prepare($sql3); 
            $stmt3->bindParam(':mmr_id', $mmr_id); 
            $stmt3->bindParam(':month', $month[$j]); 
            $stmt3->bindParam(':year', $year[$j]); 
            $stmt3->bindParam(':hkstaff', $hkstaff[$j]);
            $stmt3->bindParam(':hksupervisor', $hksupervisor[$j]);  
            $stmt3->bindParam(':status', $status);
            $stmt3->bindParam(':created_date', $created_date);
            $stmt3->bindParam(':created_by', $created_by);
            $res3 = $stmt3->execute();
          }
        }        
        for($k=0; $k < count($schedule_type) ; $k++) {
          if(isset($mmrecwid[$k]) && ($mmrecwid[$k] != "")){  
            $ecwdate = ''; 
            $ecwdate = date("Y-m-d",strtotime(($ecw_date[$k])));
            $sql4 = "UPDATE ".DB_PREFIX."mmrecworks SET schedule_type =:schedule_type, ecw_date = :ecw_date,floor = :ecwfloor, area = :ecwarea, complaint = :ecwcomplaint, modified_date = :modified_date, modified_by = :modified_by where mmrecwid = :mmrecwid";
            $stmt4 = $this->connection->prepare($sql4); 
            $stmt4->bindParam(':schedule_type', $schedule_type[$k]); 
            $stmt4->bindParam(':ecw_date', $ecwdate); 
            $stmt4->bindParam(':ecwfloor', $ecwfloor[$k]); 
            $stmt4->bindParam(':ecwarea', $ecwarea[$k]); 
            $stmt4->bindParam(':ecwcomplaint', $ecwcomplaint[$k]);
            $stmt4->bindParam(':modified_date', $modified_date);
            $stmt4->bindParam(':modified_by', $modified_by);
            $stmt4->bindParam(':mmrecwid', $mmrecwid[$k]);
            $res4 =$stmt4->execute();
          }else{
            $ecwdate = ''; 
            $ecwdate = date("Y-m-d",strtotime(($ecw_date[$k])));
            $sql4 = "INSERT INTO ".DB_PREFIX."mmrecworks(mmr_id,schedule_type,ecw_date,floor,area,complaint,status,created_date,created_by) VALUES(:mmr_id, :schedule_type, :ecw_date, :ecwfloor, :ecwarea, :ecwcomplaint, :status, :created_date, :created_by)";
            $status = 0;      
            $stmt4 = $this->connection->prepare($sql4); 
            $stmt4->bindParam(':mmr_id', $mmr_id); 
            $stmt4->bindParam(':schedule_type', $schedule_type[$k]); 
            $stmt4->bindParam(':ecw_date', $ecwdate);
            $stmt4->bindParam(':ecwfloor', $ecwfloor[$k]); 
            $stmt4->bindParam(':ecwarea', $ecwarea[$k]); 
            $stmt4->bindParam(':ecwcomplaint', $ecwcomplaint[$k]);
            $stmt4->bindParam(':status', $status);
            $stmt4->bindParam(':created_date', $created_date);
            $stmt4->bindParam(':created_by', $created_by);
            $res4 = $stmt4->execute();
          }
        }
        for ($m=0; $m < count($quantity) ; $m++) {
          if(isset($mmrmaterial_supplyid)){
            $sql5 = "UPDATE ".DB_PREFIX."mmrmaterialsupply SET material_id = :material_id, quantity = :quantity, measuring_units = :measuring_units,provided_by = :provided_by, modified_date = :modified_date, modified_by = :modified_by where mmrmaterial_supplyid = :mmrmaterial_supplyid";
            $stmt5 = $this->connection->prepare($sql5);  
            $stmt5->bindParam(':material_id', $material_id[$m]);  
            $stmt5->bindParam(':quantity', $quantity[$m]); 
            $stmt5->bindParam(':measuring_units', $measuring_units[$m]); 
            $stmt5->bindParam(':provided_by', $provided_by[$m]);  
            $stmt5->bindParam(':modified_date', $modified_date);
            $stmt5->bindParam(':modified_by', $modified_by);
            $stmt5->bindParam(':mmrmaterial_supplyid', $mmrmaterial_supplyid[$m]);
            $res5 = $stmt5->execute();
          }else{
            $sql5 = "INSERT INTO ".DB_PREFIX."mmrmaterialsupply (mmr_id,material_id,quantity,measuring_units,provided_by,status,created_date,created_by) VALUES(:mmr_id, :material_id,  :quantity, :measuring_units, :provided_by, :status, :created_date, :created_by)";
             $status = 0;      
            $stmt5 = $this->connection->prepare($sql5); 
            $stmt5->bindParam(':mmr_id', $mmr_id); 
            $stmt5->bindParam(':material_id', $material_id[$m]);  
            $stmt5->bindParam(':quantity', $quantity[$m]); 
            $stmt5->bindParam(':measuring_units', $measuring_units[$m]); 
            $stmt5->bindParam(':provided_by', $provided_by[$m]);  
            $stmt5->bindParam(':status', $status);
            $stmt5->bindParam(':created_date', $modified_date);
            $stmt5->bindParam(':created_by', $modified_by);
            $res5 = $stmt5->execute();
          }
        }
        for ($n=0; $n < count($found_by) ; $n++) {
          if(isset($mmrlostfound_id[$n]) && ($mmrlostfound_id[$n] != "")){  
            $sql6 = "UPDATE ".DB_PREFIX."mmrlostfound set item_id = :item_id, floor = :lffloor, area = :lfarea, found_by = :found_by, handover_to = :handover_to, modified_date = :modified_date, modified_by = :modified_by where mmrlostfound_id = :mmrlostfound_id";
            $stmt6 = $this->connection->prepare($sql6);  
            $stmt6->bindParam(':item_id', $item_id[$n]);  
            $stmt6->bindParam(':lffloor', $lffloor[$n]); 
            $stmt6->bindParam(':lfarea', $lfarea[$n]); 
            $stmt6->bindParam(':found_by', $found_by[$n]);  
            $stmt6->bindParam(':handover_to', $handover_to[$n]);   
            $stmt6->bindParam(':modified_date', $modified_date);
            $stmt6->bindParam(':modified_by', $modified_by);
            $stmt6->bindParam(':mmrlostfound_id', $mmrlostfound_id[$n]);
            $res6 = $stmt6->execute();
          }else{
            $sql6 = "INSERT INTO ".DB_PREFIX."mmrlostfound(mmr_id,item_id,floor,area,found_by,handover_to,status,created_date,created_by) VALUES(:mmr_id, :item_id,  :lffloor, :lfarea, :found_by,:handover_to, :status, :created_date, :created_by)";
            $status = 0;      
            $stmt6 = $this->connection->prepare($sql6); 
            $stmt6->bindParam(':mmr_id', $mmr_id); 
            $stmt6->bindParam(':item_id', $item_id[$n]);  
            $stmt6->bindParam(':lffloor', $lffloor[$n]); 
            $stmt6->bindParam(':lfarea', $lfarea[$n]); 
            $stmt6->bindParam(':found_by', $found_by[$n]);  
            $stmt6->bindParam(':handover_to', $handover_to[$n]);  
            $stmt6->bindParam(':status', $status);
            $stmt6->bindParam(':created_date', $modified_date);
            $stmt6->bindParam(':created_by', $modified_by);
            $res6 = $stmt6->execute();
          }
        }        
        if(isset($emp1_id) && ($emp1_id != '')){
          $sql7 = "UPDATE ".DB_PREFIX."mmremployees set emp_name = :emp_name, emp_picture =  :emp_picture, emp_criteria = :emp_criteria, modified_date = :modified_date, modified_by = :modified_by where mmremp_id = :mmremp_id";     
          $stmt7 = $this->connection->prepare($sql7); 
          $empCriteria1 = '';   
          $empCriteria1 = implode(",",$emp_criteria1);
          $stmt7->bindParam(':mmremp_id', $emp1_id); 
          $stmt7->bindParam(':emp_name', $emp_name1);  
          $stmt7->bindParam(':emp_picture', $emp_picture1); 
          $stmt7->bindParam(':emp_criteria', $empCriteria1); 
          $stmt7->bindParam(':modified_date', $modified_date);
          $stmt7->bindParam(':modified_by', $modified_by);
          $stmt7->execute();
        }else{
          $sql7 = "INSERT INTO ".DB_PREFIX."mmremployees(mmr_id,emp_name,emp_picture,emp_criteria,status,created_date,created_by) VALUES(:mmr_id, :emp_name,  :emp_picture, :emp_criteria, :status, :created_date, :created_by)";
          $status = 0;      
          $empCriteria1 = '';   
          $empCriteria1 = implode(",",$emp_criteria1);
          $stmt7 = $this->connection->prepare($sql7); 
          $stmt7->bindParam(':mmr_id', $mmr_id); 
          $stmt7->bindParam(':emp_name', $emp_name1);  
          $stmt7->bindParam(':emp_picture', $emp_picture1); 
          $stmt7->bindParam(':emp_criteria', $empCriteria1);  
          $stmt7->bindParam(':status', $status);
          $stmt7->bindParam(':created_date', $modified_date);
          $stmt7->bindParam(':created_by', $modified_by);
          $stmt7->execute();
        }
        if(isset($emp2_id) && ($emp2_id != '')){
          $sql77 = "UPDATE ".DB_PREFIX."mmremployees set emp_name = :emp_name, emp_picture =  :emp_picture, emp_criteria = :emp_criteria, modified_date = :modified_date, modified_by = :modified_by where mmremp_id = :mmremp_id";     
          $stmt77 = $this->connection->prepare($sql77); 
          $empCriteria2 = '';   
           $empCriteria2 = implode(",",$emp_criteria2);
          $stmt77->bindParam(':mmremp_id', $emp2_id); 
          $stmt77->bindParam(':emp_name', $emp_name2);  
          $stmt77->bindParam(':emp_picture', $emp_picture2); 
          $stmt77->bindParam(':emp_criteria', $empCriteria2); 
          $stmt77->bindParam(':modified_date', $modified_date);
          $stmt77->bindParam(':modified_by', $modified_by);
          $stmt77->execute();
        } else {          
          $sql77 = "INSERT INTO ".DB_PREFIX."mmremployees(mmr_id,emp_name,emp_picture,emp_criteria,status,created_date,created_by) VALUES(:mmr_id, :emp_name,  :emp_picture, :emp_criteria, :status, :created_date, :created_by)";
          $status = 0;     
          $empCriteria2 = '';   
          $empCriteria2 = implode(",",$emp_criteria2); 
          $stmt77 = $this->connection->prepare($sql77); 
          $stmt77->bindParam(':mmr_id', $mmr_id); 
          $stmt77->bindParam(':emp_name', $emp_name2);  
          $stmt77->bindParam(':emp_picture', $emp_picture2); 
          $stmt77->bindParam(':emp_criteria', $empCriteria2);  
          $stmt77->bindParam(':status', $status);
          $stmt77->bindParam(':created_date', $modified_date);
          $stmt77->bindParam(':created_by', $modified_by);
          $stmt77->execute();
        }
        for ($b=0; $b < count($reported_on) ; $b++) {
          $reported_on[$b] = date("Y-m-d",strtotime(($reported_on[$b])));
          if(isset($mmrbmssnag_id[$b]) && ($mmrbmssnag_id[$b] != "")){  
            $sql8 = "UPDATE ".DB_PREFIX."mmrbmssnag SET reported_on = :reported_on, floor = :bmsfloor, area = :bmsarea, complaint = :bmscomplaint, modified_date = :modified_date, modified_by = :modified_by where mmrbmssnag_id = :mmrbmssnag_id";
            $stmt8 = $this->connection->prepare($sql8);  
            $stmt8->bindParam(':reported_on', $reported_on[$b]);  
            $stmt8->bindParam(':bmsfloor', $bmsfloor[$b]); 
            $stmt8->bindParam(':bmsarea', $bmsarea[$b]);  
            $stmt8->bindParam(':bmscomplaint', $bmscomplaint[$b]); 
            $stmt8->bindParam(':modified_date', $modified_date);
            $stmt8->bindParam(':modified_by', $modified_by);
            $stmt8->bindParam(':mmrbmssnag_id', $mmrbmssnag_id[$b]);
            $stmt8->execute();
          }else{
            $sql8 = "INSERT INTO ".DB_PREFIX."mmrbmssnag(mmr_id,reported_on,floor,area,complaint,status,created_date,created_by) VALUES(:mmr_id, :reported_on,  :bmsfloor, :bmsarea, :bmscomplaint,:status, :created_date, :created_by)";
            $status = 0;      
            $stmt8 = $this->connection->prepare($sql8); 
            $stmt8->bindParam(':mmr_id', $mmr_id); 
            $stmt8->bindParam(':reported_on', $reported_on[$b]);  
            $stmt8->bindParam(':bmsfloor', $bmsfloor[$b]); 
            $stmt8->bindParam(':bmsarea', $bmsarea[$b]);  
            $stmt8->bindParam(':bmscomplaint', $bmscomplaint[$b]);  
            $stmt8->bindParam(':status', $status);
            $stmt8->bindParam(':created_date', $modified_date);
            $stmt8->bindParam(':created_by', $modified_by);
            $stmt8->execute();
          }
        }
        for ($t=0; $i < count($trainer_name) ; $t++) {
          if(isset($mmrtraining_id[$t]) && ($mmrtraining_id[$t] != "")){  
            $sql9 = "UPDATE ".DB_PREFIX."mmrtrainings set trainer_name = :trainer_name,training_date = :training_date,topics = :topics,people_cnt =:people_cnt, designation = :designation,training1_attendance = :training1_attendance,training2_attendance = :training2_attendance, training3_attendance = :training3_attendance where mmrtraining_id = :mmrtraining_id";     
            $stmt9 = $this->connection->prepare($sql9);  
            $stmt9->bindParam(':trainer_name', $trainer_name[$t]);  
            $stmt9->bindParam(':training_date', $training_date[$t]); 
            $stmt9->bindParam(':topics', $topics[$t]);  
            $stmt9->bindParam(':people_cnt', $people_cnt[$t]);  
            $stmt9->bindParam(':designation', $designation[$t]);  
            $stmt9->bindParam(':training1_attendance', $training1_attendance);
            $stmt9->bindParam(':training2_attendance', $training2_attendance);
            $stmt9->bindParam(':training3_attendance', $training3_attendance); 
            $stmt9->bindParam(':modified_date', $modified_date);
            $stmt9->bindParam(':modified_by', $modified_by);
            $stmt9->bindParam(':mmrtraining_id', $mmrtraining_id[$t]);
            $stmt9->execute();
          }else{
            $sql9 = "INSERT INTO ".DB_PREFIX."mmrtrainings(mmr_id,trainer_name,training_date,topics,people_cnt,designation,training1_attendance,training2_attendance,training3_attendance,status,created_date,created_by) VALUES(:mmr_id, :trainer_name,  :training_date, :topics, :people_cnt,:designation,:training1_attendance, :training2_attendance, :training3_attendance,:status, :created_date, :created_by)";
            $status = 0;      
            $stmt9 = $this->connection->prepare($sql9); 
            $stmt9->bindParam(':mmr_id', $mmr_id); 
            $stmt9->bindParam(':trainer_name', $trainer_name[$t]);  
            $stmt9->bindParam(':training_date', $training_date[$t]); 
            $stmt9->bindParam(':topics', $topics[$t]);  
            $stmt9->bindParam(':people_cnt', $people_cnt[$t]);  
            $stmt9->bindParam(':designation', $designation[$t]);  
            $stmt9->bindParam(':training1_attendance', $training1_attendance);
            $stmt9->bindParam(':training2_attendance', $training2_attendance);
            $stmt9->bindParam(':training3_attendance', $training3_attendance);
            $stmt9->bindParam(':status', $status);
            $stmt9->bindParam(':created_date', $modified_date);
            $stmt9->bindParam(':created_by', $modified_by);
            $stmt9->execute();
          }
        }
        for($mc=0; $mc < count($machine_id) ; $mc++) {
          $service_date[$mc] = date("Y-m-d H:i:s",strtotime($service_date[$mc]));
          if(isset($mmr_mc_id[$mc]) && ($mmr_mc_id[$mc] != "")){
            $sql_mc = "UPDATE ".DB_PREFIX."mmrmachinery set machine_id = :machine_id, company_id = :company_id, mc_count =:mc_count,  condition_id = :condition_id,service_date = :service_date,provided_by =:provided_by ,modified_date = :modified_date, modified_by = :modified_by  where mmr_mc_id = :mmr_mc_id  ";
            $stm_mc = $this->connection->prepare($sql_mc); 
            $stm_mc->bindParam(':machine_id', $machine_id[$mc]); 
            $stm_mc->bindParam(':company_id', $company_id[$mc]);  
            $stm_mc->bindParam(':mc_count', $mc_count[$mc]);  
            $stm_mc->bindParam(':condition_id', $condition_id[$mc]);  
            $stm_mc->bindParam(':service_date', $service_date[$mc]);  
            $stm_mc->bindParam(':provided_by', $provided_by[$mc]);  
            $stm_mc->bindParam(':mmr_mc_id', $mmr_mc_id[$mc]);   
            $stm_mc->bindParam(':modified_date', $modified_date); 
            $stm_mc->bindParam(':modified_by', $modified_by); 
            $res = $stm_mc->execute();
          }else{
            $sql_mc = "INSERT INTO ".DB_PREFIX."mmrmachinery(mmr_id,machine_id,company_id,mc_count,condition_id,service_date,provided_by,status,created_date,created_by) VALUES(:mmr_id, :machine_id, :company_id, :mc_count,:condition_id,:service_date,:provided_by,:status,:created_date,:created_by)";
            $status = 0;
            $stm_mc = $this->connection->prepare($sql_mc); 
            $stm_mc->bindParam(':mmr_id', $mmr_id); 
            $stm_mc->bindParam(':machine_id', $machine_id[$mc]); 
            $stm_mc->bindParam(':company_id', $company_id[$mc]);  
            $stm_mc->bindParam(':mc_count', $mc_count[$mc]);  
            $stm_mc->bindParam(':condition_id', $condition_id[$mc]);  
            $stm_mc->bindParam(':service_date', $service_date[$mc]);  
            $stm_mc->bindParam(':provided_by', $provided_by[$mc]); 
            $stm_mc->bindParam(':created_date', $modified_date); 
            $stm_mc->bindParam(':created_by', $modified_by); 
            $stm_mc->execute();
          }
        }
        if(isset($event_month)){
          for ($c=0; $c < count($event_month) ; $c++) {
            if(isset($mmrevent_id[$c]) && ($mmrevent_id[$c] != "")){
              $eventdate='';
              $eventdate = date("Y-m-d",strtotime($event_date[$c]));    
              $sql10 = "UPDATE ".DB_PREFIX."mmrevents set event_month = :event_month, event_date = :event_date, events_no = :events_no, event = :event, modified_date = :modified_date, modified_by = :modified_by where mmrevent_id = :mmrevent_id";  
              $stmt10 = $this->connection->prepare($sql10); 
              $stmt10->bindParam(':event_month', $event_month[$c]);  
              $stmt10->bindParam(':event_date', $eventdate); 
              $stmt10->bindParam(':events_no', $events_no[$c]);  
              $stmt10->bindParam(':event', $event[$c]);
              $stmt10->bindParam(':modified_date', $modified_date);
              $stmt10->bindParam(':modified_by', $modified_by);
              $stmt10->bindParam(':mmrevent_id', $mmrevent_id[$c]);
              $stmt10->execute();
            }else{
              $eventdate='';
              $eventdate = date("Y-m-d",strtotime($event_date[$c]));
              $sql10 = "INSERT INTO ".DB_PREFIX."mmrevents(mmr_id,event_month,event_date,events_no,event,status,created_date,created_by) VALUES(:mmr_id, :event_month,  :event_date, :events_no, :event,:status, :created_date, :created_by)";
              $status = 0;      
              $stmt10 = $this->connection->prepare($sql10); 
              $stmt10->bindParam(':mmr_id', $mmr_id); 
              $stmt10->bindParam(':event_month', $event_month[$c]);  
              $stmt10->bindParam(':event_date', $eventdate); 
              $stmt10->bindParam(':events_no', $events_no[$c]);  
              $stmt10->bindParam(':event', $event[$c]);   
              $stmt10->bindParam(':status', $status);
              $stmt10->bindParam(':created_date', $modified_date);
              $stmt10->bindParam(':created_by', $modified_by);
              $stmt10->execute();
            }
          }
        }
        if($res & $res2 & $res3 & $res4 & $res5){
          $status = array(
           'status' =>"200",
           'message' =>"Sites Updated Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Updated"
          );
         }
        return $status;
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrecw($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrecworks set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrecwid=:mmrecwid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrecwid',$mmrecwid);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrbmssnag($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrbmssnag set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrbmssnag_id=:mmrbmssnag_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrbmssnag_id',$mmrbmssnag_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrmaterial($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrmaterialsupply set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrmaterial_supplyid=:mmrmaterial_supplyid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrmaterial_supplyid',$mmrmaterial_supplyid);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrlostfound($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrlostfound set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrlostfound_id=:mmrlostfound_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrlostfound_id',$mmrlostfound_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrtraining($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrtrainings set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrtraining_id=:mmrtraining_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrtraining_id',$mmrtraining_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrevent($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrevents set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrevent_id=:mmrevent_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrevent_id',$mmrevent_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrprevattndnce($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrattnprevmonths set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrattnmonths_id=:mmrattnmonths_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrattnmonths_id',$mmrattnmonths_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrecwattachments($data){ 
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrecwattachments set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrecwattach_id=:mmrecwattach_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrecwattach_id',$mmrecwattach_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function deleteMmrtrattachments($data){
      try{
        extract($data);
        $modified_date = date('Y-m-d H:i:s');
        $sql = "UPDATE ".DB_PREFIX."mmrtraining_attachments set status='9',modified_date=:modified_date,modified_by=:modified_by where mmrtrattachment_id=:mmrtrattachment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by',$modified_by);
        $stmt->bindParam(':mmrtrattachment_id',$mmrtrattachment_id);
        $res = $stmt->execute();
        if($res){
          $status = array(
           'status' =>"200",
           'message' =>"Record Deleted Successfully"); 
         }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Deleted"
          );
         }
        return $status;
      }
      catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
    public function getCompanyList(){
      try{
        $sql = "SELECT * FROM ".DB_PREFIX."companies WHERE status != 9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $companies = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($companies)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'companies' => $companies
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getMonthsList(){
      try{
        $sql = "SELECT * FROM ".DB_PREFIX."months ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $months = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($months)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'months' => $months
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getRegistersList(){
      try{
        $sql = "SELECT * FROM ".DB_PREFIX."registers WHERE status !=9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $registers = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($registers)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'registers' => $registers
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getFilesList(){
      try{
        $sql = "SELECT * FROM ".DB_PREFIX."files WHERE status !=9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $files = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($files)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'files' => $files
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getAuditDetails(){
      try{
        $sql = "SELECT * FROM ".DB_PREFIX."auditdetails WHERE status !=9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $audit_details = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($audit_details)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'audit_details' => $audit_details
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function getRequirementsList(){
      try{
        $sql = "SELECT * FROM ".DB_PREFIX."requirements WHERE status !=9 ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $requirements = $stmt->fetchAll(PDO::FETCH_OBJ);
        if(!empty($requirements)){
          $status = array(
            'status' => ERR_OK,
            'message' => "Success.",
            'requirements' => $requirements
          );          
        }else{
          $status = array(
            'status' => "204",
            'message' => "No Data Found"
          );
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
    public function generateMmr($data){
      try{
        extract($data);
        $mmr = array();
        $sql1 = "SELECT *,date_format(mmr_date,'%d %b,%Y') mmr_date,get_siteName(site) siteName,(select site_logo from tbl_sites where site_id=m.site) site_logo,get_cityName(city) city,city as city_id,get_stateName(state) state,state as state_id,DATE_FORMAT(STR_TO_DATE(CONCAT(mmr_year, '-', mmr_month, '-01'), '%Y-%m-%d'), '%M %Y') AS mmrmonth,get_empName(ops_mgr) AS ops_mgr_name,get_empName(unit_mgr) AS unit_mgr_name FROM tbl_mmr m where mmr_id = :mmr_id ";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bindParam(':mmr_id', $mmr_id);
        $stmt1->execute();
        $mmr['data'] = $stmt1->fetch(PDO::FETCH_OBJ);
        $sql_cnt = "select (select count(1) AS attn_cnt from tbl_mmrattendance where mmr_id =:mmr_id ) AS attn_cnt, (select count(1) AS ec_cnt from tbl_mmrecworks where mmr_id =:mmr_id ) AS ec_cnt ,(select count(1) AS material_cnt from tbl_mmrmaterialsupply where mmr_id =:mmr_id  ) AS material_cnt, (select count(1) AS lost_cnt from tbl_mmrlostfound where mmr_id = :mmr_id) AS lost_cnt,
          (select count(1) AS bms_cnt from tbl_mmrbmssnag where mmr_id =:mmr_id) AS bms_cnt, (select count(1) AS record_cnt from tbl_mmrrecord_details where mmr_id =:mmr_id ) AS record_cnt,  (select count(1) AS mc_cnt from tbl_mmrmachinery where mmr_id =:mmr_id ) AS mc_cnt, (select count(1) AS req_cnt from tbl_mmrrequirements where mmr_id =:mmr_id ) AS req_cnt, (select count(1) AS tr_cnt from tbl_mmrtrainings where mmr_id =:mmr_id ) AS tr_cnt,(select count(1) AS event_cnt from tbl_mmrevents where mmr_id =:mmr_id ) AS event_cnt";
        $stmt_cnt = $this->connection->prepare($sql_cnt);
        $stmt_cnt->bindParam(':mmr_id', $mmr_id);
        $stmt_cnt->execute();
        $mmr['counts'] = $stmt_cnt->fetch(PDO::FETCH_OBJ);
        $sql2 = "SELECT * from tbl_mmrattendance where mmr_id = :mmr_id AND status !=9";
        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bindParam(':mmr_id', $mmr_id);
        $stmt2->execute();
        $mmr['attn'] = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $sql4 = "SELECT * FROM tbl_mmrattnprevmonths where mmr_id = :mmr_id AND status !=9 ";
        $stmt4 = $this->connection->prepare($sql4);
        $stmt4->bindParam(':mmr_id', $mmr_id);
        $stmt4->execute();
        $mmr['prev_mnt'] = $stmt4->fetchAll(PDO::FETCH_OBJ);
        $sql5 = "SELECT *,get_FloorName(floor) AS floor_name,get_SubareaName(area) area_name,get_ECWNatureWork(complaint) nature_of_work FROM tbl_mmrecworks where mmr_id = :mmr_id AND status !=9 AND schedule_type != 16";
        $stmt5 = $this->connection->prepare($sql5);
        $stmt5->bindParam(':mmr_id', $mmr_id);
        $stmt5->execute();
        $mmr['ecw_done'] = $stmt5->fetchAll(PDO::FETCH_OBJ);
        $sql55 = "SELECT *,get_FloorName(floor) AS floor_name,get_SubareaName(area) area_name,get_ECWNatureWork(complaint) nature_of_work FROM tbl_mmrecworks where mmr_id = :mmr_id AND status !=9 AND schedule_type = 16";
        $stmt55 = $this->connection->prepare($sql55);
        $stmt55->bindParam(':mmr_id', $mmr_id);
        $stmt55->execute();
        $mmr['ecw_planned'] = $stmt55->fetchAll(PDO::FETCH_OBJ);
        $sql6 = "SELECT * FROM tbl_mmrecwattachments where mmr_id = :mmr_id AND status !=9 LIMIT 0,12";
        $stmt6 = $this->connection->prepare($sql6);
        $stmt6->bindParam(':mmr_id', $mmr_id);
        $stmt6->execute();
        $mmr['ecwattachments'] = $stmt6->fetchAll(PDO::FETCH_OBJ);
        $sql_li = "SELECT * FROM tbl_mmrecwattachments WHERE mmr_id = :mmr_id AND status != 9 LIMIT 12, 18446744073709551615 ";
        $stmt_li = $this->connection->prepare($sql_li);
        $stmt_li->bindParam(':mmr_id', $mmr_id);
        $stmt_li->execute();
        $mmr['ecwatt_links'] = $stmt_li->fetchAll(PDO::FETCH_OBJ);
        $sql7 = "SELECT *,get_generalITemname(material_id) material_name,get_generalITemname(provided_by) provided_name FROM tbl_mmrmaterialsupply where mmr_id = :mmr_id AND status !=9 ";
        $stmt7 = $this->connection->prepare($sql7);
        $stmt7->bindParam(':mmr_id', $mmr_id);
        $stmt7->execute();
        $mmr['ms'] = $stmt7->fetchAll(PDO::FETCH_OBJ);
        $sql9 = "SELECT *,get_generalITemname(item_id) item_name,get_FloorName(floor) floor_name,get_SubareaName(area) area_name,get_generalITemname(handover_to) handover_to_name FROM tbl_mmrlostfound where mmr_id = :mmr_id AND status !=9 ";
        $stmt9 = $this->connection->prepare($sql9);
        $stmt9->bindParam(':mmr_id', $mmr_id);
        $stmt9->execute();
        $mmr['mlf'] = $stmt9->fetchAll(PDO::FETCH_OBJ);
        $sql11 = "SELECT me.*,(SELECT GROUP_CONCAT(criteria_name ORDER BY criteria_name SEPARATOR ',') AS criteria_names FROM tbl_bestempcriteria WHERE FIND_IN_SET(empcriteria_id, me.emp_criteria) ) emp_criterias FROM tbl_mmremployees me where mmr_id = :mmr_id AND status !=9 ";  
        $stmt11 = $this->connection->prepare($sql11);
        $stmt11->bindParam(':mmr_id', $mmr_id);
        $stmt11->execute();
        $mmr['emp'] = $stmt11->fetchAll(PDO::FETCH_OBJ);
        $sql12 = "SELECT *  ,date_format(reported_on,'%d %b, %Y') reported_on,get_FloorName(floor) floor_name,get_SubareaName(area) area_name,get_BMSNatureofComplaint(complaint) nat_of_complaint FROM tbl_mmrbmssnag where mmr_id = :mmr_id AND status !=9 ";
        $stmt12 = $this->connection->prepare($sql12);
        $stmt12->bindParam(':mmr_id', $mmr_id);
        $stmt12->execute();
        $mmr['bms'] = $stmt12->fetchAll(PDO::FETCH_OBJ);
        $sql_ad = "SELECT * ,date_format(audit_date,'%d %b, %Y') audit_date FROM tbl_mmrauditdetails where mmr_id = :mmr_id AND status !=9";
        $stmt_ad = $this->connection->prepare($sql_ad);
        $stmt_ad->bindParam(':mmr_id', $mmr_id);
        $stmt_ad->execute();
        $mmr['audit_details'] = $stmt_ad->fetchAll(PDO::FETCH_OBJ);
        $sql_rc = "SELECT *,get_RegisterName(register_id) register_name,get_FileName(file_id) file_name FROM tbl_mmrrecord_details where mmr_id = :mmr_id AND status !=9";
        $stmt_rc = $this->connection->prepare($sql_rc);
        $stmt_rc->bindParam(':mmr_id', $mmr_id);
        $stmt_rc->execute();
        $mmr['record_details'] = $stmt_rc->fetchAll(PDO::FETCH_OBJ);
        $sql_st = "SELECT * FROM tbl_mmrstaff where mmr_id = :mmr_id AND status !=9";
        $stmt_st = $this->connection->prepare($sql_st);
        $stmt_st->bindParam(':mmr_id', $mmr_id);
        $stmt_st->execute();
        $mmr['staff'] = $stmt_st->fetchAll(PDO::FETCH_OBJ);
        $sql_mc = "SELECT *,date_format(service_date,'%d %b, %Y') service_date,CASE  WHEN provided_by = 0 THEN 'Client'
           ELSE 'Mclean' END AS provided_by_name,CASE  WHEN condition_id = 0 THEN 'Working'
           ELSE 'Non Working' END AS mc_condition,get_MachineryName(machine_id) machine_name,get_CompanyName(company_id) company_name FROM tbl_mmrmachinery where mmr_id = :mmr_id AND status !=9";
        $stmt_mc = $this->connection->prepare($sql_mc);
        $stmt_mc->bindParam(':mmr_id', $mmr_id);
        $stmt_mc->execute();
        $mmr['machines'] = $stmt_mc->fetchAll(PDO::FETCH_OBJ);
        $sql_rq = "SELECT * , get_RequirementName(requirement_id) req_name FROM tbl_mmrrequirements where mmr_id = :mmr_id AND status !=9";
        $stmt_rq = $this->connection->prepare($sql_rq);
        $stmt_rq->bindParam(':mmr_id', $mmr_id);
        $stmt_rq->execute();
        $mmr['requirements'] = $stmt_rq->fetchAll(PDO::FETCH_OBJ);
        $sql14 = "SELECT *,date_format(training_date,'%d %b,%Y') tr_date,get_generalITemname(topics) topics_name,get_generalITemname(designation) tr_designation FROM tbl_mmrtrainings where mmr_id = :mmr_id  AND status !=9";
        $stmt14 = $this->connection->prepare($sql14);
        $stmt14->bindParam(':mmr_id', $mmr_id);
        $stmt14->execute();
        $mmr['trainings'] = $stmt14->fetchAll(PDO::FETCH_OBJ);
        $sql14 = "SELECT * FROM tbl_mmrtraining_attachments where mmr_id = :mmr_id  AND status !=9";
        $stmt14 = $this->connection->prepare($sql14);
        $stmt14->bindParam(':mmr_id', $mmr_id);
        $stmt14->execute();
        $mmr['trainingattachaments'] = $stmt14->fetchAll(PDO::FETCH_OBJ);
        $sql16 = "SELECT *,date_format(event_date,'%d %b,%Y') ev_date,get_monthName(event_month) month_name,get_generalITemname(event) event_name FROM tbl_mmrevents where mmr_id = :mmr_id  AND status !=9";
        $stmt16 = $this->connection->prepare($sql16);
        $stmt16->bindParam(':mmr_id', $mmr_id);
        $stmt16->execute();
        $mmr['events'] = $stmt16->fetchAll(PDO::FETCH_OBJ);
        $sql17 = "SELECT * FROM tbl_mmrpendingbills where mmr_id = :mmr_id ";
        $stmt17 = $this->connection->prepare($sql17);
        $stmt17->bindParam(':mmr_id', $mmr_id);
        $stmt17->execute();
        $mmr['pending_bills'] = $stmt17->fetchAll(PDO::FETCH_OBJ);
        $mmr_details = $mmr; 
        $site_logo =  IMGURL.'sites/'.$mmr_details['data']->site_logo; 
        $str = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Untitled Document</title>
            <style type="text/css">
            body {
              margin-left: 0px;
              margin-top: 0px;
              margin-right: 0px;
              margin-bottom: 0px;
            }
            body,td,th {
              font-family: Arial, Helvetica, sans-serif;
            }
            </style>
          </head>
          <body>
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" style="background-color:#fe8637">
                    <tr>
                      <th width="20%" align="left" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                      <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#fff; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">'.$mmr_details['data']->siteName.'.</span><br />
                      MMR of '.$mmr_details['data']->mmrmonth.'</h1></th>
                      <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/qr.jpg" width="95" height="95" /></th>
                    </tr>
                </table></th>
              </tr>
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th width="20%" align="left" valign="top" scope="col"><img src="'.$site_logo.'" width="200" height="200" /></th>
                    <th width="80%" align="right" valign="top" scope="col"><table width="90%" border="1" align="right" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                      <tr>
                        <th colspan="2" align="center" bgcolor="#fe8637" scope="col" style="font-size:10pt; color:#fff"><strong>Site Name</strong></th>
                        </tr>
                      <tr>
                        <td height="40" colspan="2" align="left" style="font-size:15pt"><strong> '.$mmr_details['data']->siteName.'</strong></td>
                        </tr>
                      <tr>
                        <td align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>City</strong></td>
                        <td align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>State</strong></td>
                      </tr>
                      <tr>
                        <td height="40" align="left" style="font-size:15pt"><strong>'.$mmr_details['data']->city.'</strong></td>
                        <td height="40" align="left" style="font-size:15pt"><strong>'.$mmr_details['data']->state.'</strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" style="font-size:11pt; font-weight:normal"><strong>Address :</strong><br />
                          '.$mmr_details['data']->site_address.'</td>
                        </tr>
                    </table></th>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th width="20%" align="left" valign="top" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="200" height="120" /></th>
                    <th width="80%" align="right" valign="top" scope="col"><table width="90%" border="1" align="right" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                      <tr>
                        <th colspan="2" align="center" bgcolor="#fe8637" scope="col" style="font-size:10pt; color:#fff"><strong>Operations Manager</strong></th>
                      </tr>
                      <tr>
                        <td height="40" align="left" style="font-size:15pt"><strong>'.$mmr_details['data']->ops_mgr_name.'</strong></td>
                        <td height="40" align="left" style="font-size:15pt"><strong>'.$mmr_details['data']->ops_mgremail.'</strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" style="font-size:11pt; font-weight:normal"><strong>Address :</strong><br />
                          Head Office: #1-89/3/B/40-42/KS/101, 1st Floor, Krishe Sapphire, Madhapur,<br />
                          Hitec City, Hyderabad-500081</td>
                      </tr>
                    </table></th>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Summary of '.$mmr_details['data']->mmrmonth.'</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="21%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="61%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Description</strong></td>
                    <td width="18%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Count</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">1</td>
                    <td align="left" bgcolor="#ffd8cc">Attendance</td>
                    <td align="center" bgcolor="#ffd8cc"><strong>'.$mmr_details['counts']->attn_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">2</td>
                    <td align="left" bgcolor="#ffede7">Extra works done in '.$mmr_details['data']->mmrmonth.'</td>
                    <td align="center" bgcolor="#ffede7"><strong>'.$mmr_details['counts']->ec_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">3</td>
                    <td align="left" bgcolor="#ffd8cc">Extra works planned for next month</td>
                    <td align="center" bgcolor="#ffd8cc"><strong>1</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">4</td>
                    <td align="left" bgcolor="#ffede7">BMS snag report</td>
                    <td align="center" bgcolor="#ffede7"><strong>'.$mmr_details['counts']->bms_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">5</td>
                    <td align="left" bgcolor="#ffd8cc">Material Consumption</td>
                    <td align="center" bgcolor="#ffd8cc"><strong>'.$mmr_details['counts']->material_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">6</td>
                    <td align="left" bgcolor="#ffede7">Lost and found</td>
                    <td align="center" bgcolor="#ffede7"><strong>'.$mmr_details['counts']->lost_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">7</td>
                    <td align="left" bgcolor="#ffd8cc">Best employee(s)</td>
                    <td align="center" bgcolor="#ffd8cc"><strong>2</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">8</td>
                    <td align="left" bgcolor="#ffede7">Training classes</td>
                    <td align="center" bgcolor="#ffede7"><strong>'.$mmr_details['counts']->tr_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">9</td>
                    <td align="left" bgcolor="#ffd8cc">Events</td>
                    <td align="center" bgcolor="#ffd8cc"><strong>'.$mmr_details['counts']->event_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">10</td>
                    <td align="left" bgcolor="#ffede7">Records</td>
                    <td align="center" bgcolor="#ffede7"><strong>'.$mmr_details['counts']->record_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">11</td>
                    <td align="left" bgcolor="#ffd8cc">Machinery Health Report</td>
                    <td align="center" bgcolor="#ffd8cc"><strong>'.$mmr_details['counts']->mc_cnt.'</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">12</td>
                    <td align="left" bgcolor="#ffede7">Requirements</td>
                    <td align="center" bgcolor="#ffede7"><strong>'.$mmr_details['counts']->req_cnt.'</strong></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Attendance</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="23%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Staff</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Staff Approved</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>No of Days</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Budget</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Actual Present</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Percentage</strong></td>
                    <td width="18%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>ODC / OT</strong></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffd8cc">1</td>
                    <td align="left" bgcolor="#ffd8cc">HK Staff</td>
                    <td align="center" bgcolor="#ffd8cc">52</td>
                    <td align="center" bgcolor="#ffd8cc">31</td>
                    <td align="center" bgcolor="#ffd8cc">1612</td>
                    <td align="center" bgcolor="#ffd8cc">1274</td>
                    <td align="center" bgcolor="#ffd8cc">79.03%</td>
                    <td align="center" bgcolor="#ffd8cc">0</td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#ffede7">2</td>
                    <td align="left" bgcolor="#ffede7">HK Supervisors</td>
                    <td align="center" bgcolor="#ffede7">4</td>
                    <td align="center" bgcolor="#ffede7">31</td>
                    <td align="center" bgcolor="#ffede7">124</td>
                    <td align="center" bgcolor="#ffede7">99</td>
                    <td align="center" bgcolor="#ffede7">79.83%</td>
                    <td align="center" bgcolor="#ffede7">0</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th width="55%" align="left" valign="top" scope="col"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                      <tr>
                        <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                        <td width="23%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Month</strong></td>
                        <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>HK Supervisor</strong></td>
                        <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>HK Staff</strong></td>
                        </tr>
                      <tr>
                        <td align="center" bgcolor="#ffd8cc" style="font-weight:normal">1</td>
                        <td align="left" bgcolor="#ffd8cc" style="font-weight:normal">July</td>
                        <td align="center" bgcolor="#ffd8cc" style="font-weight:normal">79%</td>
                        <td align="center" bgcolor="#ffd8cc" style="font-weight:normal">79%</td>
                        </tr>
                      <tr>
                        <td align="center" bgcolor="#ffede7" style="font-weight:normal">2</td>
                        <td align="left" bgcolor="#ffede7" style="font-weight:normal">June</td>
                        <td align="center" bgcolor="#ffede7" style="font-weight:normal">74%</td>
                        <td align="center" bgcolor="#ffede7" style="font-weight:normal">78%</td>
                        </tr>
                        <tr>
                        <td align="center" bgcolor="#ffd8cc" style="font-weight:normal">3</td>
                        <td align="left" bgcolor="#ffd8cc" style="font-weight:normal">May</td>
                        <td align="center" bgcolor="#ffd8cc" style="font-weight:normal">78%</td>
                        <td align="center" bgcolor="#ffd8cc" style="font-weight:normal">68%</td>
                        </tr>
                    </table></th>
                    <th width="45%" align="right" valign="top" scope="col"><img src="images/attendance-graph.png" width="400" height="320" /></th>
                  </tr>
                </table></td>
              </tr>
            </table>
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Extra Work Done - '.$mmr_details['data']->mmrmonth.'</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="10%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Date</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Floor</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Area</strong></td>
                    <td width="30%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Nature of work</strong></td>
                  </tr>';
                  if(!empty($mmr_details->ecw_done)){
                    foreach ($mmr_details->ecw_done as $e => $ecw) {
                      $str.= '<tr>
                      <td align="center" bgcolor="#ffd8cc">'.($e+1).'</td>
                      <td align="left" bgcolor="#ffd8cc">'.$ecw->ecw_date.'</td>
                      <td align="left" bgcolor="#ffd8cc">'.$ecw->floor_name.'</td>
                      <td align="left" bgcolor="#ffd8cc">'.$ecw->area_name.'</td>
                      <td align="left" bgcolor="#ffd8cc">'.$ecw->nature_of_work.'</td>
                    </tr>';
                    }
                  }
                  $str .=' </table></td>
              </tr>
            </table>
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Extra Cleaning Images - '.$mmr_details['data']->mmrmonth.'</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                <tr>
                  <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">';
                    if(!empty($mmr_details->ecwattachments)){
                      $ec_at = count($mmr_details->ecwattachments) / 3;
                      // Loop through the images in groups of 6
                      $images = $mmr_details->ecwattachments;
                      $chunks = array_chunk($images, 6);  // Split the images into chunks of 6
                      foreach ($chunks as $chunk) {  // Create the first row (3 images)
                        $str .= '<tr>';
                        for ($i = 0; $i < 3 ; $i++) {
                          if($chunk[$i]->attachment_name != ''){
                            $str .= '<th align="center" valign="top"><img src="'.IMGURL.'mmr/ecw/' .$chunk[$i]->attachment_name . '" width="250" height="249" /></th>';
                          }
                        }
                        $str .= '</tr>';
                        // Create the second row (3 images)
                        $str .= '<tr>';
                        for ($i = 3; $i < 6 ; $i++) {
                          if($chunk[$i]->attachment_name != ''){
                            $str .=  '<th align="center" valign="top"><img src="'.IMGURL.'mmr/ecw/'. $chunk[$i]->attachment_name . '" width="250" height="249" /></th>';
                           }
                        }
                        $str .=  '</tr>';
                      }
                    }                   
                  $str .= '</table></td>
                </tr>
                </table></td>
              </tr>
            </table> 
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">';
            if(!empty($mmr_details->ecwatt_links)){ 
              foreach ($mmr_details->ecwatt_links as $key => $value) {
                $str .= '<a target="_blank" href="'.IMGURL.'mmr/ecw/'.$value->attachment_name.'" /> Image-'.$value->mmrecwattach_id.'</a> , ';
              } 
            }
            $str .= '</table>
            <br/>
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Extra Work Planned for Next Month</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="23%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Date</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Floor</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Area</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Nature of work</strong></td>
                  </tr>';
                  if(!empty($mmr_details->ecw_planned)){
                    foreach ($mmr_details->ecw_planned as $ep => $vep) {
                      $str .= '<tr>
                        <td align="center" bgcolor="#ffd8cc">'.($ep+1).'</td>
                        <td align="left" bgcolor="#ffd8cc">'.$vep->ecw_date.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$vep->floor_name.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$vep->area_name.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$vep->nature_of_work.'</td>
                      </tr>';
                    }
                  }
                $str .= '</table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">BMS Snag Report</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="10%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Reported On</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Floor</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Area</strong></td>
                    <td width="30%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Nature of Compliant</strong></td>
                  </tr>';
                  if(!empty($mmr_details->bms)){
                    foreach ($mmr_details->bms as $b => $bms) {
                      $str .='<tr>
                          <td align="center" bgcolor="#ffd8cc">'.($b+1).'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$bms->reported_on.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$bms->floor_name.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$bms->area_name.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$bms->nat_of_complaint.'</td>
                        </tr>
                      ';
                    }
                  } 
                $str .= '</table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Material Consumption '.$mmr_details['data']->mmrmonth.'</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="10%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Materials</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Quantity Consumed</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Provided By</strong></td>
                  </tr>';
                  if(!empty($mmr_details->ms)){
                    foreach ($mmr_details->ms as $m => $ms) {
                      $str .='<tr>
                          <td align="center" bgcolor="#ffd8cc">'.($m+1).'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$ms->material_name.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$ms->quantity.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$ms->provided_name.'</td> 
                        </tr> ';
                    }
                  }  
                $str .= '</table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Material Consumption Graph for '.$mmr_details['data']->mmrmonth.'</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><img src="images/material-graph.png" width="504" height="363" /></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Lost & Found</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="23%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Item Found</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Floor</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Area</strong></td>
                    <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Found by</strong></td>
                       <td width="11%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Handed over to</strong></td>
                  </tr>';
                  if(!empty($mmr_details->mlf)){
                    foreach ($mmr_details->mlf as $l => $lf) {
                      $str .='<tr>
                          <td align="center" bgcolor="#ffd8cc">'.($l+1).'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$lf->item_name.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$lf->floor_name.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$lf->area_name.'</td> 
                          <td align="left" bgcolor="#ffd8cc">'.$lf->found_by.'</td> 
                          <td align="left" bgcolor="#ffd8cc">'.$lf->handover_to_name.'</td> 
                        </tr> ';
                    }
                  }  
                $str .= '</table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Best Employee</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="10%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Employee Name</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Parameter</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Employee Image</strong></td>
                  </tr>';
                  if(!empty($mmr_details->emp)){
                    foreach ($mmr_details->emp as $ek => $emp) {
                      $str .='<tr>
                          <td align="center" bgcolor="#ffd8cc">'.($ek+1).'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$emp->emp_name.'</td>
                          <td align="left" bgcolor="#ffd8cc">'.$emp->emp_criterias.'</td>
                          <td align="center" bgcolor="#ffd8cc"><img src="'.IMGURL.'mmr/emp/'.$emp->emp_picture.'" width="150" height="151" /></td> 
                        </tr> ';
                    }
                  }
                $str .= '</table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Training Classes</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="10%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Trainer Name</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Date</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Topics</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Number of People</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Designation</strong></td>
                  </tr>';
                  if(!empty($mmr_details->trainings)){
                    foreach ($mmr_details->trainings as $t => $tr) {
                      $str .= '<tr>
                      <td align="center" valign="middle" bgcolor="#ffd8cc">'.($t+1).'</td>
                      <td align="left" valign="middle" bgcolor="#ffd8cc">'.$tr->trainer_name.'</td>
                      <td align="left" valign="middle" bgcolor="#ffd8cc">'.$tr->tr_date.'</td>
                      <td align="left" valign="middle" bgcolor="#ffd8cc">'.$tr->topics_name.'</td>
                      <td align="left" valign="middle" bgcolor="#ffd8cc">'.$tr->people_cnt.'</td>
                      <td align="left" valign="middle" bgcolor="#ffd8cc">'.$tr->tr_designation.'</td>
                    </tr>';
                    }
                  }
                $str .= '</table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><img src="images/training_01.jpg" width="324" height="455" /></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Training Images</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">';
                if(!empty($mmr_details->trainingattachaments)){ 
                  $tr_images = $mmr_details->trainingattachaments;
                    $tr_chunks = array_chunk($tr_images, 6);  // Split the images into chunks of 6
                    foreach ($tr_chunks as $tr_chunk) { 
                      // Create the first row (3 images)
                      $str .= '<tr>';
                      for ($i = 0; $i < 3 ; $i++) {
                        if($tr_chunk[$i]->attachment_name != ''){
                          $str .= '<th align="center" valign="top"><img src="'.IMGURL.'mmr/trainings/' .$tr_chunk[$i]->attachment_name . '" width="250" height="249" /></th>';
                        }
                      }
                      $str .= '</tr>';
                      // Create the second row (3 images)
                      $str .= '<tr>';
                      for ($i = 3; $i < 6 ; $i++) {
                        if($tr_chunk[$i]->attachment_name != ''){
                          $str .=  '<th align="center" valign="top"><img src="'.IMGURL.'mmr/trainings/'. $tr_chunk[$i]->attachment_name . '" width="250" height="249" /></th>';
                        }
                      }
                      $str .=  '</tr>';
                    }
                  }                      
                $str .= '</table></td>
              </tr>              
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Events during the month</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="10%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Month</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Date</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>No. of Events</strong></td>
                    <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Events</strong></td>
                  </tr>';
                   if(!empty($mmr_details['events'])){
                    foreach ($mmr_details['events'] as $ke => $ev) {
                    $str .='<tr>
                      <td align="center" valign="middle" bgcolor="#ffd8cc">'.($ke+1).'</td>
                      <td align="center" valign="middle" bgcolor="#ffd8cc">'.$ev->month_name.'</td>
                      <td align="center" valign="middle" bgcolor="#ffd8cc">'.$ev->ev_date.'</td>
                      <td align="center" valign="middle" bgcolor="#ffd8cc">'.$ev->events_no.'</td>
                      <td align="left" valign="middle" bgcolor="#ffd8cc">'.$ev->event_name.'</td>
                    </tr> ';
                    }
                  }
                $str .= '</table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Records</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                  <tr>
                    <th width="50%" scope="col"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                      <tr>
                        <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                        <td width="80%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Registers</strong></td>
                      </tr>';
                      if(!empty($mmr_details['record_details'])){
                        foreach ($mmr_details['record_details'] as $kr => $rec) {
                        $str .='<tr>
                          <td align="center" valign="middle" bgcolor="#ffd8cc" style="font-weight:normal">'.($kr+1).'</td> 
                          <td align="left" valign="middle" bgcolor="#ffd8cc" style="font-weight:normal">'.$rec->register_name.'</td> 
                        </tr> ';
                        }
                      }
                    $str .= '</table></th>
                    <th width="50%" scope="col"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                      <tr>
                        <td width="20%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                        <td width="80%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Files</strong></td>
                      </tr>';
                      if(!empty($mmr_details['record_details'])){
                        foreach ($mmr_details['record_details'] as $kf => $val) {
                        $str .='<tr>
                          <td align="center" valign="middle" bgcolor="#ffd8cc" style="font-weight:normal">'.($kf+1).'</td> 
                          <td align="left" valign="middle" bgcolor="#ffd8cc" style="font-weight:normal">'.$val->file_name.'</td> 
                        </tr> ';
                        }
                      } 
                    $str .= '</table></th>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Machinery Health Report</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="7%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="27%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Machine</strong></td>
                    <td width="16%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Brand</strong></td>
                    <td width="7%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>No’s</strong></td>
                    <td width="12%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Condition</strong></td>
                    <td width="15%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Date of servicing</strong></td>
                    <td width="16%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Provided by</strong></td>
                  </tr>';
                  if(!empty($mmr_details['machines'])){
                    foreach ($mmr_details['machines'] as $mc => $mv) {
                      $str .='<tr>
                        <td align="center" bgcolor="#ffd8cc">'.($mc+1).'</td>
                        <td align="left" bgcolor="#ffd8cc">'.$mv->machine_name.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$mv->company_name.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$mv->mc_count.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$mv->mc_condition.'</td>
                        <td align="left" bgcolor="#ffd8cc">'.$mv->service_date.'</td>
                        <td align="center" bgcolor="#ffd8cc">'.$mv->provided_by_name.'</td>
                      </tr> ';
                    }
                  } 
                  $str .=' </table></td>
              </tr>
            </table>
            <br />
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col"><h1 style="color:#000; font-weight:normal; font-size:18pt"><span style="font-weight:bold; font-size:20pt">Requirements</span></h1></th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border:1pt solid #000">
                  <tr>
                    <td width="14%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Sno</strong></td>
                    <td width="86%" align="center" bgcolor="#fe8637" style="font-size:10pt; color:#fff"><strong>Requirements</strong></td>
                  </tr>';
                  if(!empty($mmr_details['requirements'])){
                    foreach ($mmr_details['requirements'] as $mr => $req) {
                      $str .='<tr>
                    <td align="center" valign="middle" bgcolor="#ffd8cc" style="font-weight:normal">'.($mr+1).'</td>
                    <td align="left" valign="middle" bgcolor="#ffd8cc" style="font-weight:normal">'.$req->req_name.'</td>
                      </tr> ';
                    }
                  }  
                $str .= '</table></td>
              </tr>
            </table>
            <table width="1000" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <th scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <th width="20%" align="left" valign="middle" scope="col"><img src="'.$site_logo.'" width="100" height="100" /></th>
                    <th width="60%" align="center" valign="middle" scope="col">&nbsp;</th>
                    <th width="20%" align="right" valign="middle" scope="col"><img src="'.THEMEURL.'assets/images/mcclean_logo.jpg" width="150" height="92" /></th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td height="300" align="center" valign="middle"><h1 style="color:#000;"><span style="font-weight:bold; font-size:20pt">Thank You</span></h1></td>
              </tr>
            </table>
          </body>
        </html>' ;
        echo $str; die();
        ini_set('max_execution_time', '300');
        require_once(LIBS . 'helpers/mpdf/autoload.php');
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',
          'format' => 'A4-L',
          'orientation' => 'L']);
        $mpdf->WriteHTML($str); 
        $mpdf->Output('mmrname.pdf','I');
        return $str; 
      }catch(PDOException $e) {
        $status = array(
          'status' => "500",
          'message' => $e->getMessage()
        );
        return $status;
      }
    }
  }
?>
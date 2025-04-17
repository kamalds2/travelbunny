<?php
/*
* PHP version 5
* @author siriinnovations.com
* @version 1.0
* @license http://URL name 
* @access public
*/ 
class myView_model extends Model {	
  public function __construct() {
    parent::__construct();
  }	

  public function access($adminRoleId) {        
    $result = $this->db->find('SELECT * FROM '.DB_PREFIX.'privileges 
         WHERE  role_id = :role_id', array(':role_id' => $adminRoleId));
    return $result;        
  }


  public function getMenuDetails(){
    $url = RESTURL."travelbunny/getallmenus"; 
    $res = $this->CallAPI("GET",$url); 
    return $res;
  }

  
  public function getPageDetails($array,$parentId = 0, $menuId = 'topmenu'){
    if(is_array($array) && count($array) > 0) {
      $submenu = false; 
      $link = '';
      foreach($array as $key => $row){ 
        if($row->menu_parentid == $parentId){ 
          if ($submenu === false) {
            $submenu = true;  
            // print "<ul>\n"; 
          } 
          switch ($row->menu_contenttype) { 
            case 'page':
              if($row->menu_name  == 'Home') {
                $url = SITEURL;                 
                $link .= '<li class="active" id="menu'.$row->menu_id.'"><a href="' . $url . '">'.$row->menu_name . '</a>';                
              }else{                      
                $url = SITEURL.'content/'.$row->menu_slug;                
                  
                if($url == 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']){
                  $link .= '<li  class="active" id="menu'.$row->menu_id.'" ><a href="' . $url . '">'.$row->menu_name . '</a>';
                }else{
                  $link .= '<li  id="menu'.$row->menu_id.'" ><a href="' . $url . '">'.$row->menu_name . '</a>';
                }
              }

              $ids = $row->menu_id;

              $result = $this->db->find("SELECT count(menu_id) AS cnt  FROM ".DB_PREFIX."menus WHERE menu_status = 'y' and menu_parentid = $ids");
              if($result['cnt'] != '0'){
                $link = '<li  ><a href="#">'.$row->menu_name . '<i class="ti-angle-down"></i></a><div class="sub-menu"></div>'; 
              }

              $result = $this->db->find("SELECT *  FROM ".DB_PREFIX."menus WHERE menu_status = 'y' and menu_parentid = $ids");  
              if($result != false){
                $url = SITEURL.'content/'.$result['menu_slug'];
                if($url == 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']){
                  $link = '<li  class="active" ><a href="#">'.$row->menu_name . '<i class="ti-angle-down"></i></a><div class="sub-menu"></div>';
                }

              }
              break;
            case 'module':                
              $ids = $row->menu_id;
              $mids = $row->menu_moduleid; 
              $result = $this->db->find("SELECT count(menu_id) AS cnt  FROM ".DB_PREFIX."menus WHERE menu_status = 'y' and menu_parentid = $ids");

              $modId = $this->getModuleDetails($row->menu_moduleid); 
              $url = SITEURL.$modId->res->module_slug;
              $controller = $modId->res->module_slug;
              
              $pageurl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
              $page = explode("/", $pageurl);
               
              if($result['cnt'] != '0'){
                $link .= '<li ><a href="#">'.$row->menu_name . '<i class="ti-angle-down"></i></a>';
              }
              elseif($controller == $page[2]){
                $link .= '<li class="active" id="menu'.$row->menu_name.'" ><a href="' . $url . '">'.$row->menu_name . '</a>';
              }
              elseif($row->menu_parentid !='0'){
                $link .= '<li id='.$row->menu_name.'><a href="' . $url . '">'.$row->menu_name. '</a>';
              }
              else{
                $link .= '<li id='.$row->menu_name.'><a href="' . $url . '">'.$row->menu_name . '</a>';
              }
              break;

            case 'web':
              $ids = $row->menu_id;
              $url = $row->menu_link;
              
          
              $result = $this->db->find("SELECT count(menu_id) AS cnt FROM ".DB_PREFIX."menus WHERE menu_status = 'y' and menu_parentid=$ids");
             
              if($result['cnt'] != '0'){
                $link .= '<li ><a href="#">'.$row['menu_name'] . '<i class="ti-angle-down"></i></a>';
              }                           
                
              elseif($row['menu_link'] =='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']){
                
                
                $link .= '<li  class="active" id="menu'.$row->menu_name.'"><a href="' . $row->menu_link. '" target="' . $row->menu_target. '">'.$row->menu_name. '</a>';
              }
              else{
                $link .= '<li id="menu'.$row->menu_name.'"><a href="' . $row->menu_link. '" target="' . $row->menu_target . '">'.$row->menu_name. '</a>';
              }                            
              break;
          }
          // $this->getPageDetails($array, $key);
        }
      } 
      // unset($row);          
      // if ($submenu === true) {
      //   // print "</ul>\n";
        
      // }   
    }
    return $link;
  }

  public function getModuleDetails($id) {
    $url = RESTURL."travelbunny/getmoduledetails/".$id;  
    $res = $this->CallAPI("GET",$url); 
    return $res;
     
  }
  
  public function getSettingsData(){    
    $url = RESTURL."travelbunny/getsettingsdata";  
    $res = $this->CallAPI("GET",$url);   
    return $res;
  }
   
}
?>
<?php

/**
 * Manage Menus Managements 
 * 
 * PHP version 5
 * 
 * @author sudhakar <sudhakar.c@siriinnovations.com>
 * @version 1.0
 * @license http://URL name 
 * @access public
 */
class menus extends Controller {
    
    /**
     * This is constructor 
     */
    public function __construct() {
        parent::__construct();
        if(!$this->session->gets('adminuser_id')) 
        $this->redirect('login');
        $menus = array();
    }    
    /**
     * By using this method getting all Apilines and load the view 
     */
     public function index() {
        $this->view->menuString = $this->addMenu();
        $this->view->menuDisplayString = $this->displayMenu();
        $this->view->LoadView('manageMenus', 'menus');
    }
    /**
     * Ajax Save Menu
     */
    public function ajaxSaveMenu() {
        $i = 0; $data = array();
        foreach ($_POST['list'] as $k => $v) {            
            $i++;        
            $data['parent_id'] = $v;
            $data['position'] = $i;
            $data['menu_id'] = $k;
            $this->model->updateMenu($data);
        }
        echo "Menu Updated Successfully.";
        exit;
    }
    public function ajaxDisplayMenu() {
        echo $this->displayMenu();
    }
    /**
     * displayMenu();
     */
    public function displayMenu($parent_id = 0) {
        $submenu = false;
        $class = ($parent_id == 0) ? "parent" : "child";
        
        static $menuString = '';
        $this->a = $this->getParentMenu();      
        foreach ($this->menus as $key => $row) {
            if ($row['menu_parent'] == $parent_id) {
                if ($submenu === false) {
                        $submenu = true;
                        $menuString .= "<ul>\n";
                }
                $menuString .= '<li id="list_' . $row['menu_id'] . '">'
                .'<div><a id="item_'.$row['menu_id'].'" onclick="deleteMenu('.$row['menu_id'].')" data-title="' . $row['menu_name'] . '" class="delete">'
                .'<img src="images/del.png" alt="" class="tooltip" title="delete"/><i class="icon-'. $row['menu_icon'] .'"></i></a>'
                .'<a href="'.SITEURL.'menus/editMenus/' . $row['menu_id'] . '" class="'.$class.'">' . $row['menu_name'] . '</a></div>';
                $this->displayMenu($key);
                $menuString .= "</li>\n";
            }
        }
        unset($row);
        if ($submenu === true)
                $menuString .= "</ul>\n";
        
        return $menuString;
    }

    /**
     * By using this method load the add Menu view page
     */
    public function addMenu($parent_id = 0, $level = 0, $spacer ='&#166;&nbsp;&nbsp;&nbsp;&nbsp;', $selected = false) {
         
        static $menuString = '';
        $this->a = $this->getParentMenu();
        foreach ($this->menus as $key => $row) {
            $sel = ($row['menu_id'] == $selected) ? " selected=\"selected\"" : "" ;
		if ($parent_id == $row['menu_parent']) {
                    $menuString .=  "<option value=\"" . $row['menu_id'] . "\"".$sel.">";
                    for ($i = 0; $i < $level; $i++)
                       $menuString .= $spacer;
                    
			  $menuString .=  $row['menu_name'] . "</option>\n";
                            $level++;
			    $this->addMenu($key, $level, $spacer, $selected);
			    $level--;
			  }
		  }
        return $menuString;
      }
     
     /**
      * 
      * @return array
      */
      public function getParentMenu() {
         $this->a = $this->model->getMenus();
         foreach($this->a as $m) {
            $this->menus[$m['menu_id']]  = array('menu_id'=>$m['menu_id'],'menu_icon' => $m['menu_icon'],
                'menu_name' => $m['menu_name'],'menu_parent' => $m['menu_parent']);
         }
         return $this->menus;
     }
     /**
      * By using this funtion get all possible pages
      */
     public function getAllPages() {
          $result = $this->model->getAllPages();
          header('Content-type: application/json');
         die( json_encode( $result ) );
     }
      /**
      * By using this funtion get all possible modules
      */
     public function getAllModules() {
          $result = $this->model->getAllModules();
          header('Content-type: application/json');
         die( json_encode( $result ) );
     }
     

     /**
     * By using this method add Api detials into database
     */
      public function addMenuDetails() {
        if(isset($_POST['submit'])) {
        $result = $this->model->addMenuDetails($_POST);
            if($result) {
                $this->session->sets("success", 'Successfully Added');
                $this->redirect('menus');
            } else {
                $this->session->sets("faillure", 'sorry due to some error process not completed');
                $this->redirect('menus');
            }
        } else {
            $this->session->sets("faillure", 'sorry due to some error process not completed');
            $this->redirect('menus');
        }
     }   
    
    /*
     * by using this method edit menu items
     * $id integer
     */
    public function editMenus($id){  
        $this->view->menuString = $this->addMenu();
        $this->view->menuDisplayString = $this->displayMenu();
        $menuItem = $this->model->getMenuDetails($id);
        $this->view->menuDetails = $menuItem;
        // var_dump($menuItem);die();
        if($menuItem['menu_contenttype'] == 'page') {
            $result = $this->model->getAllPages();
            $str = "<select data-rule-required='true' id='select' name='menu_pageid' class='form-control'><option value=''>Select page</option>";
            foreach($result as $res) {
                $str .= "<option value='".$res['page_id']."'";
                if($res['page_id'] == $menuItem['menu_pageid']) {
                    $str .= " selected";
                }
                $str .= ">".$res['page_title']."</option>";
            }
            $str .= "</select>";            
        }
        else if($menuItem['menu_contenttype'] == 'module') {
            $result = $this->model->getAllModules();
            $str = "<select data-rule-required='true' id='select' name='menu_moduleid' class='form-control'><option value=''>Select Module</option>";
            foreach($result as $res) {
                $str .= "<option value='".$res['module_id']."'";
                if($res['module_id'] == $menuItem['menu_moduleid']) {
                    $str .= " selected";
                }
                $str .= ">".$res['module_name']."</option>";
            }
            $str .= "</select>";
        }
        else {
            $str = "<input name='menu_link' type='text'  value='".$menuItem['menu_link']."' size='25'>
                    <select name='menu_target' style='width:100px;' class='select'>
                    <option value=''>target</option>
                    <option value='_blank'>Blank</option>
                    <option value='_self'>Self</option>
                    </select>";
        }
        $this->view->contentStr = $str;
        $this->view->LoadView('editMenus', 'menus');
    }
    
    /*
     * by using this method updating menu details in databsae
     * 
     */
    public function updateMenuDetails(){
        if(isset($_POST['submit'])) {
            $menuId = $_POST['menuId'];
            $results = $this->model->updateMenuDetails($_POST);
            if($results) {
                $this->session->sets("success", 'Successfully Updated');
                $this->redirect('menus');
            } else {
                $this->session->sets("faillure", 'sorry due to some error process not completed');
                $this->redirect('menus');
            }
         } else {
             $this->session->sets("faillure", 'sorry due to some error process not completed');
             $this->redirect('menus');
         }
                
    }
    
    /*
     * this method is for deleting menu items
     */
    public function deleteMenuItems(){  
        if(isset($_POST['delete'])) {
        $this->model->deleteMenuItems($_POST);
        $id = $_POST['deletId'];
        $r = $this->model->getSubMenus($id);
        if($r != ''){
            foreach($r as $m){
                $this->model->deleteSubmenus($m['menu_id']);
            }
        }
        } else {
        $this->redirect('menus');
        }
    }
}
    ?>
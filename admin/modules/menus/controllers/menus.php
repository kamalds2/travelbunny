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

        $this->set_logs($this->session->gets('adminuser_id'),'menus','index','error_logs','Menus','ACTS');  

        $this->view->LoadView('manageMenus', 'menus');

    }

    /**

     * Ajax Save Menu

     */

    public function ajaxSaveMenu() {
    $data = json_decode($_POST['menu'], true); // Decode the JSON data
    foreach ($data as $key => $item) {
        $newPosition = $key + 1;
        $parent_id = 0; // Default parent_id is 0 unless a parent is defined
        if (isset($item['children']) && is_array($item['children'])) {
            $parent_id = $item['id']; // Set parent_id to the current item's id
        }
        $this->updateMenuItem($item, $parent_id, $newPosition);
    }
    $this->set_logs($this->session->gets('adminuser_id'),'menus','ajaxSaveMenu'.implode('~',$_POST),'error_logs','Menu Updted Successfully','ACTS'); 
    echo "Menu Updated Successfully.";
    exit;
}

private function updateMenuItem($item, $parent_id = 0, $position = 0) {
    $menu_id = $item['id'];
    if($menu_id==$parent_id){
        $parent_id = 0;
    }
    $this->model->updateMenuById($menu_id, $parent_id, $position);
    if (isset($item['children']) && is_array($item['children'])) {
        foreach ($item['children'] as $key => $child) {
            $this->updateMenuItem($child, $menu_id, $key + 1); // Position starts from 1
        }
    }
}


    public function ajaxDisplayMenu() {

        echo $this->displayMenu();

    }
     public function displayMenu($parent_id = 0) {
        
        $submenu = false;
        $class = ($parent_id == 0) ? "parent" : "child";
        $menuString = ''; // Reset $menuString for each call
        // Assuming $this->menus is your menu data
        // data-url="' . htmlspecialchars($row['menu_url']) . '"
        foreach ($this->menus as $key => $row) {
            if ($row['menu_parentid'] == $parent_id) {
                if ($submenu === false) {
                    $submenu = true;
                    $menuString .= '<ol class="dd-list">';
                } 
                $menuString .= '<li class="dd-item dd3-item" data-id="' . $row['menu_id'] . '" data-label="' . htmlspecialchars($row['menu_name']) . '" >'
                  . '<div class="dd-handle dd3-handle"> Drag </div>'
                  . '<div class="dd3-content"><span>' . htmlspecialchars($row['menu_name']) . '</span><div class="item-edit"><a href="'.SITEURL.'menus/editMenus/'.$row['menu_id'].'" class="text-muted px-1"><i class="bi bi-pencil-fill"></i></a><a href="#" class="text-muted px-1 delete_menu" data-id="'.$row['menu_id'].'"><i class="bi bi-trash-fill"></i></a></div></div>'
                  ;
                // Recursively call displayMenu for children
                $menuString .= $this->displayMenu($key);
                $menuString .= "</li>\n";
            }
        }
        if ($submenu === true)
            $menuString .= "</ol>\n";
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

		if ($parent_id == $row['menu_parentid']) {



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
        
        foreach($this->a->menus as $m) { 
            $this->menus[$m->menu_id]  = array('menu_id'=>$m->menu_id,'menu_icon' => $m->menu_icon,

                'menu_name' => $m->menu_name,'menu_parentid' => $m->menu_parentid);

         }

         return $this->menus;

     }

     /**

      * By using this funtion get all possible pages

      */

    public function getAllPages() {
        $result = $this->model->getAllPages();

        echo json_encode($result->pages) ;

     }

      /**

      * By using this funtion get all possible modules

      */

     public function getAllModules() {

          $result = $this->model->getAllModules();

         echo json_encode($result->modules) ;


     }

     



     /**

     * By using this method add Api detials into database

     */

    public function addMenuDetails() {
        try{ 
            $result = $this->model->addMenuDetails($_POST); 

            if($result) {

                $this->session->sets("success", 'Successfully Added');

                $this->set_logs($this->session->gets('adminuser_id'),'menus','addMenuDetails'.implode('~',$_POST),'error_logs','Menu Added Successfully','ACTS'); 

                $this->redirect('menus');

            } else {

                $this->session->sets("faillure", 'sorry due to some error process not completed');

                $this->set_logs($this->session->gets('adminuser_id'),'menus','addMenuDetails'.implode('~', $_POST),'error_logs','Menus Not added ','ERR');

                $this->redirect('menus');

            }

        } catch (Exception $e)  {
            $this->session->sets("failure", 'sorry due to some error process not completed');

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
        $this->view->parent = $this->model->getParentMenu($menuItem['menu_parentid']);
        $this->view->menuDetails = $menuItem;
        // var_dump($this->view->menuDetails);die;
        if($menuItem['menu_contenttype'] == 'page') {
            $result = $this->model->getAllPages();

            $str = "<select data-rule-required='true' id='select' name='menu_pageid' class='form-control'><option value=''>Select page</option>";
            foreach($result->pages as $res) {
                $str .= "<option value='".$menuItem['menu_pageid']."'";
                if($res->page_id == $menuItem['menu_pageid']) {
                    $str .= " selected";
                }
                $str .= ">".$res->page_title."</option>";
            }
            $str .= "</select>";            
        }
        else if($menuItem['menu_contenttype'] == 'module') {
            $result = $this->model->getAllModules();
            $str = "<select data-rule-required='true' id='select' name='menu_moduleid' class='form-control'><option value=''>Select Module</option>";
            foreach($result->modules as $res) {
                $str .= "<option value='".$res->module_id."'";
                if($res->module_id == $menuItem['menu_moduleid']) {
                    $str .= " selected";
                }
                $str .= ">".$res->module_name."</option>";
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

                $this->set_logs($this->session->gets('adminuser_id'),'menus','updateMenuDetails'.implode('~', $_POST),'error_logs','Menu Updated Successfully','ACTS');

                $this->redirect('menus');

            } else {

                $this->session->sets("faillure", 'sorry due to some error process not completed');

                $this->set_logs($this->session->gets('adminuser_id'),'menus','updateMenuDetails'.implode('~', $_POST),'error_logs', 'Menu not Updated','ERR');

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
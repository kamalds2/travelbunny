<?php



/**

 *  Manage Menus Managements model

 * 

 * PHP version 5

 * 

 * @author sudhakar <sudhakar.c@siriinnovations.com>

 * @version 1.0

 * @license http://URL name 

 * @access public

 */



class menus_model extends Model {

    

    public function __construct() {

        parent::__construct();

    }

    

    /**

     * 

     * @return array

     */

    public function getMenus() {
         

         return $this->db->findAll("SELECT * FROM ".DBPREFIX."_menus ORDER BY menu_position,menu_parentid");

    }

    /**

     * 

     * @return array

     */

    public function getAllPages() {

        $sql = "SELECT * FROM ".DBPREFIX."_pages  WHERE page_status='y'";

        $result = $this->db->findAll($sql);

        return $result;

    }

    /**

     * 

     * @return array

     */

    public function getAllModules() {

        $sql = "SELECT * FROM ".DBPREFIX."_modules WHERE module_status ='y' ORDER BY module_id";

        $result = $this->db->findAll($sql);

        return $result;

    }





    /**

     * 

     * @param array $data

     * @return boolean

     */

    public function addMenuDetails($data) {

      

        extract($data);

        $values = array();

        $values['menu_name'] = $menu_name;

          $values['menu_pageid'] = $menu_pageid;

        $values['menu_slug'] = $this->slug($menu_name);

        if(isset($menu_pageid)){ 

            $id=$menu_pageid;

            $result =  $this->db->find("SELECT page_slug FROM ".DBPREFIX."_pages WHERE page_id = $id");

           

            $values['menu_link'] = $result['page_slug'];

        }

        if(isset($menu_moduleid)) {

            $values['menu_moduleid'] = $menu_moduleid;

        }

        if(isset($menu_link)) {

            $values['menu_link'] = $menu_link;

        }

        if(isset($menu_target)) {

            $values['menu_target'] = $menu_target;

        }

        $values['menu_icon'] = $menu_icon;

        $values['menu_parentid'] = $menu_parentid;

        $values['menu_contenttype'] = $menu_contenttype;

        $values['menu_status'] = $menu_status;

      // print_r($value); exit;

        $res = $this->db->insert(DBPREFIX.'_menus', $values);

        if($res) {

            return true;

        } else {

            return false;

        }

    }

    /**

     * 

     * @param integer $id

     * @return array

     */

     public function getApiDetails($id) {

        

        $result = $this->db->find('SELECT * FROM '.DBPREFIX.'_apilines WHERE  api_id = :api_id', array(':api_id' => $id));

        return $result;

         

        

    }

    /**

     * 

     * @param array $data

     * @return boolean

     */

     public function updateMenu($data) {

        extract($data);

        $values = array();

              

        $values['menu_parentid'] = $parent_id;

        $values['menu_position'] = $position;       

        $id = $menu_id;

        

        $result = $this->db->update(DBPREFIX.'_menus', $values, "`menu_id` = $id");

        if($result) {

            return true;

        } else {

            return false;    

        }

    }

     /**

     * 

     * @param integer $id

     * @return array

     */

    public function deleteApi($id) {

         return $this->db->delete(DBPREFIX.'_apilines', "`api_id` = $id");

    }

    

    /**

     * 

     * @param array $data

     * @return boolean

     */

    public function deleteAllApilines($data) {

      extract($data);

      $ids = $deletdata;

      return $this->db->deleteAll(DBPREFIX.'_apilines', "`api_id`", $ids);

    }

        

    /**

     * 

     * @param array $data

     * @return boolean

     */

    public function changeApiStatus($data) {

        

        extract($data);

        $apiId = $apiId;

        $status = $status;

        $values = array();

        if($status == 'y') {

            $values['api_status'] = 'n';

        } else {

            $values['api_status'] = 'y';

        }

        $result = $this->db->update(DBPREFIX.'_apilines', $values, "`api_id` = $apiId");

        if($result) {

            return true;

        } else {

            return false;

        }

        

    }

    

    /*

     * for getting menu details

     * parameter integer $id

     * return array

     */

    public function getMenuDetails($id){

        return $this->db->find("SELECT * FROM ".DBPREFIX."_menus WHERE `menu_id` = :menu_id", array(':menu_id' => $id));

    }

    

    /*

     * for updating menu data

     * parameter array $data

     * return boolean

     */

    public function updateMenuDetails($data){

        extract($data);

        $values = array();

        $values['menu_name'] = $menu_name;

        $values['menu_slug'] = $this->slug($menu_name);

        if(isset($menu_pageid)){ 

            $id=$menu_pageid;

            $result =  $this->db->find("SELECT page_slug FROM ".DBPREFIX."_pages WHERE page_id = $id");

           

            $values['menu_link'] = $result['page_slug'];

        }

        if(isset($menu_moduleid)) {

            $values['menu_moduleid'] = $menu_moduleid;

        }

        if(isset($menu_link)) {

            $values['menu_link'] = $menu_link;

        }

        if(isset($menu_target)) {

            $values['menu_target'] = $menu_target;

        }

        $values['menu_icon'] = $menu_icon;

        $values['menu_parentid'] = $menu_parentid;

        $values['menu_contenttype'] = $menu_contenttype;

        $values['menu_status'] = $menu_status;

        

        return $this->db->update(DBPREFIX.'_menus', $values, "`menu_id` = $menuId");

    }

    

    /*

     * foe deleting menu items

     *  parameter array $data

     */

    public function deleteMenuItems($data){

        extract($data);

        return $this->db->delete(DBPREFIX.'_menus', "`menu_id` = $deletId");

    }

    

    public function getSubMenus($id){

        return $this->db->findAll("SELECT menu_id FROM ".DBPREFIX."_menus WHERE `menu_parentid` = $id");

    }

    

    public function deleteSubmenus($id){

        return $this->db->delete(DBPREFIX.'_menus', "`menu_id` = $id");

    }

    public function getParentMenu($id){

        return $this->db->find("SELECT menu_name FROM ".DBPREFIX."_menus WHERE `menu_id` = $id");

    }

}

    ?>
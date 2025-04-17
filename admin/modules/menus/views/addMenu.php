<?php

/** 
 * Add Mange Menu
 * 
 * PHP version 5
 * 
 * @author sudhakar <sudhakar.c@siriinnovations.com>
 * @version 1.0
 * @license http://URL name 
 * @access public
 */
?>
<?php  if(!$this->access('23', 'add'))  { ?>
  <div style='float:left; margin-left:300px; margin-top:200px'>
<?php $this->noAccess(); }?>
    <!-- BEGIN Content -->
  <div id="main-content"> 
    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li> <i class="icon-home"></i> <a href="<?php echo SITEURL; ?>">Home</a> 
            <span class="divider"><i class="icon-angle-right"></i></span>
        </li>
        <li class="active">Add Menu</li>
      </ul>
    </div>
    <!-- END Breadcrumb --> 
    <?php
      if($this->session->gets('success') || $this->session->gets('faillure') ) {  ?>
      <div class="success_msg">
         <?php  if($this->session->gets('faillure')) {  ?>
          <i class="icon-remove"></i>
          <span class="text-error">
            <?php  echo $this->session->gets('faillure');  $this->session->sets('faillure', ''); ?>
         </span><br />
         <?php } else if($this->session->gets('success')) { ?>
          <i class="icon-check"></i><span class="text-success">
            <?php 
             echo $this->session->gets('success');
             $this->session->sets('success', '');
             ?>
        </span><br />
         <?php } ?>
     </div>
         <?php } ?>
    <!-- BEGIN Main Content --> 
    <!-- form inputs -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-title">
            <h3><i class="icon-reorder"></i>Menu Inputs</h3>
            
          </div>
          <div class="box-content frms">
            <form method="post" action="<?php echo SITEURL; ?>menus/addMenuDetails" class="form-horizontal" id="validation-form" autocommplete="off">
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Menu Name</label>
                <div class="col-lg-12 controls">
                  <div class="input-group"> <span class="input-group-addon"><i class="icon-user"></i><strong>Menu Name<span>*</span></strong></span>
                    <input type="text" data-rule-minlength="3" data-rule-required="true" class="form-control" id="username" name="menu_name" placeholder="Menu Name">
                  </div>
                </div>
              </div>
             
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Menu Parent</label>
                <div class="col-lg-12 controls">
                  <div class="input-group"> <span class="input-group-addon"><i class="icon-edit"></i><strong>Menu Parent<span>*</span></strong></span>
                    <select name='menu_parentid' data-placeholder="Select Parent Menu" class="form-control chosen-with-diselect select-search" tabindex="-1" id="selCSI">
                      <option value="0">Top Level</option>
                      <?php
                      echo $this->menuString;
                      ?>
                    </select>
                  </div>
                </div>
              </div>                 
                  
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Content Type<span>*</span></label>
                <div class="col-lg-12 controls">
                  <div class="input-group"> <span class="input-group-addon"><i class="icon-edit"></i><strong>Content Type<span>*</span></strong></span>
                    <select name='menu_contenttype' data-placeholder="Your Favorite Type of Bear" class="form-control chosen-with-diselect select-search" tabindex="-1" id="menu_contenttype">
                      <option value=""> Select content</option>
                      <option value="page">Content Page</option>
                      <option value="module">Module</option>
                      <option value="web">External Link</option>
                    </select>
                  </div>
                </div>
              </div>
                  
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Select Content</label>
                <div class="col-lg-12 controls">
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="icon-chevron-down"></i>
                          <strong>Select Content<span>*</span></strong></span>
                      <span id='conid'>
                    <select data-rule-required="true" id="select" name="select" class="form-control">
                      <option value="">-- Please select Content --</option>
                     </select>
                      </span>
                  </div>
                </div>
              </div>
                  
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Menu Status</label>
                <div class="col-lg-12 controls">
                  <div class="input-group"><span class="input-group-addon hide-span"><i class="icon-circle"></i><strong>Menu Status</strong></span>
                  <div class="rc-div">
                    <div class="radio-inline">
                        <input type="radio" name="menu_status" value="y" class="regular-radio" id="r1" checked="checked" />
                      <label for="r1"></label>
                      <label>Active</label>
                    </div>
                    <div class="radio-inline">
                      <input type="radio"  name="menu_status" value="n" class="regular-radio" id="r2" />
                      <label for="r2"></label>
                      <label>Deactive</label>
                    </div>
                   
                 </div><!-- rc-div end -->   
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                  <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                  <button class="btn" type="button" id="cancel">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- END Main Content -->
    <script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    
    $('#menu_contenttype').change(function () {
        var option = $(this).val();
      if(option == 'page') {
      
       $.ajax({
       url:'<?php echo SITEURL; ?>menus/getAllPages',
       type: 'POST',
       datatype:'application/json',
       success:function(data){
       var htmlString ='';
       htmlString+="<select data-rule-required='true' id='select' name='menu_pageid' class='form-control'>"
       htmlString+="<option value=''>Select page</option>"
       $.each(data,function(i){
             htmlString+="<option value="+data[i]['page_id']+">"+data[i]['page_title']+"</option>"
           });
           htmlString+="</select>"
       $("#conid").html(htmlString);
       }
       });
       } else if(option == 'module') {
       $.ajax({
       url:'<?php echo SITEURL; ?>menus/getAllModules',
       type: 'POST',
       datatype:'application/json',
       success:function(data){
      
       var htmlString ='';
       htmlString+="<select data-rule-required='true' id='select' name='menu_moduleid' class='form-control'>"
       htmlString+="<option value=''>Select Module</option>"
       $.each(data,function(i){
             htmlString+="<option value="+data[i]['module_id']+">"+data[i]['module_name']+"</option>"
           });
           htmlString+="</select>"
       $("#conid").html(htmlString);
       }
       });
       } else {
       var htmlString ='';
           htmlString+= "<input name='menu_link' type='text'  value='' size='25'>"
           htmlString+="<select name='menu_target' style='width:100px;' class='select'>"
           htmlString+="<option value=''>target</option>"
           htmlString+="<option value='_blank'>Blank</option>"
	   htmlString+="<option value='_self'>Self</option>"
           htmlString+="</select></div>"
	   htmlString+="<input name='page_id' type='hidden' value='0' />";
          $('#conid').html(htmlString).show();
        }
     });
    

});
</script>

<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('#cancel').click(function() {
       if(confirm("Are you sure you want to navigate away from this page?"))
       {
          window.location.href = "<?php echo SITEURL; ?>dashboard";
       }        
       return false;
    });
});
</script>
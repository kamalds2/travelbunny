<?php

/**
 *  Menus Management
 * 
 * PHP version 5
 * 
 * @author sudhakar <sudhakar.c@siriinnovations.com>
 * @version 1.0
 * @license http://URL name 
 * @access public
 */
?>

  <!-- BEGIN Content -->
  <div id="main-content"> 
    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li> <i class="icon-home"></i> <a href="<?php echo SITEURL; ?>">Home</a> <span class="divider"><i class="icon-angle-right"></i></span> </li>
        <li class="active">Menus</li>
      </ul>
    </div>
    <!-- END Breadcrumb --> 
    <div>
        
    </div> 
      <!-- success message -->  
    <?php
         if($this->session->gets('success') || $this->session->gets('faillure') ) {
         ?>
     <div class="success_msg" id="divsuccess">
         <?php
         if($this->session->gets('faillure')) {
         ?>
         <i class="icon-remove"></i><span class="text-error">
             <?php 
             echo $this->session->gets('faillure');
             $this->session->sets('faillure', '');
             ?>
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
      <!-- success message end-->
      <div class="success_msg" id="divSuccessMsg" style="display: none;">
     <i class="icon-check"></i>
     <span class="text-success">Success Message Success Message Success Message</span>
     </div>
    <div id="msgholder"></div>
    <!-- BEGIN Main Content --> 
    <!-- form inputs -->
    <div class="row">
      <div class="col-md-4 col-pos">
        <div class="box">
          <div class="box-title">
            <h3><i class="icon-list"></i>Menu</h3>
            
          </div>
          <div class="box-content frms">
            <div class="sortable ui-sortable">
             <?php echo $this->menuDisplayString; ?>
            </div>
            <div class="btns">
              <button class="btn btn-danger show-tooltip" data-original-title="Reset" id="loadreset"><i class="icon-refresh"></i></button>
              <button class="btn btn-success show-tooltip" data-original-title="Save" id="serialize" ><i class="icon-save "></i></button>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="box">
          <div class="box-title">
            <h3><i class="icon-reorder"></i>Menu Item</h3>
            
          </div>
           
          <div class="box-content frms">
          <form method="post" action="<?php echo SITEURL; ?>menus/addMenuDetails" class="form-horizontal" id="validation-form" autocomplete="off">
           
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Menu Name</label>
                <div class="col-lg-12 controls">
                  <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-text-width"></i><strong>Menu Name</strong></span>
                    <input type="text" data-rule-minlength="3" data-rule-required="true" class="form-control" id="username" name="menu_name" placeholder="Menu Name">
                  </div>
                </div>
              </div>
             
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Menu Parent</label>
                <div class="col-lg-12 controls">
                  <div class="input-group"> <span class="input-group-addon"><i class="icon-chevron-down"></i><strong>Menu Parent</strong></span>
                    <select name='menu_parentid' data-placeholder="Select Parent Menu" class="form-control chosen-with-diselect select-search" tabindex="-1" id="selCSI">
                      <option value="0">Top Level</option>
                      <?php echo $this->menuString;    ?>
                    </select>
                  </div>
                </div>
              </div>                 
                  
                    <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Content Type</label>
                <div class="col-lg-12 controls">
                  <div class="input-group"> <span class="input-group-addon"><i class="icon-chevron-sign-down"></i><strong>Content Type</strong></span>
                    <select name='menu_contenttype' data-rule-required="true" data-placeholder="Your Favorite Type of Bear" class="form-control chosen-with-diselect select-search" tabindex="-1" id="menu_contenttype">
                      <option value="">Select content</option>
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
                          <strong>Select Content</strong></span>
                      <span id='conid'>
                    <select data-rule-required="true" id="select" name="select" class="form-control ">
                      <option value="">-- Please select Content --</option>
                     </select>
                      </span>
                  </div>
                </div>
              </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Menu Icon</label>
                <div class="col-lg-12 controls">
                     <div class="input-group"><span class="input-group-addon hide-span"><i class="icon-circle"></i><strong>Menu icon</strong></span>
                  <div class="input-group radio-list">
                <ul class="odd">
                  <li class="even">
                      <input type="radio" checked="" id="rd1" class="regular-radio" value="ellipsis-horizontal" name="menu_icon">
                    <label for="rd1"></label>
                    <i class="icon-ellipsis-horizontal"></i><span>No Icon Required</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd2" class="regular-radio" value="refresh" name="menu_icon">
                    <label for="rd2"></label>
                    <i class="icon-refresh"></i><span>Reload</span> </li>
                  <li class="even">
                    <input type="radio" id="rd3" class="regular-radio" value="3" name="menu_icon">
                    <label for="rd3"></label>
                    <i class="glyphicon glyphicon-flash"></i><span>Flash</span> </li>
                </ul>
                <ul class="even">
                  <li class="odd">
                    <input type="radio" id="rd4" class="regular-radio" value="desktop" name="menu_icon">
                    <label for="rd4"></label>
                    <i class="icon-desktop"></i><span>Tv</span> </li>
                  <li class="even">
                    <input type="radio" id="rd5" class="regular-radio" value="building" name="menu_icon">
                    <label for="rd5"></label>
                    <i class="icon-building"></i><span>Switch</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd6" class="regular-radio" value="undo" name="menu_icon">
                    <label for="rd6"></label>
                    <i class="icon-undo"></i><span>Undo</span> </li>
                </ul>
                <ul class="odd">
                  <li class="even">
                    <input type="radio" id="rd7" class="regular-radio" value="phone" name="menu_icon">
                    <label for="rd7"></label>
                    <i class="icon-phone"></i><span>Phone</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd8" class="regular-radio" value="search" name="menu_icon">
                    <label for="rd8"></label>
                    <i class="icon-search"></i><span>Search</span> </li>
                  <li class="even">
                    <input type="radio" id="rd9" class="regular-radio" value="user" name="menu_icon">
                    <label for="rd9"></label>
                    <i class="icon-user"></i><span>User</span> </li>
                </ul>
                <ul class="even">
                  <li class="odd">
                    <input type="radio" id="rd10" class="regular-radio" value="arrow-right" name="menu_icon">
                    <label for="rd10"></label>
                    <i class="icon-arrow-right"></i><span>Arrow</span> </li>
                  <li class="even">
                    <input type="radio" id="rd11" class="regular-radio" value="volume-up" name="menu_icon">
                    <label for="rd11"></label>
                    <i class="icon-volume-up"></i><span>Volume</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd12" class="regular-radio" value="circle-arrow-left" name="menu_icon">
                    <label for="rd12"></label>
                    <i class="icon-circle-arrow-left"></i><span>Track back</span> </li>
                </ul>
                <ul class="odd">
                  <li class="even">
                    <input type="radio" id="rd13" class="regular-radio" value="forward" name="menu_icon">
                    <label for="rd13"></label>
                    <i class="icon-forward"></i><span>Forward</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd14" class="regular-radio" value="bullseye" name="menu_icon">
                    <label for="rd14"></label>
                    <i class="icon-bullseye"></i><span>Cd</span> </li>
                  <li class="even">
                    <input type="radio" id="rd15" class="regular-radio" value="male" name="menu_icon">
                    <label for="rd15"></label>
                    <i class="icon-male"></i><span>Men</span> </li>
                </ul>
                <ul class="even">
                  <li class="odd">
                    <input type="radio" id="rd16" class="regular-radio" value="female" name="menu_icon">
                    <label for="rd16"></label>
                    <i class="icon-female"></i><span>Women</span> </li>
                  <li class="even">
                    <input type="radio" id="rd17" class="regular-radio" value="plus" name="menu_icon">
                    <label for="rd17"></label>
                    <i class="icon-plus"></i><span>Add</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd18" class="regular-radio" value="trash" name="menu_icon">
                    <label for="rd18"></label>
                    <i class="icon-trash"></i><span>Delete</span> </li>
                </ul>
                <ul class="odd">
                  <li class="even">
                    <input type="radio" id="rd19" class="regular-radio" value="envelope" name="menu_icon">
                    <label for="rd19"></label>
                    <i class="icon-envelope"></i><span>Message</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd20" class="regular-radio" value="star" name="menu_icon">
                    <label for="rd20"></label>
                    <i class="icon-star"></i><span>Star</span> </li>
                  <li class="even">
                    <input type="radio" id="rd21" class="regular-radio" value="upload" name="menu_icon">
                    <label for="rd21"></label>
                    <i class="icon-upload"></i><span>Upload</span> </li>
                </ul>
                <ul class="even">
                  <li class="odd">
                    <input type="radio" id="rd22" class="regular-radio" value="move" name="menu_icon">
                    <label for="rd22"></label>
                    <i class="icon-move"></i><span>Move</span> </li>
                  <li class="even">
                    <input type="radio" id="rd23" class="regular-radio" value="music" name="menu_icon">
                    <label for="rd23"></label>
                    <i class="icon-music"></i><span>Music</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd24" class="regular-radio" value="off" name="menu_icon">
                    <label for="rd24"></label>
                    <i class="icon-off"></i><span>Off</span> </li>
                </ul>
                <ul class="odd">
                  <li class="even">
                    <input type="radio" id="rd25" class="regular-radio" value="ok" name="menu_icon">
                    <label for="rd25"></label>
                    <i class="icon-ok"></i><span>Ok</span> </li>
                  <li class="odd">
                    <input type="radio" id="rd26" class="regular-radio" value="rss" name="menu_icon">
                    <label for="rd26"></label>
                    <i class="icon-rss"></i><span>Rss</span> </li>
                  <li class="even">
                    <input type="radio" id="rd27" class="regular-radio" value="reply" name="menu_icon">
                    <label for="rd27"></label>
                    <i class="icon-reply"></i><span>Reply</span> </li>
                </ul>
               
              </div>
                    </div><!-- rc-div end -->   
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
                      <label>In-Active</label>
                    </div>
                   
                 </div><!-- rc-div end -->   
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                  <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                  <a href = "<?php echo SITEURL; ?>"><button class="btn" type="button" id="cancel">Cancel</button></a>
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
    //$("#divsuccess").fadeOut(5000);
    $('#loadreset').click(function () {  
        loadList();
    });         
    function loadList() {
   
        $.ajax({
            type: 'post',
            url: "<?php echo SITEURL;?>menus/ajaxDisplayMenu",
            data: 'getmenus=1',
            cache: false,
            success: function (html) {
                $("div.sortable").html(html);
            }
        });
    }
    loadList();
    function showResponse(msg) {
        $(this).html(msg);
        setTimeout(function () {
            $(loadList()).fadeIn("slow");
        }, 2000);
        $("html, body").animate({
            scrollTop: 0
        }, 600);
    }
    $('div.sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div'
    });
    $('#serialize').click(function () {
        serialized = $('.sortable').nestedSortable('serialize');
        serialized += '&sortmenuitems=1';
        
        $.ajax({
            type: 'post',
            url: "<?php echo SITEURL;?>menus/ajaxSaveMenu",
            data: serialized,
            success: function (msg) {
			//$("#msgholder").html(msg);
			//$(loadList()).fadeIn("slow");
                        $("#divSuccessMsg").show();
                        $("#divSuccessMsg").html(msg);
                        $(loadList()).fadeIn("slow");	
                        $("#divSuccessMsg").fadeOut(10000);
            }

        });
    });
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
function deleteMenu(id){ 
    if(confirm("Are You Sure Delete!")){    
    $.ajax({
            type: "POST",
            url: "<?php echo SITEURL;?>menus/deleteMenuItems",
            data: 'deletId='+ id +'&delete=delete',
            success:function(data) {
             //document.location.reload();
             //alert(data);
             $('#list_'+id).hide();
             $('#divSuccessMsg').show();
            $('#divSuccessMsg').html("<i class='icon-check'></i><span class='text-success'>Record deleted Sucessfully </span>")
            .fadeIn(1000).fadeOut(5000); 
            }
            });
    } else {
        return false;
    }
}
</script>

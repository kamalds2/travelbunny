<?php

/**

 *  Menus Management

 * 

 * PHP version 5

 * 

 * @author Siri <contact@siriinnovations.com>

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

        <li class="active">Pages</li>

      </ul>

    </div>

    <!-- END Breadcrumb --> 

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

            <h3><i class="icon-reorder"></i>Form Inputs</h3>

            

          </div>

           

          <div class="box-content frms">

           <form method="post" action="<?php echo SITEURL; ?>menus/updateMenuDetails" class="form-horizontal" id="validation-form">           

           <div class="form-group">

                <label class="col-sm-3 col-lg-2 control-label">Menu Name</label>

                <div class="col-lg-12 controls">

                  <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-text-width"></i><strong>Menu Name</strong></span>

                    <input type="text" data-rule-minlength="3" value="<?php echo $this->menuDetails['menu_name'];?>" data-rule-required="true" class="form-control" id="username" name="menu_name" placeholder="Menu Name">

                  </div>

                </div>

              </div>

             

                <div class="form-group">

                <label class="col-sm-3 col-lg-2 control-label">Menu Parent</label>

                <div class="col-lg-12 controls">

                  <div class="input-group"> <span class="input-group-addon"><i class="icon-chevron-down"></i><strong>Menu Parent</strong></span>

                    <select name='menu_parentid' data-placeholder="Select Parent Menu" class="form-control chosen-with-diselect select-search" tabindex="-1" id="selCSI">

                      <?php if($this->menuDetails['menu_parentid'] == 0){?>

                      <option value="0" selected> Top Level</option>

                      <?php }else{?>

                      <option value='<?php echo $this->menuDetails['menu_parentid'];?>' selected><?php echo $this->parent['menu_name'];?></option>

                       <option value="0" > Top Level</option>

                      <?php }?>

                  

                      <?php

                      echo $this->menuString;

                      ?>

                    </select>

                  </div>

                </div>

              </div>

                  

               <div class="form-group">

                <label class="col-sm-3 col-lg-2 control-label">Content Type</label>

                <div class="col-lg-12 controls">

                  <div class="input-group"> <span class="input-group-addon"><i class="icon-chevron-sign-down"></i><strong>Content Type</strong></span>

                    <select name='menu_contenttype' data-placeholder="Your Favorite Type of Bear" class="form-control chosen-with-diselect select-search" tabindex="-1" id="menu_contenttype">

                      <option value=""> Select content</option>

                      <option value="page" <?php if($this->menuDetails['menu_contenttype'] == 'page') echo "selected"; ?>>Content Page</option>

                      <option value="module"<?php if($this->menuDetails['menu_contenttype'] == 'module') echo "selected"; ?> >Module</option>

                      <option value="web" <?php if($this->menuDetails['menu_contenttype'] == 'web') echo "selected"; ?>>External Link</option>

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

                          <?php echo $this->contentStr; ?>

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

                      <input type="radio" checked="" <?php if($this->menuDetails['menu_icon'] == 'ellipsis-horizontal') echo "checked"; ?> id="rd1" class="regular-radio" value="ellipsis-horizontal" name="menu_icon">

                    <label for="rd1"></label>

                    <i class="icon-ellipsis-horizontal"></i><span>No Icon Required</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd2" <?php if($this->menuDetails['menu_icon'] == 'refresh') echo "checked"; ?> class="regular-radio" value="refresh" name="menu_icon">

                    <label for="rd2"></label>

                    <i class="icon-refresh"></i><span>Reload</span> </li>

                  <li class="even">

                    <input type="radio" id="rd3" <?php if($this->menuDetails['menu_icon'] == 'flash') echo "checked"; ?> class="regular-radio" value="flash" name="menu_icon">

                    <label for="rd3"></label>

                    <i class="glyphicon glyphicon-flash"></i><span>Flash</span> </li>

                </ul>

                <ul class="even">

                  <li class="odd">

                    <input type="radio" id="rd4" <?php if($this->menuDetails['menu_icon'] == 'desktop') echo "checked"; ?> class="regular-radio" value="desktop" name="menu_icon">

                    <label for="rd4"></label>

                    <i class="icon-desktop"></i><span>Tv</span> </li>

                  <li class="even">

                    <input type="radio" id="rd5" <?php if($this->menuDetails['menu_icon'] == 'building') echo "checked"; ?> class="regular-radio" value="building" name="menu_icon">

                    <label for="rd5"></label>

                    <i class="icon-building"></i><span>Switch</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd6" <?php if($this->menuDetails['menu_icon'] == 'undo') echo "checked"; ?> class="regular-radio" value="undo" name="menu_icon">

                    <label for="rd6"></label>

                    <i class="icon-undo"></i><span>Undo</span> </li>

                </ul>

                <ul class="odd">

                  <li class="even">

                    <input type="radio" id="rd7" <?php if($this->menuDetails['menu_icon'] == 'phone') echo "checked"; ?> class="regular-radio" value="phone" name="menu_icon">

                    <label for="rd7"></label>

                    <i class="icon-phone"></i><span>Phone</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd8" <?php if($this->menuDetails['menu_icon'] == 'search') echo "checked"; ?> class="regular-radio" value="search" name="menu_icon">

                    <label for="rd8"></label>

                    <i class="icon-search"></i><span>Search</span> </li>

                  <li class="even">

                    <input type="radio" id="rd9" <?php if($this->menuDetails['menu_icon'] == 'user') echo "checked"; ?> class="regular-radio" value="user" name="menu_icon">

                    <label for="rd9"></label>

                    <i class="icon-user"></i><span>User</span> </li>

                </ul>

                <ul class="even">

                  <li class="odd">

                    <input type="radio" id="rd10" <?php if($this->menuDetails['menu_icon'] == 'arrow-right') echo "checked"; ?> class="regular-radio" value="arrow-right" name="menu_icon">

                    <label for="rd10"></label>

                    <i class="icon-arrow-right"></i><span>Arrow</span> </li>

                  <li class="even">

                    <input type="radio" id="rd11" <?php if($this->menuDetails['menu_icon'] == 'volume-up') echo "checked"; ?> class="regular-radio" value="volume-up" name="menu_icon">

                    <label for="rd11"></label>

                    <i class="icon-volume-up"></i><span>Volume</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd12" <?php if($this->menuDetails['menu_icon'] == 'circle-arrow-left') echo "checked"; ?> class="regular-radio" value="circle-arrow-left" name="menu_icon">

                    <label for="rd12"></label>

                    <i class="icon-circle-arrow-left"></i><span>Track back</span> </li>

                </ul>

                <ul class="odd">

                  <li class="even">

                    <input type="radio" <?php if($this->menuDetails['menu_icon'] == 'forward') echo "checked"; ?> id="rd13" class="regular-radio" value="forward" name="menu_icon">

                    <label for="rd13"></label>

                    <i class="icon-forward"></i><span>Forward</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd14" <?php if($this->menuDetails['menu_icon'] == 'bullseye') echo "checked"; ?> class="regular-radio" value="bullseye" name="menu_icon">

                    <label for="rd14"></label>

                    <i class="icon-bullseye"></i><span>Cd</span> </li>

                  <li class="even">

                    <input type="radio" id="rd15" <?php if($this->menuDetails['menu_icon'] == 'male') echo "checked"; ?> class="regular-radio" value="male" name="menu_icon">

                    <label for="rd15"></label>

                    <i class="icon-male"></i><span>Men</span> </li>

                </ul>

                <ul class="even">

                  <li class="odd">

                    <input type="radio" id="rd16" <?php if($this->menuDetails['menu_icon'] == 'female') echo "checked"; ?> class="regular-radio" value="female" name="menu_icon">

                    <label for="rd16"></label>

                    <i class="icon-female"></i><span>Women</span> </li>

                  <li class="even">

                    <input type="radio" id="rd17" <?php if($this->menuDetails['menu_icon'] == 'plus') echo "checked"; ?> class="regular-radio" value="plus" name="menu_icon">

                    <label for="rd17"></label>

                    <i class="icon-plus"></i><span>Add</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd18" <?php if($this->menuDetails['menu_icon'] == 'trash') echo "checked"; ?> class="regular-radio" value="trash" name="menu_icon">

                    <label for="rd18"></label>

                    <i class="icon-trash"></i><span>Delete</span> </li>

                </ul>

                <ul class="odd">

                  <li class="even">

                    <input type="radio" id="rd19" <?php if($this->menuDetails['menu_icon'] == 'envelope') echo "checked"; ?> class="regular-radio" value="envelope" name="menu_icon">

                    <label for="rd19"></label>

                    <i class="icon-envelope"></i><span>Message</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd20" <?php if($this->menuDetails['menu_icon'] == 'star') echo "checked"; ?> class="regular-radio" value="star" name="menu_icon">

                    <label for="rd20"></label>

                    <i class="icon-star"></i><span>Star</span> </li>

                  <li class="even">

                    <input type="radio" id="rd21" <?php if($this->menuDetails['menu_icon'] == 'upload') echo "checked"; ?> class="regular-radio" value="upload" name="menu_icon">

                    <label for="rd21"></label>

                    <i class="icon-upload"></i><span>Upload</span> </li>

                </ul>

                <ul class="even">

                  <li class="odd">

                    <input type="radio" id="rd22" <?php if($this->menuDetails['menu_icon'] == 'move') echo "checked"; ?> class="regular-radio" value="move" name="menu_icon">

                    <label for="rd22"></label>

                    <i class="icon-move"></i><span>Move</span> </li>

                  <li class="even">

                    <input type="radio" id="rd23" <?php if($this->menuDetails['menu_icon'] == 'music') echo "checked"; ?> class="regular-radio" value="music" name="menu_icon">

                    <label for="rd23"></label>

                    <i class="icon-music"></i><span>Music</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd24" <?php if($this->menuDetails['menu_icon'] == 'off') echo "checked"; ?> class="regular-radio" value="off" name="menu_icon">

                    <label for="rd24"></label>

                    <i class="icon-off"></i><span>Off</span> </li>

                </ul>

                <ul class="odd">

                  <li class="even">

                    <input type="radio" id="rd25" <?php if($this->menuDetails['menu_icon'] == 'ok') echo "checked"; ?> class="regular-radio" value="ok" name="menu_icon">

                    <label for="rd25"></label>

                    <i class="icon-ok"></i><span>Ok</span> </li>

                  <li class="odd">

                    <input type="radio" id="rd26" <?php if($this->menuDetails['menu_icon'] == 'rss') echo "checked"; ?> class="regular-radio" value="rss" name="menu_icon">

                    <label for="rd26"></label>

                    <i class="icon-rss"></i><span>Rss</span> </li>

                  <li class="even">

                    <input type="radio" id="rd27" <?php if($this->menuDetails['menu_icon'] == 'reply') echo "checked"; ?> class="regular-radio" value="reply" name="menu_icon">

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

                        <input type="radio" <?php if($this->menuDetails['menu_status'] == 'y') echo "checked"; ?> name="menu_status" value="y" class="regular-radio" id="r1" checked="checked" />

                      <label for="r1"></label>

                      <label>Active</label>

                    </div>

                    <div class="radio-inline">

                      <input type="radio" <?php if($this->menuDetails['menu_status'] == 'n') echo "checked"; ?> name="menu_status" value="n" class="regular-radio" id="r2" />

                      <label for="r2"></label>

                      <label>Deactive</label>

                    </div>

                   

                 </div><!-- rc-div end -->   

                  </div>

                </div>

              </div>

              <div class="form-group">

                <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">

                    <input type="hidden" name="menuId" value="<?php echo $this->menuDetails['menu_id'];?>">

                    <input type="hidden" name="pageId" id="pageId" value="<?php echo $this->menuDetails['menu_pageid'];?>">

                    <input type="hidden" name="moduleId" id="moduleId" value="<?php echo $this->menuDetails['menu_moduleid'];?>">

                    <input type="hidden" name="extLink" id="extLink" value="<?php echo $this->menuDetails['menu_link'];?>">

                  <input type="submit" value="Update" name="submit" class="btn btn-primary">

                  <button id="cancel" class="btn" type="button">Cancel</button>

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

    $('#loadreset').click(function () {  

        loadList();

    }); 

    loadList();

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

                $("#divSuccessMsg").show();

                $("#divSuccessMsg").html(msg);

                $(loadList()).fadeIn("slow");	

                $("#divSuccessMsg").fadeOut(10000);

            }

        });

    });    

    $(".delete").click(function() {

         if(confirm("Are You Sure Delete!")) {

            var delId = $(this).attr('id');

            $.ajax({

               type: "POST",

               url: "<?php echo SITEURL;?>menus/deleteMenuItems",

               data: 'deletId='+ delId +'&delete=delete',

               success:function(data) {

                 alert(data);

               }

            });

         } 

         else {

            return false;

         }

    });    

    $('#menu_contenttype').change(function () {

      var option = $('#menu_contenttype').val();

      if(option == 'page') {

            var pageid = $('#pageId').val();

            $.ajax({

                url:'<?php echo SITEURL; ?>menus/getAllPages',

                type: 'POST',

                datatype:'application/json',

                success:function(data) {

                    var htmlString ='';

                    htmlString += "<select data-rule-required='true' id='select' name='menu_pageid' class='form-control'>";

                    htmlString += "<option value=''>Select page</option>";

                    $.each(data,function(i) {

                        if(pageid == data[i]['page_id']) {

                            var sel = "selected";

                        }

                        else{

                            var sel = "";

                        }

                        htmlString += "<option value="+ data[i]['page_id'] +" " + sel+ " >" + data[i]['page_title'] + "</option>";

                    });

                    htmlString += "</select>";

                    $("#conid").html(htmlString);

                }

             });

       } 

       else if(option == 'module') {

            var moduleid = $('#moduleId').val();

            $.ajax({

                url:'<?php echo SITEURL; ?>menus/getAllModules',

                type: 'POST',

                datatype:'application/json',

                success:function(data) {       

                    var htmlString ='';

                    htmlString += "<select data-rule-required='true' id='select' name='menu_moduleid' class='form-control'>";

                    htmlString += "<option value=''>Select Module</option>";

                    $.each(data,function(i){

                        if(moduleid == data[i]['module_id']){

                            var sel = "selected";

                        }

                        else{

                            var sel = "";

                        }

                        htmlString += "<option value="+ data[i]['module_id'] +" " + sel + ">" + data[i]['module_name'] + "</option>";

                    });

                    htmlString += "</select>";

                    $("#conid").html(htmlString);

                }

            });

       } 

       else {

           var extlink = $('#extLink').val();

           var htmlString = '';

           htmlString += "<input name='menu_link' type='text'  value='" + extlink + "' size='25'>";

           htmlString += "<select name='menu_target' style='width:100px;' class='select'>";

           htmlString += "<option value=''>target</option>";

           htmlString += "<option value='_blank'>Blank</option>";

	   htmlString += "<option value='_self'>Self</option>";

           htmlString += "</select></div>";

	   htmlString += "<input name='page_id' type='hidden' value='0' />";

          $('#conid').html(htmlString).show();

        }

     });

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

function showResponse(msg) {

    $(this).html(msg);

    setTimeout(function () {

        $(loadList()).fadeIn("slow");

    }, 2000);

    $("html, body").animate({

        scrollTop: 0

    }, 600);

}

</script>

   <script type="text/javascript"> 

// <![CDATA[

$(document).ready(function () {

$('#cancel').click(function() {

   if(confirm("Are you sure you want to navigate away from this page?"))

   {

      history.go(-1);

   }        

   return false;

});

});

</script>


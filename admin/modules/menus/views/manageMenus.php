<style type="text/css">
    body {
        font-family: sans-serif;
        background: #fff5f5;
    }
    input, button {
        font-size: 15px;
        padding: 5px;
    }
    button {
        background: #333;
        color: #fff;
    }

    /**
    * Nestable Draggable Handles
    */
    .dd3-content {
        display: block;
        height: 45px;
        padding: 5px 10px 5px 54px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        line-height: 32px; 
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 0;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd3-content:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-dragel > .dd3-item > .dd3-content {
        margin: 0;
    }

    
    .dd3-item {
        margin: 10px 0;
    }
    .dd3-item > button {
        margin-left: 30px;
    }

    .dd3-handle {
        position: absolute;
        margin: 0;
        left: 0;
        top: 0;
        cursor: move;
        width: 45px;
        height: 45px;
        text-indent: 70px;
        white-space: nowrap;
        overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: linear-gradient(top, #ddd 0%, #bbb 100%);
        border-radius: 0;
    }

    .dd3-handle:before {
        content: '≡';
        display: block;
        position: absolute;
        left: 0;
        top: 12px;
        width: 100%;
        text-align: center;
        text-indent: 0;
        color: #fff;
        font-size: 25px;
        font-weight: bolder;
    }

    .dd3-handle:hover {
        background: #ddd;
    }

    .item-edit {
        font-size: 13px;
        float: right;
        color: rgb(49, 35, 248);
        cursor: pointer;
    }
    .item-edit:hover {
        text-decoration: underline;
    }

    .item-settings.d-none {
        display: none!important;
    }
    .item-settings {
        display: block;
        padding: 10px;
        position: relative;
        z-index: 10;
        border: 1px solid #e5e5e5;
        background: #fff;
        border-top: none;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    .item-settings p {
        margin-top: 0;
    }

    .item-settings p label {
        font-size: 13px;
        color: #666;
        line-height: 1.5;
    }

    .item-settings p label input {
        border: 1px solid #ddd;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
        background-color: #fff;
        color: #32373c;
        outline: 0;
        border-spacing: 0;
        width: -webkit-fill-available;
        clear: both;
        margin: 0;
        font-size: 14px;
        padding: 5px;
        border-radius: 0;
    }

    .item-settings .item-delete {
        color: #a00;
    }

</style>


        <!-- Begin page -->
<div id="layout-wrapper"> 
    <style>

        .form-check-input {
            background-color: #e5e5e5;
        }
        .blockquote {
                border-left: 4px solid #224a98;
        }
        .blockquote h5{
            color: #224a98;
        }
    </style>
<div class="main-content">

<div class="page-content">
  <div class="card mt-n4 mx-n3 border-0 rounded-0 bg-primary-subtle breadcrumb_bg">
    <div class="card-body pb-0 px-4">
      <div class="container-fluid">
        <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
          <div class="col-lg-4">
            <h4 class="mb-0">Menus</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row mt-n5">
      <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <?php if($this->session->gets('success_msg')) { ?>
                    <div class="mb-3" id="successMessage"> 
                        <div class="alert alert-success text-center" role="alert">
                        <strong><?php echo $this->session->gets('success_msg'); ?>! </strong>  
                        <?php unset($_SESSION['success_msg']); ?>
                    </div>
  
                <?php  } ?>
                <?php if($this->session->gets('error_msg')) { ?>
                    <div class="mb-3"> 
                        <div class="alert alert-danger mb-xl-0 text-center" role="alert">
                            <strong> <?php echo $this->session->gets('success_msg'); ?>! </strong>  —check it out! <?php unset($_SESSION['error_msg']); ?>
                        </div>
                    </div>
                <?php } ?>
                 
                    <div class="mb-3" > 
                        <div class="alert alert-success text-center" id="divSuccessMsg" style="display: none;" role="alert">
                        <strong> Updated Succesfully ! </strong>  
                    </div>
                 
            </div>  
          <div class="card-body">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  
                  <div class="col-sm-6">
                    <div class="card p-3">
                      <figure class="mb-0">
                          <blockquote class="blockquote">
                              <h5 class="mb-0">Menu Title</h5>
                          </blockquote>
                      </figure>
                      <form id="addMenuForm" action="<?php echo SITEURL;?>menus/addMenuDetails" method="post">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="mb-3">
                              <label for="firstNameinput" class="form-label">Menu Name*</label>
                              <input type="text" class="form-control" placeholder="Menu Name" id="firstNameinput" name="menu_name">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="mb-3">
                              <label for="" class="form-label">Menu Parent</label>
                              <select id="" class="form-select" name="menu_parentid" >
                                <option value="0" selected>Top Level</option>
                                  <?php echo $this->menuString; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="mb-3">
                              <label for="menu_contenttype" class="form-label">Content Type*</label>
                              <select id="menu_contenttype" class="form-select"  name="menu_contenttype">
                                  <option value="" selected>Select Content</option>
                                  <option value="page">Content Page</option>
                                  <option value="module">Module</option>
                                  <option value="web">External Link</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="mb-3">
                              <label for="conid" class="form-label">Select Content*</label>
                              <span id="conid">
                                <select  class="form-select"  >
                                  <option selected>--Please Select Content--</option>
                                </select>
                              </span>
                            </div>
                          </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                              <label for="" class="form-label">Menu icon</label>
                
                                <div class="row">
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault1" value="noicon">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                              <i class="mdi mdi-dots-horizontal"></i> No Icon Required
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault2" value="reload">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                              <i class="mdi mdi-autorenew"></i> Reload
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault3">
                                            <label class="form-check-label" for="flexRadioDefault3">
                                              <i class="mdi mdi-flash-outline"></i> Flash
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault4">
                                            <label class="form-check-label" for="flexRadioDefault4">
                                              <i class="mdi mdi-television"></i> TV
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault5">
                                            <label class="form-check-label" for="flexRadioDefault5">
                                              <i class="mdi mdi-office-building-outline"></i> Switch
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault6">
                                            <label class="form-check-label" for="flexRadioDefault6">
                                              <i class="mdi mdi-undo"></i> Undo
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault7">
                                            <label class="form-check-label" for="flexRadioDefault7">
                                              <i class="mdi mdi-phone"></i> Phone
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault8">
                                            <label class="form-check-label" for="flexRadioDefault8">
                                              <i class="mdi mdi-magnify"></i> Search
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault9">
                                            <label class="form-check-label" for="flexRadioDefault9">
                                              <i class="mdi mdi-account-circle-outline"></i> User
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault10">
                                            <label class="form-check-label" for="flexRadioDefault10">
                                              <i class="mdi mdi-arrow-right"></i> Arrow
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault11">
                                            <label class="form-check-label" for="flexRadioDefault11">
                                              <i class="mdi mdi-volume-high"></i> Volume
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault12">
                                            <label class="form-check-label" for="flexRadioDefault12">
                                              <i class="mdi mdi-arrow-left-circle-outline"></i> Track Back
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault13">
                                            <label class="form-check-label" for="flexRadioDefault13">
                                              <i class="mdi mdi-skip-forward-outline"></i> Forward
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault14">
                                            <label class="form-check-label" for="flexRadioDefault14">
                                              <i class="mdi mdi-disc"></i> CD
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="menu_icon" id="flexRadioDefault15">
                                            <label class="form-check-label" for="flexRadioDefault15">
                                              <i class="mdi mdi-account"></i> Men
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                </div>                                                            
                            </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="" class="form-label">Menu Status</label>
                
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio"  id="flexRadioDefault16"  name="menu_status" value="y" >
                            <label class="form-check-label" for="flexRadioDefault16">
                               Active
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio"  id="flexRadioDefault17"  name="menu_status" value="n" >
                            <label class="form-check-label" for="flexRadioDefault17">
                             In-Active
                            </label>
                        </div>
                    </div>
                    
                    
                </div>

            </div>
            
        </div>


        <div class="col-md-12">
            <div class="mb-3">
               <div class="text-start">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger">Cancel</button>
            </div>
        </div>                                                                
        </div>

    </div>
</form>
</div>
</div>
<div class="col-sm-6">
                    <div class="card p-3">
                      <figure class="mb-0">
                        <blockquote class="blockquote">
                          <h5 class="mb-0">Menu</h5>
                          <div class="dd" id="nestable">
                            <?php echo $this->menuDisplayString; ?>
                          </div>
                          <div class="btns">
                            <button class="btn btn-danger show-tooltip" data-original-title="Reset" id="loadreset"><i class="bi bi-recycle"></i></button>
                            <button class="btn btn-success show-tooltip" data-original-title="Save" id="serialize" ><i class="bi bi-save "></i></button>
                          </div>
                        </blockquote>
                      </figure>
                    </div>
                  </div>
                        </div>
                    </div>
                </div>
                    </div>  
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>

</div>











<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
$("#divsuccess").fadeOut(5000);
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


$('#serialize').click(function () {
    serialized = JSON.stringify($('#nestable').nestable('serialize'));
    //serialized += '&sortmenuitems=1';

    $.ajax({
        method: 'post',
        url: "<?php echo SITEURL;?>menus/ajaxSaveMenu",
        data: 'menu='+serialized,
        success: function (msg) {
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
            console.log(JSON.parse(data));
            data = JSON.parse(data);
            var htmlString ='';
            htmlString += '<select id="select" class="form-select" name="menu_pageid" >';
            htmlString += '<option value="" selected >Select Page</option>';  
            $.each(data,function(i){
                console.log(data[i]);
                htmlString +='<option value='+data[i]["page_id"]+'>'+data[i]["page_title"]+'</option>';
            });
            htmlString+='</select>';
            $("#conid").empty();
            $("#conid").html(htmlString);
        }
    });
}else if(option == 'module') {
    $.ajax({
        url:'<?php echo SITEURL; ?>menus/getAllModules',
        type: 'POST',
        datatype:'application/json',
        success:function(data){
            data = JSON.parse(data);
            console.log(data);
            var htmlString ='';
            htmlString+="<select  id='select' name='menu_moduleid' class='form-control'>"
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
    htmlString += "<input name='menu_link' type='text' class='form-control'  value='' size='25'>"
    htmlString += "<select name='menu_target' style='width:100px;' class='select'>"
    htmlString += "<option value=''>target</option>"
    htmlString += "<option value='_blank'>Blank</option>"
    htmlString += "<option value='_self'>Self</option>"
    htmlString += "</select></div>"
    htmlString += "<input name='page_id' type='hidden' value='0' />";
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


$(document).ready(function () {

    var updateOutput = function () {
    $('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
    };

    $('#nestable').nestable().on('change', updateOutput);

    updateOutput();


    $("body").delegate(".item-delete", "click", function (e) {
        $(this).closest(".dd-item").remove();
        updateOutput();
    });


    $("body").delegate(".item-edit, .item-close", "click", function (e) {
        var item_setting = $(this).closest(".dd-item").find(".item-settings");
        if (item_setting.hasClass("d-none")) {
        item_setting.removeClass("d-none");
        } else {
        item_setting.addClass("d-none");
        }
    });

    $("body").delegate("input[name='navigation_label']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("label", $(this).val());
        $(this).closest(".dd-item").find(".dd3-content span").text($(this).val());
    });

    $("body").delegate("input[name='navigation_url']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("url", $(this).val());
    });

});

$(document).on('click', '.delete_menu', function() { 
    var delId = $(this).data('id'); 
    console.log(delId);
    bootbox.confirm({
    title: "<strong>Confirmation</strong> Box",
        message: "Are you sure, you want to delete?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            console.log(delId);
            if(result) {    
                console.log(delId);        
            jQuery.ajax({
                type: "POST",             
                url:"<?php echo SITEURL; ?>menus/deleteMenuItem",
                data: 'deletId='+ delId,
                success: function(data) {
                    console.log(delId);
                    console.log(data);
                    document.location.reload();
                }
            });
          }
        }
    });
});
</script> 
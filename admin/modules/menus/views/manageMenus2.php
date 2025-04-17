<!-- Begin page -->
<div id="layout-wrapper">
    <div class="main-content">                
        <div class="page-content">
            <div class="card mt-n4 mx-n3 border-0 rounded-0 bg-primary-subtle breadcrumb_bg">
                <div class="card-body pb-0 px-4">
                    <div class="container-fluid">
                        <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                            <div class="col-lg-4">
                                <h4 class="mb-0">Pages</h4>
                            </div>
                            <div class="col-lg-2">
                                <a type="button" class="btn btn-primary w-100 addContact-modal" href="<?php echo SITEURL?>pages/addPage"  ><i class="bi bi-plus align-middle"></i> Add Page</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid"> 
            <div class="row mt-n5">               
                 
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="addPagesForm"   class="needs-validation p-2" novalidate method="post" action="<?php echo SITEURL?>menus/addMenuDetails" enctype="multipart/form-data">
                         
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="menu_name" class="form-label">Menu Name</label>
                                    <input type="text" class="form-control" name="menu_name" id="menu_name" required />                                
                                </div>
                                <div class="col-lg-12 mb-3">                                 
                                    <label for="label" class="form-label">Menu Parent:</label>
                                    <select class="form-select" id="label" name="menu_parentid" required>
                                        <option value="0" >Top Level</option>
                                        <?php echo $this->menuString;    ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="menu_contenttype" class="form-label">Content Type</label>
                                    <select class="form-select" id="menu_contenttype" name="menu_contenttype" required>
                                        <option value="">Select content</option>
                                        <option value="page">Content Page</option>
                                        <option value="module">Module</option>
                                        <option value="web">External Link</option>
                                    </select>                          
                                </div>
                                <div class="col-lg-12 mb-3">                                 
                                    <label for="" class="form-label">Select Content:</label> 
                                    <select class="form-select" id="" name="conid" required>
                                        <option value="">Select content</option> 
                                    </select> 
                                </div>
                                <div class="col-md-6 mb-3">                                 
                                    <label for="image" class="form-label">Menu Icon</label>
                                    <div class="input-group radio-list">
                                        <ul class="odd">
                                            <li class="even">
                                                <input type="radio" checked="" id="rd1" class="regular-radio" value="ellipsis-horizontal" name="menu_icon">
                                                <label for="rd1"></label>
                                                <i class="icon-ellipsis-horizontal"></i><span>No Icon Required</span> 
                                            </li>
                                            <li class="odd">
                                                <input type="radio" id="rd2" class="regular-radio" value="refresh" name="menu_icon">
                                                <label for="rd2"></label>
                                                <i class="mdi mdi-refresh"></i><span>Reload</span>
                                            </li>
                                            <li class="even">
                                                <input type="radio" id="rd3" class="regular-radio" value="3" name="menu_icon">
                                                <label for="rd3"></label>
                                                <i class="glyphicon glyphicon-flash"></i><span>Flash</span>
                                            </li>
                                        </ul>
                                        <ul class="even">
                                            <li class="odd">
                                                <input type="radio" id="rd4" class="regular-radio" value="desktop" name="menu_icon">
                                                <label for="rd4"></label>
                                                <i class="icon-desktop"></i><span>Tv</span>
                                            </li>
                                            <li class="even">
                                                <input type="radio" id="rd5" class="regular-radio" value="building" name="menu_icon">
                                                <label for="rd5"></label>
                                                <i class="icon-building"></i><span>Switch</span>
                                            </li>
                                            <li class="odd">
                                                <input type="radio" id="rd6" class="regular-radio" value="undo" name="menu_icon">
                                                <label for="rd6"></label>
                                                <i class="icon-undo"></i><span>Undo</span>
                                            </li>
                                        </ul>
                                        <ul class="odd">
                                            <li class="even">
                                                <input type="radio" id="rd7" class="regular-radio" value="phone" name="menu_icon">
                                                <label for="rd7"></label>
                                                <i class="icon-phone"></i><span>Phone</span>
                                            </li>
                                            <li class="odd">
                                                <input type="radio" id="rd8" class="regular-radio" value="search" name="menu_icon">
                                                <label for="rd8"></label>
                                                <i class="icon-search"></i><span>Search</span>
                                            </li>
                                            <li class="even">
                                                <input type="radio" id="rd9" class="regular-radio" value="user" name="menu_icon">
                                                <label for="rd9"></label>
                                                <i class="icon-user"></i><span>User</span>
                                            </li>
                                        </ul>
                                        <ul class="even">
                                            <li class="odd">
                                                <input type="radio" id="rd10" class="regular-radio" value="arrow-right" name="menu_icon">
                                                <label for="rd10"></label>
                                                <i class="icon-arrow-right"></i><span>Arrow</span>
                                            </li>
                                            <li class="even">
                                                <input type="radio" id="rd11" class="regular-radio" value="volume-up" name="menu_icon">
                                                <label for="rd11"></label>
                                                <i class="icon-volume-up"></i><span>Volume</span>
                                            </li>
                                            <li class="odd">
                                                <input type="radio" id="rd12" class="regular-radio" value="circle-arrow-left" name="menu_icon">
                                                <label for="rd12"></label>
                                                <i class="icon-circle-arrow-left"></i><span>Track back</span>
                                            </li>
                                        </ul>
                                        <ul class="odd">
                                            <li class="even">
                                                <input type="radio" id="rd13" class="regular-radio" value="forward" name="menu_icon">
                                                <label for="rd13"></label>
                                                <i class="icon-forward"></i><span>Forward</span>
                                            </li>
                                            <li class="odd">
                                                <input type="radio" id="rd14" class="regular-radio" value="bullseye" name="menu_icon">
                                                <label for="rd14"></label>
                                                <i class="icon-bullseye"></i><span>Cd</span>
                                            </li>
                                            <li class="even">
                                                <input type="radio" id="rd15" class="regular-radio" value="male" name="menu_icon">
                                                <label for="rd15"></label>
                                                <i class="icon-male"></i><span>Men</span>
                                            </li>
                                        </ul>
                                        <ul class="even">
                                            <li class="odd">
                                                <input type="radio" id="rd16" class="regular-radio" value="female" name="menu_icon">
                                                <label for="rd16"></label>
                                                <i class="icon-female"></i><span>Women</span>
                                            </li>
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
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="label" class="form-label">Status</label>
                                    <select class="form-select" id="label" name="page_status" required>
                                        <option value="0"  >Active</option>
                                        <option value="1" >InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Add</button>
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                        </div>  
                    </div>
                </div>                 
            </div>       <!--end row-->
        </div>
    </div>

    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body p-md-5">
                    <div class="text-center">
                        <div class="text-danger">
                            <i class="bi bi-trash display-4"></i>
                        </div>
                        <div class="mt-4 fs-15">
                            <h4 class="mb-1">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

<script type="text/javascript"> 

    $(document).ready(function () {
    
    
        $(document).on('change', '#menu_contenttype',function(){      
          
            var option = $(this).val(); 
            if(option == 'page') {
                jQuery.ajax({
                  type:"POST",
                  url:"<?php echo SITEURL; ?>menus/getAllPages",
                  data : '',
                  success:function(data){      
                    // data = JSON.parse(data);        
                    var htmlString ='';
                    htmlString+="<select data-rule-required='true' id='select' name='menu_pageid' class='form-control'>"
                    htmlString+="<option value=''>Select page</option>"
                    $.each(data,function(i){
                      htmlString+="<option value="+data[i]['page_id']+">"+data[i]['page_title']+"</option>"
                    });
                    htmlString+="</select>"
                   $("#conid").html(htmlString);     
                  },
                  error:function(data){
                    alert("Error In Connecting");
                  }
                });  
            }   
        });
    });

</script>

                

                 
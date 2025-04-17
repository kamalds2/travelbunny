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
                    </div>
                </div>
            </div>
        </div> 
        <div class="container-fluid"> 
            <div class="row mt-n5"> 
                <div class="card">   
            
                    <form id="editPgesForm" autocomplete="off" class="needs-validation p-2" novalidate method="post" action="<?php echo SITEURL?>pages/updatePage" enctype="multipart/form-data" >
                        <input type="hidden" id="edit_page_id" class="form-control" value="<?php echo $this->pages->page_id?>" name="page_id">
                         
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="edit_page_title" class="form-label">Title: <span>*</span>  </label>
                                <input type="text" class="form-control" name="page_title" id="edit_page_title" required value="<?php echo $this->pages->page_title?>"/>                                
                            </div>
                            <div class="col-lg-12 mb-3">                                 
                                <label for="label" class="form-label">Description: <span>*</span> </label>
                                <textarea  class="ckeditor-classic" name="page_description"><?php echo $this->pages->page_description?></textarea>
                            </div>
                            <!-- <div class="col-md-6 mb-3">                                 
                                <label for="image" class="form-label">File Upload</label>
                                <?php //if($this->pages->banner_image !='') {?>

                                    <img src="<?php //echo FRONTUPLOADURL.'pages/'.$this->pages->banner_image; ?>" style="width:100px;">             
                                    <input type="hidden" class="form-control"  name="banner_image_old" value="<?php //echo  $this->pages->banner_image; ?>" >
                                <?php //} ?>
                                <input type="file" class="form-control" id="image" name="banner_image">
                            </div> -->
                            <div class="col-lg-12 mb-3">
                                <label for="edit_page_meta_title" class="form-label">Page Meta Title:</label>
                                <input type="text" class="form-control" name="page_meta_title" id="edit_page_meta_title" value="<?php echo $this->pages->page_meta_title?>"  />                                
                            </div>
                            <div class="col-lg-12 mb-3">                                 
                                <label for="edit_page_meta_description" class="form-label">Page Meta Description:</label>
                                <textarea  class="form-control" name="page_meta_description" id="editpage_meta_description"><?php echo $this->pages->page_meta_description?></textarea>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="label" class="form-label">Status <span>*</span> </label>
                                <select class="form-select" id="label" name="page_status" required>
                                    <option value="0" <?php if($this->pages->page_status == '0') echo 'selected'  ?> >Active</option>
                                    <option value="1" <?php if($this->pages->page_status == '1') echo 'selected'  ?>>InActive</option>
                                </select>
                            </div>
                        </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-danger" onclick="history.back('-1');">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">  
    $(document).ready(function () {  
         
        $('#editPgesForm').validate({ 
            rules: {
                page_title : {
                    "required":true,
                    maxlength:100
                },
                page_description : {
                    "required":true
                },
                                 
                page_status : "required"
            },
            messages: {
                page_title : {
                    required: "Please enter Page title",
                    maxlength : "Please enter maximum 100 letters"
                },
                page_description : {
                    required: "Please enter Page description" 
                },
                 
                page_status : "Please select status"
            }
        }); 


    });

</script>
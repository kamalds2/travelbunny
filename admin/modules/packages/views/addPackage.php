<div id="layout-wrapper">
    <div class="main-content">  
        <div class="page-content">
            <div class="card mt-n4 mx-n3 border-0 rounded-0 bg-primary-subtle breadcrumb_bg">
                <div class="card-body pb-0 px-4">
                    <div class="container-fluid">
                        <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                            <div class="col-lg-4">
                                <h4 class="mb-0">Add <?php echo $this->categoryDetails->categories->category_name;?> Package</h4>
                            </div>                            
                    </div>
                </div>
            </div>
        </div> 
        <div class="container-fluid"> 
            <div class="row mt-n5"> 
                <div class="card">            
                    <form id="addPackageForm" autocomplete="off" class="needs-validation p-2" novalidate method="post" action="<?php echo SITEURL?>packages/addPackageDetails" enctype="multipart/form-data" onSubmit="return validform();">
                         
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                            <div class="col-lg-9 mb-3">
                                <label for="edit_package_title" class="form-label">Title <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="package_title" id="edit_package_title"  />
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="m-t-30" style="margin-top: 40px;">Popular Package
                                   <input  name="featured" value="1" type="checkbox" data-checkbox="icheckbox_square-aero"/>
                                   </label>
                            </div> 
                            
                            <div class="col-lg-12 mb-3">                                 
                                <label for="package_description" class="form-label">Description:  <span class="text-danger"> * </span> </label>
                                <textarea class="form-control" name="description" id="package_description"></textarea>
                                 <span class="text-danger" id="package_description-error">   </span>
                            </div>

                            <div class="col-md-6 mb-3">                                 
                                <label for="package_images" class="form-label"> File Upload :  <span class="text-danger"> * </span> </label>
                                <input type="file" class="form-control" id="package_images" name="package_images">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="location" class="form-label"> Location<span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="location" id="location"  />
                            </div> 

                            <div class="col-lg-6 mb-3">
                                <label for="reviews" class="form-label"> Reviews <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="reviews" id="reviews"  />
                            </div> 

                            <div class="col-lg-6 mb-3">
                                <label for="no_of_days" class="form-label"> No of days <span class="text-danger"> * </span></label>
                                <input type="number" class="form-control" name="no_of_days" id="no_of_days"  />
                            </div> 

                            <div class="col-lg-6 mb-3">
                                <label for="no_of_nights" class="form-label"> No of Nights<span class="text-danger"> * </span></label>
                                <input type="number" class="form-control" name="no_of_nights" id="no_of_nights"  />
                            </div> 

                            <div class="col-lg-6 mb-3">
                                <label for="min_age" class="form-label"> Min Age </label>
                                <input type="number" class="form-control" name="min_age" id="min_age"  />
                            </div> 

                            <div class="col-lg-6 mb-3">
                                <label for="package_price" class="form-label">Package Price <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="package_price" id="package_price"  />
                            </div> 

 
                            <div class="col-lg-6 mb-3">
                                <label for="package_status" class="form-label">Status:  <span class="text-danger"> * </span> </label>
                                <select class="form-select" id="package_status" name="package_status" >
                                    <option value=""  > Select Status  </option>
                                    <option value="0"  >Active</option>
                                    <option value="1" >InActive</option>
                                </select>
                            </div>

                             
                            <div class="col-lg-6 mb-3">
                                <label for="summernote_includes" class="form-label">Includes:  <span class="text-danger"> * </span> </label>
                                 <textarea  name="includes" id="summernote_includes" class=" form-control" rows="6"></textarea>
                                 <span class="text-danger" id="summernote_includes-error">   </span>
                            </div>
                            
                            <div class="col-lg-6 mb-3">
                                <label for="summernote_excludes" class="form-label">Excludes:  <span class="text-danger"> * </span> </label>
                                 <textarea  name="excludes" id="summernote_excludes" class=" form-control" rows="6"></textarea>
                                 <span class="text-danger" id="summernote_excludes-error">   </span>
                            </div>
                            
                            <div class="col-lg-12 mb-3">
                                <label for="page_meta_title" class="form-label"> Meta Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="meta_title" id="page_meta_title"  />                                
                            </div>
                            <div class="col-lg-12 mb-3">                                 
                                <label for="page_meta_description" class="form-label"> Meta Description<span class="text-danger">*</span>:</label>
                                <textarea  class="form-control" name="meta_description" id="page_meta_description"></textarea>
                            </div>
                            <div class="col-lg-12 mb-3">                                 
                                <label for="page_meta_keywords" class="form-label"> Meta Keywords<span class="text-danger">*</span>:</label>
                                <textarea  class="form-control" name="meta_keywords" id="page_meta_keywords"></textarea>
                            </div>
                             
                        </div>
                            <div class="text-end">
                                <input type="hidden" name="category_id" value="<?php echo base64_decode($this->cat_id) ; ?>" >
                                <button type="submit" class="btn btn-success">Add</button>
                                <button type="button" class="btn btn-danger" onclick="history.back('-1')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
     $('#package_description ').summernote({
        placeholder: 'Enter Description Here ',
        tabsize: 2,
        height: 300
    });

    function validform(){
        var error=0;
          
        if($('#package_description').summernote('isEmpty')){
            $('#package_description-error').html('Please enter Package Description ');
            error=1;
        }else{
            $('#package_description-error').html('');
        }

        if($('#summernote_includes').summernote('isEmpty')){ 
            $('#summernote_includes-error').html('Please enter Package Includes ');
            error=1;
        }else{
            $('#summernote_includes-error').html('');
        }

        if($('#summernote_excludes').summernote('isEmpty')){
            $('#summernote_excludes-error').html('Please enter Package Excludes ');
            error=1;
        }else{
            $('#summernote_excludes-error').html('');
        }
    }
    $(document).ready(function () {
        $('#summernote_includes').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true,
            callbacks: {
                onInit: function() {
                  // Remove default paragraph tag
                  var $note = $('#summernote_includes');
                  $note.summernote('code', $note.summernote('code').replace(/<p><br><\/p>/g, '<ul><li></li></ul>'));
                }
            }                  // set focus to editable area after initializing summernote
        });$('#summernote_excludes').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true,
            callbacks: {
                onInit: function() {
                  // Remove default paragraph tag
                  var $note = $('#summernote_excludes');
                  $note.summernote('code', $note.summernote('code').replace(/<p><br><\/p>/g, '<ul><li></li></ul>'));
                }
            }                  // set focus to editable area after initializing summernote
        });  
        $('#addPackageForm').validate({   
              
            rules: {
                package_title : {
                    "required":true,
                    maxlength:100
                },     
                package_image : {
                    "required":true,
                    accept:"image/jpg,image/png,image/jpeg,image/gif"
                },                            
                location : "required",
                no_of_days : "required",
                no_of_nights : "required",
                reviews : "required",
                package_price : "required",
                package_status : "required",
                meta_title : "required",
                meta_description : "required",
                meta_keywords : "required"
            },
            messages: {
                package_title : {
                    required: "Please enter  title",
                    maxlength : "Please enter maximum 100 letters"
                }, 
                
                package_image : {
                    required: "Please upload image with 600px * 330px or more" 
                }, 

                location : "Please Enter location",
                no_of_days : "Please Enter No of Days",
                no_of_nights : "Please Enter No of Nights",
                reviews : "Please Enter Reviews",
                package_price : "Please Enter Price",
                package_status : "Please select status",
                meta_title : "Please Enter Meta Title ",
                meta_description : "Please Enter Meta Description ",
                meta_keywords : "Please Enter Meta Keywords ",
            }
        }); 


    });
</script>
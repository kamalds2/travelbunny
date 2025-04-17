<div id="layout-wrapper">
    <div class="main-content">  
        <div class="page-content">
            <div class="card mt-n4 mx-n3 border-0 rounded-0 bg-primary-subtle breadcrumb_bg">
                <div class="card-body pb-0 px-4">
                    <div class="container-fluid">
                        <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                            <div class="col-lg-4">
                                <h4 class="mb-0">  Package Gallery</h4>
                            </div>                            
                    </div>
                </div>
            </div>
        </div> 
        <div class="container-fluid"> 
            <div class="row mt-n5"> 
                 
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
                            <strong> <?php echo $this->session->gets('error_msg'); ?>! </strong>  —check it out! <?php unset($_SESSION['error_msg']); ?>
                        </div>
                    </div>
                <?php } ?> 
                <div class="col-md-12">
                    <div class="mb-3">
                                                        
                        <div class="dropzone" id="myDropzone" action="<?php echo SITEURL.'packages/uploadPackageImages/'.$this->package_id;?>" >
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple">
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>

                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </div>


                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
                                <!-- This is used as the file preview template -->
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-sm bg-light rounded">
                                                <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                                    <!-- end dropzon-preview -->
                    </div>
                </div>



            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?php 
                         
                        $packageImages = @$this->gallery->packages;
                        
                        if(!empty($packageImages)){
                            foreach ($packageImages as $img) { ?>
                                                             
                            <div class="col-lg-4">
                                <img src="<?php echo UPLOADURL; ?>packages/gallery/<?php echo $img->image_url?>" >
                                
                            </div>
                    <?php   }}  ?>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
<!--<script language="javascript"> 

    Dropzone.options.myAwesomeDropzone = {
        init: function() {
            var _this = this;
            $(document).on("click","#clear-dropzone", function() {
              _this.removeAllFiles();
              $("#clear-dropzone").hide();
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                  $("#clear-dropzone").show();
                     
                }
            });
        }
    };

    // Initialize Dropzone
    Dropzone.autoDiscover = false; // Disable auto discovery of dropzone elements
     
    $("#myDropzone").dropzone({
        paramName: 'file',
        url: $(this).attr("action"),
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
        dictDefaultMessage: "Drag your images",
        clickable: true,
        enqueueForUpload: true,
        //maxFilesize: 5,
        uploadMultiple: false,
        addRemoveLinks: false
    });
                    
   
       
    
</script>-->
 
<script type="text/javascript">
    Dropzone.autoDiscover = false; // Disable auto discovery of dropzone elements

    // Initialize Dropzone on the element with id "myDropzone"
    var myDropzone = new Dropzone("#myDropzone", {
        paramName: "file", // Name of the file parameter
        url: "<?php echo SITEURL.'packages/uploadPackageImages/'.$this->package_id; ?>",
        maxFilesize: 5, // Maximum file size in MB
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
        dictDefaultMessage: "Drag your images here or click to upload",
        addRemoveLinks: true, // Enable remove file links
        init: function() {
            var myDropzone = this;

            // Event listener for when a file is added
            this.on("addedfile", function(file) {
                console.log("File added: " + file.name);
            });

            // Event listener for when all files are uploaded
            this.on("queuecomplete", function() {
                console.log("All files uploaded successfully.");
            });
        }
    });

</script>

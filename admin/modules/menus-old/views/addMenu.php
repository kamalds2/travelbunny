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
                    <form id="addPagesForm" autocomplete="off" class="needs-validation p-2" novalidate method="post" action="<?php echo SITEURL?>menus/addMenuDetails" enctype="multipart/form-data">
                         
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label for="" class="form-label">Menu Name</label>
                                <input type="text" class="form-control" name="menu_name" id="" required />                                
                            </div>
                            <div class="col-lg-12 mb-3">                                 
                                <label for="label" class="form-label">Menu Parent</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected>Select your Status </option>
                                    <option value="1">Declined Payment</option>
                                    <option value="2">Delivery Error</option>
                                    <option value="3">Wrong Amount</option>
                                </select>
                                <textarea  class="ckeditor-classic" name="slider_description"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">                                 
                                <label for="image" class="form-label">File Upload</label>
                                <input type="file" class="form-control" id="image" name="slider_image">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="label" class="form-label">Status</label>
                                <select class="form-select" id="label" name="slider_status" required>
                                    <option value="0"  >Active</option>
                                    <option value="1" >InActive</option>
                                </select>
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
    </div>
</div>
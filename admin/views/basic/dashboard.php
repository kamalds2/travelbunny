 
<div class="main-content">             
    <div class="page-content">
        <div class="container-fluid">
             <div class="row">
                <div class="col">
                    <div class="h-100"> 
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">TOTAL PAGES</p>
                                                <h4 class="fs-22 fw-semibold mb-3"><?php echo $this->dashboardCnt->res->pages_cnt ?> </h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="mdi mdi-book-open-page-variant-outline text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->                                     
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">TOTAL SLIDERS</p>
                                                <h4 class="fs-22 fw-semibold mb-3"> <?php echo $this->dashboardCnt->res->sliders_cnt ?></h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="mdi mdi-view-grid-outline text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->                                     
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">TOTAL PACKAGES</p>
                                                <h4 class="fs-22 fw-semibold mb-3"> <?php echo $this->dashboardCnt->res->packages_cnt ?> </h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="ri ri-suitcase-2-line  text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->                                     
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">TOTAL TESTIMONIALS</p>
                                                <h4 class="fs-22 fw-semibold mb-3"> <?php echo $this->dashboardCnt->res->testimonials_cnt ?></h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="ri ri-youtube-line text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->                                     
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1"> Pages</h4>
                                        <div class="text-end">
                                            <a type="button" class="btn btn-primary btn-sm addContact-modal" href="<?php echo SITEURL?>pages/addPage"  ><i class="bi bi-plus align-middle"></i> Add Page</a>
                                        </div>
                                         
                                    </div><!-- end card header -->
                                
                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table dataTable table-bordered" id="pages_datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Status</th> 
                                                        <th scope="col">Action</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $pages = @$this->pages->pages;
                                                        if(!empty($pages)){ 
                                                            foreach ($pages as $key => $value) {
                                                            ?>
                                                            <tr>
                                                            <td><?php echo $value->page_title;?></td>                                       
                                                            <td><span class="badge badge-soft-success"><?php echo ($value->page_status == '0') ? "Active":"In-Active";;?></span></td>
                                                            <td>
                                                                <div class="d-flex align-items-left gap-2">    
                                                                    <div class="editPageDetails">
                                                                        <a  href="<?php echo SITEURL;?>pages/editPage/<?php echo $value->page_id ?>" class="text-muted px-1 d-block"><i class="bi bi-pencil-fill"></i></a>
                                                                    </div>                        
                                                                    <div>
                                                                        <a href="javascript:void(0)"  data-id="<?php echo $value->page_id; ?>" class="text-muted px-1 d-block deletePage" ><i class="bi bi-trash-fill"></i></a>
                                                                    </div>                      
                                                                </div>
                                                            </td>
                                                                 
                                                            </tr>
                                                            
                                                            


                                                        <?php }} ?>
                                                   <!-- end tr -->
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1"> Sliders</h4>
                                         <div class="text-end">
                                            <a type="button" class="btn btn-primary btn-sm addContact-modal" href="<?php echo SITEURL?>sliders/addSlider"  ><i class="bi bi-plus align-middle"></i> Add Slider</a>
                                        </div>
                                    </div><!-- end card header -->
                                
                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table nowrap dt-responsive align-middle table-hover table-bordered" id="slider_datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Sub Title</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sliders = @$this->sliders->sliders; 
                                                        if(!empty($sliders)){ 
                                                            foreach ($sliders as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo ($value->slider_title != '') ? $value->slider_title : '-'; ?></td>
                                                                <td><?php echo ($value->sub_title != '') ? $value->sub_title : '-'; ?></td> 
                                                                
                                                                <td><span class="badge badge-soft-success"><?php echo ($value->slider_status == '0') ? "Active":"In-Active";;?></span></td>
                                                                <td>
                                                                    <div class="d-flex align-items-left gap-2 ">    
                                                                        <div class="editSliderDetails">
                                                                            <a  href="<?php echo SITEURL;?>sliders/editSlider/<?php echo $value->slider_id ?>" class="text-muted px-1 d-block"><i class="bi bi-pencil-fill"></i></a>
                                                                        </div>                        
                                                                        <div>
                                                                            <a href="javascript:void(0)"  data-id="<?php echo $value->slider_id; ?>" class="text-muted px-1 d-block deleteSlider"><i class="bi bi-trash-fill"></i></a>
                                                                        </div>                      
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                    <?php }} ?>
                                                   <!-- end tr -->
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div><!-- end col -->
                            
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Recent Enquiries</h4>
                                         
                                    </div><!-- end card header -->
                                
                                    <div class="card-body">
                                        <div class="table-responsive ">
                                            <table class="table dataTable table-dynamic filter-footer" style="width:100%"  id="alternative-pagination">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Destination</th>
                                                        <th scope="col">Action</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $enquiries = @$this->enquiries->enquiries;
                                                        if(!empty($enquiries)){ 
                                                            foreach ($enquiries as $key => $v) {
                                                            ?>
                                                                <tr>
                                                                    <td>  <?php echo $v->name; ?>  </td>
                                                                    <td>  <?php echo $v->mobile_no; ?>  </td>
                                                                    <td>  <?php echo $v->email; ?>  </td>
                                                                    <td>  <?php echo $v->destination; ?>  </td>
                                                                    <td>  <?php if($v->message != '') {?>
                                                                        <a href="" class="text-muted px-1 d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="<?php echo $v->message;?>"><i class="mdi mdi-information-outline"></i></a>
                                                                    <?php } ?>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                            


                                                        <?php }} ?>
                                                   <!-- end tr -->
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div>

                        

                    </div> 

                </div>

                
            </div>

        </div>
    </div>
</div>
 
 <script type="text/javascript">
     
      $(document).ready(function() {
        $('[data-bs-toggle=tooltip]').tooltip();
        $('#pages_datatable').DataTable();
        $('#slider_datatable').DataTable();
    });
 </script>
               
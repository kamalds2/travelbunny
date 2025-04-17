<!-- Begin page -->
<div id="layout-wrapper">
    <div class="main-content">                
        <div class="page-content">
            <div class="card mt-n4 mx-n3 border-0 rounded-0 bg-primary-subtle breadcrumb_bg">
                <div class="card-body pb-0 px-4">
                    <div class="container-fluid">
                        <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                            <div class="col-lg-4">
                                <h4 class="mb-0">Enquiries</h4>
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
                            <div class="card">
                      
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table id="alternative-pagination" class="table dataTable table-dynamic filter-footer" style="width:100%">
                                        <thead  class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Mobile</th> 
                                                <th>Message</th> 
                                                <th>Destination</th> 
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $this->enquiriesList = (Array) $this->enquiriesList->enquiries;
                                              if($this->enquiriesList != '') {                                               
                                              foreach($this->enquiriesList as $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $value->name;?></td>  
                                                <td><?php echo $value->mobile_no;?></td>  
                                                <td><?php echo $value->message;?></td>  
                                                <td><?php echo $value->destination;?></td> 
                                                <td>
                                                    <?php if($value->message != '') {?>
                                                        <a href="javascript:void(0)" class="text-muted px-1 d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="<?php echo $value->message;?>"><i class="mdi mdi-information-outline"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <?php  }  }   ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>                 
            </div>       <!--end row-->
        </div>
    </div>
     
    
    <div id="removeEnquiryModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
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

      $(document).on('click', '.deleteEnquiry', function() { 
            var delId = $(this).data('id'); 
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
                  if(result) {            
                    jQuery.ajax({
                        type: "POST",             
                        url:"<?php echo SITEURL; ?>enquiries/deleteEnquiry",
                        data: 'deletId='+ delId,
                        success: function(data) {
                            // document.location.reload();
                        }
                    });
                  }
                }
            });
        });
     


      $(document).ready(function() {
        $('[data-bs-toggle=tooltip]').tooltip();
    }); 
</script>

                

                 
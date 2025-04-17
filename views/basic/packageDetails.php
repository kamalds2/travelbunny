
 <section class="page-header">
    <div class="page-header__bg"></div>
    <div class="container">
        <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Best of Goa with Dudhsagar Falls</h2>
        <div class="page-header__breadcrumb-box">
            <ul class="travel-breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Tour Packages</li>
            </ul>
        </div>
    </div>
</section>

<section class="tour-listing-details">
            
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="tour-listing-details__slider">
                    <div class="tour-listing-details__carousel travel-owl__carousel travel-owl__carousel--basic-nav     owl-theme owl-carousel" data-owl-options='{
                            "items": 1,
                            "margin": 30,
                            "smartSpeed": 700,
                            "loop":false,
                            "autoplay": 6000,
                            "nav":false,
                            "dots":true,
                            "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                            "responsive":{
                                "0":{
                                    "items": 1
                                },
                                "768":{
                                    "items": 1
                                }
                            }
                        }'>
                        <?php 
                            $galleryList = $this->packageGallery->res; 
                            if(!empty($galleryList)){
                                foreach ($galleryList as $img) { ?>
                                    <div class="tour-listing-details__carousel-item item">
                                        <div class="tour-listing-details__carousel-image-box">
                                            <img src="<?php echo UPLOADURL; ?>packages/gallery/<?php echo $img->image_url?>" alt="tour-listing-details-slide" class="tour-listing-details__carousel-image">
                                        </div>
                                    </div>
                                
                                <?php }   }            ?>
                        
                         
                    </div>
                </div>
                <div class="tour-listing-details__explore">
                    <div class="wow animated fadeIn" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <h3 class="tour-listing-details__title tour-listing-details__explore-title"><?php echo $this->packageDetails->res->package_title; ?></h3>
                    </div>
                    <div class="tour-listing-details__explore-text wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                         <?php echo $this->packageDetails->res->description; ?>
                    </div>
                </div><!-- /.tour-listing-details__explore -->
                <div class="tour-listing-details__included">
                    <h3 class="tour-listing-details__title tour-listing-details__included-title">Included/Exclude</h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-7 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                            <ul class="tour-listing-details__included-list-one">
                                <?php                                     
                                    $includes = explode('.',$this->packageDetails->res->includes);
                                    if(!empty($includes)){
                                        foreach ($includes as $v) { ?>
                                           <li>
                                            <i class="fas fa-check-circle"></i>
                                            <p><?php   echo $v; ?></p>
                                        </li>
                                 <?php }    }  ?>
                                 
                                 
                            </ul><!-- /.tour-listing-details__included-list-one -->
                        </div><!-- /.col-lg-6 col-md-7 -->
                        <div class="col-lg-6 col-md-5 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                            <ul class="tour-listing-details__included-list-two">
                                <?php 
                                    $excludes = explode('.',$this->packageDetails->res->excludes);
                                    if(!empty($excludes)){
                                        for($i=0;$i<count($excludes);$i++) { ?>
                                            <li>
                                                <i class="fas fa-times"></i>
                                                <p><?php   echo $excludes[$i]; ?></p>
                                            </li>
                                 <?php }    }  ?>
                                
                                 
                            </ul>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="col-xl-4">
                <aside class="tour-listing-details__sidebar">
                    <div class="tour-listing-details__sidebar-book-tours tour-listing-details__sidebar-single wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                    <div class="tour-listing-details__destination-right">
                        <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                            <span class="icon-clock-1"></span>
                            <div class="tour-listing-details__destination-info-title">
                                <h4 class="tour-listing-details__destination-info-top">Duration</h4>
                                <h4 class="tour-listing-details__destination-info-bottom"> <?php echo $this->packageDetails->res->no_of_days .' Days'; ?></h4>
                            </div>
                        </div>
                        <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                            <span class="icon-Duration"></span>
                            <div class="tour-listing-details__destination-info-title">
                                <h4 class="tour-listing-details__destination-info-top">Min Age</h4>
                                <h4 class="tour-listing-details__destination-info-bottom"><?php echo $this->packageDetails->res->min_age; ?>+</h4>
                            </div>
                        </div>
                        <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.7s" data-wow-duration="1500ms">
                            <span class="icon-location-1"></span>
                            <div class="tour-listing-details__destination-info-title">
                                <h4 class="tour-listing-details__destination-info-top">Location</h4>
                                <h4 class="tour-listing-details__destination-info-bottom"><?php echo $this->packageDetails->res->location; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="tour-listing-details__sidebar-book-tours tour-listing-details__sidebar-single wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <h3 class="tour-listing-details__sidebar-title">ENQUIRY NOW</h3>
                        <form action="<?php echo SITEURL?>packages/sendEnquiry" method="post" class="tour-listing-details__sidebar-form contact-form-validated" name="addEnquiryForm" id="addEnquiryForm">
                            <div class="tour-listing-details__sidebar-form-input">
                                <input type="text" placeholder="Name*" name="name">
                            </div>
                            <div class="tour-listing-details__sidebar-form-input">
                                <input type="email" placeholder="Email*" name="email">
                            </div>
                            <div class="tour-listing-details__sidebar-form-input">
                                <input type="number" placeholder="Mobile*" name="mobile_no">
                            </div>
                            <div class="tour-listing-details__sidebar-form-input">
                              <input type="text" placeholder="Destination*" name="destination" value="<?php echo $this->packageDetails->res->location?>" readonly>
                            </div>
                            <div class="tour-listing-details__sidebar-form-input">
                                <textarea type="text" placeholder="Message" name="message"></textarea>
                            </div>
                            <input type="hidden"  name="package_id" value="<?php echo $this->packageDetails->res->package_id?>">
                            <button type="submit" class="tour-listing-details__sidebar-btn travel-btn travel-btn--base"><span>Submit</span></button>
                        </form>
                        <div class="result"></div>
                    </div>
                    
                </aside>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () { 
        $('#addEnquiryForm').validate({   
                  
            rules: {
                name : {
                    "required":true,
                    letterswithspace : true,
                },   
                email : {
                    "required" : true,
                    "email" : true
                } ,
                mobile_no : {
                    "required" : true,
                    "minlength" : 10,
                    "maxlength" : 12
                } ,
                message : "required"
                
            },
            messages: {
                name : {
                    required : "Please enter Name",
                    letterswithspace : "Please enter alphabets only", 
                } , 
                email : {
                    required : "Please enter Email", 
                    email : "Please enter Valid Email"
                } ,
                mobile_no : {
                    "required" : "Please Enter Mobile Number",
                    "minlength" : "Should atleast 10 numbers ",
                    "maxlength" : "Should not exceed 12 numbers"
                } ,
                message : "Please Enter Message",
            }
        }); 

        jQuery.validator.addMethod("letterswithspace", function(value, element) {
            return this.optional(element) || /^[a-z][a-z\s]*$/i.test(value);
        }, "Name should not allow special characters");
    });
</script>

 

<section class="main-slider-one">
    <div class="main-slider-one__carousel travel-owl__carousel owl-carousel owl-theme" data-owl-options='{
		"items": 1,
		"margin": 0,
		"loop": true,
		"smartSpeed": 700,
		"animateOut": "fadeOut",
		"autoplayTimeout": 5000, 
		"nav": true,
		"navText": ["<span class=\"icon-left-arrow\"></span>","<span class=\"icon-right-arrow\"></span>"],
		"dots": false,
		"autoplay": true
		}'> 
        <?php
            $slidersList = $this->sliders->res; 
            if(!empty($slidersList)){
                foreach ($slidersList as $slider) {  ?>
                    <div class="item">
                        <div class="main-slider-one__image" style="background-image: url(<?php echo UPLOADURL.'sliders/'.$slider->slider_image; ?>);"></div>
                            <div class="container">
                                <div class="main-slider-one__content">
                                    <h5 class="main-slider-one__sub-title"> <?php echo $slider->sub_title; ?> <img src="<?php echo THEMEURL; ?>assets/images/slider-1-shape-1.png" alt="travel"></h5>
                                    <h3 class="main-slider-one__title"><?php echo $slider->slider_title; ?><img src="<?php echo THEMEURL; ?>assets/images/slider-1-shape-2.png" alt="travel"></h3>
                                </div>
                            </div>
                        </div> 
                <?php }
            }
        ?>
        
    </div>
    <div class="banner-form wow fadeInUp" data-wow-delay="300ms">
        <div class="container">

            <form class="banner-form__wrapper" action="<?php echo SITEURL?>packages/sendEnquiry" name="addEnquiryForm" id="addEnquiryForm">
                <h3 class="text-center enquiry_text mb-3 text-black">Enquiry Now</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-3 mt-3 px-1">
                        <div class="input_group">
                            <span>
                                 <img src="<?php echo THEMEURL; ?>assets/images/user.png" alt="" />
                            </span>
                            <input class="form-control" type="text" placeholder="Name*" name="name">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mt-3 px-1">
                        <div class="input_group">
                            <span>
                                 <img src="<?php echo THEMEURL; ?>assets/images/email_1.png" alt=""/>
                            </span>
                            <input class="form-control" type="email" placeholder="Email*" name="email">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mt-3 px-1">
                        <div class="input_group">
                            <span>
                                 <img src="<?php echo THEMEURL; ?>assets/images/call.png" alt=""/>
                            </span>
                            <input class="form-control" type="phone" placeholder="Mobile*" name="mobile_no">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mt-3 px-1">
                        <div class="input_group">
                            <span>
                                 <img src="<?php echo THEMEURL; ?>assets/images/location.png" alt=""/>
                            </span>
                            <input class="form-control" type="destination" placeholder="Destination*" name="destination">
                        </div>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <button type="submit" class="travel-btn travel-btn--base-two"><span>Submit</span></button>
                </div>
            </form>
         </div>
    </div>
</section>

<section class="tour-listing-one" style="background-image: url(<?php echo THEMEURL; ?>assets/images/tour-bg-1.jpg);">
    <div class="container">
        <div class="sec-title text-center">

            <p class="sec-title__tagline">Featured Tours</p>

            <h2 class="sec-title__title">Most Favorite Tour Place</h2>
        </div>
        <div class="tour-listing-one__carousel travel-owl__carousel travel-owl__carousel--basic-nav travel-owl__carousel--with-shadow owl-theme owl-carousel" data-owl-options='{
            "items": 4,
            "margin": 20,
            "smartSpeed": 700,
            "loop":true,
            "autoplay": 5000,
            "nav":false,
            "dots":true,
            "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
            "responsive":{
                "0":{
                    "items": 1
                },
                "768":{
                    "items": 2
                },
                "1200":{
                    "items": 4
                }
            }
            }'>
            <?php 
                $featuresPackages = $this->featuresPackages->res; 
                if(!empty($featuresPackages)){
                    foreach ($featuresPackages as $fp) {  ?>
                        <div class="item">
                            <div class="tour-listing__card">
                                <a href="<?php echo SITEURL.'packages/packageDetails/'.$fp->package_id?>" class="tour-listing__card-image-box">
                                    <img src="<?php echo UPLOADURL.'packages/'.$fp->package_images; ?>" alt="" class="tour-listing__card-image">
                                    
                                    <div class="tour-listing__card-image-overlay"></div>
                                </a>
                                <div class="tour-listing__card-content">
                                    <h3 class="tour-listing__card-title"><a href="<?php echo SITEURL.'packages/packageDetails/'.$fp->package_id?>"><?php echo $fp->package_title ?></a></h3>
                                    <p class="tour-listing__card-text text-small"><?php echo substr($fp->description,0,50).'.........' ?></p>
                                    <div class="tour-listing__card-inner-content">
                                        
                                        <div class="tour-listing__card-location-box">
                                            <span class="icon-location-1"></span>
                                            <p class="tour-listing__card-location-text text-small"><?php echo $fp->location;?></p>
                                        </div>
                                        <div class="tour-listing__card-divider"></div>
                                        <div class="tour-listing__card-bottom">
                                            <div class="tour-listing__card-bottom-left">
                                                <div class="tour-listing__card-day">
                                                    <span class="icon-clock-1"></span>
                                                    <p class="tour-listing__card-day-text text-small"><?php echo $fp->no_of_days.' Days';?> </p>
                                                </div>
                                                <div class="tour-listing__card-people">
                                                    <span class="icon-Duration"></span>
                                                    <p class="tour-listing__card-people-text text-small"><?php echo $fp->no_of_nights.' Nights';?> </p>
                                                </div>
                                            </div>
                                            <div class="tour-listing__card-bottom-right">
                                                <h4 class="tour-listing__card-price">₹<?php echo $fp->package_price;?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            <?php }} ?>
           
             
                    
        </div>
    </div>
</section>
      

<section class="domastic_packages">
    <div class="container">
        <div class="sec-title text-center">
                <img src="<?php echo THEMEURL; ?>assets/images/about-1-shape-1.png" class="about_shape1" alt=""/>
            <img src="<?php echo THEMEURL; ?>assets/images/sun.png" class="about_shape2" alt=""/>
            <p class="sec-title__tagline">Holiday Packages In India</p>

            <h2 class="sec-title__title">Domestic Packages</h2>
        </div>
        <div class="tour-listing-one__carousel travel-owl__carousel travel-owl__carousel--basic-nav travel-owl__carousel--with-shadow owl-theme owl-carousel" data-owl-options='{
            "items":4,
            "margin": 20,
            "smartSpeed": 1000,
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
                    "items": 2
                },
                "1200":{
                    "items": 4
                }
            }
            }'>

            <?php 
                $packagesList = $this->packages->res; 
                if(!empty($packagesList)){
                    foreach ($packagesList as $package) {  ?>
                        <div class="item">
                            <div class="tour-listing__card">
                                <a href="<?php echo SITEURL.'packages/packageDetails/'.$package->package_id?>" class="tour-listing__card-image-box">
                                    <img src="<?php echo UPLOADURL.'packages/'.$package->package_images; ?>" alt="" class="tour-listing__card-image">
                                    
                                    <div class="tour-listing__card-image-overlay"></div>
                                </a>
                                <div class="tour-listing__card-content">
                                    
                                    <h3 class="tour-listing__card-title"><a href="<?php echo SITEURL.'packages/packageDetails/'.$package->package_id?>"> <?php echo $package->package_title; ?></a></h3>
                                    <p class="tour-listing__card-text text-small"> <?php echo substr($package->description,0,100).'.........' ?></p>
                                    <div class="tour-listing__card-inner-content">
                                        
                                        <div class="tour-listing__card-location-box">
                                            <span class="icon-location-1"></span>
                                            <p class="tour-listing__card-location-text text-small"><?php echo $package->location;?></p>
                                        </div>
                                        <div class="tour-listing__card-divider"></div>
                                        <div class="tour-listing__card-bottom">
                                            <div class="tour-listing__card-bottom-left">
                                                <div class="tour-listing__card-day">
                                                    <span class="icon-clock-1"></span>
                                                    <p class="tour-listing__card-day-text text-small"><?php echo $package->no_of_days.' Days';?></p>
                                                </div>
                                                <div class="tour-listing__card-people">
                                                    <span class="icon-Duration"></span>
                                                    <p class="tour-listing__card-people-text text-small"><?php echo $package->no_of_nights.' Nights';?></p>
                                                </div>
                                            </div>
                                            <div class="tour-listing__card-bottom-right">
                                                <h4 class="tour-listing__card-price">₹<?php echo $package->package_price;?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }  }     ?>            
        </div>
    </div>
</section>
 
 <?php  echo $this->pageDetails->res->page_description;?>


<div class="testimonial_sec">
     
    <div class="container">
        <div class="sec-title text-center">

            <p class="sec-title__tagline text-theme">Testimonials</p>

            <h2 class="sec-title__title">What Our Customers are<br> Saying?</h2>
        </div>
        <div class="blog-page__carousel travel-owl__carousel travel-owl__carousel--basic-nav owl-theme owl-carousel" data-owl-options='{
            "items": 4,
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
                    "items": 2
                },
                "1200":{
                    "items": 4
                }
            }
            }'>
            <div class="item">
               
                <div class="icon">
                    <img src="<?php echo THEMEURL; ?>assets/images/youtube_icon.png" alt="" />
                </div>
                <img src="<?php echo THEMEURL; ?>assets/images/testimonial-1.jpg" class="main_img" alt="" />
                
            </div>
            <div class="item">
                    <div class="icon">
                        <img src="<?php echo THEMEURL; ?>assets/images/youtube_icon.png" alt="" />
                    </div>
                    <img src="<?php echo THEMEURL; ?>assets/images/testimonial-2.jpg" class="main_img" alt="" />
            </div>
            <div class="item">
                    <div class="icon">
                        <img src="<?php echo THEMEURL; ?>assets/images/youtube_icon.png" alt="" />
                    </div>
                    <img src="<?php echo THEMEURL; ?>assets/images/testimonial-3.jpg" class="main_img" alt="" />
            </div>
            <div class="item">
                    <div class="icon">
                        <img src="<?php echo THEMEURL; ?>assets/images/youtube_icon.png" alt=""/>
                    </div>
                    <img src="<?php echo THEMEURL; ?>assets/images/testimonial-4.jpg" class="main_img" alt=""/>
            </div>
            <div class="item">
                    <div class="icon">
                        <img src="<?php echo THEMEURL; ?>assets/images/youtube_icon.png" alt="" />
                    </div>
                    <img src="<?php echo THEMEURL; ?>assets/images/testimonial-5.jpg" class="main_img" alt="" />
            </div>
            <div class="item">
                    <div class="icon">
                        <img src="<?php echo THEMEURL; ?>assets/images/youtube_icon.png" alt="" />
                    </div>
                    <img src="<?php echo THEMEURL; ?>assets/images/testimonial-6.jpg" class="main_img" alt="" />
            </div>
        </div>
    </div>
    <img src="<?php echo THEMEURL; ?>assets/images/testimonial-1-bg-2.png" class="testimonials_bg" alt=""/>
</div>
       

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

 
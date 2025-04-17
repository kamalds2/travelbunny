
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
            <div class="item">
                <div class="tour-listing__card">
                    <a href="package_details.php" class="tour-listing__card-image-box">
                        <img src="<?php echo THEMEURL; ?>assets/images/tour-3-1.jpg" alt="" class="tour-listing__card-image">
                        
                        <div class="tour-listing__card-image-overlay"></div>
                    </a>
                    <div class="tour-listing__card-content">
                        <h3 class="tour-listing__card-title"><a href="package_details.php">Best of Goa with Dudhsagar Falls</a></h3>
                        <p class="tour-listing__card-text text-small">Lorem ipsum dolor sit amet, consectet adipiscing elit.</p>
                        <div class="tour-listing__card-inner-content">
                            
                            <div class="tour-listing__card-location-box">
                                <span class="icon-location-1"></span>
                                <p class="tour-listing__card-location-text text-small">Sonaulim, Goa</p>
                            </div>
                            <div class="tour-listing__card-divider"></div>
                            <div class="tour-listing__card-bottom">
                                <div class="tour-listing__card-bottom-left">
                                    <div class="tour-listing__card-day">
                                        <span class="icon-clock-1"></span>
                                        <p class="tour-listing__card-day-text text-small">3 Days</p>
                                    </div>
                                    <div class="tour-listing__card-people">
                                        <span class="icon-Duration"></span>
                                        <p class="tour-listing__card-people-text text-small">2 Nights</p>
                                    </div>
                                </div>
                                <div class="tour-listing__card-bottom-right">
                                    <h4 class="tour-listing__card-price">₹5999</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="tour-listing__card">
                    <a href="package_details.php" class="tour-listing__card-image-box">
                        <img src="<?php echo THEMEURL; ?>assets/images/tour-3-2.jpg" alt="" class="tour-listing__card-image">
                        
                        <div class="tour-listing__card-image-overlay"></div>
                    </a>
                    <div class="tour-listing__card-content">
                        
                        <h3 class="tour-listing__card-title"><a href="package_details.php">Mesmerizing Kerala Backwaters  Tour </a></h3>
                        <p class="tour-listing__card-text text-small">Lorem ipsum dolor sit amet, consectet adipiscing elit.</p>
                        <div class="tour-listing__card-inner-content">
                            
                            <div class="tour-listing__card-location-box">
                                <span class="icon-location-1"></span>
                                <p class="tour-listing__card-location-text text-small">Cochin, Alleppey, Kumarakom</p>
                            </div>
                            <div class="tour-listing__card-divider"></div>
                            <div class="tour-listing__card-bottom">
                                <div class="tour-listing__card-bottom-left">
                                    <div class="tour-listing__card-day">
                                        <span class="icon-clock-1"></span>
                                        <p class="tour-listing__card-day-text text-small">3 Days</p>
                                    </div>
                                    <div class="tour-listing__card-people">
                                        <span class="icon-Duration"></span>
                                        <p class="tour-listing__card-people-text text-small">2 Nights</p>
                                    </div>
                                </div>
                                <div class="tour-listing__card-bottom-right">
                                    <h4 class="tour-listing__card-price">₹5999</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="tour-listing__card">
                    <a href="package_details.php" class="tour-listing__card-image-box">
                        <img src="<?php echo THEMEURL; ?>assets/images/tour-3-3.jpg" alt="" class="tour-listing__card-image">
                        
                        <div class="tour-listing__card-image-overlay"></div>
                    </a>
                    <div class="tour-listing__card-content">
                        
                        <h3 class="tour-listing__card-title"><a href="package_details.php">Taj Mahal And Indian Wildlife Tour</a></h3>
                        <p class="tour-listing__card-text text-small">Lorem ipsum dolor sit amet, consectet adipiscing elit.</p>
                        <div class="tour-listing__card-inner-content">
                            
                            <div class="tour-listing__card-location-box">
                                <span class="icon-location-1"></span>
                                <p class="tour-listing__card-location-text text-small">New Delhi</p>
                            </div>
                            <div class="tour-listing__card-divider"></div>
                            <div class="tour-listing__card-bottom">
                                <div class="tour-listing__card-bottom-left">
                                    <div class="tour-listing__card-day">
                                        <span class="icon-clock-1"></span>
                                        <p class="tour-listing__card-day-text text-small">3 Days</p>
                                    </div>
                                    <div class="tour-listing__card-people">
                                        <span class="icon-Duration"></span>
                                        <p class="tour-listing__card-people-text text-small">2 Nights</p>
                                    </div>
                                </div>
                                <div class="tour-listing__card-bottom-right">
                                    <h4 class="tour-listing__card-price">₹5999</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="tour-listing__card">
                    <a href="package_details.php" class="tour-listing__card-image-box">
                        <img src="<?php echo THEMEURL; ?>assets/images/tour-3-1.jpg" alt="" class="tour-listing__card-image">
                        
                        <div class="tour-listing__card-image-overlay"></div>
                    </a>
                    <div class="tour-listing__card-content">
                        
                        <h3 class="tour-listing__card-title"><a href="package_details.php">Best of Goa with Dudhsagar Falls</a></h3>
                        <p class="tour-listing__card-text text-small">Lorem ipsum dolor sit amet, consectet adipiscing elit.</p>
                        <div class="tour-listing__card-inner-content">
                            
                            <div class="tour-listing__card-location-box">
                                <span class="icon-location-1"></span>
                                <p class="tour-listing__card-location-text text-small">New Delhi</p>
                            </div>
                            <div class="tour-listing__card-divider"></div>
                            <div class="tour-listing__card-bottom">
                                <div class="tour-listing__card-bottom-left">
                                    <div class="tour-listing__card-day">
                                        <span class="icon-clock-1"></span>
                                        <p class="tour-listing__card-day-text text-small">3 Days</p>
                                    </div>
                                    <div class="tour-listing__card-people">
                                        <span class="icon-Duration"></span>
                                        <p class="tour-listing__card-people-text text-small">2 Nights</p>
                                    </div>
                                </div>
                                <div class="tour-listing__card-bottom-right">
                                    <h4 class="tour-listing__card-price">₹5999</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    
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
                                <a href="package_details.php" class="tour-listing__card-image-box">
                                    <img src="<?php echo UPLOADURL.'packages/'.$package->package_images; ?>" alt="" class="tour-listing__card-image">
                                    
                                    <div class="tour-listing__card-image-overlay"></div>
                                </a>
                                <div class="tour-listing__card-content">
                                    
                                    <h3 class="tour-listing__card-title"><a href="package_details.php"> <?php echo $package->package_title; ?></a></h3>
                                    <p class="tour-listing__card-text text-small"> <?php echo substr($package->description,0,100).'.........'?>  </p>
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

<section class="about_sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="sec-title text-left">
                        <p class="sec-title__tagline text-white">About Us</p>
                        <h2 class="sec-title__title text-white">Experience The World With Our Travel Bunny</h2>

                        <div class="mt-4">
                        <div class="row">
                            <div class="col-2">
                                <div class="circle red">
                                    <img src="<?php echo THEMEURL; ?>assets/images/wallet.png" alt="">
                                </div>
                            </div>
                            <div class="col-10">
                                <h5 class="text-white mb-0">Affordable Prices</h5>
                                <p class="text-white">We provide some very affordable prices compared to others.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="circle blue">
                                    <img src="<?php echo THEMEURL; ?>assets/images/users.png" alt="">
                                </div>
                            </div>
                            <div class="col-10">
                                <h5 class="text-white mb-0">Unforgettable Experience</h5>
                                <p class="text-white">We provide a very unforgettable hot air balloon ride experience.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="circle green">
                                    <img src="<?php echo THEMEURL; ?>assets/images/heart.png" alt="">
                                </div>
                            </div>
                            <div class="col-10">
                                <h5 class="text-white mb-0">Very Friendly Service</h5>
                                <p class="text-white">We will provide excellent and friendly service for the sake of our customers.</p>
                            </div>
                        </div>
                         <div class="view_detail_btn mt-4">
                        <a href="about.php" class="travel-btn travel-btn--base-two"><span>Know More</span></a>
                    </div>
                      </div>
                    </div>
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="200ms">
                     <div class="why-choose-four__author">
                        <div class="why-choose-four__author__image">
                            <img src="<?php echo THEMEURL; ?>assets/images/customer-1.png" alt="customer">
                            <img src="<?php echo THEMEURL; ?>assets/images/customer-2.png" alt="customer">
                            <img src="<?php echo THEMEURL; ?>assets/images/customer-3.png" alt="customer">
                            <img src="<?php echo THEMEURL; ?>assets/images/customer-4.png" alt="customer">
                        </div>
                        <div class="why-choose-four__author__text">
                            <h3 class="why-choose-four__author__total">38K +</h3>
                            <h3 class="why-choose-four__author__title">Satisfied Customers</h3>
                        </div>
                    </div>
                <img src="<?php echo THEMEURL; ?>assets/images/about_img.png" class="img-fluid" alt=""/>
            </div>
        </div>
    </div>
</section>

        
<section class="about-one pad-60-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 wow fadeInLeft" data-wow-delay="200ms">
                <div class="about-one__image">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="about-one__image__one travel-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 3, "speed": 700, "scale": 1 }'>
                                <img src="<?php echo THEMEURL; ?>assets/images/about-1-1.jpg" alt="travel">
                                <img src="<?php echo THEMEURL; ?>assets/images/about-1-2.jpg" alt="travel">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 178 30">
                                    <path d="M177.276 2.12957C155.784 21.96 90.3733 49.5857 0.667034 1.44487" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="about-one__image__two">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 163 75">
                                    <path d="M1.02818 74.4809C12.3872 47.5342 60.5019 -4.68383 162.089 2.01835" />
                                </svg>
                                <div class="travel-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 5, "speed": 700, "scale": 1 }'>
                                    <img src="<?php echo THEMEURL; ?>assets/images/about-1-3.jpg" alt="travel">
                                </div>
                                <div class="about-one__image__two__shape"><img src="<?php echo THEMEURL; ?>assets/images/about-1-shape-3.png" alt="travel"></div>
                                <div class="about-one__counter" style="background-image: url(<?php echo THEMEURL; ?>assets/images/about-1-shape-4.png);">
                                    <div class="about-one__counter__number count-box"><span class="count-text" data-stop="30" data-speed="1500"></span>%</div><!-- /.counter__number -->
                                    <p class="about-one__counter__title">Discount</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="about-one__shape-two">
                    <img src="<?php echo THEMEURL; ?>assets/images/about-1-shape-2.png" alt="travel">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 wow fadeInRight" data-wow-delay="200ms">
                <div class="about-one__content">
                    <div class="sec-title text-left">
                        <p class="sec-title__tagline text-theme">GET TO KNOW US</p>
                        <h2 class="sec-title__title text-black">Made in India for all your travel needs</h2>
                    </div>
                    
                    <div class="about-one__box">
                        <div class="about-one__box__icon"><img src="<?php echo THEMEURL; ?>assets/images/about_icon1.png" alt=""/></div>
                        <h3 class="about-one__box__title">Best Client <br>Support</h3>
                        <p class="about-one__box__text">24x7 IVR and chat support available with dedicated support team</p>
                    </div>
                    <div class="about-one__box">
                        <div class="about-one__box__icon"><img src="<?php echo THEMEURL; ?>assets/images/about_icon2.png" alt=""/></div>
                        <h3 class="about-one__box__title">Best Domestic & International Air Fares</h3>
                        <p class="about-one__box__text">Industry wide best incentives on all airlines along with special offline fares.</p>
                    </div>
                    <div class="about-one__box">
                        <div class="about-one__box__icon"><img src="<?php echo THEMEURL; ?>assets/images/about_icon3.png" alt=""/></div>
                        <h3 class="about-one__box__title">Your Clients Will <br>Love Us</h3>
                        <p class="about-one__box__text">Fast, reliable and quick services for your customers</p>
                    </div>
                    <div class="about-one__box">
                        <div class="about-one__box__icon"><img src="<?php echo THEMEURL; ?>assets/images/about_icon4.png" alt=""/></div>
                        <h3 class="about-one__box__title">White Label <br>and API Services </h3>
                        <p class="about-one__box__text">Custom technology solutions available for all your travel needs</p>
                    </div>
                    <div class="about-one__box">
                        <div class="about-one__box__icon"><img src="<?php echo THEMEURL; ?>assets/images/about_icon5.png" alt=""/></div>
                        <h3 class="about-one__box__title">Domestic & International Hotels</h3>
                        <p class="about-one__box__text">From single star to seven star hotels with best rates</p>
                    </div>
                    <div class="view_detail_btn">
                        <a href="about.php" class="travel-btn"><span>View Details</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="what_we_sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="sec-title text-left">
                        <p class="sec-title__tagline text-white">What We Do</p>
                        <h2 class="sec-title__title text-white">The Best Trips, Like The Best Love Affairs, Never Really End.</h2>
                       

                        <div class="mt-4">
                            <div class="item">
                                <div class="row">
                                     <div class="col-2">
                                        <div class="icon">
                                            <img src="<?php echo THEMEURL; ?>assets/images/what_we_icon1.png" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="text-black">Domestic International Holiday Packages</h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur..</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="row">
                                     <div class="col-2">
                                        <div class="icon">
                                            <img src="<?php echo THEMEURL; ?>assets/images/what_we_icon2.png" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="text-black">Luxury Honeymoon <br>Packages</h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur..</p>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="row">
                                     <div class="col-2">
                                        <div class="icon">
                                            <img src="<?php echo THEMEURL; ?>assets/images/what_we_icon3.png" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="text-black">Destination Weddings <br>Packages</h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur..</p>
                                    </div>
                                </div>
                            </div>
                        
                      </div>
                    </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="200ms">
                     
                     <div class="why-choose-two__img">

                    <div class="why-choose-two__img__one wow fadeInUp" data-wow-delay="200ms">
                        <div class="trevlo-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 7, "speed": 700, "scale": 1 }'>
                            <img src="<?php echo THEMEURL; ?>assets/images/what-we-do-2-1.jpg" alt="what-we-do">
                        </div>
                        <div class="trevlo-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 7, "speed": 700, "scale": 1 }'>
                            <img src="<?php echo THEMEURL; ?>assets/images/what-we-do-2-2.jpg" alt="what-we-do">
                        </div>
                    </div>
                    <div class="why-choose-two__img__two wow fadeInUp" data-wow-delay="300ms">
                        <div class="trevlo-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 7, "speed": 700, "scale": 1 }'>
                            <img src="<?php echo THEMEURL; ?>assets/images/what-we-do-2-3.jpg" alt="what-we-do">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="<?php echo THEMEURL; ?>assets/images/what_we_arrow.png" class="what_we_arrow" alt=""/>
</section>
       
<section class="destination-one">
    <div class="container">
        <div class="destination-page__row row">
            <div class="col-xl-3 col-md-6 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                <div class="sec-title text-left">

                    <p class="sec-title__tagline text-theme">Destination list</p>

                    <h2 class="sec-title__title text-black">Explore the Beautiful Places Around the <br> World</h2>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                <div class="destination-one__card">
                    <div class="destination-one__card-img-box destination-one__card-img-box--round">
                        <img src="<?php echo THEMEURL; ?>assets/images/destination-1-2.jpg" alt="destination" class="destination-one__card-img destination-one__card-img--round">
                        <div class="destination-one__card-overlay destination-one__card-overlay--round">
                            <div class="destination-one__card-content destination-one__card-content--round">
                                <a class="destination-one__card-btn destination-one__card-btn--round travel-btn travel-btn--base travel-btn--base-three"><span>8 TOURS</span></a>
                                <h4 class="destination-one__card-title">Spain</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-8 wow animated fadeInUp" data-wow-delay="0.5s" data-wow-duration="1500ms">
                <div class="destination-one__card">
                    <div class="destination-one__card-img-box destination-one__card-img-box--round">
                        <img src="<?php echo THEMEURL; ?>assets/images/destination-1-3.jpg" alt="destination" class="destination-one__card-img destination-one__card-img--round">
                        <div class="destination-one__card-overlay destination-one__card-overlay--round">
                            <div class="destination-one__card-content destination-one__card-content--round">
                                <a class="destination-one__card-btn destination-one__card-btn--round travel-btn travel-btn--base travel-btn--base-three"><span>7 TOURS</span></a>
                                <h4 class="destination-one__card-title">Thailand</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                <div class="destination-one__card">
                    <div class="destination-one__card-img-box destination-one__card-img-box--circle">
                        <img src="<?php echo THEMEURL; ?>assets/images/destination-1-4.jpg" alt="destination" class="destination-one__card-img destination-one__card-img--circle">
                        <div class="destination-one__card-overlay destination-one__card-overlay--circle">
                            <div class="destination-one__card-content destination-one__card-content--circle">
                                <a class="destination-one__card-btn destination-one__card-btn--circle travel-btn travel-btn--base travel-btn--base-three"><span>8 TOURS</span></a>
                                <h4 class="destination-one__card-title">Dubai</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                <div class="destination-one__card">
                    <div class="destination-one__card-img-box destination-one__card-img-box--round">
                        <img src="<?php echo THEMEURL; ?>assets/images/destination-1-5.jpg" alt="destination" class="destination-one__card-img destination-one__card-img--round">
                        <div class="destination-one__card-overlay destination-one__card-overlay--round">
                            <div class="destination-one__card-content destination-one__card-content--round">
                                <a class="destination-one__card-btn destination-one__card-btn--round travel-btn travel-btn--base travel-btn--base-three"><span>13 TOURS</span></a>
                                <h4 class="destination-one__card-title">Australia</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow animated fadeInUp" data-wow-delay="0.5s" data-wow-duration="1500ms">
                <div class="destination-one__card">
                    <div class="destination-one__card-img-box destination-one__card-img-box--circle">
                        <img src="<?php echo THEMEURL; ?>assets/images/destination-1-7.jpg" alt="destination" class="destination-one__card-img destination-one__card-img--circle">
                        <div class="destination-one__card-overlay destination-one__card-overlay--circle">
                            <div class="destination-one__card-content destination-one__card-content--circle">
                                <a class="destination-one__card-btn destination-one__card-btn--circle travel-btn travel-btn--base travel-btn--base-three"><span>2 TOURS</span></a>
                                <h4 class="destination-one__card-title">Italy</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                <div class="destination-one__card">
                    <div class="destination-one__card-img-box destination-one__card-img-box--round">
                        <img src="<?php echo THEMEURL; ?>assets/images/destination-1-5.jpg" alt="destination" class="destination-one__card-img destination-one__card-img--round">
                        <div class="destination-one__card-overlay destination-one__card-overlay--round">
                            <div class="destination-one__card-content destination-one__card-content--round">
                                <a class="destination-one__card-btn destination-one__card-btn--round travel-btn travel-btn--base travel-btn--base-three"><span>13 TOURS</span></a>
                                <h4 class="destination-one__card-title">Egypt</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="<?php echo THEMEURL; ?>assets/images/destination_bg.png" class="destination_bg" alt=""/>
</section>
        
<section class="offer-one" style="background-image: url('<?php echo THEMEURL; ?>assets/images/offer-1-bg.png');">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6">
                <div class="offer-one__content sec-title">
                    <p class="sec-title__tagline text-white">A look at our services</p>
                    <h2 class="offer-one__heading sec-title__heading">What services does TravelBunny offer</h2>
                    <p class="offer-one__text">TravelBunny offers a wide variety of travel related solutions to fulfill all your travel requirements. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pharetra dictum metus et porta. Aliquam vulputate laoreet odio, et congue turpis laoreet sit amet. Suspendisse finibus interdum maximus.</p>
                    <div class="offer-one__btn-box wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <a href="why_to_choose.php" class="main-header__booking-btn travel-btn travel-btn--white-two"><span>View Details</span></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 wow animated fadeInRight" data-wow-delay="0.1s" data-wow-duration="1500ms">
                <div class="offer-one__img-box">
                    <div class="offer-one__inner-img-box">
                        <img src="<?php echo THEMEURL; ?>assets/images/offer-1-1.jpg" alt="offer" class="offer-one__img-one">
                        <img src="<?php echo THEMEURL; ?>assets/images/offer-1-2.jpg" alt="offer" class="offer-one__img-two">
                        <img src="<?php echo THEMEURL; ?>assets/images/offer-1-3.png" alt="offer" class="offer-one__img-three">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="offer-one__bottom-bg" style="background-image: url('<?php echo THEMEURL; ?>assets/images/offer-1-4.png');"></div>
</section>

<section class="counter-one">
    <div class="counter-one__bg-box"></div>
    <div class="counter-one__main-content">
        <div class="container">
            <div class="counter-one__container container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <div class="counter-box @@extraClassName">
                            <div class="counter-box__icon">
                                <span><img src="<?php echo THEMEURL; ?>assets/images/fact_1.png" alt=""/></span>
                            </div>
                            <div class="counter-box__inner sec-title count-box">
                                <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text" data-stop="1000" data-speed="1500">00</h3>
                                <h3 class="counter-box__count-text sec-title__heading">+</h3>
                            </div>
                            <p class="counter-box__title">Happy Customers</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                        <div class="counter-box @@extraClassName">
                            <div class="counter-box__icon">
                                <span><img src="<?php echo THEMEURL; ?>assets/images/fact_2.png" alt=""/></span>
                            </div>
                            <div class="counter-box__inner sec-title count-box">
                                <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text" data-stop="150" data-speed="1500">00</h3>
                                <h3 class="counter-box__count-text sec-title__heading">+</h3>
                            </div>
                            <p class="counter-box__title">Amazing Tours</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.5s" data-wow-duration="1500ms">
                        <div class="counter-box @@extraClassName">
                            <div class="counter-box__icon">
                               <span><img src="<?php echo THEMEURL; ?>assets/images/fact_3.png" alt=""/></span>
                            </div>
                            <div class="counter-box__inner sec-title count-box">
                                <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text" data-stop="30" data-speed="1500">00</h3>
                                <h3 class="counter-box__count-text sec-title__heading">+</h3>
                            </div>
                            <p class="counter-box__title">Branches</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.7s" data-wow-duration="1500ms">
                        <div class="counter-box counter-box--no-border">
                            <div class="counter-box__icon">
                                <span><img src="<?php echo THEMEURL; ?>assets/images/fact_4.png" alt=""/></span>
                            </div>
                            <div class="counter-box__inner sec-title count-box">
                                <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text" data-stop="10" data-speed="1500">00</h3>
                                <h3 class="counter-box__count-text sec-title__heading">+</h3>
                            </div>
                            <p class="counter-box__title">Years of Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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

 
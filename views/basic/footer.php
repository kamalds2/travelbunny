  <?php 
    $settingsData = $this->getSettingsData();  
    $contact_nos = explode(',',$settingsData->contact_nos);  
    
  ?>
  <footer class="main-footer @@extraClassName">
   <div class="container">
     <div class="network_sec">
        <h2 class="text-white text-center sec-title__title">Our Network</h2>
        <div class="content">
         <div class="row">
           <div class="col-6 col-xs-3 col-md-2">
             <img src="<?php echo THEMEURL; ?>assets/images/netswork_logo1.png" alt=""/>
           </div>
           <div class="col-6 col-xs-3 col-md-2">
             <img src="<?php echo THEMEURL; ?>assets/images/netswork_logo2.png" alt=""/>
           </div>
           <div class="col-6 col-xs-3 col-md-2">
             <img src="<?php echo THEMEURL; ?>assets/images/netswork_logo3.png" alt=""/>
           </div>
           <div class="col-6 col-xs-3 col-md-2">
             <img src="<?php echo THEMEURL; ?>assets/images/netswork_logo4.png" alt=""/>
           </div>
           <div class="col-6 col-xs-3 col-md-2">
             <img src="<?php echo THEMEURL; ?>assets/images/netswork_logo5.png" alt=""/>
           </div>
           <div class="col-6 col-xs-3 col-md-2">
             <img src="<?php echo THEMEURL; ?>assets/images/netswork_logo6.png" alt=""/>
           </div>
         </div>
        </div>
     </div>
     <div class="main-footer__top row mt-n6">
       <div class="col-lg-3 col-sm-4 mt-0">
         <div class="main-footer__logo-box">
           <img src="<?php echo THEMEURL; ?>assets/images/logo-dark.png" alt="logo-dark" class="main-footer__logo">
         </div>
       </div>
       <div class="col-lg-9 col-sm-8">
         <ul class="main-footer__social">
           <li class="main-footer__social-item">
             <a href="https://facebook.com" target="_blank" class="main-footer__social-link">
               <img src="<?php echo THEMEURL; ?>assets/images/fb.png" alt=""/>
             </a>
           </li>
           <li class="main-footer__social-item">
             <a href="https://twitter.com" target="_blank" class="main-footer__social-link">
               <img src="<?php echo THEMEURL; ?>assets/images/tw.png" alt=""/>
             </a>
           </li>
           <li class="main-footer__social-item">
             <a href="https://instagram.com" target="_blank" class="main-footer__social-link">
               <img src="<?php echo THEMEURL; ?>assets/images/insta.png" alt=""/>
             </a>
           </li>
           <li class="main-footer__social-item">
             <a href="https://youtube.com" target="_blank" class="main-footer__social-link">
               <img src="<?php echo THEMEURL; ?>assets/images/yt.png" alt=""/>
             </a>
           </li>
         </ul>
       </div>
       <div class="col-12">
         <div class="main-footer__line"></div>
       </div>
     </div>
     <div class="row gutter-y-40">
       <div class="col-lg-3 col-md-4 col-sm-6 col-xl-2 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
         <div class="footer-widget footer-widget--links">
           <h2 class="footer-widget__title">Company</h2>
           <ul class="footer-widget__links">
              <?php  
                echo $this->getMenuDetails();                     
              ?> 
             <!-- <li>
               <a href="index.php">Home</a>
             </li>
             <li>
               <a href="about.php">About Us</a>
             </li>
             <li>
               <a href="what_we_do.php">What We Do</a>
             </li>
             <li>
               <a href="why_to_choose.php">Why To Choose</a>
             </li>
             <li>
               <a href="testimonials.php">Testimonials</a>
             </li> -->
             <li>
               <a href="<?php echo SITEURL?>contact">Contact Us</a>
             </li>
           </ul>
         </div>
       </div>
       <div class="col-lg-3 col-md-4 col-sm-6 col-xl-2 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
         <div class="footer-widget footer-widget--links">
           <h2 class="footer-widget__title">Explore</h2>
           <ul class="footer-widget__links">
             <li>
               <a href="<?php echo SITEURL?>packages">Tour Listings</a>
             </li>
             <li>
               <a href="<?php echo SITEURL?>packages">Domastic Tours</a>
             </li>
             <!-- <li>
               <a href="<?php //echo SITEURL?>packages">International Tours</a>
             </li> -->
             <li>
               <a href="<?php echo SITEURL?>privacyPolicy">Privacy Policy</a>
             </li>
           </ul>
         </div>
       </div>
       <div class="col-lg-6 col-md-4 col-xl-4 wow animated fadeInUp" data-wow-delay="0.5s" data-wow-duration="1500ms">
         <div class="footer-widget footer-widget--contact">
           <h2 class="footer-widget__title">Contact</h2>
           <ul class="footer-widget__info">
             <li class="footer-widget__address">
               <i>
                 <img src="<?php echo THEMEURL; ?>assets/images/location_icon.png" alt=""/>
               </i> <?php echo $settingsData->footer_address; ?>
             </li>
             <li>
               <i>
                 <img src="<?php echo THEMEURL; ?>assets/images/phone_icon.png" alt=""/>
               </i>
               <?php 
                if(!empty($contact_nos)){
                  foreach ($contact_nos as $key => $value) { ?>
                     <a href="tel: <?php echo $value; ?>"> <?php echo $value; ?></a>
                  <?php }  } ?> 
             </li>
             <li>
               <i>
                 <img src="<?php echo THEMEURL; ?>assets/images/email_icon.png" alt=""/>
               </i>
               <a href="mailto: <?php echo $settingsData->email; ?>"><?php echo $settingsData->email; ?></a>
             </li>
           </ul>
         </div>
       </div>
       <div class="col-lg-7 col-xl-4 wow animated fadeInUp" data-wow-delay="0.7s" data-wow-duration="1500ms">
           <div class="footer-widget footer-widget--contact">
           <h2 class="footer-widget__title">About Us</h2>
           <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nec luctus velit. Proin sit amet massa diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra.  <a href="<?php echo SITEURL.'aboutus'?>">Read More</a></p>

         </div>
       </div>
     </div>
     <img src="<?php echo THEMEURL; ?>assets/images/footer_bg.png" class="footer_bg" alt=""/>
   </div>
   <div class="main-footer__bottom">
     <div class="container">
       <div class="main-footer__bottom-inner">
         <div class="row">
           <div class="col-md-6">
             <p class="main-footer__copyright text-left"> &copy; Copyright <span class="dynamic-year"></span>
               <span class="text-base">Travel Bunny</span>, All Rights Reserved.
             </p>
           </div>
           <div class="col-md-6">
             <p class="main-footer__copyright text-right"> Powered by : <a href="https://siriinnovations.com/" target="_black">
                 <img src="<?php echo THEMEURL; ?>assets/images/siri_logo.png" style="width:50px;" alt=""/>
               </a>
             </p>
           </div>
         </div>
       </div>
     </div>
   </div>
  </footer>
 <!-- </div> -->
 <div class="mobile-nav__wrapper">
   <div class="mobile-nav__overlay mobile-nav__toggler"></div>
   <div class="mobile-nav__content">
     <span class="mobile-nav__close mobile-nav__toggler">
       <i class="fa fa-times"></i>
     </span>
     <div class="logo-box">
       <a href="#" aria-label="logo image">
         <img src="<?php echo THEMEURL; ?>assets/images/logo-dark.png" width="155" alt="" />
       </a>
     </div>
     <div class="mobile-nav__container"></div>
     <ul class="mobile-nav__contact list-unstyled">
       <li>
         <i class="fa fa-envelope"></i>
         <a href="mailto:<?php echo $settingsData->email ?>"> <?php echo $settingsData->email ?> </a>
       </li>
       <li>
         <i class="fa fa-phone-alt"></i>
         <a href="tel:<?php echo $settingsData->toll_free_no;?>"><?php echo $settingsData->toll_free_no;?></a>
       </li>
     </ul>
     <div class="mobile-nav__social">
       <ul class="main-footer__social">
         <li class="main-footer__social-item">
           <a href="<?php echo $settingsData->facebook_link;?>" target="_blank" class="main-footer__social-link">
             <img src="<?php echo THEMEURL; ?>assets/images/fb.png" alt=""/>
           </a>
         </li>
         <li class="main-footer__social-item">
           <a href="<?php echo $settingsData->facebook_link;?>" target="_blank" class="main-footer__social-link">
             <img src="<?php echo THEMEURL; ?>assets/images/tw.png" alt=""/>
           </a>
         </li>
         <li class="main-footer__social-item">
           <a href="<?php echo $settingsData->instagram_link;?>" target="_blank" class="main-footer__social-link">
             <img src="<?php echo THEMEURL; ?>assets/images/insta.png" alt=""/>
           </a>
         </li>
         <li class="main-footer__social-item">
           <a href="<?php echo $settingsData->youtube_link;?>" target="_blank" class="main-footer__social-link">
           <a href="<?php echo $settingsData->youtube_link;?>" target="_blank" class="main-footer__social-link">
             <img src="<?php echo THEMEURL; ?>assets/images/yt.png" alt=""/>
           </a>
         </li>
       </ul>
     </div>
   </div>
 </div>
 <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
   <span class="scroll-to-top__text">back top</span>
   <span class="scroll-to-top__wrapper">
     <span></span>
   </span>
 </a>
 
 
 <script src="<?php echo THEMEURL; ?>assets/js/bootstrap.bundle.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/bootstrap-select.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jarallax.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery-ui.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.ajaxchimp.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.appear.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.circle-progress.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.magnific-popup.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.validate.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/nouislider.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/tiny-slider.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/wNumb.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/owl.carousel.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/owlcarousel2-filter.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/wow.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/tilt.jquery.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/simpleParallax.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/imagesloaded.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/isotope.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/countdown.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/moment.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/daterangepicker.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.circleType.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/jquery.lettering.min.js"></script>
 <script src="<?php echo THEMEURL; ?>assets/js/custom.js"></script>
 </body>
 </html>
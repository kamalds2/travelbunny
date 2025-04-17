  <section class="page-header">
    <div class="page-header__bg"></div>
    <div class="container">
        <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Contact Us</h2>
        <div class="page-header__breadcrumb-box">
            <ul class="travel-breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
</section>

<section class="contact-page what_we_sec">
    <div class="row">
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
    </div>   
    <div class="container">
        <div class="sec-title text-center">
            <h2 class="sec-title__title">Enquiry Form</h2>
        </div>
        <form action="<?php echo SITEURL?>contact/addContactDetails" id="addContactForm" name="addContactForm" method="post" class="contact-page__form form-one row gutter-20 contact-form-validated">
            <div class="col-md-6 wow animated fadeInUp" data-wow-delay="0s" data-wow-duration="1500ms">
                <div class="form-one__group">
                    <input type="text" name="name" id="form-one-name-input" placeholder="Your Name" class="form-one__input">
                </div>
            </div>
            <div class="col-md-6 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                <div class="form-one__group">
                    <input type="email" name="email" id="form-one-email-input" placeholder="Email Address" class="form-one__input">
                </div>
            </div>
            <div class="col-md-6 wow animated fadeInUp" data-wow-delay="0s" data-wow-duration="1500ms">
                <div class="form-one__group">
                    <input type="tel" name="mobile_no" id="form-one-phone-input" placeholder="Phone" class="form-one__input">
                </div>
            </div>
            <div class="col-md-6 wow animated fadeInUp" data-wow-delay="0.3s" data-wow-duration="1500ms">
                <div class="form-one__group">
                    <input type="text" name="subject" id="form-one-subject-input" placeholder="Subject" class="form-one__input">
                </div>
            </div>
            <div class="col-12 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                <div class="form-one__group">
                    <textarea name="message" id="form-one-message-input" cols="30" rows="10" placeholder="Write a Message" class="form-one__message form-one__input"></textarea>
                </div>
            </div>
            <div class="col-12 wow animated fadeInUp" data-wow-delay="0.2s" data-wow-duration="1500ms">
                <div class="form-one__btn-box">
                    <button type="submit" class="form-one__btn travel-btn travel-btn--base"><span>Send
                            Message</span></button>
                </div>
            </div>
        </form>
        <div class="result"></div>
         
    </div>
    <div class="contact-page__info">
        <div class="contact-page__info-container container">
            <div class="contact-page__info-top">
                <p class="contact-page__info-top-title">Contact Information</p>
            </div>
            <div class="contact-page__info-row row">
                <div class="col-lg-4 wow animated fadeInUp mt-2" data-wow-delay="0.6s" data-wow-duration="1500ms">
                    <div class="contact-page__info-box contact-page__info-box--three">
                        <div class="contact-page__info-icon-box">
                            <span class="icon-location-1"></span>
                        </div>
                        <div class="contact-page__info-text-box">
                            <p class="contact-page__info-title">Visit Anytime</p>
                            <h4 class="contact-page__info-text">#FF3, The Toursim Plaza, Balayogi Bhavn, Greenlands, Begumpet, Hyderabad - 500016</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow animated fadeInUp mt-2" data-wow-delay="0s" data-wow-duration="1500ms">
                    <div class="contact-page__info-box">
                        <div class="contact-page__info-icon-box">
                            <span class="icon-phone-1"></span>
                        </div>
                        <div class="contact-page__info-text-box">
                            <p class="contact-page__info-title">Have any question?</p>
                            <a href="tel:23(000)-8050">
                                <h4 class="contact-page__info-text contact-page__info-text-link">+91 7095544995, +91 8340000365
                                </h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow animated fadeInUp mt-2" data-wow-delay="0.3s" data-wow-duration="1500ms">
                    <div class="contact-page__info-box">
                        <div class="contact-page__info-icon-box">
                            <span class="icon-envelope"></span>
                        </div>
                        <div class="contact-page__info-text-box">
                            <p class="contact-page__info-title">Send Email</p>
                            <a href="mailto:help@trevlo.com">
                                <h4 class="contact-page__info-text contact-page__info-text-link"> chandra@travelbunny.in</h4>
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <img src="<?php echo THEMEURL?>assets/images/what_we_arrow_dark.png" class="what_we_arrow" style="bottom: 610px; right: -560px;" />
    <div class="google-map google-map__@@extraClassName">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.5364902155743!2d78.45226097486999!3d17.4340179014606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb974ceb91a8b7%3A0xe56beddbe7c3633a!2sVACATIONS%20EXOTICA%20(A%20Holiday%20Division%20of%20Balmer%20Lawrie%20%26%20Co%20Ltd)!5e0!3m2!1sen!2sin!4v1711173170620!5m2!1sen!2sin" width="100%" height="300"></iframe>
       
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () { 
        $('#addContactForm').validate({   
                  
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



 
 <section class="page-header">
            <div class="page-header__bg"></div>
            <div class="container">
                <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Testimonials</h2>
                <div class="page-header__breadcrumb-box">
                    <ul class="travel-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li>Testimonials</li>
                    </ul>
                </div>
            </div>
        </section>

<section class="testimonial_sec">
    <div class="container">
        <div class="row ">
            <?php 
                $testimonialsList = $this->testimonials->res; 
                if(!empty($testimonialsList)){
                    foreach ($testimonialsList as $test) { 
                
            ?>
            <div class="col-sm-4">
                <div class="item position-relative">
                   <iframe width="100%" height="300" src="<?php echo $test->video_url;?>"></iframe>
                </div>
            </div>
            
             <?php }} ?>
        </div>
    </div>
</section>

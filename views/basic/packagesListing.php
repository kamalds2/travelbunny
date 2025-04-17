
<section class="page-header">
    <div class="page-header__bg"></div>
    <div class="container">
        <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Tour Packages</h2>
        <div class="page-header__breadcrumb-box">
            <ul class="travel-breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Tour Packages</li>
            </ul>
        </div>
    </div>
</section>

<section class="tour-listing-filter tour-listing">
    <div class="container">
        <div class="tour-listing-filter__row row">
             
            <?php 
                $packagesList = $this->packages->res; 
            if(!empty($packagesList)){
                foreach ($packagesList as $pack) {  
                
            ?>
            <div class="col-xl-3 col-md-6 wow animated fadeInUp" data-wow-delay="0.1s" data-wow-duration="1500ms">
                <div class="item">
                    <div class="tour-listing__card">
                        <a href="<?php echo SITEURL.'packages/packageDetails/'.$pack->package_id?>" class="tour-listing__card-image-box">
                            <img src="<?php echo UPLOADURL.'packages/'.$pack->package_images; ?>" alt="<?php echo UPLOADURL.'packages/'.$pack->package_images; ?>" class="tour-listing__card-image">
                        
                            <div class="tour-listing__card-image-overlay"></div>
                        </a>
                        <div class="tour-listing__card-content">
                        
                            <h3 class="tour-listing__card-title"><a href="<?php echo SITEURL.'packages/packageDetails/'.$pack->package_id?>"><?php echo $pack->package_title;?> </a></h3>
                            <p class="tour-listing__card-text text-small"> <?php echo substr($pack->description,0,100).'.........'?> </p>
                            <div class="tour-listing__card-inner-content">
                            
                                <div class="tour-listing__card-location-box">
                                    <span class="icon-location-1"></span>
                                    <p class="tour-listing__card-location-text text-small"><?php   echo $pack->location;?></p>
                                </div>
                                <div class="tour-listing__card-divider"></div>
                                <div class="tour-listing__card-bottom">
                                    <div class="tour-listing__card-bottom-left">
                                        <div class="tour-listing__card-day">
                                            <span class="icon-clock-1"></span>
                                            <p class="tour-listing__card-day-text text-small"><?php echo $pack->no_of_days;?>  Days</p>
                                        </div>
                                        <div class="tour-listing__card-people">
                                            <span class="icon-Duration"></span>
                                            <p class="tour-listing__card-people-text text-small"><?php echo $pack->no_of_nights;?>  Nights</p>
                                        </div>
                                    </div>
                                    <div class="tour-listing__card-bottom-right">
                                        <h4 class="tour-listing__card-price">₹<?php echo $pack->package_price;?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>   
            <?php } }?>  
            <!-- <ul class="post-pagination tour-listing-filter__pagination">
                <li>
                    <a href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul> -->
        </div>
    </div>
</section>



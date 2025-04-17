<section class="page-header">
    <div class="page-header__bg"></div>
    <div class="container">
        <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms"><?php echo $this->pageDetails->res->page_title;?></h2>
        <div class="page-header__breadcrumb-box">
            <ul class="travel-breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li><?php echo $this->pageDetails->res->page_title;?></li>
            </ul>
        </div>
    </div>
</section>

<section class="about-one">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sec-title">
                    <!-- <h2 class="sec-title__title text-black"> <?php //echo $this->pageDetails->res->page_title;?>
                    </h2> -->
                    <div class="text-justify">
                         <?php echo $this->pageDetails->res->page_description;?>
          
                    </div>
                                
                </div>
            </div>
             
        </div>
    
    </div>
</section>

 
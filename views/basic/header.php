<?php 
   $settingsData = $this->getSettingsData();  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $this->metaDetails['meta_title']; ?></title>
    
    <link rel="icon" type="image/png" href="<?php echo UPLOADURL.'settings/'.$settingsData->fav_icon; ?>" />
    
    <meta name="description" content="<?php echo $this->metaDetails['meta_description']; ?>">

    <meta name="keywords" content="<?php echo $this->metaDetails['meta_keywords']; ?>" />
    <link rel="canonical" href="<?php echo SITEURL; ?>" />

    <meta property="og:title" content="<?php echo $this->metaDetails['meta_title']; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo SITEURL;?>" />
    <meta property="og:image" content="https://vyz.bz/travel_bunny/html/assets/images/og_banner.jpg" />
    <meta property="og:site_name" content="Travel Bunny - India's Best Upcoming B2B Destination Management Company" />
    <meta property="og:description" content="<?php echo $this->metaDetails->res->meta_description; ?>" />
    <meta name="twitter:card" value="summary" />
    <meta name="twitter:site" value="@Travel Bunny - India's Best Upcoming B2B Destination Management Company" />
    <meta property="twitter:url" content="<?php echo SITEURL; ?>" />
    <meta property="twitter:title" content="<?php echo $this->metaDetails['meta_title']; ?>" />
    <meta property="twitter:description" content="<?php echo $this->metaDetails['meta_description']; ?>" />

    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/animate.min.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>assets/css/custom.css" />
    <script src="<?php echo THEMEURL; ?>assets/js/jquery-3.7.0.min.js"></script>
  </head>
  <body class="custom-cursor">
    <div class="preloader">
      <div class="preloader__image" style="background-image: url(<?php echo THEMEURL; ?>assets/images/loader.png);"></div>
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">
      <div class="topbar-one">
        <div class="topbar-one__container container-fluid">
          <div class="topbar-one__inner">
            <div class="topbar-one__left">
              <ul class="topbar-one__info">
                <li class="topbar-one__info-item">
                  <span class="topbar-one__info-icon icon-location-1"></span>
                  <span class="topbar-one__info-text"> <?php echo $this->getSettingsData()->address; ?></span>

                </li>
                <li class="topbar-one__info-item">
                  <span class="topbar-one__info-icon icon-envelope"></span>
                  <a href="mailto:needhelp@company.com" class="topbar-one__info-text"> <?php echo $this->getSettingsData()->email; ?></a>
                </li>
              </ul>
              <ul class="topbar-one__info topbar-one__info--right">
                <li class="topbar-one__info-item">
                  <span class="topbar-one__info-icon icon-clock-1"></span>
                  <span class="topbar-one__info-text"> <?php echo $this->getSettingsData()->business_timings; ?></span>
                </li>
              </ul>
            </div>
            <div class="topbar-one__right">
              <ul class="topbar-one__social">
                <li class="topbar-one__social-item">
                  <a href="<?php echo $settingsData->facebook_link;?>" target="_blank" class="topbar-one__social-link">
                    <img src="<?php echo THEMEURL; ?>assets/images/fb.png" alt=""/>
                  </a>
                </li>
                <li class="topbar-one__social-item">
                  <a href="<?php echo $settingsData->twitter_link;?>" target="_blank" class="topbar-one__social-link">
                    <img src="<?php echo THEMEURL; ?>assets/images/tw.png" alt=""/>
                  </a>
                </li>
                <li class="topbar-one__social-item">
                  <a href="<?php echo $settingsData->instagram_link;?>" target="_blank" class="topbar-one__social-link">
                    <img src="<?php echo THEMEURL; ?>assets/images/insta.png" alt=""/>
                  </a>
                </li>
                <li class="topbar-one__social-item">
                  <a href="<?php echo $settingsData->youtube_link;?>" target="_blank" class="topbar-one__social-link">
                    <img src="<?php echo THEMEURL; ?>assets/images/yt.png" alt=""/>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <header class="main-header">
        <div class="container">
          <div class="main-header__inner">
            <div class="main-header__left">
              <div class="main-header__logo">
                <a href="<?php echo SITEURL;?>">
                  <img src="<?php echo UPLOADURL.'settings/'.$settingsData->logo; ?>" alt="Travel Bunny" width="246">
                </a>
              </div>
              <nav class="main-header__nav main-menu">
                <ul class="main-menu__list">
                  <?php  
                    echo $this->getMenuDetails();                     
                  ?> 
                </ul>
              </nav>
            </div>
            <div class="main-header__right">
              <div class="mobile-nav__btn mobile-nav__toggler">
                <span></span>
                <span></span>
                <span></span>
              </div>
              <a href="<?php echo SITEURL;?>contact" class="main-header__booking-btn travel-btn travel-btn--white-two header_book_now">
                <span>Contact Us</span>
              </a>
              <div class="main-header__right-right">
                <div class="main-header__phone">
                  <div class="main-header__phone-icon">
                    <span class="icon-phone-1"></span>
                  </div>
                  <div class="main-header__phone-text">
                    <p class="main-header__phone-title">Call Anytime</p>
                    <h4 class="main-header__phone-number">
                      <a href="tel:18003099936"><?php echo $settingsData->toll_free_no;?></a>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
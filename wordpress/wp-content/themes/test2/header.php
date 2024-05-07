<html class="no-js" lang="en">
    <!-- Mirrored from raistheme.com/html/hostgem/hostgem/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Jan 2021 15:44:26 GMT -->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body>
        
        <!-- header-area -->
        <header id="header-sticky" class="transparent-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="logo">
                        
                            <a href="index.html"> <img src="<?php echo get_theme_file_uri('assets/img/logo/logo.png'); ?>" alt="Logo"> </a>
                        </div>
                    </div>
                    <div class="col-lg-8 order-12 order-lg-0">
                        <div class="menu-area">
                            <div class="main-menu text-right">
                                <nav id="mobile-menu">
                                    <?php 
                                        wp_nav_menu(array(
                                            'theme_location'=> 'primary_menu',
                                            
                                        ));
                                    ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-5">
                        <div class="menu-icon">
                            <a href="#" data-toggle="modal" data-target="#search-modal"><i class="fas fa-search"></i></a>
                            <a href="#" class="user"><i class="far fa-user"></i></a>
                            <!-- Modal Search -->
                            <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <?php get_search_form(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header-area-end -->
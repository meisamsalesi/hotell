 <!-- main-area -->
 <?php 
        get_header();
        ?>
 <main>
            <!-- breadcrumb-area -->
            <section class="breadcrumb-area d-flex align-items-center breadcrumb-bg" data-background="<?php echo get_theme_file_uri ('/assets/img/bg/breadcrumb_bg.png') ;?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="breadcrumb-wrap">
                                <h2><?php the_title()?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb-area-end -->
            <!-- news-details -->
            <section class="news-details news-details-p pt-150 pb-150">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                        <?php
                            if ( have_posts() ) {
                                while ( have_posts() ) {
                                    the_post(); 
                                    ?>
                                    <div class="blog-wrapper mb-80">
                             
                                <div class="blog-thumb mb-35">
                                    <img src="<?php echo get_the_post_thumbnail_url() ;?>" alt="">
                                </div>
                                <div class="post-meta">
                                    <ul>
                                        <li>
                                            <a href="#"><?php the_author(); ?></a>
                                        </li>
                                        <li><?php the_time(); ?></li>
                                    </ul>
                                </div>
                                <div class="inner-blog-content">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <p><?php the_content(); ?></p>
                                    <a href="<?php echo site_url('/وبلاگ'); ?>" class="btn">بازگشت به صفحه</a>
                                </div>
                            </div>
                            <?php
                                } // end while
                            } // end if
                        ?>
                            

                            <div class="pagination-wrap">
                                <?php echo paginate_links();?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                        <?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
	                            <ul id="sidebar">
		                            <?php dynamic_sidebar('sidebar-1'); ?>
	                            </ul>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- news-details-end -->
        </main>
        <!-- main-area-end -->
        <?php 
        get_footer();
        ?>
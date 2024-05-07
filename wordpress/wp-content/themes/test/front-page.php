<?php 
get_header();
$top_title = fw_get_db_settings_option('top_title');
$value = fw_get_db_customizer_option('option_1');
?>

 <!-- echo get_theme_file_uri('/assets/img/slider/slider_bg03'); -->

<!-- main-area -->
<main>
            <!-- slider-area -->
            <section class="slider-area fix d-flex align-items-center slider-bg t-slider-bg" data-background="<?php echo get_theme_file_uri('/assets/img/slider/slider_bg03.png');?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="slider-content t-slider-content">
                                <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s"><?php echo $top_title?></h2>
                                <p class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s"><?php echo $value; ?></p>
                                <div class="slider-btn t-slider-btn">
                                    <a href="#" class="btn red wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".6s">همین حالا شروع کنید</a>
                                    <a href="#" class="btn purple-btn wow fadeInRight" data-wow-duration="1s" data-wow-delay=".6s">بیشتر بخوانید</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- slider-area-end -->
            <!-- features-area -->
            <section class="features-area gray-bg pt-120 pb-85">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="ts-features mb-30">
                                <div class="features-icon wow zoomIn" data-wow-duration="1s">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/t_features_icon01.png');?>" alt="icon">
                                </div>
                                <div class="features-content fix">
                                    <h5>بالاترین سرعت در بین شرکت های رقیب هاستینگ</h5>
                                    <p>لورم  ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از  طراحان گرافیک است   چاپگرها و متون بلکه روزنامه و مجله در ستون و  سطرآنچنان که لازم است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="ts-features mb-30">
                                <div class="features-icon wow zoomIn" data-wow-duration="1s">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/t_features_icon02.png');?>" alt="icon">
                                </div>
                                <div class="features-content fix">
                                    <h5>کنترل پنل سی پنل که بهترین کمنترل پنل است</h5>
                                    <p>لورم  ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از  طراحان گرافیک است   چاپگرها و متون بلکه روزنامه و مجله در ستون و  سطرآنچنان که لازم است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="ts-features mb-30">
                                <div class="features-icon wow zoomIn" data-wow-duration="1s">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/t_features_icon03.png');?>" alt="icon">
                                </div>
                                <div class="features-content fix">
                                    <h5>آپتایم 100 درصدی</h5>
                                    <p>لورم  ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از  طراحان گرافیک است   چاپگرها و متون بلکه روزنامه و مجله در ستون و  سطرآنچنان که لازم است</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- features-area-end -->
            <!-- hosting-plan -->
            <section class="hosting-plan-area hosting-md-pb pt-115 pb-125">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section-title text-center pricing-title mb-110">
                                <h2>بهترین پلن های هاستینگ</h2>
                                <p>لورم  ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ   و با استفاده از  طراحان گرافیک است   چاپگرها و متون بلکه روزنامه و مجله در ستون و  سطرآنچنان که لازم است</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="single-hplan third-hplan mb-30">
                                <div class="hplan-head text-center">
                                    <span>پلن سوم</span>
                                    <h3>1تومن /ماهانه</h3>
                                </div>
                                <div class="third-hplan-btn mb-35 text-center">
                                    <a href="#" class="btn purple-btn">خرید</a>
                                </div>
                                <div class="hplan-third-list">
                                    <ul>
                                        <li>
                                            <i class="fas fa-check"></i>1سایت
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>ایمیل اکانت
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>100گیگ پهنای باند
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>سی پی یو اختصاصی
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-hplan third-hplan active mb-30">
                                <span class="popular-tag">بهترین&nbsp; پلن</span>
                                <div class="hplan-head text-center">
                                    <span>پلن دوم</span>
                                    <h3>3تومن/ماهانه</h3>
                                </div>
                                <div class="third-hplan-btn mb-35 text-center">
                                    <a href="#" class="btn red">خرید</a>
                                </div>
                                <div class="hplan-third-list">
                                    <ul>
                                        <li>
                                            <i class="fas fa-check"></i>1سایت
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>ایمیل اکانت
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>100گیگ پهنای باند
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>سی پی یو اختصاصی
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-hplan third-hplan mb-30">
                                <div class="hplan-head text-center">
                                    <span>پلن اول</span>
                                    <h3>5تومن /ماهانه</h3>
                                </div>
                                <div class="third-hplan-btn mb-35 text-center">
                                    <a href="#" class="btn purple-btn">خرید</a>
                                </div>
                                <div class="hplan-third-list">
                                    <ul>
                                        <li>
                                            <i class="fas fa-check"></i>1سایت
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>ایمیل اکانت
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>100گیگ پهنای باند
                                        </li>
                                        <li>
                                            <i class="fas fa-check"></i>سی پی یو اختصاصی
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- hosting-plan-end -->
            <!-- search-area -->
            <section class=" search-area d-search-bg pt-115 pb-110" data-background="<?php echo get_theme_file_uri ('/assets/img/bg/d_search_bg.jpg') ;?>">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section-title white-title search-title text-center mb-40">
                                <h2>جستجو دامنه</h2>
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10">
                            <div class="domain-search">
                                <form action="#" class="p-relative">
                                    <input type="text" placeholder="دامنه خود را وارد کنید">
                                    <button class="btn ds-btn red">جستجو&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="domain-list s-domain-list mb-30 text-center">
                                <ul>
                                    <li>
                                        <i class="far fa-check-circle"></i>&nbsp;کام&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    </li>
                                    <li>
                                        <i class="far fa-check-circle"></i>نت&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    </li>
                                    <li>
                                        <i class="far fa-check-circle"></i>او&nbsp; آر جی&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    </li>
                                    <li>
                                        <i class="far fa-check-circle"></i>بیز&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    </li>
                                </ul>
                            </div>
                            <div class="payment-method">
                                <ul>
                                    <li>
                                    
                                        <img src="<?php echo get_theme_file_uri('/assets/img/images/payment_method01.png');?>" alt="img">
                                    </li>
                                    <li>
                                        <img src="<?php echo get_theme_file_uri('/assets/img/images/payment_method02.png');?>" alt="img">
                                    </li>
                                    <li>
                                        <img src="<?php echo get_theme_file_uri('/assets/img/images/payment_method03.png');?>" alt="img">
                                    </li>
                                    <li>
                                        <img src="<?php echo get_theme_file_uri('/assets/img/images/payment_method04.png');?>" alt="img">
                                    </li>
                                    <li>
                                        <img src="<?php echo get_theme_file_uri('/assets/img/images/payment_method05.png');?>" alt="img">
                                    </li>
                                    <li>
                                        <img src="<?php echo get_theme_file_uri('/assets/img/images/payment_method06.png');?>" alt="img">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- search-area-end -->
            <!-- unlimited-features -->
            <section class="unlimited-features gray-bg pt-115 pb-60">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section-title text-center mb-75">
                                <h2>دارای ویژگی های نامحدود</h2>
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک استلورم متن&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="single-ufeatures mb-55">
                                <div class="ufeatures-icon">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/suf_icon01.png');?>" alt="icon">
                                </div>
                                <div class="ufeatures-content fix">
                                    <h5>هارد پرسرعت</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-ufeatures mb-55">
                                <div class="ufeatures-icon">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/suf_icon02.png');?>" alt="icon">
                                </div>
                                <div class="ufeatures-content fix">
                                    <h5>هارد بک آپ</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-ufeatures mb-55">
                                <div class="ufeatures-icon">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/suf_icon03.png');?>" alt="icon">
                                </div>
                                <div class="ufeatures-content fix">
                                    <h5>امنیت رایگان</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-ufeatures mb-55">
                                <div class="ufeatures-icon">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/suf_icon04.png');?>" alt="icon">
                                </div>
                                <div class="ufeatures-content fix">
                                    <h5>کلود&nbsp; ابری</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-ufeatures mb-55">
                                <div class="ufeatures-icon">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/suf_icon05.png');?>" alt="icon">
                                </div>
                                <div class="ufeatures-content fix">
                                    <h5>پشتیبانی همیشگی</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-ufeatures mb-55">
                                <div class="ufeatures-icon">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/icon/suf_icon06.png');?>" alt="icon">
                                </div>
                                <div class="ufeatures-content fix">
                                    <h5>نصب آسان</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- unlimited-features-end -->
            <!-- testimonial-area -->
            <section class="s-testimonial-area pt-115 pb-120">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section-title text-center mb-75">
                                <h2>مشتریان ما در رابطه ما چه میگویند؟</h2>
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است لورم ساز</p>
                            </div>
                        </div>
                    </div>
                    <div class="row s-testimonial-active">
                    <?php
                        $testimonial_query = new WP_Query(array(
                            'post_type' => 'testination',
                            'posts_per_page' => 2,   
                        ));



                        if ($testimonial_query -> have_posts() ) :
                            while ( $testimonial_query -> have_posts() ) :$testimonial_query ->  the_post();
                            ?>
                            <div class="col-xl-6">
                            <div class="s-single-testimonial third-testimonial text-center">
                                <div class="s-testimonial-avatar mb-15">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/images/testimonial_img01.png');?>" alt="img">
                                </div>
                                <div class="s-testimonial-content p-relative mb-30">
                                    <p><?php the_content(); ?></p>
                                    <span>از طرف شرکت: <?php the_field('از_شرکت'); ?></span>
                                    <div class="s-testi-avatar-info">
                                    <p><?php the_title(); ?></p>
                                    
                                </div>
                                </div>
                                
                            </div>
                        </div><?php 
                            endwhile;
                        endif; wp_reset_postdata();
                        ?>
                        
                    </div>
                </div>
            </section>
            <!-- testimonial-area-end -->
            <!-- brand-area -->
            <div class="brand-area pb-120">
                <div class="container">
                    <div class="row brand-active">
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="<?php echo get_theme_file_uri('/assets/img/brand/brand_logo04.png');?>" alt="brand">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="<?php echo get_theme_file_uri('/assets/img/brand/brand_logo02.png');?>" alt="brand">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="<?php echo get_theme_file_uri('/assets/img/brand/brand_logo03.png');?>" alt="brand">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="<?php echo get_theme_file_uri('/assets/img/brand/brand_logo01.png');?>" alt="brand">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="<?php echo get_theme_file_uri('/assets/img/brand/brand_logo05.png');?>" alt="brand">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="<?php echo get_theme_file_uri('/assets/img/brand/brand_logo01.png');?>" alt="brand">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- brand-area-end -->
            <!-- money-back-area -->
            <section class="moneyback-area primary-bg pt-115 pb-120">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 text-center">
                            <div class="moneyback-title mb-45">
                                <h3>گارانتی بازگشت وجه</h3>
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ  و با استفاده از طراحان گرافیک است</p>
                            </div>
                            <div class="moneyback-wrap">
                                <div class="moneyback-img mb-45">
                                    <img src="<?php echo get_theme_file_uri('/assets/img/images/money-back.png');?>" class="wow zoomIn" data-wow-duration="1s" alt="img">
                                </div>
                                <div class="moneyback-btn">
                                    <a href="#" class="btn red">همین حالا شروع کنید</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- money-back-area-end -->
        </main>
        <!-- main-area-end -->

        <?php 
get_footer();
?>

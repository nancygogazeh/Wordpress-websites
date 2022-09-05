<?php
/**
 * Template part for displaying front page section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Construction Light
 */

/**
 * Hook -  construction_light_action_about
 *
 * @hooked construction_light_action_about - 35
*/

/**
 * About Us Section.
*/
if (! function_exists( 'construction_light_about2' ) ):

    function construction_light_about2(){ 

        $aboutus_options = get_theme_mod('construction_light_aboutus_service_section','enable');
        
        if( !empty( $aboutus_options ) && $aboutus_options == 'enable' ){
        ?>
        <section id="cl_aboutus" class="about_us_front">
            <div class="container">
                <div class="row">
                    <?php
                        $aboutus = get_theme_mod('construction_light_aboutus');

                        if (!empty( $aboutus ) ):

                        $aboutus_args = array(
                            'posts_per_page' => 1,
                            'post_type' => 'page',
                            'page_id' => $aboutus,
                            'post_status' => 'publish',
                        );

                        $aboutus_query = new WP_Query($aboutus_args);
                        $alignment = get_theme_mod('construction_light_aboutus_alignment', 'text-left');
                        if ( $aboutus_query->have_posts() ) : while ( $aboutus_query->have_posts() ) : $aboutus_query->the_post();
                    
                        $about_image = get_theme_mod('construction_light_aboutus_image2');
                        
                        $style = get_theme_mod('construction_light_aboutus_style', 'left');
                        $about_col = '';
                        if( !empty( $about_image ) ){
                            $about_col = 7;
                        }else{
                            $about_col = 12;
                        }
                        if($style == 'bottom'){
                            $about_col = 12;
                        }

                        
                        if (!empty($about_image) && $style == 'left'): ?>
                            <div class="col-lg-5 col-md-5 col-sm-12 <?php echo esc_attr($alignment); ?>">
                                <img src="<?php echo esc_url( $about_image ); ?>"/>
                            </div>
                        <?php endif; ?>

                        <div class="col-lg-<?php echo intval( $about_col ); ?> col-md-<?php echo intval( $about_col ); ?> col-sm-12 <?php echo esc_attr($alignment); ?>">

                            <h3><?php the_title(); ?></h3>
                            
                            <?php
                                $aboutus_info = get_theme_mod('construction_light_aboutus_content', 'excerpt');
                                if ( !empty( $aboutus_info ) && $aboutus_info == 'excerpt') {

                                    the_excerpt();

                                } else {

                                    the_content();
                                } 
                            ?>

                            <?php 
                                $about_email  = get_theme_mod('construction_light_aboutus_email_address');
                                $about_phone  = get_theme_mod('construction_light_aboutus_phone_number');

                                if( !empty( $about_email ) || !empty( $about_phone ) ){
                            ?>
                                <div class="address-info">
                                    <ul>
                                        <?php if( !empty( $about_email ) ){ ?>

                                            <li><?php esc_html_e('Email Us :','spark-building-construction'); ?>
                                                <a href="mailto:<?php echo esc_attr( antispambot( $about_email ) ); ?>" class="about-us-email">
                                                    <?php echo esc_html( antispambot( $about_email ) ); ?>
                                                </a>
                                            </li>

                                        <?php } if( !empty( $about_phone ) ){ ?>

                                            <li><?php esc_html_e('Contact Us :','spark-building-construction'); ?>
                                                <a href="tel:<?php echo esc_attr( $about_phone ); ?>" class="about-us-contact">
                                                    <?php echo esc_html( $about_phone ); ?>
                                                </a>
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>

                            <?php
                                $aboutus_info = get_theme_mod('construction_light_aboutus_content', 'excerpt');
                                
                                if( function_exists( 'pll_register_string' ) ){ 

                                    $about_button = pll__( get_theme_mod( 'construction_light_aboutus_button_text','Read More' ) ); 

                                }else{ 

                                    $about_button = get_theme_mod( 'construction_light_aboutus_button_text','Read More' );
                                }

                                if ( !empty( $aboutus_info ) && $aboutus_info == 'excerpt') {
                            ?>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php echo esc_html( $about_button ); ?><i class="fas fa-arrow-right"></i>
                                </a>

                            <?php } 

                                if (get_theme_mod('construction_light_aboutus_progressbar', true) == true):

                                $about_progressbar = get_theme_mod('construction_light_progressbar');

                                if (!empty( $about_progressbar ) ):
                            ?>
                                <div class="achivement-items">
                                    <ul>
                                        <?php
                                            $progressbars = json_decode($about_progressbar);
                                            foreach ($progressbars as $progressbar):
                                        ?>
                                            <li>
                                                <div class="timer achivement"><?php echo intval( $progressbar->progressbar_number ); ?></div>
                                                <span class="medium"><?php echo esc_html( $progressbar->progressbar_title ); ?></span>
                                            </li>
                                        <?php endforeach; endif; ?>
                                    </ul>
                            <?php endif; ?>

                            <?php
                                /** about us accoridon faq */
                                $enable = get_theme_mod('construction_light_aboutus_show_faq', false);
                                if( $enable ):
                                    $faq_content = get_theme_mod('construction_light_aboutus_faq');
                                    if( $faq_content ):
                                ?>
                                    <div class="ed-about-list" id="edu-accordion">
                                        <?php
                                        $faqs = json_decode( $faq_content );

                                        foreach( $faqs as $content ): 
                                            $post = get_post( $content->page );
                                            if(is_wp_error($post)) continue;

                                        ?>
                                            <h3 class="cl-bg-primary"><?php echo esc_html($post->post_title) ?></h3>
                                            <div><?php echo apply_filters( 'the_content', $post->post_content ); ?></div>
                                        <?php endforeach; ?>

                                    </div>
                            <?php endif; endif; ?>

                            <?php 
                                $justify_class = str_replace("text","justify-content", $alignment); 
                                $justify_class = str_replace("right","end", $justify_class);
                                
                                $profile_name = get_theme_mod('construction_light_aboutus_profile_name');
                                $signature = get_theme_mod('construction_light_aboutus_signature');
                                if( $profile_name || $signature ):
                            ?>
                            <div class="numbers-profile d-flex align-items-center flex-wrap mt-4 <?php echo esc_attr($justify_class); ?>">
                                <?php if($about_image): ?>
                                <div class="profile-img bg-cover" style="background-image: url('<?php echo esc_url($about_image); ?>')"></div>
                                <?php endif; ?>
                                
                                <?php if( $profile_name = get_theme_mod('construction_light_aboutus_profile_name') ): ?>
                                <div class="profile-info">
                                    <h3 class="name mb-0"><?php echo esc_html($profile_name ); ?></h3>
                                    <?php if($profile_role = get_theme_mod('construction_light_aboutus_profile_role') ): ?>
                                    <span class="role"><?php echo esc_html( $profile_role ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php
                                    if( $signature ): ?>
                                        <div class="signature align-self-end ml-3">
                                            <img src="<?php echo esc_url($signature); ?>" alt="signature">
                                        </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                        </div>


                        <?php if (!empty($about_image) && $style == 'right'): ?>
                            <div class="col-lg-5 col-md-5 col-sm-12 <?php echo esc_attr($alignment); ?>">
                                <img src="<?php echo esc_url( $about_image ); ?>"/>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($about_image) && $style == 'bottom'): ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 <?php echo esc_attr($alignment); ?>">
                                <img src="<?php echo esc_url( $about_image ); ?>"/>
                            </div>
                        <?php endif; ?>

                    <?php endwhile; endif; endif; ?>
                </div>
            </div>
        </section>
    <?php } }
endif;
add_action('construction_light_action_about2', 'construction_light_about2', 36);

add_action('construction_light_action_about_layout_3', 'construction_light_action_about_layout_3', 36);

if(!function_exists('construction_light_action_about_layout_3')):
    function construction_light_action_about_layout_3(){
        $aboutus_options = get_theme_mod('construction_light_aboutus_service_section','enable');
        if( !empty( $aboutus_options ) && $aboutus_options == 'enable' ): 
            $alignment = get_theme_mod('construction_light_aboutus_alignment', 'text-left');
            ?>
            <section id="cl_aboutus" class="about_us_front">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-5 col-sm-12 <?php echo esc_attr($alignment); ?>">
                            <?php
                                $aboutus = get_theme_mod('construction_light_aboutus');
                                $post = get_post( $aboutus );
                                if ($post): ?>

                                    <h3><?php echo esc_html( $post->post_title ); ?></h3>
                            
                                    <?php
                                        $aboutus_info = get_theme_mod('construction_light_aboutus_content', 'excerpt');
                                        if ( !empty( $aboutus_info ) && $aboutus_info == 'excerpt') {
                                            echo wp_trim_words( $post->post_content );
                                        } else {
                                            echo apply_filters( 'the_content', $post->post_content );
                                        }
                                endif;
                            ?>

                            <?php 
                                $about_email  = get_theme_mod('construction_light_aboutus_email_address');
                                $about_phone  = get_theme_mod('construction_light_aboutus_phone_number');

                                if( !empty( $about_email ) || !empty( $about_phone ) ){
                            ?>
                                <div class="address-info">
                                    <ul>
                                        <?php if( !empty( $about_email ) ){ ?>

                                            <li><?php esc_html_e('Email Us :','spark-building-construction'); ?>
                                                <a href="mailto:<?php echo esc_attr( antispambot( $about_email ) ); ?>" class="about-us-email">
                                                    <?php echo esc_html( antispambot( $about_email ) ); ?>
                                                </a>
                                            </li>

                                        <?php } if( !empty( $about_phone ) ){ ?>

                                            <li><?php esc_html_e('Contact Us :','spark-building-construction'); ?>
                                                <a href="tel:<?php echo esc_attr( $about_phone ); ?>" class="about-us-contact">
                                                    <?php echo esc_html( $about_phone ); ?>
                                                </a>
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>

                            <?php
                                /** about us accoridon faq */
                                $enable = get_theme_mod('construction_light_aboutus_show_faq', false);
                                if( $enable ):
                                    $faq_content = get_theme_mod('construction_light_aboutus_faq');
                                    if( $faq_content ):
                                ?>
                                    <div class="ed-about-list" id="edu-accordion">
                                        <?php
                                        $faqs = json_decode( $faq_content );

                                        foreach( $faqs as $content ): 
                                            $post = get_post( $content->page );
                                            if(is_wp_error($post)) continue;

                                        ?>
                                            <h3 class="cl-bg-primary"><?php echo esc_html($post->post_title) ?></h3>
                                            <div><?php echo apply_filters( 'the_content', $post->post_content ); ?></div>
                                        <?php endforeach; ?>

                                    </div>
                            <?php endif; endif; ?>


                            <?php
                                $about_image = get_theme_mod('construction_light_aboutus_image2');
                                $justify_class = str_replace("text","justify-content", $alignment); 
                                $justify_class = str_replace("right","end", $justify_class);
                            
                            ?>
                            <div class="numbers-profile mt-3 d-flex align-items-center flex-wrap <?php echo esc_attr($justify_class); ?>">
                                <?php if($about_image): ?>
                                <div class="profile-img bg-cover" style="background-image: url('<?php echo esc_url($about_image); ?>')"></div>
                                <?php endif; ?>
                                
                                <?php if( $profile_name = get_theme_mod('construction_light_aboutus_profile_name') ): ?>
                                <div class="profile-info">
                                    <h3 class="name mb-0"><?php echo esc_html($profile_name ); ?></h3>
                                    <?php if($profile_role = get_theme_mod('construction_light_aboutus_profile_role') ): ?>
                                    <span class="role"><?php echo esc_html( $profile_role ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php
                                    $signature = get_theme_mod('construction_light_aboutus_signature');
                                    if( $signature ): ?>
                                        <div class="signature align-self-end ml-3">
                                            <img src="<?php echo esc_url($signature); ?>" alt="signature">
                                        </div>
                                <?php endif; ?>
                            </div>
                    
                        </div>
                        <?php 
                            $about_progressbar = get_theme_mod('construction_light_progressbar');
                            if( $about_progressbar ): ?>

                                <div class="col-lg-7 col-md-7 col-sm-12 right-content <?php echo esc_attr($alignment); ?> ">
                                    <div class="progressbar-wrapper">
                                        <?php 
                                            $index = 0;
                                            $progressbars = json_decode($about_progressbar);
                                            $class_list = array('progress-large', 'progress-medium', 'progress-third');
                                            if( count($progressbars) > 3) $class_list = array('sp-position-relative progress-large', 'sp-position-relative progress-medium', 'sp-position-relative progress-third');
                                            foreach ($progressbars as $progressbar): ?>
                                                <div class="sp-progress <?php if(isset($class_list[$index]) ) echo $class_list[$index]; ?>">
                                                    <svg class="radial-progress" data-percentage="<?php echo intval( $progressbar->progressbar_number ); ?>" data-color="<?php echo esc_attr( get_theme_mod('construction_light_primary_color', apply_filters('construction_light_primary_color', '#fc5e16') ) ); ?>" viewBox="0 0 80 80">
                                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                                        <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">
                                                            <tspan x="50%" y="45%"><?php echo intval( $progressbar->progressbar_number ); ?>%</tspan>
                                                            <tspan x="50%" y="60%"><?php echo esc_html( $progressbar->progressbar_title ); ?></tspan>
                                                        </text>
                                                        
                                                    </svg>
                                                </div>
                                        <?php $index ++; endforeach; ?>
                                        
                                    </div>

                                </div>
                            <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php
        endif;

    }
endif;

$layout = get_theme_mod('construction_light_aboutus_layout', 'layout-two');
if( $layout == 'layout-two'):
    do_action('construction_light_action_about_layout_3');
else:
    do_action('construction_light_action_about2');
endif;
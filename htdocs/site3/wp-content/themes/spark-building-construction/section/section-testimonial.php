<?php
/**
 * Template part for displaying front page section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Construction Light
 */

/**
 * Hook -  construction_light_action_testimonial
 *
 * @hooked sparkle_construction_building_testimonial - 70
 */

/**
 *  Testimonial Section.
*/
if (! function_exists( 'sparkle_construction_building_testimonial' ) ):
    function sparkle_construction_building_testimonial(){

        $title = get_theme_mod('construction_light_testimonial_title');
        $sub_title = get_theme_mod('construction_light_testimonial_sub_title');

        $testimonial_bg = get_theme_mod('construction_light_testimonials_image');
        $testimonial_page = get_theme_mod('construction_light_testimonials'); 

        $testimonial_options = get_theme_mod('construction_light_testimonial_options','enable');
        if( !empty( $testimonial_options ) && $testimonial_options == 'enable' ){
        ?>
        <section id="cl_testimonial" class="cons_light_testimonial cons-testimonial-layout-left" style="background-image:url(<?php echo esc_url( $testimonial_bg ); ?>);">
            <div class="container">

                <div class="row h-100 align-items-center">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <?php construction_light_section_title( $title, $sub_title ); ?>

                        <div class="owl-nav text-left mt-4">
                            <button type="button" role="presentation" class="owl-prev mr-2"><i class="fas fa-angle-left"></i></button>
                            <button type="button" role="presentation" class="owl-next"><i class="fas fa-angle-right"></i></button>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="owl-carousel owl-theme testimonial-slider">
                            <?php
                                if (!empty($testimonial_page)):

                                $testimonial_pages = json_decode($testimonial_page);

                                foreach ($testimonial_pages as $testimonial_page):

                                $page_id = $testimonial_page->testimonial_page;

                                if (!empty($page_id)):

                                $testimonial_query = new WP_Query('page_id=' . $page_id);

                                if ( $testimonial_query->have_posts() ): while ($testimonial_query->have_posts()): $testimonial_query->the_post();
                            ?>
                                <div class="item row">
                                    <div class="blank-space"></div>
                                    <div class="wrapper">
                                    <div class="col-lg-12 col-md-12 col-sm-12">

                                        <div class="client-img">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </div>

                                        <?php the_excerpt(); ?>

                                        <div class="client-text">
                                            <h3>
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <h4><?php echo esc_html( $testimonial_page->designation ); ?></h4>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                            <?php endwhile; endif; endif; endforeach; endif; ?>

                        </div>
                    </div> 
                </div>
            </div>
        </section>
    <?php } }
endif;
add_action('construction_light_action_testimonial2', 'sparkle_construction_building_testimonial', 70);
do_action( 'construction_light_action_testimonial2' );
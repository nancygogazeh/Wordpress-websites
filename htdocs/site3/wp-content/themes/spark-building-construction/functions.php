<?php
/**
 * Describe child theme functions
 *
 * @package Construction Light
 * @subpackage Spark Building Construction
 * 
 */

 if ( ! function_exists( 'spark_building_construction_setup' ) ) :

    function spark_building_construction_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Spark Building Construction, use a find and replace
		* to change 'spark-building-construction' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'spark-building-construction', get_template_directory() . '/languages' );

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
        
        $spark_building_construction_theme_info = wp_get_theme();
        $GLOBALS['spark_building_construction_version'] = $spark_building_construction_theme_info->get( 'Version' );

		add_theme_support( "title-tag" );
		add_theme_support( 'automatic-feed-links' );
    }
endif;
add_action( 'after_setup_theme', 'spark_building_construction_setup' );


/**
 * Enqueue child theme styles and scripts
*/
function spark_building_construction_scripts() {
    
    global $spark_building_construction_version;

	wp_dequeue_style( 'construction-light-fonts');
	wp_dequeue_style( 'construction-light-style' );
    
    wp_enqueue_style( 'spark-building-construction-parent-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'style.css', array(), esc_attr( $spark_building_construction_version ) );
    
	wp_enqueue_style( 'spark-building-construction-fonts', spark_building_construction_fonts_url(), array(), null );

    wp_enqueue_style( 'spark-building-construction-responsive', get_template_directory_uri(). '/assets/css/responsive.css');
    
    wp_enqueue_style( 'spark-building-construction-style', get_stylesheet_uri(), esc_attr( $spark_building_construction_version ) );

    wp_enqueue_script('spark-building-construction', get_stylesheet_directory_uri() . '/js/spark-building-construction.js', array('jquery','masonry'), esc_attr( $spark_building_construction_version ), true);
	if ( is_rtl() ) {
		wp_enqueue_style( 'construction-light-rtl', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'rtl.css', array(), esc_attr( $spark_building_construction_version ) );	
	}

}
add_action( 'wp_enqueue_scripts', 'spark_building_construction_scripts', 20 );

function spark_building_construction_css_strip_whitespace($css) {
    $replace = array(
        "#/\*.*?\*/#s" => "", // Strip C style comments.
        "#\s\s+#" => " ", // Strip excess whitespace.
    );
    $search = array_keys($replace);
    $css = preg_replace($search, $replace, $css);

    $replace = array(
        ": " => ":",
        "; " => ";",
        " {" => "{",
        " }" => "}",
        ", " => ",",
        "{ " => "{",
        ";}" => "}", // Strip optional semicolons.
        ",\n" => ",", // Don't wrap multiple selectors.
        "\n}" => "}", // Don't wrap closing braces.
        "} " => "}\n", // Put each rule on it's own line.
    );
    $search = array_keys($replace);
    $css = str_replace($search, $replace, $css);

    return trim($css);
}

/**
 * Dynamic Style
 */
add_filter( 'construction-light-dynamic-css', 'spark_building_construction_dymanic_styles', 100 );
function spark_building_construction_dymanic_styles($dynamic_css) {
    
    $services_bg = get_theme_mod('construction_light_service_image');
 
    $primar_color = esc_html( get_theme_mod('construction_light_primary_color', '#fc5e16') );
	if($primar_color){
		
		$dynamic_css .= "
		.site-header:not(.headertwo) .nav-classic .site-branding h1 a,
		.cons_light_feature.layout_four .feature-list .icon-box{
			color: {$primar_color};
		}
		.about_us_front .achivement-items ul li{
			border-color: {$primar_color};
		}
		.hl-border,
		.testimonial-slider .item:before,
		header.cons-agency .nav-classic{
			background-color: {$primar_color};
		}
		";
	}
	$header_text_color = get_header_textcolor();
	if( $header_text_color == '000000'){
		$header_text_color = 'ffffff';
	}
	$header_text_color = esc_html( $header_text_color );
	if( $header_text_color ){
		$dynamic_css .="
		.site-header:not(.headertwo) .nav-classic .site-branding h1 a{
			color: #{$header_text_color};
		}";
	}


	$construction_light_aboutus_text_color = esc_html ( get_theme_mod('construction_light_aboutus_text_color') );
	if($construction_light_aboutus_text_color) {
		$dynamic_css .="
			svg.radial-progress text{ fill: {$construction_light_aboutus_text_color};
		";
	}
	
	wp_add_inline_style( 'spark-building-construction-style', spark_building_construction_css_strip_whitespace($dynamic_css) );

}
/** modify customizer */
if ( ! function_exists( 'spark_building_construction_child_options' ) ) {

    function spark_building_construction_child_options( $wp_customize ) {
		$wp_customize->remove_control('construction_light_quick_info_hide_mobile');
		
		$wp_customize->get_control('construction_light_service_layout')->choices = array(
			'layout_one'  => esc_html__('Layout One', 'spark-building-construction'),
			'layout_two'  =>esc_html__('Layout Two', 'spark-building-construction'),
			'layout_three'  =>esc_html__('Layout Three', 'spark-building-construction'),
			'layout_four'  =>esc_html__('Layout Four', 'spark-building-construction'),
		);
		
		$wp_customize->get_control('construction_light_team_layout')->choices = array(
			'layout_one' => esc_html__('Layout One', 'spark-building-construction'),
			'layout_two' => esc_html__('Layout Two', 'spark-building-construction'),
			'layout_three' => esc_html__('Layout Three', 'spark-building-construction'),
		);

		$wp_customize->get_setting('construction_light_primary_color')->default = apply_filters('construction_light_primary_color', '#fc5e16');
		$wp_customize->get_setting('header_textcolor')->default = apply_filters('header_textcolor', '#ffff');
		
		/**
		 * About Us Section additional field
		 */
		$wp_customize->add_setting( 'construction_light_aboutus_layout', array(
			'sanitize_callback' => 'spark_building_construction_sanitize_select', 	 //done	
			'default' => 'layout-two'
			// 'transport' => 'postMessage'
		));
		$wp_customize->add_control('construction_light_aboutus_layout', array(
			'label'		=> esc_html__( 'Layout', 'spark-building-construction' ),
			'section'	=> 'construction_light_aboutus_section',
			'type'      => 'select',
			'choices' => array(
				'layout-one' => esc_html__('Layout One', 'spark-building-construction'),
				'layout-two' => esc_html__('Layout Two', 'spark-building-construction'),
			),
			'priority' => -1
		));

		$wp_customize->add_setting( 'construction_light_aboutus_profile_name', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
			// 'transport' => 'postMessage'
		));

		$wp_customize->add_control('construction_light_aboutus_profile_name', array(
			'label'		=> esc_html__( 'Profile Name', 'spark-building-construction' ),
			'section'	=> 'construction_light_aboutus_section',
			'type'      => 'text',
			'priority' => 10
		));
		
		$wp_customize->add_setting( 'construction_light_aboutus_profile_role', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
			// 'transport' => 'postMessage'
		));

		$wp_customize->add_control('construction_light_aboutus_profile_role', array(
			'label'		=> esc_html__( 'Designadtion', 'spark-building-construction' ),
			'section'	=> 'construction_light_aboutus_section',
			'type'      => 'text',
			'priority' => 10
		));
		$wp_customize->add_setting('construction_light_aboutus_signature', array(
			'transport' => 'postMessage',
			'priority' => 10,
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'construction_light_aboutus_signature', array(
			'label'	   => esc_html__('Signature Image','spark-building-construction'),
			'section'  => 'construction_light_aboutus_section',
		)));

		$wp_customize->add_control(new Construction_Light_Repeater_Control($wp_customize, 
			'construction_light_progressbar', 

			array(
			    'label' 	   => esc_html__('Achievement Awards Settings', 'spark-building-construction'),
			    'section' 	   => 'construction_light_aboutus_section',
			    'settings' 	   => 'construction_light_progressbar',
			    'cl_box_label' => esc_html__('Achievement Awards Settings', 'spark-building-construction'),
			    'cl_box_add_control' => esc_html__('Add New Awards', 'spark-building-construction'),
			    'active_callback' => 'construction_light_active_progressbar'
			),
		    array(
		        'progressbar_title' => array(
		            'type' => 'text',
		            'label' => esc_html__('Awards Title', 'spark-building-construction'),
		            'default' => ''
		        ),

		        'progressbar_number' => array(
		            'type' => 'number',
		            'label' => esc_html__('Awards Value(%) ', 'spark-building-construction'),
		            'default' => '',
					'min' => 1,
					'max' => 100
		        ),
		        
			)
		));



		/** contact section */
		$wp_customize->add_section('construction_light_contact_section', array(
			'title' => esc_html__('Contact Section', 'spark-building-construction'),
			'panel' => 'construction_light_frontpage_settings',
			'priority' => construction_light_get_section_position('construction_light_contact_section') or 100,
			'hiding_control' => 'construction_light_contact_section_disable'
		));

		//ENABLE/DISABLE SERVICE SECTION
		$wp_customize->add_setting('construction_light_contact_section_disable', array(
			'sanitize_callback' => 'spark_building_construction_sanitize_switch',
			'transport' => 'postMessage',
			'default' => 'disable'
		));

		$wp_customize->add_control(new Construction_Light_Switch_Control($wp_customize, 'construction_light_contact_section_disable', array(
			'section' => 'construction_light_contact_section',
			'label' => esc_html__('Enable Section ', 'spark-building-construction'),
			'switch_label' => array(
				'enable' => esc_html__('Yes', 'spark-building-construction'),
				'disable' => esc_html__('No', 'spark-building-construction'),
			),
			'class' => 'switch-section',
			'priority' => -1
		)));

		// Section Title.
		$wp_customize->add_setting( 'construction_light_contact_title', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
			'transport' => 'postMessage'
		));

		$wp_customize->add_control('construction_light_contact_title', array(
			'label'		=> esc_html__( 'Enter Section Title', 'spark-building-construction' ),
			'section'	=> 'construction_light_contact_section',
			'type'      => 'text'
		));

		//Section Sub Title.
		$wp_customize->add_setting( 'construction_light_contact_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field',			//done
			'transport' => 'postMessage'
		) );

		$wp_customize->add_control( 'construction_light_contact_sub_title', array(
			'label'    => esc_html__( 'Enter Section Sub Title', 'spark-building-construction' ),
			'section'  => 'construction_light_contact_section',
			'type'     => 'text',
		));

		$wp_customize->add_setting('construction_light_contact_quick_link', array(
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control(new ConstructionAgencyInfoText($wp_customize, 'construction_light_contact_quick_link', array(
			'label' => esc_html__('Contact Info', 'spark-building-construction'),
			'section' => 'construction_light_contact_section',
			'description' => sprintf(esc_html__('Add your %s here, content is comes from top header quick info', 'spark-building-construction'), '<a href="?autofocus[section]=construction_light_top_header" target="_blank">Contact Info</a>')
		)));

		$wp_customize->add_setting( 'construction_light_contact_shortcode', array(
			'sanitize_callback' => 'construction_light_sanitize_text', 	 //done	
			'transport' => 'postMessage'
		));

		$wp_customize->add_control('construction_light_contact_shortcode', array(
			'label'		=> esc_html__( 'Contact Form Shortcode', 'spark-building-construction' ),
			'section'	=> 'construction_light_contact_section',
			'type'      => 'text'
		));

		$wp_customize->add_setting( 'construction_light_contact_map', array(
			'sanitize_callback' => 'construction_light_sanitize_text', 	 //done	
			'transport' => 'postMessage'
		));

		$wp_customize->add_control('construction_light_contact_map', array(
			'label'		=> esc_html__( 'Enter Map Iframe', 'spark-building-construction' ),
			'section'	=> 'construction_light_contact_section',
			'type'      => 'textarea'
		));

		$wp_customize->selective_refresh->add_partial('construction_light_contact_title', array(
			'selector' => '#cl-contact-section .section-title',
			'container_inclusive' => true
		));

		$wp_customize->selective_refresh->add_partial('construction_light_contact_shortcode', array(
			'selector' => '#cl-contact-section .contact-and-map-section',
			'container_inclusive' => true
		));

		$wp_customize->selective_refresh->add_partial( 'construction_light_contact_refresh', array (
			'settings' => array( 
				'construction_light_contact_section_disable',
				'construction_light_contact_title',
				'construction_light_contact_sub_title',
				'construction_light_contact_shortcode',
				'construction_light_contact_map',
		
			),
			'selector' => '#cl-contact-section',
			'fallback_refresh' => false,
			'container_inclusive' => true,
			'render_callback' => function () {
				return get_template_part( 'section/section-contact' );
			}
		));


    }
}
add_action( 'customize_register' , 'spark_building_construction_child_options', 11 );

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
if( !function_exists('spark_building_construction_sanitize_select')){
	function spark_building_construction_sanitize_select( $input, $setting ) {
		
		// Ensure input is a slug.
		$input = sanitize_key( $input );
		
		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;
		
		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Switch Class sanitization callback example.
 *
 * - Sanitization: switch
 * - Control: switch (manual class)
 * 
 * Sanitization callback for 'switch' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
if( !function_exists('spark_building_construction_sanitize_switch')){
	function spark_building_construction_sanitize_switch( $input, $setting ) {
		// Ensure input is a slug.
		$input = sanitize_key( $input );
		
		// Get list of switch_label from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->switch_label;
		
		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/** include files */
require get_stylesheet_directory() . '/inc/theme-functions.php';

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'ConstructionAgencyInfoText' ) ) :
    /**
     * Info Text Control
     */
    class ConstructionAgencyInfoText extends WP_Customize_Control {
        public function render_content() {
            ?>
            <span class="customize-control-title">
                <?php echo esc_html($this->label); ?>
            </span>
            <?php if ($this->description) { ?>
                <span class="customize-control-description">
                    <?php echo wp_kses_post($this->description); ?>
                </span>
                <?php
            }
        }
    }
endif;

if( !function_exists('spark_building_construction_fonts_url')):
	function spark_building_construction_fonts_url() {

        $fonts_url = '';

        $font_families = array();

        
        if ( 'off' !== _x( 'on', 'Oswald: on or off', 'spark-building-construction' ) ) {
            $font_families[] = 'Oswald:200,300,400,600,700,800';
        }

        if ( 'off' !== _x( 'on', 'Open Sans: on or off', 'spark-building-construction' ) ) {
            $font_families[] = 'Open Sans:300,400,600,700,800';
        }

        if( $font_families ) {

            $query_args = array(

                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url ( $fonts_url );
    }
endif;
/**
 * starter content
 */
require get_stylesheet_directory() .'/inc/starter-content/init.php';

// The filter callback function.
function spark_building_construction_primary_color( $color ) {
    return "#fc5e16";
}
add_filter( 'construction_light_primary_color', 'spark_building_construction_primary_color', 10, 1 );

function spark_building_construction_header_textcolor(){
	return '#ffffff';
}
add_filter( 'header_textcolor', 'spark_building_construction_header_textcolor', 10, 1 );
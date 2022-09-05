<?php
/**
 * Plugin Name: Services Section - Block
 * Description: Use Services Section Block to provide services of your business to clients with customizable settings.
 * Version: 1.2.9
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: services-section
 */

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'SSB_PLUGIN_VERSION', isset($_SERVER['HTTP_HOST']) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.2.9' );
define( 'SSB_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'assets/' );
define( 'SSB_SERVICE_PATTERN', plugins_url( 'dist/src/img/service-pattern.png', __FILE__ ) );

// Services Section Block
class ServicesSectionBlock{
	function __construct(){
		add_action( 'enqueue_block_assets', [$this, 'enqueueBlockAssets'] );
		add_action( 'init', [$this, 'onInit'] );
	}

	function enqueueBlockAssets(){ wp_enqueue_style( 'fontAwesome', SSB_ASSETS_DIR . 'css/fontAwesome.min.css', [], '5.15.4' ); }

	function onInit(){
		wp_register_style( 'services-section-services-editor-style', plugins_url( 'dist/editor.css', __FILE__ ), [ 'wp-edit-blocks' ], SSB_PLUGIN_VERSION ); // Backend Style
		wp_register_style( 'services-section-services-style', plugins_url( 'dist/style.css', __FILE__ ), [ 'wp-editor' ], SSB_PLUGIN_VERSION ); // Frontend Style

		register_block_type( __DIR__, [
			'editor_style'		=> 'services-section-services-editor-style',
			'style'				=> 'services-section-services-style',
			'render_callback'	=> [$this, 'render_services']
		] ); // Register Block

		wp_set_script_translations( 'services-section-services-editor-script', 'services-section', plugin_dir_path( __FILE__ ) . 'languages' ); // Translate
	} // Register

	function render_services( $attributes, $content ){
		extract( $attributes );

		$className = $className ?? '';
		$servicesBlockClassName = 'wp-block-services-section-services ' . $className . ' align' . $align;

		ob_start(); ?>
		<div class='<?php echo esc_attr( $servicesBlockClassName ); ?>' id='ssbServices-<?php echo esc_attr( $cId ); ?>' data-attributes='<?php echo esc_attr( wp_json_encode( $attributes ) ); ?>'>
			<div class='ssbServicesStyle'></div>

			<div class='ssbServices <?php echo esc_attr( $layout ); ?> columns-<?php echo esc_attr( $columns['desktop'] ); ?> columns-tablet-<?php echo esc_attr( $columns['tablet'] ); ?> columns-mobile-<?php echo esc_attr( $columns['mobile'] ); ?>'>
				<?php echo wp_kses_post( $content ); ?>
			</div>
		</div>

		<?php return ob_get_clean();
	} // Render Services
}
new ServicesSectionBlock;

// Require files
require_once plugin_dir_path( __FILE__ ) . 'child/child.php';
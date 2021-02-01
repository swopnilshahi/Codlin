<?php
/**
 * Plugin Name: Testimonials Slider and Showcase
 * Plugin URI: https://radiustheme.com
 * Description: Best Responsive Testimonials Slider and Showcase. It is a fully Responsive & mobile friendly WordPress plugin to manage your company Testimonials. It had Slider & Grid layouts. You can create unlimited shortcode. It is fully flexible to use you can control how many display per row and primary colors from shortcode generator.
 * Author: RadiusTheme
 * Version: 1.2.6
 * Author URI: https://radiustheme.com
 * Tag: testimonials slider, testimonial, testimonials,testimonial slide, testimonial showcase, responsive testimonial, testimonial plugin
 * Text Domain: testimonial-slider-showcase
 * Domain Path: /languages
 */
$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
define( 'TSS_VERSION', $plugin_data['Version'] );
define( 'TSS_PLUGIN_PATH', dirname( __FILE__ ) );
define( 'TSS_PLUGIN_ACTIVE_FILE_NAME', plugin_basename( __FILE__ ) );
define( 'TSS_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'TSS_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages' );

require( 'lib/init.php' );
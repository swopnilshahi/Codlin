<?php
/**
 * app.js  -  autop issue solution, animtions - added for all styles
 * 
 * mainstyles.css  -  for all styles .. 
 * mdstyle8.css  - style 8 needed - 
 *                  for floating style added with conditons - in this file
 *                  for shortcodes added at there related template files.. ( sc-style- .php )
 * 
 * @package ccw
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Add_Styles_Scripts' ) ) :
    
class CCW_Add_Styles_Scripts {


    /**
	 * Register styles - front end ( non admin )
	 *
	 * @since 1.0
	 */
    function ccw_register_files() {

        wp_register_style('ccw_main_css', plugins_url( 'prev/assets/css/mainstyles.css', HT_CTC_PLUGIN_FILE ), '', HT_CTC_VERSION );
        wp_enqueue_style('ccw_main_css');
        
        
        wp_register_style('ccw_mdstyle8_css', plugins_url( 'new/inc/assets/css/mdstyle8.css', HT_CTC_PLUGIN_FILE ), '', HT_CTC_VERSION );
        // needs - s8
        // wp_enqueue_style('ccw_mdstyle8_css');
        
        wp_enqueue_script( 'ccw_app', plugins_url( 'prev/assets/js/app.js', HT_CTC_PLUGIN_FILE ), array ( 'jquery' ), HT_CTC_VERSION, true );

        // As now - for floating style - enqueue md style added like this
        // but for shortcodes enqueue while calling that template file
        $mobile_style = ht_ccw()->variables->get_option['stylemobile'];
        $desktop_style = ht_ccw()->variables->get_option['style'];

        /**
         * is mobile or not
         * and then enqueue styles if selected style is 8
         */
        if ( 1 == ht_ccw()->device_type->is_mobile ) {
            if ( 8 == $mobile_style ) {
                wp_enqueue_style('ccw_mdstyle8_css');
            }
        } else {
            if ( 8 == $desktop_style ) {
                wp_enqueue_style('ccw_mdstyle8_css');
            }
        }
        
    }


}

endif; // END class_exists check


$add_styles_scripts = new CCW_Add_Styles_Scripts();

add_action('wp_enqueue_scripts', array( $add_styles_scripts, 'ccw_register_files' ) );
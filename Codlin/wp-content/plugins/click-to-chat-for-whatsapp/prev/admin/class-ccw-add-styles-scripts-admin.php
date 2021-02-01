<?php
/**
* Enqueue styles, scripts
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Add_Styles_Scripts_Admin' ) ) :

class CCW_Add_Styles_Scripts_Admin {


    // Register css styles, javascript files only on 'click-to-chat' page
    function ccw_register_files_admin($hook) {
        
        if( 'toplevel_page_click-to-chat' == $hook || 'click-to-chat_page_ccw-edit-styles' == $hook ) {

            wp_enqueue_style( 'wp-color-picker' );
            
            wp_enqueue_style('ccw_admin_md_css', plugins_url( 'new/admin/admin_assets/css/materialize.min.css', HT_CTC_PLUGIN_FILE ) , '', HT_CTC_VERSION );
            wp_enqueue_style('ccw_admin_main_css', plugins_url( 'prev/assets/css/admin_main.css', HT_CTC_PLUGIN_FILE ) , '', HT_CTC_VERSION );

            wp_enqueue_script( 'ccw_admin_md_js', plugins_url( 'new/admin/admin_assets/js/materialize.min.js', HT_CTC_PLUGIN_FILE ), array( 'jquery' ), HT_CTC_VERSION, true );
            wp_enqueue_script( 'ccw_admin_app_js', plugins_url( 'prev/assets/js/admin_app.js', HT_CTC_PLUGIN_FILE ), array( 'ccw_admin_md_js', 'jquery', 'wp-color-picker' ), HT_CTC_VERSION, true );
        } else {
            return;
        }
        
    }

}

$add_styles_scripts_admin =  new CCW_Add_Styles_Scripts_Admin();

add_action('admin_enqueue_scripts', array( $add_styles_scripts_admin, 'ccw_register_files_admin' ) );

endif; // END class_exists check
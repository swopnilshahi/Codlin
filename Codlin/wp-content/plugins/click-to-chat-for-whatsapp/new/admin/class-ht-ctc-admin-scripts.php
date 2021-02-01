<?php
/**
* Register css styles, javascript files at admin side
*
* @package ctc
* @subpackage admin
* @since 2.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Scripts' ) ) :

class HT_CTC_Admin_Scripts {


    // Register css styles, javascript files only on 'click-to-chat' page
    function register_scripts_admin($hook) {

        // true/false
        $load_js_bottom = apply_filters( 'ht_ctc_fh_load_js_bottom', true );
        
        // hook .. 
        if( 'toplevel_page_click-to-chat' == $hook || 'click-to-chat_page_click-to-chat-chat-feature' == $hook || 'click-to-chat_page_click-to-chat-group-feature' == $hook || 'click-to-chat_page_click-to-chat-share-feature' == $hook || 'click-to-chat_page_click-to-chat-customize-styles' == $hook ) {

            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style('ctc_admin_md_css', plugins_url( 'new/admin/admin_assets/css/materialize.min.css', HT_CTC_PLUGIN_FILE ) , '', HT_CTC_VERSION );
            wp_enqueue_style('ctc_admin_css', plugins_url( 'new/admin/admin_assets/css/admin.css', HT_CTC_PLUGIN_FILE ) , '', HT_CTC_VERSION );

            wp_enqueue_script( 'ctc_admin_md_js', plugins_url( 'new/admin/admin_assets/js/materialize.min.js', HT_CTC_PLUGIN_FILE ), array( 'jquery' ), HT_CTC_VERSION, $load_js_bottom );
            wp_enqueue_script( 'ctc_admin_js', plugins_url( 'new/admin/admin_assets/js/admin.js', HT_CTC_PLUGIN_FILE ), array( 'jquery', 'wp-color-picker', 'ctc_admin_md_js' ), HT_CTC_VERSION, $load_js_bottom );
        } else {
            return;
        }

        
    }

}

$ht_ctc_admin_scripts =  new HT_CTC_Admin_Scripts();

add_action('admin_enqueue_scripts', array( $ht_ctc_admin_scripts, 'register_scripts_admin' ) );


endif; // END class_exists check
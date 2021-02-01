<?php
/**
* Admin - menu page  - add_menu_page for this plugin  - top level menu
* calls settings_page.php  ( ccw_settings_page - > require_once('settings_page.php') )
*   and page content display at admin_menu.php
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Admin_Menu' ) ) :

class CCW_Admin_Menu {

    // top level page
    function ccw_options_page() {
        add_menu_page(
            'Click to Chat for WhatsApp - Plugin Option Page',
            'Click to Chat',
            'manage_options',
            'click-to-chat',
            array( $this, 'ccw_settings_page' ),
            'dashicons-format-chat'
        );
    }

    // top level page - setting page
    function ccw_settings_page() {
        
        if ( ! current_user_can('manage_options') ) {
            return;
        }

        include_once('settings_page.php'); 
    }


    // customize style page 
    function ccw_options_page_two() {
        add_submenu_page( 
            'click-to-chat', 
            'Edit Styles', 
            'Customize Styles', 
            'manage_options', 
            'ccw-edit-styles', 
            array( $this, 'ccw_settings_page_two' )
        );

    }

    // customize style page - setting page
    function ccw_settings_page_two() {
        
        if ( ! current_user_can('manage_options') ) {
            return;
        }

        include_once('sp_customize_styles.php'); 
    }
    

}

$admin_menu = new CCW_Admin_Menu();

add_action('admin_menu',  array( $admin_menu, 'ccw_options_page') );

add_action('admin_menu', array( $admin_menu, 'ccw_options_page_two') );

endif; // END class_exists check
<?php
/**
* three function -  while actiavte , deactivate , uninstall( while deleting ) 
* as plan to preserve the database options which usefull when reinstall plugin/ update 
*       so that setting wont last
*     and as no custom post types or so.. to flush rewrite rules
*               so deactivate, uninstall not doing any thing here
*
* @package ccw
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW_Register' ) ) :
    
class HT_CCW_Register {

    // when plugin activate
    public static function activate() {

        
        if( version_compare( get_bloginfo('version'), '3.1.0', '<') )  {
            wp_die( 'please update WordPress' );
        }

        // add default values to options db 
        include_once( HT_CTC_PLUGIN_DIR . '/prev/admin/default-values.php' );
    }
    
    // when plugin deactivate
    public static function deactivate() {
    }

    // when plugin uninstall 
    public static function uninstall() {
    }

    // for plugin updates - run on plugins_loaded 
    public static function version_check() {
        
        $ccw_plugin_details = get_option('ccw_plugin_details');
    
        if ( HT_CTC_VERSION !== $ccw_plugin_details['version'] ) {
            //  to update the plugin - just like activate plugin
            self::activate();

        }
    }

    // add settings page links in plugins page - at plugin
    public static function plugin_action_links( $links ) {
		$new_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=click-to-chat' ) . '">' . __( 'Settings' , 'click-to-chat-for-whatsapp' ) . '</a>',
		);

		return array_merge( $new_links, $links );
	}

    

}

endif; // END class_exists check
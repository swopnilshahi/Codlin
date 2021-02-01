<?php
/**
 * Activate
 * deactivate (no custom post types or so.. to flush rewrite rules)
 * uninstall ( delete if set )
 * 
 * @package ctc
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Register' ) ) :
    
class HT_CTC_Register {

    // when plugin activate
    public static function activate() {

        if( version_compare( get_bloginfo('version'), '3.1.0', '<') )  {
            wp_die( 'please update WordPress' );
        }

        // add default values to options db 
        include_once( HT_CTC_PLUGIN_DIR . '/new/admin/class-ht-ctc-db.php' );
    }
    
    // when plugin deactivate
    public static function deactivate() {
    }

    // when plugin uninstall 
    public static function uninstall() {

        $options = get_option( 'ht_ctc_othersettings' );

        if ( isset ( $options['delete_options'] ) ) {

            global $wpdb;

            // $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'ht\_ctc\_%';" );
            delete_option( 'ht_ctc_main_options' );
            delete_option( 'ht_ctc_chat_options' );
            delete_option( 'ht_ctc_plugin_details' );
            delete_option( 'ht_ctc_group' );
            delete_option( 'ht_ctc_one_time' );
            delete_option( 'ht_ctc_othersettings' );

            delete_option( 'ccw_options' );
            delete_option( 'ccw_options_cs' );
            delete_option( 'ht_ccw_ga' );
            delete_option( 'ht_ccw_fb' );

            // deletes custom styles, share, switch
            $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'ht\_ctc\_s%';" );

            // deletes page level settings
            $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'ht\_ctc\_page\_%';" );

            // todo
            // clear cache
            // if ( function_exists('wp_cache_flush') ) {
            //     wp_cache_flush();
            // }
        }

    }

    // for plugin updates - run on plugins_loaded 
    public static function version_check() {
        
        $ht_ctc_plugin_details = get_option('ht_ctc_plugin_details');
    
        if ( HT_CTC_VERSION !== $ht_ctc_plugin_details['version'] ) {
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
<?php
/*
Plugin Name: Click to Chat
Plugin URI:  https://wordpress.org/plugins/click-to-chat-for-whatsapp/
Description: Lets make your Web page visitors contact you through WhatsApp with a single click/tap
Version:     2.9.1
Author:      HoliThemes
Author URI:  https://holithemes.com/plugins/click-to-chat/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: click-to-chat-for-whatsapp
*/

if ( ! defined( 'WPINC' ) ) {
	die('dont try to call this directly');
}

// ctc - Version
if ( ! defined( 'HT_CTC_VERSION' ) ) {
	define( 'HT_CTC_VERSION', '2.9.1' );
}

// define HT_CTC_PLUGIN_FILE
if ( ! defined( 'HT_CTC_PLUGIN_FILE' ) ) {
	define( 'HT_CTC_PLUGIN_FILE', __FILE__ );
}

// define HT_CTC_PLUGIN_DIR
if ( ! defined( 'HT_CTC_PLUGIN_DIR' ) ) {
	define( 'HT_CTC_PLUGIN_DIR', plugin_dir_path( HT_CTC_PLUGIN_FILE ) );
}

include_once HT_CTC_PLUGIN_DIR .'new/inc/class-ht-ctc-register.php';
register_activation_hook( __FILE__, array( 'HT_CTC_Register', 'activate' )  );
register_deactivation_hook( __FILE__, array( 'HT_CTC_Register', 'deactivate' )  );
register_uninstall_hook(__FILE__, array( 'HT_CTC_Register', 'uninstall' ) );

include_once 'common/class-ht-ctc-switch.php';
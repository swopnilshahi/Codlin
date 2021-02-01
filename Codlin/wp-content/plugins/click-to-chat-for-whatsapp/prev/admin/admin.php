<?php
/**
*  starting point for the admin side of this plugin.
*  include other file here .. which need in admin side. 
*  In click-to-chat.php this file will be loaded as is_admin
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/*************** includes ***********/
include_once('class-ccw-add-styles-scripts-admin.php');

include_once('commons/class-ht-ccw-admin-lists.php');

include_once('class-ccw-admin-menu.php');
include_once('class-ccw-admin-page.php');
include_once('class-ccw-admin-page-customize-styles.php');
include_once('class-ccw-admin-others.php');


// as translation text added only in admin - so done here
// function load_ht_ccw_textdomain() {
//     load_plugin_textdomain( 'click-to-chat-for-whatsapp', FALSE, HT_CTC_PLUGIN_BASENAME . 'prev/languages/' );
// }

// add_action( 'plugins_loaded', 'load_ht_ccw_textdomain' );



/**
 * ccw_admin_sidebar_card  -  by default there is no option .. 
 * so when no option exists .. so it not equal to 'hide'
 * so in admin sidebar the card will display . . 
 * if clicks on hide card .. 
 *      then an option update will happen ( create an option )
 * 
 */
add_action( 'wp_ajax_ccw_admin_sidebar', 'ht_ccw_admin_sidebar_ajax' );

function ht_ccw_admin_sidebar_ajax() {

    $wca_card = get_option( 'ccw_admin_sidebar_card' );

    // wp_localize_script can use - but this may be easy, as only one value .. 
    echo $wca_card;

    wp_die();
}



// action -  ccw_hide_admin_sidebar_card
// update the option ccw_admin_sidebar_card to hide
add_action( 'wp_ajax_ccw_hide_admin_sidebar_card', 'ht_ccw_hide_admin_sidebar_card_ajax' );

function ht_ccw_hide_admin_sidebar_card_ajax() {

    $wca_card = get_option( 'ccw_admin_sidebar_card' );

    update_option( 'ccw_admin_sidebar_card', 'hide' );

    wp_die();
}
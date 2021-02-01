<?php
/**
 * new interface starter .. 
 * 
 * Include files - admin - front end 
 * add hooks
 * 
 * @package CTC
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC' ) ) :

class HT_CTC {

    /**
     * singleton instance
     *
     * @var HT_CTC 
     */
    private static $instance = null;
    
    /**
     * wp_is_mobile - if true then yes, else no
     *
     * @var if mobile, tab .. then yes, else no
     */
    public $device_type;

    /**
     * instance of HT_CTC_Values
     * 
     * database values , .. . options .. 
     *
     * @var HT_CTC_Values
     */
    public $values = null;

    /**
     * main instance - HT_CTC
     *
     * @return HT_CTC instance
     * @since 1.0
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __clone() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'click-to-chat-for-whatsapp' ), '1.0' );
    }
    
    public function __wakeup() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'click-to-chat-for-whatsapp' ), '1.0' );
    }

    /**
     * constructor 
     * basic(), includes() -> include files
     * hooks()  -> run hooks 
     */
    public function __construct() {
        $this->basic();
        $this->includes();
        $this->hooks();
    }

    /**
     * add the basic things
     * 
     * calling this before include, initilize other things
     * 
     * because this things may useful before initilize other things
     * 
     *  e.g. include, initialize files based on device, user settings
     */
    private function basic() {

        include_once HT_CTC_PLUGIN_DIR .'new/inc/commons/class-ht-ctc-ismobile.php';
        include_once HT_CTC_PLUGIN_DIR .'new/inc/commons/class-ht-ctc-values.php';
        include_once HT_CTC_PLUGIN_DIR .'new/inc/commons/class-ht-ctc-hooks.php';
        
        $this->device_type = new HT_CTC_IsMobile();
        $this->values = new HT_CTC_Values();
        
    }
    
    /**
     * include plugin file
     */
    private function includes() {

        //  is_admin ? include file to admin area : include files to non-admin area 
        if ( is_admin() ) {
            // admin
             // admin main file
            include_once HT_CTC_PLUGIN_DIR . 'new/admin/admin.php';
        } else {
            // front
             // main file
            include_once HT_CTC_PLUGIN_DIR . 'new/inc/class-ht-ctc-main.php';
             // scripts
            include_once HT_CTC_PLUGIN_DIR . 'new/inc/commons/class-ht-ctc-scripts.php';
        }

        // admin and front
         // woo init
        include_once HT_CTC_PLUGIN_DIR . 'new/tools/woo/ht-ctc-woo.php';
        
    }

    /**
     * Register hooks - when plugin activate, deactivate, uninstall
     * commented deactivation, uninstall hook - its not needed as now
     * 
     * plugins_loaded  - Check Diff - uses when plugin updates.
     */
    private function hooks() {

        // initilaze classes
        if ( ! is_admin() ) {
            add_action( 'init', array( $this, 'init' ), 0 );
        }

        // enable shortcodes in widget area.
        add_filter('widget_text', 'do_shortcode');
        
        // add_filter( 'the_excerpt', 'do_shortcode');

        // settings page link
        add_filter( 'plugin_action_links_' . HT_CTC_PLUGIN_BASENAME, array( 'HT_CTC_Register', 'plugin_action_links' ) );

        // when plugin updated - check version diff
        add_action('plugins_loaded', array( 'HT_CTC_Register', 'version_check' ) );

    }

    /**
     * create instance
     * @uses this->hooks() - using init hook - priority 0
     */
    public function init() {
        // $this->values = new HT_CTC_Values();
        // $this->device_type = new HT_CTC_IsMobile();
    }

}

endif; // END class_exists check
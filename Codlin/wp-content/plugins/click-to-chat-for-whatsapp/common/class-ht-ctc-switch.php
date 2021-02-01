<?php
/**
 * Switch .. new or previous - user inerface
 * new user default to new interface
 * prev user - default to prev interface if not switched.
 * 
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Swift' ) ) :

class HT_CTC_Swift {

	public function __construct() {
        $this->define_constants();
        $this->to_switch();
	}
	
	/**
     * Define Constants
     */
    private function define_constants() {
        
		$this->define( 'HT_CTC_WP_MIN_VERSION', '4.6' );
        $this->define( 'HT_CTC_PLUGIN_BASENAME', plugin_basename( HT_CTC_PLUGIN_FILE ) );
        $this->define( 'HT_CTC_BLOG_NAME', get_bloginfo('name') );
	}

	/**
     * @uses this->define_constants
     * @param string $name Constant name
     * @param string.. $value Constant value
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
	}
	

	public function to_switch() {

		// new interface  yes/no
		$is_new = '';

		// user new/prev
		$user = '';


		// if first time user - new interface .. $is_new = 'yes';
		// if user swifted to new interface .. $is_new = 'yes';

		// if user swifted to prev interface .. $is_new = 'no';
		// if prev user / update .. $is_new = 'no';
		
		$ccw_options = get_option('ccw_options');

		if ( isset( $ccw_options['number'] ) ) {
			$user = 'prev';
			$is_new = 'no';
		} else {
			// new user - new interface
			$user = 'new';
			$is_new = 'yes';
		}

		// prev user and if switched ( checkbox option at admin )
		if ( 'prev' == $user ) {

			$ht_ctc_switch = get_option('ht_ctc_switch');

			if ( 'yes' == $ht_ctc_switch['interface'] ) {
				$is_new = 'yes';
			}
		} 


		// while testing
		// $is_new = 'yes';

		// define HT_CTC_IS_NEW
		if ( ! defined( 'HT_CTC_IS_NEW' ) ) {
			define( 'HT_CTC_IS_NEW', $is_new );
		}


		// include related files ..
		if ( 'yes' == HT_CTC_IS_NEW ) {
			// new interface

			// include main file - prev
			include_once HT_CTC_PLUGIN_DIR .'new/class-ht-ctc.php';

			// create instance for the main file - HT_CTC
			function ht_ctc() {
				return HT_CTC::instance();
			}

			ht_ctc();

		} else {
			// prev interface 

			// include main file - prev
			include_once HT_CTC_PLUGIN_DIR .'prev/inc/class-ht-ccw.php';


			// create instance for the main file - HT_CCW
			function ht_ccw() {
				return HT_CCW::instance();
			}

			ht_ccw();
		}

	}


}

new HT_CTC_Swift();

endif; // END class_exists check
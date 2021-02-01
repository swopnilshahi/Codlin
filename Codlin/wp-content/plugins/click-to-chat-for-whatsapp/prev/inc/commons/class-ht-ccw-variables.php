<?php
/**
 * Varibales to use among plugin - try to avoid globals .. 
 * replaced variables.php 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW_Variables' ) ) :

class HT_CCW_Variables {

    /**
     * db options table - ccw_options values
     * @var array get_options ccw_options
     */
    public $get_option;

    public function __construct() {
        $this->get_option();
    }

    public function get_option() {
        $this->get_option =  get_option('ccw_options');
    }

    // public function ccw_enable() {
    //     $ccw_enable = esc_attr( $this->get_option['enable'] );
    //     return $ccw_enable;
    // }

}

endif; // END class_exists check
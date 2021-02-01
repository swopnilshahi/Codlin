<?php
/**
 * some common things in admin .. 
 * Animations .. 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW_Admin_lists' ) ) :

class HT_CCW_Admin_lists {

    /**
     * If new animation have to add - add the animation name here
     *   and then add related css - anstyles.scss ( in dev environment, and run webpack )
     */
    public static $animations_list = array(
        'no-animation',
        'bounce',
        'tada',
    );

}

endif; // END class_exists check
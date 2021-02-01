<?php
/**
 * Other function, features .. to
 * 
 * admin notices
 *  If whatsapp number not added. 
 * 
 * @since 2.7
 * @package ctc
 * @subpackage admin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW_Admin_Others' ) ) :

class HT_CCW_Admin_Others {
    

    public function __construct() {
        $this->admin_hooks();
    }

    function admin_hooks() {

        // if number blank
        $ccw_options = get_option('ccw_options');
        if ( isset( $ccw_options['number'] ) ) {
            if ( '' == $ccw_options['number'] ) {
                add_action('admin_notices', array( $this, 'ifnumberblank') );
            }
        }
    }

    function ifnumberblank() {
        ?>
        <div class="notice notice-info is-dismissible">
            <p>Click to Chat is almost ready. <a href="<?php echo admin_url('admin.php?page=click-to-chat');?>">Add WhatsApp Number</a> to let vistiors chat.</p>
            <!-- <a href="?dismis">Dismiss</a> -->
        </div>
        <?php
    }


}

new HT_CCW_Admin_Others();

endif; // END class_exists check
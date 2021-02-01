<?php
/**
 * Group chat/invite feature - main page
 * 
 * @subpackage group
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Group' ) ) :

class HT_CTC_Group {

    public function __construct() {
        // $this->group();
    }

    public function group() {
        
        $options = get_option('ht_ctc_group');

        // show/hide
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/show-hide.php';

        if ( 'no' == $display ) {
            return;
        }

        $main_options = ht_ctc()->values->ctc_main_options;

        // position
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/position-to-place.php';
        
        // is mobile to select styles
        $is_mobile = ht_ctc()->device_type->is_mobile();

        // style
        if ( 'yes' == $is_mobile ) {
            $style = esc_attr( $options['style_mobile'] );
        } else {
            $style = esc_attr( $options['style_desktop'] );
        }

        // call to action
        $call_to_action = esc_attr( $options['call_to_action'] );

        // class names
        $class_names = "ht-ctc ht-ctc-group style-$style";

        // group id
        $group_id = esc_attr( $options['group_id'] );

        // group_id - at page level
        $page_id = get_the_ID();
        $page_group_id = esc_attr( get_post_meta( $page_id, 'ht_ctc_page_group_id', true ) );

        if ( isset( $page_group_id ) && '' !== $page_group_id ){
            $group_id = $page_group_id;
        }

        // return if group id is blank
        if ( '' == $group_id ) {
            return;
        }

        // analytics
        $is_ga_enable = apply_filters( 'ht_ctc_fh_is_ga_enable', 'no' );
        $is_fb_pixel = apply_filters( 'ht_ctc_fh_is_fb_pixel', 'no' );
        $is_fb_an_enable = apply_filters( 'ht_ctc_fh_is_fb_an_enable', 'no' );


        $display_mobile = 'show';
        if ( isset( $options['hideon_mobile'] ) ) {
            $display_mobile = 'hide';
        }
        $display_desktop = 'show';
        if ( isset( $options['hideon_desktop'] ) ) {
            $display_desktop = 'hide';
        }

        $title = '';
        if ( '2' == $style || '3' == $style ) {
            $title = "title = '$call_to_action'";
        }

        // call style
        $path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style. '.php';

        if ( is_file( $path ) ) {
            do_action('ht_ctc_ah_before_fixed_position');
            ?>
            <div <?php echo $title ?> onclick="ht_ctc_click(this);" class="<?php echo $class_names ?>" 
                style="display: none; position: fixed; <?php echo $position ?> cursor: pointer; z-index: 99999999;"
                data-return_type="group" 
                data-group_id="<?php echo $group_id ?>" 
                data-is_ga_enable="<?php echo $is_ga_enable ?>" 
                data-is_fb_pixel="<?php echo $is_fb_pixel ?>" 
                data-is_fb_an_enable="<?php echo $is_fb_an_enable ?>" 
                data-display_mobile="<?php echo $display_mobile ?>" 
                data-display_desktop="<?php echo $display_desktop ?>" 
                >
                <?php include $path; ?>
            </div>
            <script> try { ht_ctc_loaded(); } catch (e) {} </script>
            <?php
        }

        
    }

}

// new HT_CTC_Group();

$ht_ctc_group = new HT_CTC_Group();
add_action( 'wp_footer', array( $ht_ctc_group, 'group' ) );


endif; // END class_exists check
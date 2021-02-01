<?php
/**
 * Share feature - main page
 * 
 * @subpackage share
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Share' ) ) :

class HT_CTC_Share {

    public function __construct() {
        // $this->share();
    }

    public function share() {
        
        $options = get_option('ht_ctc_share');

        // share text
        $share_text = esc_attr( $options['share_text'] );

        // return if share text is blank
        if ( '' == $share_text ) {
            return;
        }

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
            $style = esc_html( $options['style_mobile'] );
        } else {
            $style = esc_html( $options['style_desktop'] );
        }

        // call to action
        $call_to_action = esc_html( $options['call_to_action'] );

        // class names
        $class_names = "ht-ctc ht-ctc-share style-$style";

        $page_url = get_permalink();
        $post_title = esc_html( get_the_title() );

        // if ( is_home() || is_front_page() ) {
        if ( is_home() ) {
            $page_url = get_bloginfo('url');
            $post_title = HT_CTC_BLOG_NAME;
        }

        $share_text = str_replace( array('{{url}}', '{url}', '{{title}}', '{title}', '{{site}}', '{site}' ),  array( $page_url, $page_url, $post_title, $post_title, HT_CTC_BLOG_NAME, HT_CTC_BLOG_NAME ), $share_text );

        // analytics
        $is_ga_enable = apply_filters( 'ht_ctc_fh_is_ga_enable', 'no' );
        $is_fb_pixel = apply_filters( 'ht_ctc_fh_is_fb_pixel', 'no' );
        $is_fb_an_enable = apply_filters( 'ht_ctc_fh_is_fb_an_enable', 'no' );


        // webapi: web/api.whatsapp,  api: api.whatsapp
        $webandapi = 'api';
        if ( isset( $options['webandapi'] ) ) {
            $webandapi = 'webapi';
        }

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
                data-return_type="share" 
                data-share_text="<?php echo $share_text ?>" 
                data-is_ga_enable="<?php echo $is_ga_enable ?>" 
                data-is_fb_pixel="<?php echo $is_fb_pixel ?>" 
                data-is_fb_an_enable="<?php echo $is_fb_an_enable ?>" 
                data-webandapi="<?php echo $webandapi ?>" 
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

// new HT_CTC_Share();

$ht_ctc_share = new HT_CTC_Share();
add_action( 'wp_footer', array( $ht_ctc_share, 'share' ) );


endif; // END class_exists check
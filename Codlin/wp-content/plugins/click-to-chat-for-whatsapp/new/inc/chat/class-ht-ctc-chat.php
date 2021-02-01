<?php
/**
 * WhatsApp Chat  - main page .. 
 * 
 * @subpackage chat
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Chat' ) ) :

class HT_CTC_Chat {

    public function chat() {
        
        $options = get_option('ht_ctc_chat_options');
        
        $ht_ctc_chat = array();

        // show/hide
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/show-hide.php';

        if ( 'no' == $display ) {
            return;
        }
        
        $main_options = ht_ctc()->values->ctc_main_options;

        // position
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/position-to-place.php';
        
        // is mobile
        $is_mobile = ht_ctc()->device_type->is_mobile();

        $wp_device = '';

        // style
        if ( 'yes' == $is_mobile ) {
            $style = esc_attr( $options['style_mobile'] );
            $wp_device = 'mobile';
        } else {
            $style = esc_attr( $options['style_desktop'] );
            $wp_device = 'desktop';
        }

        $page_id = get_the_ID();
        $page_url = get_permalink();
        $post_title = esc_html( get_the_title() );

        // call to action
        // TODO: localization for number, prefilled, call to action
        $ht_ctc_chat['call_to_action'] = __( esc_attr( $options['call_to_action'] ) , 'click-to-chat-for-whatsapp' );

        // call to action - at page level
        $page_call_to_action = esc_attr( get_post_meta( $page_id, 'ht_ctc_page_call_to_action', true ) );
        if ( isset( $page_call_to_action ) && '' !== $page_call_to_action ){
            $ht_ctc_chat['call_to_action'] = $page_call_to_action;
        }

        // number
        $number = esc_attr( $options['number'] );
        // number - at page level
        $page_number = esc_attr( get_post_meta( $page_id, 'ht_ctc_page_number', true ) );
        if ( isset( $page_number ) && '' !== $page_number ){
            $number = $page_number;
        }

        // // return if whatsapp number is blank
        // if ( '' == $number ) {
        //     return;
        // }

        // Number
        $ht_ctc_chat['number'] = apply_filters( 'ht_ctc_fh_number_format', $number );

        // prefilled text
        $ht_ctc_chat['pre_filled'] = esc_attr( $options['pre_filled'] );

        // analytics
        $is_ga_enable = apply_filters( 'ht_ctc_fh_is_ga_enable', 'no' );
        $is_fb_pixel = apply_filters( 'ht_ctc_fh_is_fb_pixel', 'no' );
        $is_fb_an_enable = apply_filters( 'ht_ctc_fh_is_fb_an_enable', 'no' );
        
        // webapi: web/api.whatsapp,  wa: wa.me
        $webandapi = 'wa';
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

        // number not added and is administrator
        $is_admin = "";
        if ( '' == $ht_ctc_chat['number'] && current_user_can('administrator') ) {
            $is_admin = "admin";
        }

        // class names
        $class_names = "ht-ctc ht-ctc-chat style-$style $wp_device ctc-analytics $is_admin";

        // hook
        $ht_ctc_chat = apply_filters( 'ht_ctc_fh_chat', $ht_ctc_chat );
        
        $ht_ctc_chat['pre_filled'] = str_replace( array('{{url}}', '{url}', '{{title}}', '{title}', '{{site}}', '{site}' ),  array( $page_url, $page_url, $post_title, $post_title, HT_CTC_BLOG_NAME, HT_CTC_BLOG_NAME ), $ht_ctc_chat['pre_filled'] );

        // @uses at styles
        $call_to_action = $ht_ctc_chat['call_to_action'];
        
        if ( '' == $call_to_action ) {
            if ( '1' == $style || '4' == $style || '6' == $style || '8' == $style ) {
                $call_to_action = "WhatsApp us";
            }
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
                data-return_type="chat" 
                data-style="<?php echo $style ?>" 
                data-number="<?php echo $ht_ctc_chat['number'] ?>" 
                data-pre_filled="<?php echo $ht_ctc_chat['pre_filled'] ?>" 
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

// new HT_CTC_Chat();

$ht_ctc_chat = new HT_CTC_Chat();
add_action( 'wp_footer', array( $ht_ctc_chat, 'chat' ) );


endif; // END class_exists check
<?php
/**
 * share settings page - admin 
 * 
 * share options .. 
 * 
 * @package ctc
 * @subpackage admin
 * @since 2.0 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Share_Page' ) ) :

class HT_CTC_Admin_Share_Page {

    public function menu() {

        add_submenu_page(
            'click-to-chat',
            'Share Invite',
            'Share',
            'manage_options',
            'click-to-chat-share-feature',
            array( $this, 'settings_page' )
        );
    }

    public function settings_page() {

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <div class="row">
                <div class="col s12 m12 xl8 options">
                    <form action="options.php" method="post" class="">
                        <?php settings_fields( 'ht_ctc_share_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_share_page_settings_sections_do' ) ?>
                        <?php submit_button() ?>
                    </form>
                </div>
                <!-- <div class="col s12 m12 xl6 ht-cc-admin-sidebar">
                </div> -->
            </div>

        </div>

        <?php

    }


    public function settings() {

        // main settings - options enable .. share, share .. 
        // chat options 
        register_setting( 'ht_ctc_share_page_settings_fields', 'ht_ctc_share' , array( $this, 'options_sanitize' ) );
        
        add_settings_section( 'ht_ctc_main_page_settings_sections_add', '', array( $this, 'main_settings_section_cb' ), 'ht_ctc_share_page_settings_sections_do' );
        
        add_settings_field( 'share_text', 'Share Text', array( $this, 'share_text_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'share_cta', 'Call to Action', array( $this, 'share_cta_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        
        add_settings_field( 'share_ctc_desktop_style', 'Style for Desktop', array( $this, 'share_ctc_desktop_style_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'share_ctc_mobile_style', 'Style for Mobile', array( $this, 'share_ctc_mobile_style_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'share_ctc_position', 'Position to place', array( $this, 'share_ctc_position_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'share_ctc_webandapi', 'Web WhatsApp', array( $this, 'share_ctc_webandapi_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'share_show_hide', 'Show/Hide', array( $this, 'share_show_hide_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'share_shortcode', '', array( $this, 'share_shortcode_cb' ), 'ht_ctc_share_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        
        
    }

    public function main_settings_section_cb() {
        ?>
        <h1>Share</h1>
        <?php
    }


    // WhatsApp share ID.
    function share_text_cb() {
        $options = get_option('ht_ctc_share');
        $value = ( '' == $options ) ? '' : esc_attr( $options['share_text'] );
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_share[share_text]" value="<?php echo $value ?>" id="whatsapp_share_text" type="text" class="input-margin">
                <label for="whatsapp_share_text">Share Text</label>
                <p class="description">Placeholder {{url}} returns current webpage URL - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/share-text/">more info</a> ) </p>
            </div>
        </div>
        <?php
    }

    // call to action 
    function share_cta_cb() {
        $options = get_option('ht_ctc_share');
        $value = ( '' == $options ) ? '' : esc_attr( $options['call_to_action'] );
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_share[call_to_action]" value="<?php echo $value ?>" id="call_to_action" type="text" class="input-margin">
                <label for="call_to_action">Call to Action</label>
                <p class="description">Text that appears along with WhatsApp icon/button - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/call-to-action/">more info</a> </p>
            </div>
        </div>
        <?php
    }
    


    // Desktop - select style 
    function share_ctc_desktop_style_cb() {
        $options = get_option('ht_ctc_share');
        $style_value = ( '' == $options ) ? '' : esc_attr( $options['style_desktop'] );
        ?>
        <div class="row">
            <div class="input-field col s12" style="margin-bottom: 0px;">
                <select name="ht_ctc_share[style_desktop]" class="select-2">
                    <option value="1" <?php echo $style_value == 1 ? 'SELECTED' : ''; ?> >Style-1</option>
                    <option value="2" <?php echo $style_value == 2 ? 'SELECTED' : ''; ?> >Style-2</option>
                    <option value="3" <?php echo $style_value == 3 ? 'SELECTED' : ''; ?> >Style-3</option>
                    <option value="4" <?php echo $style_value == 4 ? 'SELECTED' : ''; ?> >Style-4</option>
                    <option value="5" <?php echo $style_value == 5 ? 'SELECTED' : ''; ?> >Style-5</option>
                    <option value="6" <?php echo $style_value == 6 ? 'SELECTED' : ''; ?> >Style-6</option>
                    <option value="7" <?php echo $style_value == 7 ? 'SELECTED' : ''; ?> >Style-7</option>
                    <option value="8" <?php echo $style_value == 8 ? 'SELECTED' : ''; ?> >Style-8</option>
                    <option value="99" <?php echo $style_value == 99 ? 'SELECTED' : ''; ?> >Style-99 (Add your own image / GIF)</option>
                </select>
                <label>Select Style for Desktop</label>
            </div>
        </div>

        <p class="description"> - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/list-of-styles/">List of syles</a> </p>
        <p class="description">Can customize each style  - <a target="_blank" href="<?php echo admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>"><?php _e( 'Customize Styles' , 'click-to-chat-for-whatsapp' ) ?></a> </p>

        <?php
    }


    // Mobile - select style 
    function share_ctc_mobile_style_cb() {
        $options = get_option('ht_ctc_share');
        $style_value = ( '' == $options ) ? '' : esc_attr( $options['style_mobile'] );
        ?>
        <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12">
                <select name="ht_ctc_share[style_mobile]" class="select-2">
                    <option value="1" <?php echo $style_value == 1 ? 'SELECTED' : ''; ?> >Style-1</option>
                    <option value="2" <?php echo $style_value == 2 ? 'SELECTED' : ''; ?> >Style-2</option>
                    <option value="3" <?php echo $style_value == 3 ? 'SELECTED' : ''; ?> >Style-3</option>
                    <option value="4" <?php echo $style_value == 4 ? 'SELECTED' : ''; ?> >Style-4</option>
                    <option value="5" <?php echo $style_value == 5 ? 'SELECTED' : ''; ?> >Style-5</option>
                    <option value="6" <?php echo $style_value == 6 ? 'SELECTED' : ''; ?> >Style-6</option>
                    <option value="7" <?php echo $style_value == 7 ? 'SELECTED' : ''; ?> >Style-7</option>
                    <option value="8" <?php echo $style_value == 8 ? 'SELECTED' : ''; ?> >Style-8</option>
                    <option value="99" <?php echo $style_value == 99 ? 'SELECTED' : ''; ?> >Style-99 (Add your own image / GIF)</option>
                </select>
                <label>Select Style for Mobile</label>
            </div>
        </div>
        
        <?php
    }


    // position to place 
    function share_ctc_position_cb() {
        $options = get_option('ht_ctc_share');

        $side_1 = ( '' == $options ) ? '' : esc_attr( $options['side_1'] );
        $side_2 = ( '' == $options ) ? '' : esc_attr( $options['side_2'] );
        $side_1_value = ( '' == $options ) ? '' : esc_attr( $options['side_1_value'] );
        $side_2_value = ( '' == $options ) ? '' : esc_attr( $options['side_2_value'] );
        ?>
        <!-- side - 1 -->
        <div class="row">
            <div class="input-field col s6">
                <select name="ht_ctc_share[side_1]" class="select-2">
                    <option value="bottom" <?php echo $side_1 == 'bottom' ? 'SELECTED' : ''; ?> >bottom</option>
                    <option value="top" <?php echo $side_1 == 'top' ? 'SELECTED' : ''; ?> >top</option>
                </select>
                <label>top / bottom </label>
            </div>

            <div class="input-field col s6">
                <input name="ht_ctc_share[side_1_value]" value="<?php echo $side_1_value ?>" id="side_1_value" type="text" class="input-margin">
                <label for="side_1_value">e.g. 10px</label>
            </div>
        </div>

        <!-- side - 2 -->
        <div class="row">
            <div class="input-field col s6">
                <select name="ht_ctc_share[side_2]" class="select-2">
                    <option value="right" <?php echo $side_2 == 'right' ? 'SELECTED' : ''; ?> >right</option>
                    <option value="left" <?php echo $side_2 == 'left' ? 'SELECTED' : ''; ?> >left</option>
                </select>
                <label>right / left </label>
            </div>

            <div class="input-field col s6">
                <input name="ht_ctc_share[side_2_value]" value="<?php echo $side_2_value ?>" id="side_2_value" type="text" class="input-margin">
                <label for="side_2_value">e.g. 10px</label>
            </div>
        </div>

        <p class="description">Add css units as suffix - e.g. 10px, 50% - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/position-to-place/">more info</a> </p>
        <?php
    }




    // If checked web / api whatsapp link. If unchecked wa.me links
    function share_ctc_webandapi_cb() {
        $options = get_option('ht_ctc_share');

        if ( isset( $options['webandapi'] ) ) {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_share[webandapi]" type="checkbox" value="1" <?php checked( $options['webandapi'], 1 ); ?> id="webandapi"   />
                    <span>Web WhatsApp on Desktop</span>
                </label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_share[webandapi]" type="checkbox" value="1" id="webandapi"   />
                    <span>Web WhatsApp on Desktop</span>
                </label>
            </p>
            <?php
        }
        ?>
        <p class="description">If checked opens Web.WhatsApp directly on Desktop and in mobile WhatsApp App - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/web-whatsapp/">more info</a> </p>
        <br>

        <?php
    }




    // show/hide 
    function share_show_hide_cb() {

        $dbrow = 'ht_ctc_share';
        $options = get_option('ht_ctc_share');

        include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-show-hide.php';

    }


    function share_shortcode_cb() {
        ?>
        <p class="description">Shortcodes for Share: [ht-ctc-share] - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/shortcodes-share">more info</a></p>
        <?php
    }






    /**
     * Sanitize each setting field as needed
     *
     * @since 2.0
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $new_input = array();

        foreach ($input as $key => $value) {

            if ( 'side_1_value' == $key ) {
                if ( is_numeric($input[$key]) ) {
                    $input[$key] = $input[$key] . 'px';
                }
                if ( '' == $input[$key] ) {
                    $input[$key] = '0px';
                }
                $new_input[$key] = sanitize_text_field( $input[$key] );
            } elseif ( 'side_2_value' == $key ) {
                if ( is_numeric($input[$key]) ) {
                    $input[$key] = $input[$key] . 'px';
                }
                if ( '' == $input[$key] ) {
                    $input[$key] = '0px';
                }
                $new_input[$key] = sanitize_text_field( $input[$key] );
            } elseif( isset( $input[$key] ) ) {
                $new_input[$key] = sanitize_text_field( $input[$key] );
            }
            
            
            // if( isset( $input[$key] ) ) {
            //     $new_input[$key] = sanitize_text_field( $input[$key] );
            // }
        }


        return $new_input;
    }


}

$ht_ctc_admin_share_page = new HT_CTC_Admin_Share_Page();

add_action('admin_menu', array($ht_ctc_admin_share_page, 'menu') );
add_action('admin_init', array($ht_ctc_admin_share_page, 'settings') );

endif; // END class_exists check

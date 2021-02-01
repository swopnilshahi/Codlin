<?php
/**
 * Main settings page - admin 
 * 
 * this main settings page contains .. 
 * 
 * enable options .. like chat default enabled, group, share, woocommerce
 * 
 * switch option
 * 
 * @package ctc
 * @subpackage admin
 * @since 2.0 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Main_Page' ) ) :

class HT_CTC_Admin_Main_Page {

    public function menu() {

        add_menu_page(
            'Click to Chat - New Interface - Plugin Option Page',
            'Click to Chat',
            'manage_options',
            'click-to-chat',
            array( $this, 'settings_page' ),
            'dashicons-format-chat'
        );
    }

    public function settings_page() {

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <!-- full row -->
            <div class="row">

                <div class="col s12 m12 xl7 options">
                    <form action="options.php" method="post" class="">
                        <?php settings_fields( 'ht_ctc_main_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_main_page_settings_sections_do' ) ?>
                        <?php submit_button() ?>
                    </form>
                </div>

                <!-- sidebar content -->
                <div class="col s12 m12 l7 xl4 ht-cc-admin-sidebar sticky-sidebar">
                    <?php include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-sidebar-content.php'; ?>
                </div>
                
            </div>

            <!-- new row - After settings page  -->
            <div class="row">
                <div class="col s12 m8 l4">
                    <div class="row">
                        <!-- after settings page / faq -->
                        <?php include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-after-settings-page.php'; ?>
                    </div>
                </div>
            </div>

        </div>

        <?php

    }


    public function settings() {


        
        // chat feautes
        $is_chat_enabled = get_option('ht_ctc_main_options');
		if ( isset( $is_chat_enabled['enable_chat'] ) ) {

            register_setting( 'ht_ctc_main_page_settings_fields', 'ht_ctc_chat_options' , array( $this, 'options_sanitize' ) );
        
            add_settings_section( 'ht_ctc_chat_page_settings_sections_add', '', array( $this, 'chat_settings_section_cb' ), 'ht_ctc_main_page_settings_sections_do' );

            add_settings_field( 'number', 'WhatsApp Number', array( $this, 'number_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'prefilled', 'Pre-Filled Message', array( $this, 'prefilled_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'cta', 'Call to Action', array( $this, 'cta_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'ctc_desktop_style', 'Style for Desktop', array( $this, 'ctc_desktop_style_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'ctc_mobile_style', 'Style for Mobile', array( $this, 'ctc_mobile_style_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'ctc_position', 'Position to place', array( $this, 'ctc_position_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'ctc_webandapi', 'Web WhatsApp', array( $this, 'ctc_webandapi_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            add_settings_field( 'ctc_show_hide', 'Display', array( $this, 'ctc_show_hide_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            
            if ( class_exists( 'WooCommerce' ) ) {
                add_settings_field( 'ctc_woo', 'WooCommerce', array( $this, 'ctc_woo_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );
            }
            add_settings_field( 'chat_shortcode', '', array( $this, 'chat_shortcode_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_chat_page_settings_sections_add' );

        }
        


        // main settings - options enable .. chat, group, share
        // switch options 
        register_setting( 'ht_ctc_main_page_settings_fields', 'ht_ctc_main_options' , array( $this, 'options_sanitize' ) );
        add_settings_section( 'ht_ctc_main_page_settings_sections_add', '', array( $this, 'main_settings_section_cb' ), 'ht_ctc_main_page_settings_sections_do' );
        
        add_settings_field( 'ctc_enable_features', 'Enable Features', array( $this, 'ctc_enable_features_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        
        $ccw_options = get_option('ccw_options');
		if ( isset( $ccw_options['number'] ) ) {
            // display this setting page only if user switched from previous interface.. ( for new users no switch option )
            register_setting( 'ht_ctc_main_page_settings_fields', 'ht_ctc_switch' , array( $this, 'options_sanitize' ) );
            add_settings_field( 'ht_ctc_switch', '', array( $this, 'ht_ctc_switch_cb' ), 'ht_ctc_main_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
		}
        
    }


    // WooCommerce related settings
    public function ctc_woo_cb() {
        do_action('ht_ctc_ah_chat_settings');
    }


    public function chat_settings_section_cb() {
        ?>
        <h1>Click to Chat ( New Interface )</h1>
        <br>
        <h1>Chat Settings</h1>
        <?php
    }


    // WhatsApp number
    function number_cb() {
        $options = get_option('ht_ctc_chat_options');
        $value = ( '' == $options ) ? '' : esc_attr( $options['number'] );
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_chat_options[number]" value="<?php echo $value ?>" id="whatsapp_number" type="text" class="input-margin tooltipped" data-position="top" data-tooltip="Country Code and Number">
                <label for="whatsapp_number">WhatsApp Number with Country Code</label>
                <!-- <span class="helper-text">Country code + number</span> -->
                <p class="description">Enter 'WhatsApp' or 'WhatsApp business' number with country code 
                <br> ( E.g. 916123456789 - herein e.g. 91 is country code, 6123456789 is the mobile number ) - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/whatsapp-number/">more info</a> ) </p>
            </div>
        </div>
        <?php
    }

    // pre-filled - message
    function prefilled_cb() {
        $options = get_option('ht_ctc_chat_options');
        $value = ( '' == $options ) ? '' : esc_attr( $options['pre_filled'] );
        $blogname = HT_CTC_BLOG_NAME;
        $placeholder = "Hello $blogname!! \nName: \nLike to know more information about {{title}}, {{url}}";
        ?>
        <div class="row">
            <div class="input-field col s12">
                <!-- <input name="ht_ctc_chat_options[pre_filled]" value="<?php // echo esc_attr( $options['pre_filled'] ) ?>" id="pre_filled" type="text" class="input-margin"> -->
                <textarea style="min-height: 84px;" placeholder="<?php echo $placeholder ?>" name="ht_ctc_chat_options[pre_filled]" id="pre_filled" class="materialize-textarea input-margin"><?php echo $value ?></textarea>
                <label for="pre_filled">Pre-filled message</label>
                <p class="description">Text that appears in the WhatsApp Chat window. Add variables {site}, {url}, {title} to replace with site name, current webpage URL, Post title - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/pre-filled-message/">more info</a> </p>
            </div>
        </div>
        <?php
    }

    // call to action 
    function cta_cb() {
        $options = get_option('ht_ctc_chat_options');
        $value = ( '' == $options ) ? '' : esc_attr( $options['call_to_action'] );
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_chat_options[call_to_action]" value="<?php echo $value ?>" id="call_to_action" type="text" class="input-margin">
                <label for="call_to_action">Call to Action</label>
                <p class="description"> Text that appears along with WhatsApp icon/button - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/call-to-action/">more info</a> </p>
                <p class="description">Style 1, 4, 6, 8 displays by default, Style 2, 5, 7 displays only on hover. Style-99 its your own image</p>
            </div>
        </div>
        <?php
    }


    // Desktop - select style 
    function ctc_desktop_style_cb() {
        $options = get_option('ht_ctc_chat_options');
        $style_value = ( '' == $options ) ? '' : esc_attr( $options['style_desktop'] );
        ?>
        <div class="row">
            <div class="input-field col s12" style="margin-bottom: 0px;">
                <select name="ht_ctc_chat_options[style_desktop]" class="select-2">
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

        <!-- <p class="description"><a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/list-of-styles/"><span class="dashicons dashicons-list-view"></span> List of styles</a> </p>
        <p class="description">Customize the styles   ( Click to Chat -> <a target="_blank" href="<?php echo admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>"><span class="dashicons dashicons-admin-customizer"></span>Customize Styles</a> ) </p> -->
        <?php
    }   


    // Mobile - select style 
    function ctc_mobile_style_cb() {
        $options = get_option('ht_ctc_chat_options');
        $style_value = ( '' == $options ) ? '' : esc_attr( $options['style_mobile'] );
        ?>
        <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12">
                <select name="ht_ctc_chat_options[style_mobile]" class="select-2">
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
        
        <p class="description"><a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/list-of-styles/">
        <!-- <span class="dashicons dashicons-list-view"></span> -->
         List of styles</a> </p>
        <p class="description" class="z-depth-4" style="border-left: 5px solid yellowgreen; padding-left: 12px;">Customize the styles   ( Click to Chat -> <a target="_blank" href="<?php echo admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>">
        <!-- <span class="dashicons dashicons-admin-customizer"></span> -->
        Customize Styles</a> ) </p>
        <br>
        <?php
    }


    // position to place 
    function ctc_position_cb() {
        $options = get_option('ht_ctc_chat_options');
        $side_1 = ( '' == $options ) ? '' : esc_attr( $options['side_1'] );
        $side_1_value = ( '' == $options ) ? '' : esc_attr( $options['side_1_value'] );
        $side_2 = ( '' == $options ) ? '' : esc_attr( $options['side_2'] );
        $side_2_value = ( '' == $options ) ? '' : esc_attr( $options['side_2_value'] );

        
        do_action('ht_ctc_ah_before_position_to_place');

        ?>
        <!-- side - 1 -->
        <div class="row">
            <div class="input-field col s6">
                <select name="ht_ctc_chat_options[side_1]" class="select-2">
                    <option value="bottom" <?php echo $side_1 == 'bottom' ? 'SELECTED' : ''; ?> >bottom</option>
                    <option value="top" <?php echo $side_1 == 'top' ? 'SELECTED' : ''; ?> >top</option>
                </select>
                <label>top / bottom </label>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_chat_options[side_1_value]" value="<?php echo $side_1_value ?>" id="side_1_value" type="text" class="input-margin">
                <label for="side_1_value">e.g. 10px</label>
            </div>
        </div>


        <!-- side - 2 -->
        <div class="row">
            <div class="input-field col s6">
                <select name="ht_ctc_chat_options[side_2]" class="select-2">
                    <option value="right" <?php echo $side_2 == 'right' ? 'SELECTED' : ''; ?> >right</option>
                    <option value="left" <?php echo $side_2 == 'left' ? 'SELECTED' : ''; ?> >left</option>
                </select>
                <label>right / left</label>
            </div>

            <div class="input-field col s6">
                <input name="ht_ctc_chat_options[side_2_value]" value="<?php echo $side_2_value ?>" id="side_2_value" type="text" class="input-margin">
                <label for="side_2_value">e.g. 10px</label>
            </div>
        </div>

        <p class="description">Add css units as suffix - e.g. 10px, 50% - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/position-to-place/">more info</a> </p>
        
        <?php
        
        do_action('ht_ctc_ah_after_position_to_place');

    }


    // If checked web / api whatsapp link. If unchecked wa.me links
    function ctc_webandapi_cb() {
        $options = get_option('ht_ctc_chat_options');

        if ( isset( $options['webandapi'] ) ) {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_chat_options[webandapi]" type="checkbox" value="1" <?php checked( $options['webandapi'], 1 ); ?> id="webandapi"   />
                    <span>Web WhatsApp on Desktop</span>
                </label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_chat_options[webandapi]" type="checkbox" value="1" id="webandapi"   />
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
    function ctc_show_hide_cb() {

        $dbrow = 'ht_ctc_chat_options';
        $options = get_option('ht_ctc_chat_options');

        include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-show-hide.php';

    }



    function chat_shortcode_cb() {
        ?>
        <p class="description">Shortcodes for Chat: [ht-ctc-chat] - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/shortcodes-chat">more info</a></p>
        <?php
    }





    /**
     * Enable featues .. 
     * 
     */
    public function main_settings_section_cb() {
        ?>
        <h1>Enable features</h1>
        <?php
    }




    // Enable Features
    function ctc_enable_features_cb() {

        $options = get_option('ht_ctc_main_options');

        ?>

        <ul class="collapsible">
        <li>
        <div class="collapsible-header">Enable features ( Chat, Share, Group, others )</div>
        <div class="collapsible-body">

        <!-- not make empty table -->
        <input name="ht_ctc_main_options[hello]" value="hello" id="" type="text" class="hide" >

        <?php

        // enable chat
        if ( isset( $options['enable_chat'] ) ) {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_main_options[enable_chat]" type="checkbox" value="1" <?php checked( $options['enable_chat'], 1 ); ?> id="enable_chat" />
                    <span>Enable WhatsApp Chat Features</span>
                </label>
                <!-- <p class="description">  - <a href="<?php echo admin_url( 'admin.php?page=click-to-chat-chat-feature' ); ?>">Chat Settings page</a> </p> -->
            </p>
            <?php
            } else {
                ?>
                <p>
                    <label>
                        <input name="ht_ctc_main_options[enable_chat]" type="checkbox" value="1" id="enable_chat" />
                        <span>Enable WhatsApp Chat Features</span>
                    </label>
                </p>
                <?php
            }
            ?>
            <p class="description">  - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/enable-chat">more info</a> </p>
            <br>
            <?php
    
    
            // enable group
            if ( isset( $options['enable_group'] ) ) {
                ?>
                <p>
                    <label>
                        <input name="ht_ctc_main_options[enable_group]" type="checkbox" value="1" <?php checked( $options['enable_group'], 1 ); ?> id="enable_group" />
                        <span>Enable Group Features</span>
                    </label>
                    <p class="description">  - <a href="<?php echo admin_url( 'admin.php?page=click-to-chat-group-feature' ); ?>">Group Settings page</a> </p>
                </p>
                <?php
                } else {
                    ?>
                    <p>
                        <label>
                            <input name="ht_ctc_main_options[enable_group]" type="checkbox" value="1" id="enable_group" />
                            <span>Enable Group Features</span>
                        </label>
                    </p>
                    <?php
                }
                ?>
                <p class="description">  - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/enable-group">more info</a> </p>
                <br>
                <?php
    
    
                // enable share
                if ( isset( $options['enable_share'] ) ) {
                ?>
                <p>
                    <label>
                        <input name="ht_ctc_main_options[enable_share]" type="checkbox" value="1" <?php checked( $options['enable_share'], 1 ); ?> id="enable_share" />
                        <span>Enable Share Features</span>
                    </label>
                    <p class="description">  - <a href="<?php echo admin_url( 'admin.php?page=click-to-chat-share-feature' ); ?>">Share Settings page</a> </p>
                </p>
                <?php
                } else {
                    ?>
                    <p>
                        <label>
                            <input name="ht_ctc_main_options[enable_share]" type="checkbox" value="1" id="enable_share" />
                            <span>Enable Share Features</span>
                        </label>
                    </p>
                    <?php
                }
                ?>
                <p class="description">  - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/enable-share">more info</a> </p>
                <br>
        <?php

        // Google Analytics
        if ( isset( $options['google_analytics'] ) ) {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_main_options[google_analytics]" type="checkbox" value="1" <?php checked( $options['google_analytics'], 1 ); ?> id="google_analytics" />
                    <span>Google Analytics</span>
                </label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_main_options[google_analytics]" type="checkbox" value="1" id="google_analytics" />
                    <span>Google Analytics</span>
                </label>
            </p>
            <?php
            }
            ?>
            <p class="description">If Google Analytics installed creates an Event there - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/google-analytics/">more info</a> </p>
            <br>


            <?php

            // Facebook Pixel
            if ( isset( $options['fb_pixel'] ) ) {
                ?>
                <p>
                    <label>
                        <input name="ht_ctc_main_options[fb_pixel]" type="checkbox" value="1" <?php checked( $options['fb_pixel'], 1 ); ?> id="fb_pixel" />
                        <span>Facebook Pixel</span>
                    </label>
                </p>
                <?php
            } else {
                ?>
                <p>
                    <label>
                        <input name="ht_ctc_main_options[fb_pixel]" type="checkbox" value="1" id="fb_pixel" />
                        <span>Facebook Pixel</span>
                    </label>
                </p>
                <?php
                }
                ?>
                <p class="description">If Facebook Pixel installed creates an Event there - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/facebook-pixel/">more info</a> </p>
                <br>


            </div>
            </div>
            </li>
            <ul>

            <?php
    }



    // switch interface
    function ht_ctc_switch_cb() {
        $options = get_option('ht_ctc_switch');
        $interface_value = esc_attr( $options['interface'] );
        ?>
        <!-- <br><br><br><br><br><br><br><br> -->
        <ul class="collapsible">
        <li>
        <div class="collapsible-header">Switch Interface</div>
        <div class="collapsible-body">

        <p class="description">If you are convenient with the previous interface in comparison to the new one, please switch to previous interface</p>
        <br><br>
        <div class="row">
            <div class="input-field col s12" style="margin-bottom: 0px;">
                <select name="ht_ctc_switch[interface]" class="select-2">
                    <option value="no" <?php echo $interface_value == 'no' ? 'SELECTED' : ''; ?> >Previous Interface</option>
                    <option value="yes" <?php echo $interface_value == 'yes' ? 'SELECTED' : ''; ?> >New Interface</option>
                </select>
                <label>Switch Interface</label>
            </div>
        <!-- <p class="description">If you are convenient with the previous interface in comparison to the new one, please switch to previous interface</p> -->
        </div>

        </div>
        </div>
        </li>
        <ul>

        <?php
    }

    
    


    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $new_input = array();

        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {

                if ( 'pre_filled' == $key ) {
                    // $new_input[$key] = esc_textarea( $input[$key] );
                    $new_input[$key] = sanitize_textarea_field( $input[$key] );
                } elseif ( 'side_1_value' == $key ) {
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
                } else {
                    $new_input[$key] = sanitize_text_field( $input[$key] );
                }
            }
        }


        return $new_input;
    }


}

$ht_ctc_admin_main_page = new HT_CTC_Admin_Main_Page();

add_action('admin_menu', array($ht_ctc_admin_main_page, 'menu') );
add_action('admin_init', array($ht_ctc_admin_main_page, 'settings') );

endif; // END class_exists check

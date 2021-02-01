<?php
/**
 * set default values
 * 
 * ccw_plugin_details - this values will be overrides 
 * 
 * @package ccw
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * table name: "ccw_options"
 * enable, enable_sc  -  2 - enable, 1 - disable
 */
$values = array(
    'enable' => '2',
    'enable_sc' => '2',
    'number' => '',
    'initial' => '',
    'input_placeholder' => 'WhatsApp us',
    'position' => '1',
    'style' => '9',
    'stylemobile' => '3',
    'position-1_bottom' => '10px',
    'position-1_right' => '10px',
    'position-2_bottom' => '10px',
    'position-2_left' => '10px',
    'position-3_top' => '10px',
    'position-3_left' => '10px',
    'position-4_top' => '10px',
    'position-4_right' => '10px',
    'list_hideon_pages' => '',
    'list_hideon_cat' => '',
    'shortcode' => 'chat',
    'return_type' => 'chat',  // chat or group_chat 
    'group_id' => '',

);
$db_values = get_option( 'ccw_options', array() );
$update_values = array_merge($values, $db_values);

if ( isset( $update_values['number'] ) ) {

    $pre_number = $update_values['number'];
    if ( '919494429789' == $pre_number || '919908469612' == $pre_number || '918897606725' == $pre_number ) {
        $update_values['number'] = '';
    }
}
update_option('ccw_options', $update_values);

/**
 * table name  - "ccw_options_cs"
 * 
 * customize styles - options page
 * 
 * @var string an_on_hover
 *  - if yes - adds 'ccw-an' to styles
 *     - added animations based on ccw-an at javascript
 */
$values_cs = array(
    's1_text_color' => '#9e9e9e',
    's1_text_color_onfocus' => '#26a69a',
    's1_border_color' => '#9e9e9e',
    's1_border_color_onfocus' => '#26a69a',
    's1_submit_btn_color' => '#26a69a',
    's1_submit_btn_text_and_icon_color' => '#ffffff',
    's1_width' => 'auto',
    's1_btn_text' => 'Submit',
    's2_text_color' => 'initial',
    's2_text_color_onhover' => 'initial',
    's2_decoration' => 'initial',
    's2_decoration_onhover' => 'initial',
    's3_icon_size' => '34px',
    's4_text_color' => 'rgba(0, 0, 0, 0.6)',
    's4_background_color' => '#e4e4e4',
    's5_color' => '#25D366',
    's5_hover_color' => '#00e51e',
    's5_icon_size' => '24px',
    's6_color' => '#ffffff',
    's6_hover_color' => '#000',
    's6_icon_size' => '24px',
    's6_circle_background_color' => '#25D366',
    's6_circle_background_hover_color' => '#00e51e',
    's6_circle_height' => '48px',
    's6_circle_width' => '48px',
    's6_line_height' => '48px',
    's7_color' => '#ffffff',
    's7_hover_color' => '#000',
    's7_icon_size' => '24px',
    's7_box_background_color' => '#25D366',
    's7_box_background_hover_color' => '#00e51e',
    's7_box_height' => '48px',
    's7_box_width' => '48px',
    's7_line_height' => '48px',
    's8_text_color' => '#ffffff',
    's8_background_color' => '#26a69a',
    's8_icon_color' => '#ffffff',
    's8_text_color_onhover' => '#ffffff',
    's8_background_color_onhover' => '#26a69a',
    's8_icon_color_onhover' => '#ffffff',
    's8_icon_float' => 'right',
    's8_1_width' => '',
    's9_icon_size' => '48px',
    's99_img_height_desktop' => '99px',
    's99_img_width_desktop' => '',
    's99_img_height_mobile' => '50px',
    's99_img_width_mobile' => '',
    's99_desktop_img' => '',
    's99_mobile_img' => '',

    // 'an_enable' => 'no',
    'an_on_load' => 'no-animation',
    'an_on_hover' => 'ccw-no-hover-an',
    
);

$db_values_cs = get_option( 'ccw_options_cs', array() );
$update_values_cs = array_merge($values_cs, $db_values_cs);
update_option('ccw_options_cs', $update_values_cs);

/**
 * Google Analytics
 * option  - ht_ccw_ga
 */
$ccw_ga = array(
    'ga_category' => 'Click to Chat for WhatsApp',
    'ga_action' => 'Click',
    'ga_label' => '{{url}}',
);
$db_ccw_ga = get_option( 'ht_ccw_ga', array() );
$update_ccw_ga = array_merge($ccw_ga, $db_ccw_ga);
update_option('ht_ccw_ga', $update_ccw_ga);

/**
 * fb Analytics
 * option  - ht_ccw_fb
 */
$ccw_fb = array(
    'fb_event_name' => 'Click to Chat Event',
    'p1_name' => 'Category',
    'p2_name' => 'Action',
    'p3_name' => 'Label',
    'p1_value' => 'Click to Chat',
    'p2_value' => 'Click',
    'p3_value' => '{{url}}',
);
$db_ccw_fb = get_option( 'ht_ccw_fb', array() );
$update_ccw_fb = array_merge($ccw_fb, $db_ccw_fb);
update_option('ht_ccw_fb', $update_ccw_fb);

// plugin details 
$plugin_details = array(
    'version' => HT_CTC_VERSION,
);
// Always use update_option - override new values .. don't preseve already existing values
update_option( 'ccw_plugin_details', $plugin_details );

/**
 * for new interface.. in advance..
 */
function new_options() {

    $new_options = get_option( 'ht_ctc_chat_options' );

    if ( ! isset( $new_options['number'] ) ) {

        $options = get_option( 'ccw_options' );
        $number = esc_attr( $options['number'] );
        $pre_filled = esc_attr( $options['initial'] );
        $call_to_action = esc_attr( $options['input_placeholder'] );
        
        $ctc_values = array(
            'number' => $number,
            'pre_filled' => $pre_filled,
            'call_to_action' => $call_to_action,

        );

        $db_ctc_values = get_option( 'ht_ctc_chat_options', array() );
        $update_ctc_values = array_merge($ctc_values, $db_ctc_values);
        update_option('ht_ctc_chat_options', $update_ctc_values);

    }

}

new_options();


/**
 * name: ht_ctc_switch 
 * 
 * interface - option - yes new interface, no previous interface
 * 
 * This have to run in previous interface also as 1.8, 1.8., 1.8.2 beta versions released 
 * as switch option is a check option
 * 
 */
function ht_ctc_switch() {

    // here in prev inteface set default as 'no'
    $interface = 'no';

    // in 1.8.1, 1.8.2 beta releases used switch option as a checklist
    $ccw_options = get_option('ccw_options');
    if ( isset ( $ccw_options['switch_to_new'] ) ) {
        $interface = 'yes';
    }

    // plugin details 
    $values = array(
        'interface' => $interface,
    );


    $db_values = get_option( 'ht_ctc_switch', array() );
    $update_values = array_merge($values, $db_values);
    update_option('ht_ctc_switch', $update_values);

}

ht_ctc_switch();
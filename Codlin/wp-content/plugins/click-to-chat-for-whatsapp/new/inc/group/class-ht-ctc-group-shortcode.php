<?php
/**
* shortcodes 
* for list of attribute support check  -> shortcode_atts ( $a )
*
* @package chat
* @since 2.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Group_Shortcode' ) ) :
    
class HT_CTC_Group_Shortcode {


    //  Register shortcode
    public function shortcodes_init() {
        add_shortcode( 'ht-ctc-group', array( $this, 'shortcode' ) );
    }

    // call back function - shortcode 
    public function shortcode( $atts = [], $content = null, $shortcode = '' ) {

        $options = get_option('ht_ctc_group');
        // $main_options = ht_ctc()->values->ctc_main_options;
        $main_options = get_option( 'ht_ctc_main_options' );

        $group_id = esc_attr( $options['group_id'] );
        $call_to_action_db = esc_attr( $options['call_to_action'] );

        $group_id = __( $group_id , 'click-to-chat-for-whatsapp' );
        $call_to_action = __( $call_to_action_db , 'click-to-chat-for-whatsapp' );

        $style_desktop = esc_attr( $options['style_desktop'] );
        $style_mobile = esc_attr( $options['style_mobile'] );

        $is_mobile = ht_ctc()->device_type->is_mobile();

        $style = $style_desktop;;
        if ( 'yes' == $is_mobile ) {
            $style = $style_mobile;
        }

        // $content = do_shortcode($content);

        // $ccw_options_cs = get_option('ccw_options_cs');
        //  use like  $ccw_options_cs['']
        
        $a = shortcode_atts(
            array(
                'group_id' => $group_id,
                'call_to_action' => $call_to_action,
                'style' => $style,
                
                'position' => '',
                'top' => '',
                'right' => '',
                'bottom' => '',
                'left' => '',
                'home' => '',  // home -  to hide on experts .. 
                'hide_mobile' => '',
                'hide_desktop' => '',
                // 'inline_issue' => '',

                's5_img_position' => '',  //left, right
                's8_width' => '',
                's8_icon_position' => '',  // left, right, hide
                
            ), $atts, $shortcode );
        // use like -  '.$a["title"].'   
        
        // group_id
        $group_id   = $a["group_id"];
    
        // hide on devices
        // if 'yes' then hide
        $hide_mobile = $a["hide_mobile"];
        $hide_desktop = $a["hide_desktop"];
        
        if( 'yes' == $is_mobile ) {
            if ( 'yes' == $hide_mobile ) {
                return;
            }
        } else {
            if ( 'yes' == $hide_desktop ) {
                return;
            }
        }
        
        $position   = $a["position"];
        $top        = $a["top"];
        $right      = $a["right"];
        $bottom     = $a["bottom"];
        $left       = $a["left"];
        
        $css = '';

        if ( '' !== $position ) {
            $css .= 'position:'.$position.';';
        }
        if ( '' !== $top ) {
            $css .= 'top:'.$top.';';
        }
        if ( '' !== $right ) {
            $css .= 'right:'.$right.';';
        }
        if ( '' !== $bottom ) {
            $css .= 'bottom:'.$bottom.';';
        }
        if ( '' !== $left ) {
            $css .= 'left:'.$left.';';
        }

        // to hide styles in home page
        $home       = $a["home"];

        // $position !== 'fixed' why !== to avoid double time adding display: none .. 
        if ( 'fixed' !== $position && 'hide' == $home && ( is_home() || is_category() || is_archive() ) ) {
                $css .= 'display:none;';
        }

        // By default postion: fixed style hide on home screen, 
        // if plan to show, then add hide='show' ( actually something not equal to 'hide' )
        if ( 'fixed' == $position && 'show' !== $home &&  ( is_home() || is_category() || is_archive() ) ) {
            $css .= 'display:none;';
        }

        $link = "https://chat.whatsapp.com/$group_id";
        $return_type = "group";

        // call to action
        $call_to_action   = $a["call_to_action"];
        
        $style = $a["style"];
        
        $class_names = "ht-ctc-sc ht-ctc-sc-group sc-style-$style";

        // analytics
        $is_ga_enable = apply_filters( 'ht_ctc_fh_is_ga_enable', 'no' );
        $is_fb_pixel = apply_filters( 'ht_ctc_fh_is_fb_pixel', 'no' );
        $is_fb_an_enable = apply_filters( 'ht_ctc_fh_is_fb_an_enable', 'no' );


        $o = '';

        // shortcode template file path
        $sc_path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles-shortcode/sc-style-' . $style. '.php';

        if ( is_file( $sc_path ) ) {
            $o .= '<div onclick="ht_ctc_shortcode_click(this);" data-ctc-link="'.$link.'" data-return_type="'.$return_type.'" data-group_id="'.$group_id.'" data-is_ga_enable="'.$is_ga_enable.'" data-is_fb_pixel="'.$is_fb_pixel.'" data-is_fb_an_enable="'.$is_fb_an_enable.'" style="display: inline; cursor: pointer; z-index: 99999999; '.$css.'" class="'.$class_names.' ht-ctc-inline">';
            include $sc_path;
            $o .= '</div>';
        } else {
            // if style is not in the list.. 
            $img_link = plugins_url("./new/inc/assets/img/whatsapp-logo.svg", HT_CTC_PLUGIN_FILE );
            $o .= '<div onclick="ht_ctc_shortcode_click(this);" data-ctc-link="'.$link.'" data-return_type="'.$return_type.'" data-is_ga_enable="'.$is_ga_enable.'" data-is_fb_pixel="'.$is_fb_pixel.'" data-is_fb_an_enable="'.$is_fb_an_enable.'" style="display: inline; cursor: pointer; z-index: 99999999; '.$css.'" class="'.$class_names.' ht-ctc-inline">';
            $o .= '<img class="img-icon-sc sc_item pointer style-3-sc" src="'.$img_link.'" alt="WhatsApp chat" style="height: 50px; '.$css.' " >';
            $o .= '</div>';
        }

        return $o;
    }

}

$shortcode = new HT_CTC_Group_Shortcode();

add_action('init', array( $shortcode, 'shortcodes_init' ) );

endif; // END class_exists check
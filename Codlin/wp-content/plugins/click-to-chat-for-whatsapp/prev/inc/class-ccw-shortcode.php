<?php
/**
* shortcodes 
* base shortcode name is [chat]
* for list of attribute support check  -> shortcode_atts ( $a )
*
* @package ccw
* @since 1.0
*/    

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Shortcode' ) ) :
    
class CCW_Shortcode {


    //  Register shortcode
    public function ccw_shortcodes_init() {
        $shortcode_name = esc_attr( ht_ccw()->variables->get_option['shortcode'] );
        // add_shortcode('chat', 'shortcode');
        add_shortcode( $shortcode_name, array( $this, 'shortcode' ) );
    }

    // call back function - shortcode 
    public function shortcode( $atts = [], $content = null, $shortcode = '' ) {

        $values = ht_ccw()->variables->get_option;

        $enable_sc = esc_attr( $values['enable_sc'] );
        $global_num = esc_attr( $values['number'] );
        $val = esc_attr( $values['input_placeholder'] );
        $style_val = esc_attr( $values['style'] );

        $return_type = esc_attr( $values['return_type'] );
        $group_id = esc_attr( $values['group_id'] );

        $prefill_text = esc_attr( $values['initial'] );


        /**
         * there is an advantage if return here - 
         *  instead of doing this before loading this file.
         * 
         * now the shortcode exists - what ever
         * If return here - 
         *   there is no content for that
         *   so shortcode added in post will be hide / null.
         */
        if( 1 == $enable_sc ) {
            return;
        }

            
        // $content = do_shortcode($content);

        $ccw_options_cs = get_option('ccw_options_cs');
        //  use like  $ccw_options_cs['']
        
        $a = shortcode_atts(
            array(
                'num' => $global_num,
                'val' => $val,
                'style' => $style_val,
                'text' => $prefill_text,
                'position' => '',
                'top' => '',
                'right' => '',
                'bottom' => '',
                'left' => '',
                'home' => '',  // home -  to hide on experts .. 
                'hide_mobile' => '',
                'hide_desktop' => '',
                'inline_issue' => '',

                'type' => $return_type,   // type= group_chat  or ( chat or any thing )
                'group_id' => $group_id,  // group chat id .. 
                
                's1_text_color' => esc_attr( $ccw_options_cs['s1_text_color'] ),
                's1_text_color_onfocus' => esc_attr( $ccw_options_cs['s1_text_color_onfocus'] ),
                's1_border_color' => esc_attr( $ccw_options_cs['s1_border_color'] ),
                's1_border_color_onfocus' => esc_attr( $ccw_options_cs['s1_border_color_onfocus'] ),
                's1_submit_btn_color' => esc_attr( $ccw_options_cs['s1_submit_btn_color'] ),
                's1_submit_btn_text_and_icon_color' => esc_attr( $ccw_options_cs['s1_submit_btn_text_and_icon_color'] ),
                's1_width' => esc_attr( $ccw_options_cs['s1_width'] ),

                's1_btn_text' => esc_attr( $ccw_options_cs['s1_btn_text'] ),
            
                's2_text_color' => esc_attr( $ccw_options_cs['s2_text_color'] ),
                's2_text_color_onhover' => esc_attr( $ccw_options_cs['s2_text_color_onhover'] ),
                's2_decoration' => esc_attr( $ccw_options_cs['s2_decoration'] ),
                's2_decoration_onhover' => esc_attr( $ccw_options_cs['s2_decoration_onhover'] ),
                
                's3_icon_size' => esc_attr( $ccw_options_cs['s3_icon_size'] ),
            
                's4_text_color' => esc_attr( $ccw_options_cs['s4_text_color'] ),
                's4_background_color' => esc_attr( $ccw_options_cs['s4_background_color'] ),
            
                's5_color' => esc_attr( $ccw_options_cs['s5_color'] ),
                's5_hover_color' => esc_attr( $ccw_options_cs['s5_hover_color'] ),
                's5_icon_size' => esc_attr( $ccw_options_cs['s5_icon_size'] ),
                
                's6_color' => esc_attr( $ccw_options_cs['s6_color'] ),
                's6_hover_color' => esc_attr( $ccw_options_cs['s6_hover_color'] ),
                's6_icon_size' => esc_attr( $ccw_options_cs['s6_icon_size'] ),
                's6_circle_background_color' => esc_attr( $ccw_options_cs['s6_circle_background_color'] ),
                's6_circle_background_hover_color' => esc_attr( $ccw_options_cs['s6_circle_background_hover_color'] ),
                's6_circle_height' => esc_attr( $ccw_options_cs['s6_circle_height'] ),
                's6_circle_width' => esc_attr( $ccw_options_cs['s6_circle_width'] ),
                's6_line_height' => esc_attr( $ccw_options_cs['s6_line_height'] ),
            
                's7_color' => esc_attr( $ccw_options_cs['s7_color'] ),
                's7_hover_color' => esc_attr( $ccw_options_cs['s7_hover_color'] ),
                's7_icon_size' => esc_attr( $ccw_options_cs['s7_icon_size'] ),
                's7_box_background_color' => esc_attr( $ccw_options_cs['s7_box_background_color'] ),
                's7_box_background_hover_color' => esc_attr( $ccw_options_cs['s7_box_background_hover_color'] ),
                's7_box_height' => esc_attr( $ccw_options_cs['s7_box_height'] ),
                's7_box_width' => esc_attr( $ccw_options_cs['s7_box_width'] ),
                's7_line_height' => esc_attr( $ccw_options_cs['s7_line_height'] ),
            
                's8_text_color' => esc_attr( $ccw_options_cs['s8_text_color'] ),
                's8_background_color' => esc_attr( $ccw_options_cs['s8_background_color'] ),
                's8_icon_color' => esc_attr( $ccw_options_cs['s8_icon_color'] ),
                's8_text_color_onhover' => esc_attr( $ccw_options_cs['s8_text_color_onhover'] ),
                's8_background_color_onhover' => esc_attr( $ccw_options_cs['s8_background_color_onhover'] ),
                's8_icon_color_onhover' => esc_attr( $ccw_options_cs['s8_icon_color_onhover'] ),
                's8_icon_float' => esc_attr( $ccw_options_cs['s8_icon_float'] ),
                's8_1_width' => esc_attr( $ccw_options_cs['s8_1_width'] ),

                's9_icon_size' => esc_attr( $ccw_options_cs['s9_icon_size'] ),


                's99_img_height_desktop' => esc_attr( $ccw_options_cs['s99_img_height_desktop'] ),
                's99_img_width_desktop' => esc_attr( $ccw_options_cs['s99_img_width_desktop'] ),
                's99_img_height_mobile' => esc_attr( $ccw_options_cs['s99_img_height_mobile'] ),
                's99_img_width_mobile' => esc_attr( $ccw_options_cs['s99_img_width_mobile'] ),
                's99_desktop_img' => esc_attr( $ccw_options_cs['s99_desktop_img'] ),
                's99_mobile_img' => esc_attr( $ccw_options_cs['s99_mobile_img'] ),
                
                
            ), $atts, $shortcode );
        // use like -  '.$a["title"].'   
        

        $num   = $a["num"];

        // initial text
        $page_url = get_permalink();
        $text = $a["text"];
        $initial_text = str_replace( '{{url}}', $page_url, $text );;

    
        //  if it is mobile device , or tab is_mobile is 1, if not 2 or any thing 
        $is_mobile = ht_ccw()->device_type->is_mobile;

        // hide based on device type
        // "string" true or "true" not boolean - boolean means is exists like ..
        $hide_mobile = $a["hide_mobile"];
        $hide_desktop = $a["hide_desktop"];

        $redirect = "";

        $is_group = $a["type"];
        $group_id = $a["group_id"];

        /**
         * If type = group_chat , then only it consider as group chat,
         * if type = chat or any thing else, consider as chat. ( default is chat )
         */
        if( 1 == $is_mobile ) {

            if ( "true" == $hide_mobile ) {
                return;
            }

            if ( 'group_chat' == $is_group ) {
                $img_click_link = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
                $redirect_a = "https://chat.whatsapp.com/$group_id";
            } else {
                $img_click_link = "window.open('https://api.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
                $redirect_a = "https://api.whatsapp.com/send?phone=$num&text=$initial_text";
            }
        } else {

            if ( "true" == $hide_desktop ) {
                return;
            }

            if ( isset( $values['app_first'] ) ) {

                // App First - so mobile based url
                if ( 'group_chat' == $is_group ) {
                    $img_click_link = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
                    $redirect_a = "https://chat.whatsapp.com/$group_id";
                } else {
                    $img_click_link = "window.open('https://api.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
                    $redirect_a = "https://api.whatsapp.com/send?phone=$num&text=$initial_text";
                }

            } else {
                
                // General - Desktop url
                if ( 'group_chat' == $is_group ) {
                    $img_click_link = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
                    $redirect_a = "https://chat.whatsapp.com/$group_id";
                } else {
                    $img_click_link = "window.open('https://web.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
                    $redirect_a = "https://web.whatsapp.com/send?phone=$num&text=$initial_text";
                }
            }

            
        }


        $position   = $a["position"];
        $top        = $a["top"];
        $right      = $a["right"];
        $bottom     = $a["bottom"];
        $left       = $a["left"];
        $home       = $a["home"];
        
        
        
        // style - 9 - green square
        $img_link_s9 = plugins_url("./new/inc/assets/img/whatsapp-icon-square.svg", HT_CTC_PLUGIN_FILE );

        
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
        // $position !== 'fixed' why !== to avoid double time adding display: none .. 
        if ( 'fixed' !== $position && 'hide' == $home && ( is_home() || is_category() || is_archive() ) ) {
                $css .= 'display:none;';
        }

        // By default postion: fixed style hide on home screen, 
        // if plan to show, then add hide='show' ( actually something not equal to 'hide' )
        if ( 'fixed' == $position && 'show' !== $home &&  ( is_home() || is_category() || is_archive() ) ) {
            $css .= 'display:none;';
        }


        // to fix inline issue ..
        $inline_issue = '';
        if ( 'true' == $a["inline_issue"] ) {
            // if "true" adds inline_issue class name
            $inline_issue = 'inline_issue';
        }

        $style = $a["style"];

        if ( '4.1' == $style ) {
            $style = '4';
            $inline_issue = 'inline_issue';
        }

        $o = '';

        // shortcode template file path
        $sc_path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'prev/inc/commons/styles-list-sc/sc-style-' . $style. '.php';

        if ( is_file( $sc_path ) ) {
            include $sc_path;
        } else {
            $img_link = plugins_url("./new/inc/assets/img/whatsapp-logo.svg", HT_CTC_PLUGIN_FILE );
            $o .= '<div class="ccw_plugin">';
            $o .= '<img class="img-icon-sc sc_item pointer style-3-sc" src="'.$img_link.'" alt="WhatsApp chat" onclick="'.$img_click_link.'" style="height: 50px; '.$css.' " >';
            $o .= '</div>';
        }

        
        return $o;

    }


}


$shortcode = new CCW_Shortcode();

add_action('init', array( $shortcode, 'ccw_shortcodes_init' ) );

endif; // END class_exists check
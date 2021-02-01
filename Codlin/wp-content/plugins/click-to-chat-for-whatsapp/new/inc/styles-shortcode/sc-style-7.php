<?php
/**
 * icon with padding borderr
 */

if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_style('ht_ctc_font_css');

$s7_options = get_option( 'ht_ctc_s7' );


$s7_icon_size = esc_attr( $s7_options['s7_icon_size'] );
$s7_icon_color = esc_attr( $s7_options['s7_icon_color'] );
$s7_icon_color_hover = esc_attr( $s7_options['s7_icon_color_hover'] );
$s7_border_size = esc_attr( $s7_options['s7_border_size'] );
$s7_border_color = esc_attr( $s7_options['s7_border_color'] );
$s7_border_color_hover = esc_attr( $s7_options['s7_border_color_hover'] );
$s7_border_radius = esc_attr( $s7_options['s7_border_radius'] );


$s7_css = "font-size: $s7_icon_size; color: $s7_icon_color; padding: $s7_border_size; background-color: $s7_border_color; border-radius: $s7_border_radius;";

$input_onhover = "this.style.color='$s7_icon_color_hover', this.style.backgroundColor='$s7_border_color_hover'" ;
$input_onhover_out = "this.style.color='$s7_icon_color', this.style.backgroundColor='$s7_border_color'";


$o .=  '
    <span title="'.$call_to_action.'" class="ctc-icon ctc-icon-whatsapp2 ctc-analytics" id="s7-icon" style="'.$s7_css.'" 
    onmouseover = "'.$input_onhover.'" 
    onmouseout  = "'.$input_onhover_out.'"
    ></span>
';
<?php
/**
 * plain text link
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s6_options = get_option( 'ht_ctc_s6' );

$s6_txt_color = esc_attr( $s6_options['s6_txt_color'] );
$s6_txt_color_on_hover = esc_attr( $s6_options['s6_txt_color_on_hover'] );
$s6_txt_decoration = esc_attr( $s6_options['s6_txt_decoration'] );
$s6_txt_decoration_on_hover = esc_attr( $s6_options['s6_txt_decoration_on_hover'] );

$input_onhover = "this.style.color='$s6_txt_color_on_hover', this.style.textDecoration='$s6_txt_decoration_on_hover'";
$input_onhover_out = "this.style.color='$s6_txt_color', this.style.textDecoration='$s6_txt_decoration'";


$o .=  '
    <a class="ctc-analytics" style="color: '.$s6_txt_color.'; text-decoration: '.$s6_txt_decoration.';"
    onmouseover = "'.$input_onhover.'" 
    onmouseout  = "'.$input_onhover_out.'"
    >
    '.$call_to_action.'
    </a>
';
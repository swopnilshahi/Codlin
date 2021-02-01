<?php
/**
 * style 99 own image
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s99_options = get_option( 'ht_ctc_s99' );

$s99_desktop_img_height = esc_attr( $s99_options['s99_desktop_img_height'] );
$s99_desktop_img_width = esc_attr( $s99_options['s99_desktop_img_width'] );
$s99_mobile_img_height = esc_attr( $s99_options['s99_mobile_img_height'] );
$s99_mobile_img_width = esc_attr( $s99_options['s99_mobile_img_width'] );

// img url
// image - width, height based on device
$s99_img_css = "";


if( 'yes' == $is_mobile ) {

    $s99_own_image = esc_html( $s99_options['s99_mobile_img_url'] );

    if ( '' !== $s99_mobile_img_height ) {
        $s99_img_css .= "height: $s99_mobile_img_height; ";
    } else {
        $s99_img_css .= "height: 40px; ";
    }

    if ( '' !== $s99_mobile_img_width ) {
        $s99_img_css .= "width: $s99_mobile_img_width; ";
    }
} else {
    $s99_own_image = esc_html( $s99_options['s99_dekstop_img_url'] );

    if ( '' !== $s99_desktop_img_height ) {
        $s99_img_css .= "height: $s99_desktop_img_height; ";
    }   else {
        $s99_img_css .= "height: 50px; ";
    }
    
    if ( '' !== $s99_desktop_img_width ) {
        $s99_img_css .= "width: $s99_desktop_img_width; ";
    }
}

// fallback image
if ( '' == $s99_own_image ) {
    $s99_own_image = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );
}


$o .=  '
    <img class="own-img" title="'.$call_to_action.'" id="style-99" src="'.$s99_own_image.'" style="'.$s99_img_css.'" alt="WhatsApp chat">
';
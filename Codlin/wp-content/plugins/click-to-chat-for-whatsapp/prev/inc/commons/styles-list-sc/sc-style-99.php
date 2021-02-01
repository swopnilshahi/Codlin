<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$s99_img_height_desktop = $a['s99_img_height_desktop'];
$s99_img_width_desktop = $a['s99_img_width_desktop'];
$s99_img_height_mobile = $a['s99_img_height_mobile'];
$s99_img_width_mobile = $a['s99_img_width_mobile'];
$s99_desktop_img = $a['s99_desktop_img'];
$s99_mobile_img = $a['s99_mobile_img'];

// img url
// image - width, height based on device
$img_css = "";

if( 1 == $is_mobile ) {
    $own_image = $s99_mobile_img;

    if ( '' !== $s99_img_height_mobile ) {
        $img_css .= "height: $s99_img_height_mobile; ";
    }
    if ( '' !== $s99_img_width_mobile ) {
        $img_css .= "width: $s99_img_width_mobile; ";
    }
} else {
    $own_image = $s99_desktop_img;

    if ( '' !== $s99_img_height_desktop ) {
        $img_css .= "height: $s99_img_height_desktop; ";
    }
    
    if ( '' !== $s99_img_width_desktop ) {
        $img_css .= "width: $s99_img_width_desktop; ";
    }
}

if ( '' == $own_image ) {
    $own_image = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );
}


$o .= '<div class="ccw_plugin pointer '.$inline_issue.' " style='.$css.'>';
$o .= '<img class="own-img-sc inline ccw-analytics" id="style-99-sc" data-ccw="style-99-sc-own-image" style=" '.$img_css.' " src=" '.$own_image.' " onclick="'.$img_click_link.'" alt="WhatsApp chat">';
$o .= '</div>';
<?php

if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_style('ccw_mdstyle8_css');

$s8_text_color = $a['s8_text_color'];
$s8_background_color = $a['s8_background_color'];
$s8_icon_color = $a['s8_icon_color'];
$s8_text_color_onhover = $a['s8_text_color_onhover'];
$s8_background_color_onhover = $a['s8_background_color_onhover'];
$s8_icon_color_onhover = $a['s8_icon_color_onhover'];
$s8_icon_float = $a['s8_icon_float'];
$s8_1_width = $a['s8_1_width'];


$s8_text_color = $s8_text_color;
$s8_background_color = $s8_background_color;
$s8_icon_color = $s8_icon_color;
$s8_text_color_onhover = $s8_text_color_onhover;
$s8_background_color_onhover = $s8_background_color_onhover;
$s8_icon_color_onhover = $s8_icon_color_onhover;
$s8_icon_float = $s8_icon_float;

$input_onhover = "this.style.backgroundColor= '$s8_background_color_onhover', this.childNodes[1].style.color= '$s8_icon_color_onhover', this.childNodes[2].style.color= '$s8_text_color_onhover' ; ";
$input_onhover_out = "this.style.backgroundColor= '$s8_background_color', this.childNodes[1].style.color= '$s8_icon_color', this.childNodes[2].style.color= '$s8_text_color' ; ";

$o .= '<div class="ccw_plugin mdstyle8 sc_item '.$inline_issue.' " style=" '.$css.' " >';
$o .= '<a style="background-color: '.$s8_background_color.';" target="_blank" href="'.$redirect_a.'" class="btn ccw-analytics" data-ccw="style-8-sc"  onmouseover= " '.$input_onhover.' "  onmouseout= " '.$input_onhover_out.' "  >   ';
$o .= '<i class="material-icons '.$s8_icon_float.' icon icon-whatsapp2 ccw-s8-icon-sc ccw-analytics" data-ccw="style-8" style="color: '.$s8_icon_color.';" ></i>';
$o .= '<span style="color: '.$s8_text_color.';" class="ccw-s8-span-sc ccw-analytics" data-ccw="style-8-sc" id="ccw-s8-icon-sc" >'.$a["val"].'</span>';
$o .= '</a>';
$o .= '</div>';
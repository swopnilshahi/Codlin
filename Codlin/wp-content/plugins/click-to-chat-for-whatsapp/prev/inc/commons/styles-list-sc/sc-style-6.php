<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$s6_color = $a['s6_color'];
$s6_hover_color = $a['s6_hover_color'];
$s6_icon_size = $a['s6_icon_size'];
$s6_circle_background_color = $a['s6_circle_background_color'];
$s6_circle_background_hover_color = $a['s6_circle_background_hover_color'];
$s6_circle_height = $a['s6_circle_height'];
$s6_circle_width = $a['s6_circle_width'];
$s6_line_height = $a['s6_line_height'];


$s6_color = $s6_color;
$s6_hover_color = $s6_hover_color;
$s6_icon_size = $s6_icon_size;
$s6_circle_background_color = $s6_circle_background_color;
$s6_circle_background_hover_color = $s6_circle_background_hover_color;
$s6_circle_height = $s6_circle_height;
$s6_circle_width = $s6_circle_width;
$s6_line_height = $s6_line_height;

$input_onhover = "this.style.backgroundColor= '$s6_circle_background_hover_color', this.style.color= '$s6_hover_color'; ";
$input_onhover_out = "this.style.backgroundColor= '$s6_circle_background_color', this.style.color= '$s6_color'; ";

$o .= '<div class="ccw_plugin '.$inline_issue.' ">';
$o .= '<div style=" background-color: '.$s6_circle_background_color.'; color: '.$s6_color.'; height: '.$s6_circle_height.'; width: '.$s6_circle_width.'; line-height: '.$s6_line_height.';  '.$css.' "  class="btn_only_style_div_circle_sc inline-block pointer ccw-analytics"  onclick="'.$img_click_link.'"    onmouseover= " '.$input_onhover.' "  onmouseout= " '.$input_onhover_out.' " >';
$o .= '<span class="btn_only_style icon icon-whatsapp2 ccw-analytics" data-ccw="style-6-sc" style= "font-size: '.$s6_icon_size.' " ></span>';
$o .= '</div>';
$o .= '</div>';
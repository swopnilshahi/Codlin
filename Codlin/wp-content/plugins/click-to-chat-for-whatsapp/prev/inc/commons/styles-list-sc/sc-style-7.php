<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$s7_color = $a['s7_color'];
$s7_hover_color = $a['s7_hover_color'];
$s7_icon_size = $a['s7_icon_size'];
$s7_box_background_color = $a['s7_box_background_color'];
$s7_box_background_hover_color = $a['s7_box_background_hover_color'];
$s7_box_height = $a['s7_box_height'];
$s7_box_width = $a['s7_box_width'];
$s7_line_height = $a['s7_line_height'];


$s7_color = $s7_color;
$s7_hover_color = $s7_hover_color;
$s7_icon_size = $s7_icon_size;
$s7_box_background_color = $s7_box_background_color;
$s7_box_background_hover_color = $s7_box_background_hover_color;
$s7_box_height = $s7_box_height;
$s7_box_width = $s7_box_width;
$s7_line_height = $s7_line_height;

$input_onhover = "this.style.backgroundColor= '$s7_box_background_hover_color', this.style.color= '$s7_hover_color'; ";
$input_onhover_out = "this.style.backgroundColor= '$s7_box_background_color', this.style.color= '$s7_color'; ";

$o .= '<div class="ccw_plugin '.$inline_issue.' ">';
$o .= '<div style="background-color: '.$s7_box_background_color.'; color: '.$s7_color.'; height: '.$s7_box_height.'; width: '.$s7_box_width.'; line-height: '.$s7_line_height.'; '.$css.' " class="btn_only_style_div inline-block pointer ccw-analytics" data-ccw="style-7-sc" onclick="'.$img_click_link.'"   onmouseover= " '.$input_onhover.' "  onmouseout= " '.$input_onhover_out.' "  >';
$o .= '<span class="btn_only_style icon icon-whatsapp2 ccw-analytics" style= "font-size: '.$s7_icon_size.' " ></span>';
$o .= '</div>';
$o .= '</div>';
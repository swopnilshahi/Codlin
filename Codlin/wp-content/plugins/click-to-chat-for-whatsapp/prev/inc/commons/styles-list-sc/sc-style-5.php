<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$s5_color = $a['s5_color'];
$s5_hover_color = $a['s5_hover_color'];
$s5_icon_size = $a['s5_icon_size'];

$s5_color = $s5_color;
$s5_hover_color = $s5_hover_color;
$s5_icon_size = $s5_icon_size;

$input_onhover = "this.style.color= '$s5_hover_color'; ";
$input_onhover_out = "this.style.color= '$s5_color'; ";

$o .= '<div class="ccw_plugin sc_item pointer '.$inline_issue.' " style=" '.$css.' color: '.$s5_color.';  "  onclick="'.$img_click_link.'"  onmouseover= " '.$input_onhover.' "  onmouseout= " '.$input_onhover_out.' " >';
$o .= '<span class="icon icon-whatsapp2 icon-2 ccw-analytics" data-ccw="style-5-sc" style=" font-size: '.$s5_icon_size.'; "></span>';
// $o .= '<a target="_blank" class="nofocus icon icon-whatsapp2 icon-2 no_a_underline ccw-analytics" href="'.$redirect_a.'" >';
// $o .= '</a>';
$o .= '</div>';
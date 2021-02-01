<?php
/**
 * materialize button
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s8_options = get_option( 'ht_ctc_s8' );

?>
<style>
.ht-ctc-sc-style-8 {
  display: none;
}
</style>
<?php

wp_enqueue_style('ht_ctc_font_css');
wp_enqueue_style('ht_ctc_mdstyle8_css');

$s8_txt_color = esc_attr( $s8_options['s8_txt_color'] );
$s8_icon_color = esc_attr( $s8_options['s8_icon_color'] );
$s8_txt_color_on_hover = esc_attr( $s8_options['s8_txt_color_on_hover'] );
$s8_bg_color = esc_attr( $s8_options['s8_bg_color'] );
$s8_bg_color_on_hover = esc_attr( $s8_options['s8_bg_color_on_hover'] );
$s8_icon_color_on_hover = esc_attr( $s8_options['s8_icon_color_on_hover'] );
$s8_icon_position = esc_attr( $s8_options['s8_icon_position'] );

$s8_btn_size = esc_attr( $s8_options['s8_btn_size'] );

$s8_icon_size_db = esc_attr( $s8_options['s8_icon_size'] );
$s8_icon_size = ('' == $s8_icon_size_db) ? "" : "font-size: $s8_icon_size_db;";
// $s8_icon_size = ('' == $s8_icon_size_db) ? "font-size: 12px;" : "font-size: $s8_icon_size_db;";

$s8_text_size_db = esc_attr( $s8_options['s8_text_size'] );
$s8_text_size = ('' == $s8_text_size_db) ? "" : "font-size: $s8_text_size_db;";
// $s8_text_size = ('' == $s8_text_size_db) ? "font-size: 16px;" : "font-size: $s8_text_size_db;";


// shortcode attributes 
$s8_width_sc   = $a["s8_width"];
// left/right/hide or any thing to display icon just before the text
$s8_icon_position_sc   = $a["s8_icon_position"];

$s8_width_css = '';
if ( '' !== $s8_width_sc ) {
  $s8_width_css = "width: $s8_width_sc";
}

if ( '' !== $s8_icon_position_sc ) {
  $s8_icon_position = $s8_icon_position_sc;
}


$input_onhover = "this.style.backgroundColor= '$s8_bg_color_on_hover', this.childNodes[1].style.color= '$s8_icon_color_on_hover', this.childNodes[3].style.color= '$s8_txt_color_on_hover'; ";
$input_onhover_out = "this.style.backgroundColor= '$s8_bg_color', this.childNodes[1].style.color= '$s8_icon_color', this.childNodes[3].style.color= '$s8_txt_color'; ";


$o .=  '
  <div class="ht-ctc-sc-style-8 mdstyle8 ctc-analytics">
    <span class="waves-effect waves-light '.$s8_btn_size.' ctc-analytics" style="background-color: '.$s8_bg_color.'; '.$s8_width_css.'"
    onmouseover= "'.$input_onhover.'"
    onmouseout= "'.$input_onhover_out.'">
        <i class="material-icons '.$s8_icon_position.' ctc-icon ctc-icon-whatsapp2 ctc-analytics" style="color: '.$s8_icon_color.'; '.$s8_icon_size.' "></i>
        <span class="ctc-analytics" style="color: '.$s8_txt_color.'; '.$s8_text_size.' ">'.$call_to_action.'</span>
    </span>
  </div>
';
<?php
/**
 * Style - 7
 * icon with customize padding
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

?>
<span title="<?php echo $call_to_action ?>" class="ctc-analytics ctc-icon ctc-icon-whatsapp2" id="s7-icon" style="<?php echo $s7_css ?>"
onmouseover = "this.style.color = '<?php echo $s7_icon_color_hover ?>', this.style.backgroundColor = '<?php echo $s7_border_color_hover ?>' " 
onmouseout  = "this.style.color = '<?php echo $s7_icon_color ?>', this.style.backgroundColor = '<?php echo $s7_border_color ?>' "
></span>
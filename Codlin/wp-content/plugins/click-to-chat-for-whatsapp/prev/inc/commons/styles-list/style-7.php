<?php
/**
 * button with icon - box
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s7_color = esc_attr( $ccw_options_cs['s7_color'] );
$s7_hover_color = esc_attr( $ccw_options_cs['s7_hover_color'] );
$s7_icon_size = esc_attr( $ccw_options_cs['s7_icon_size'] );

$s7_box_background_color = esc_attr( $ccw_options_cs['s7_box_background_color'] );
$s7_box_background_hover_color = esc_attr( $ccw_options_cs['s7_box_background_hover_color'] );
$s7_box_height = esc_attr( $ccw_options_cs['s7_box_height'] );
$s7_box_width = esc_attr( $ccw_options_cs['s7_box_width'] );
$s7_line_height = esc_attr( $ccw_options_cs['s7_line_height'] );

$s7_css_icon = "color: $s7_color; font-size: $s7_icon_size;";
$s7_css_div = "background-color: $s7_box_background_color; height: $s7_box_height; width: $s7_box_width; line-height: $s7_line_height;  ";
?>
<div class="ccw_plugin">
<div class="chatbot btn_only_style_div pointer ccw-analytics animated <?php echo $an_on_load .' '. $an_on_hover ?>" id="style-7" data-ccw="style-7" 
    style="<?php echo $p1 ?>; <?php echo $p2 ?>; <?php echo $s7_css_div ?>"
    onmouseover = "this.style.backgroundColor = '<?php echo $s7_box_background_hover_color ?>', document.getElementsByClassName('ccw-s7-icon')[0].style.color = '<?php echo $s7_hover_color ?>' "
    onmouseout  = "this.style.backgroundColor = '<?php echo $s7_box_background_color ?>', document.getElementsByClassName('ccw-s7-icon')[0].style.color = '<?php echo $s7_color ?>' "
    onclick = "<?php echo $redirect ?>" >
        <span class="icon icon-whatsapp2 ccw-s7-icon nofocus ccw-analytics" id="s7-icon" data-ccw="style-7" style="<?php echo $s7_css_icon ?>"></span>
</div>
</div>
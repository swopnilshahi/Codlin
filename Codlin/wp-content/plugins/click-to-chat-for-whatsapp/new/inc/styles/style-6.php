<?php
/**
 * Style - 6
 * 
 * link
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s6_options = get_option( 'ht_ctc_s6' );

$s6_txt_color = esc_attr( $s6_options['s6_txt_color'] );
$s6_txt_color_on_hover = esc_attr( $s6_options['s6_txt_color_on_hover'] );
$s6_txt_decoration = esc_attr( $s6_options['s6_txt_decoration'] );
$s6_txt_decoration_on_hover = esc_attr( $s6_options['s6_txt_decoration_on_hover'] );
?>

<a class="ctc-analytics" style="color: <?php echo $s6_txt_color ?>; text-decoration: <?php echo $s6_txt_decoration ?>;"
    onmouseover = "this.style.color = '<?php echo $s6_txt_color_on_hover ?>', this.style.textDecoration = '<?php echo $s6_txt_decoration_on_hover ?>' "
    onmouseout  = "this.style.color = '<?php echo $s6_txt_color ?>', this.style.textDecoration = '<?php echo $s6_txt_decoration ?>' "
    >
    <?php echo $call_to_action ?>
</a>
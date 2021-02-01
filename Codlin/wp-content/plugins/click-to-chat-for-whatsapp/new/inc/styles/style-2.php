<?php
/**
 * Style - 2
 * 
 * Andriod like - WhatsApp icon
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s2_options = get_option( 'ht_ctc_s2' );

$s2_img_size = esc_attr( $s2_options['s2_img_size'] );
$img_size = esc_attr( $s2_options['s2_img_size'] );
if ( '' == $img_size ) {
    $img_size = "50px";
}

?>
<style>
    .ht-ctc svg {
        pointer-events: none;
        display: block;
    }
    .ht-ctc.style-2 svg {
        height: <?php echo $img_size ?>;
        width: <?php echo $img_size ?>;
    }
</style>
<?php

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/svg-style-2.php';

echo style_2_svg( $img_size, $call_to_action );
<?php
/**
 * Style - 3
 * 
 * IOS like - WhatsApp icon
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s3_options = get_option( 'ht_ctc_s3' );

$s3_img_size = esc_attr( $s3_options['s3_img_size'] );
$img_size = esc_attr( $s3_options['s3_img_size'] );
if ( '' == $img_size ) {
    $img_size = "50px";
}

?>
<style>
    .ht-ctc svg {
        pointer-events: none;
        display: block;
    }
    .ht-ctc.style-3 svg {
        height: <?php echo $img_size ?>;
        width: <?php echo $img_size ?>;
    }
</style>
<?php

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/svg-style-3.php';

echo style_3_svg( $img_size, $call_to_action );
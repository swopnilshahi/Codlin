<?php
/**
 * Style - 4
 * 
 * Chip
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s4_options = get_option( 'ht_ctc_s4' );

$s4_text_color = esc_attr( $s4_options['s4_text_color'] );
$s4_bg_color = esc_attr( $s4_options['s4_bg_color'] );

$s4_img_url = esc_attr( $s4_options['s4_img_url'] );

// if user not added any image
if ( '' == $s4_img_url ) {
    $s4_img_url = plugins_url( './new/inc/assets/img/whatsapp-logo-32x32.png', HT_CTC_PLUGIN_FILE );
}

if ( '' == $call_to_action ) {
    $call_to_action = "WhatsApp us";
}
?>

<style>
.chip {
    display: inline-block;
    padding-left: 12px;
    padding-right: 12px;
    padding-top: 0px;
    padding-bottom: 0px;
    border-radius: 25px;
    font-size: 13px;
    line-height: 32px;
}
.chip img {
    float: left;
    margin: 0 8px 0 -12px;
    height: 32px;
    width: 32px;
    border-radius: 50%;
}
</style>

<div class="chip ctc-analytics" style="background-color: <?php echo $s4_bg_color ?>; color: <?php echo $s4_text_color ?>;">
    <?php echo $call_to_action ?>
    <img src="<?php echo $s4_img_url ?>" alt="whatsapp">
</div>
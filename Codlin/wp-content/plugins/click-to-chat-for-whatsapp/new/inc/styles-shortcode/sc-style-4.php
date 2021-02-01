<?php
/**
 * chip style
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

/* Image */
.chip img {
    float: left;
    margin: 0 8px 0 -12px;
    height: 32px;
    width: 32px;
    border-radius: 50%;
}

</style>


<?php

$o .=  '
    <div class="chip ctc-analytics" style="background-color: '.$s4_bg_color.'; color: '.$s4_text_color.';">
        '.$call_to_action.'
        <img src="'.$s4_img_url.'" alt="whatsapp">
    </div>
';
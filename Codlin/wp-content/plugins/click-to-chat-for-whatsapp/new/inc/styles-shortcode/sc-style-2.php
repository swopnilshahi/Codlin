<?php
/**
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s2_options = get_option( 'ht_ctc_s2' );

$s2_img_size = esc_attr( $s2_options['s2_img_size'] );

$s2_img_link = plugins_url( './new/inc/assets/img/whatsapp-icon-square.svg', HT_CTC_PLUGIN_FILE );


$o .=  '
        <img class="img-icon ctc-analytics" title="'.$call_to_action.'" style="height: '.$s2_img_size.';" src="'.$s2_img_link.'" alt="WhatsApp chat">
';
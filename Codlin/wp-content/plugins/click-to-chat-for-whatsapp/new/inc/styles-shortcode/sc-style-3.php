<?php
/**
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s3_options = get_option( 'ht_ctc_s3' );

$s3_img_size = esc_attr( $s3_options['s3_img_size'] );

$s3_img_link = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );


$o .=  '
    <img class="img-icon ctc-analytics" title="'.$call_to_action.'" style="height: '.$s3_img_size.';" src="'.$s3_img_link.'" alt="WhatsApp chat">
';
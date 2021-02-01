<?php
/**
 * Style - 1
 * 
 * theme button
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $s1_options = get_option( 'ht_ctc_s1' );

if ( '' == $call_to_action ) {
    $call_to_action = "WhatsApp us";
}
?>
<button class="ctc-analytics"><?php echo $call_to_action ?></button>
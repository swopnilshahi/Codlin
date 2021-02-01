<?php
/**
 * Init WooCommerce
 */



function ht_ctc_woo() {
    if ( class_exists( 'WooCommerce' ) ) {
        
        if ( is_admin() ) {
            include_once HT_CTC_PLUGIN_DIR .'new/tools/woo/class-ht-ctc-admin-woo.php';
        } else {
            include_once HT_CTC_PLUGIN_DIR .'new/tools/woo/class-ht-ctc-woo.php';
        }

    }
}

// After plugins loaded check if woo exists and include related files.
add_action( 'plugins_loaded', 'ht_ctc_woo' );
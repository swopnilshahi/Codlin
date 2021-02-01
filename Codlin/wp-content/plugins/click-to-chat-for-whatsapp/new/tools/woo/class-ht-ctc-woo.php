<?php
/**
 * woocommerce related front end.
 * 
 * @package ctc
 * @since 2.9
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_WOO' ) ) :

class HT_CTC_Admin_WOO {

    public function __construct() {
        $this->woo_hooks();
    }

    // Hooks
    function woo_hooks() {

        add_filter( 'ht_ctc_fh_chat', array($this, 'chat') );
    }


    function chat( $ht_ctc_chat ) {
        
        $options = get_option('ht_ctc_chat_options');

        // if woocommerce single product page
        if ( function_exists( 'is_product' ) && function_exists( 'wc_get_product' )) {
            if ( is_product() ) {

                $product = wc_get_product();

                $name = $product->get_name();
                // $title = $product->get_title();
                $price = $product->get_price();
                $regular_price = $product->get_regular_price();
                $sku = $product->get_sku();

                // pre-filled
                if ( isset( $options['woo_pre_filled'] ) && '' !== $options['woo_pre_filled'] ) {
                    $ht_ctc_chat['pre_filled'] = esc_attr( $options['woo_pre_filled'] );
                }
                // variables now works in default pre_filled also
                $ht_ctc_chat['pre_filled'] = str_replace( array('{product}', '{price}', '{regular_price}', '{sku}' ),  array( $name, $price, $regular_price, $sku ), $ht_ctc_chat['pre_filled'] );


                // call to action
                if ( isset( $options['woo_call_to_action'] ) && '' !== $options['woo_call_to_action'] ) {
                    $ht_ctc_chat['call_to_action'] = str_replace( array('{product}', '{price}', '{regular_price}', '{sku}' ),  array( $name, $price, $regular_price, $sku ), esc_attr( $options['woo_call_to_action'] ) );
                }

            }
            
        }



                

            




        return $ht_ctc_chat;

    }


    








}

new HT_CTC_Admin_WOO();

endif; // END class_exists check
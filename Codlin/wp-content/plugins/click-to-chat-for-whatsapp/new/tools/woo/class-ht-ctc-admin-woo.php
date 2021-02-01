<?php
/**
 * woocommerce related setting at chat settings page
 * 
 * @package ctc
 * @subpackage admin
 * @since 2.9
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_WOO' ) ) :

class HT_CTC_Admin_WOO {

    public function __construct() {
        $this->woo_admin_hooks();
    }

    // Hooks
    function woo_admin_hooks() {
        add_action( 'ht_ctc_ah_chat_settings', array($this, 'ht_ctc_chat_settings') );
    }



    function ht_ctc_chat_settings() {

        $options = get_option('ht_ctc_chat_options');
        
        $woo_pre_filled = '';
        if ( isset( $options['woo_pre_filled'] ) ) {
            $woo_pre_filled = esc_attr( $options['woo_pre_filled'] );
        }
        $woo_call_to_action = '';
        if ( isset( $options['woo_call_to_action'] ) ) {
            $woo_call_to_action = esc_attr( $options['woo_call_to_action'] );
        }
        $blogname = HT_CTC_BLOG_NAME;
        $placeholder = "Hello $blogname!! \nName: \nLike to buy this {{product}}, {{url}}";
        ?>

        <ul class="collapsible">
        <li class="active">
        <div class="collapsible-header">WooCommerce</div>
        <div class="collapsible-body">

            <!-- prefilled message -->
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="ht_ctc_chat_options[woo_pre_filled]" id="woo_pre_filled" class="materialize-textarea input-margin" style="min-height: 84px;" placeholder="<?php echo $placeholder ?>"><?php echo $woo_pre_filled ?></textarea>
                    <label for="woo_pre_filled">Pre-filled message</label>
                    <p class="description">Pre-filled message for WooCommerce Single Product pages. Leave blank to get default pre-filled message.</p>
                    <p class="description">Variables: {product}, {price}, {regular_price}, {sku}, {site}, {url}, {title} - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/woocommerce_pre-filled-message/">more info</a> </p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="row">
                <div class="input-field col s12">
                    <input name="ht_ctc_chat_options[woo_call_to_action]" value="<?php echo $woo_call_to_action ?>" id="woo_call_to_action" type="text" class="input-margin">
                    <label for="woo_call_to_action">Call to Action</label>
                    <p class="description">Call-to-Action for WooCommerce Single Product pages. Leave blank to get default call-to-action - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/woocommerce_call-to-action/">more info</a> </p>
                </div>
            </div>


        </div>
        </div>
        </li>
        <ul>

        <?php
    }





    
}
new HT_CTC_Admin_WOO();

endif; // END class_exists check
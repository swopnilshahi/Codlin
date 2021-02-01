<?php
/**
 * chip - logo+text
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s4_text_color = esc_attr( $ccw_options_cs['s4_text_color'] );
$s4_background_color = esc_attr( $ccw_options_cs['s4_background_color'] );

?>
<div class="ccw_plugin chatbot" style="<?php echo $p1 ?>; <?php echo $p2 ?>;">
    <div class="style4 animated <?php echo $an_on_load .' '. $an_on_hover ?>">
        <a target="_blank" href="<?php echo $redirect_a ?>" class="nofocus">
            <div class="chip style-4 ccw-analytics" id="style-4" data-ccw="style-4" style="background-color: <?php echo $s4_background_color ?>; color: <?php echo $s4_text_color ?>">
                <img src="<?php echo plugins_url( './new/inc/assets/img/whatsapp-logo-32x32.png', HT_CTC_PLUGIN_FILE ) ?>"  class="ccw-analytics" id="s4-icon" data-ccw="style-4" alt="WhatsApp">
                <?php echo $val ?>
            </div>
        </a>
    </div>
</div>
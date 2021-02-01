<?php
/**
 * logo
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s9_icon_size = esc_attr( $ccw_options_cs['s9_icon_size'] );
?>

<div class="ccw_plugin chatbot" style="<?php echo $p1 ?>; <?php echo $p2 ?>;">
    <div class="ccw_style9 animated <?php echo $an_on_load .' '. $an_on_hover ?>">
        <a target="_blank" href="<?php echo $redirect_a ?>" class="img-icon-a nofocus">   
            <img class="img-icon ccw-analytics" id="style-9" data-ccw="style-9" style="height: <?php echo $s9_icon_size ?>;" src="<?php echo plugins_url( './new/inc/assets/img/whatsapp-icon-square.svg', HT_CTC_PLUGIN_FILE ) ?>" alt="WhatsApp chat">
        </a>
    </div>
</div>
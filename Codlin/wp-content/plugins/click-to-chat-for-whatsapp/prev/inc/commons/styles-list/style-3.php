<?php
/**
 * logo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s3_icon_size = esc_attr( $ccw_options_cs['s3_icon_size'] );

?>
<div class="ccw_plugin chatbot" style="<?php echo $p1 ?>; <?php echo $p2 ?>;" >
    <div class="ccw_style3 animated <?php echo $an_on_load .' '. $an_on_hover ?> ">
        <a target="_blank" href="<?php echo $redirect_a ?>" class="img-icon-a nofocus">   
            <img class="img-icon ccw-analytics" id="style-3" data-ccw="style-3" style="height: <?php echo $s3_icon_size ?>;" src="<?php echo plugins_url( "./new/inc/assets/img/whatsapp-logo.svg", HT_CTC_PLUGIN_FILE ) ?>" alt="WhatsApp chat">
        </a>
    </div>
</div>
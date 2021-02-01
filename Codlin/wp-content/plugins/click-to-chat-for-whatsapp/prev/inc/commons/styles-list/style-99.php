<?php
/**
 * Style - 99 - own image
 * user can add image
 * 
 * @var string $img_css  - adds css styles based on device, given width, height
 * @var string $own_image  - image url
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s99_img_height_desktop = esc_attr( $ccw_options_cs['s99_img_height_desktop'] );
$s99_img_width_desktop = esc_attr( $ccw_options_cs['s99_img_width_desktop'] );
$s99_img_height_mobile = esc_attr( $ccw_options_cs['s99_img_height_mobile'] );
$s99_img_width_mobile = esc_attr( $ccw_options_cs['s99_img_width_mobile'] );

// img url
// image - width, height based on device
$img_css = "";

if( 1 == $is_mobile ) {
    // $own_image = esc_attr( $ccw_options_cs['s99_mobile_img'] );
    $own_image = esc_url( $ccw_options_cs['s99_mobile_img'] );

    if ( '' !== $s99_img_height_mobile ) {
        $img_css .= "height: $s99_img_height_mobile; ";
    }
    if ( '' !== $s99_img_width_mobile ) {
        $img_css .= "width: $s99_img_width_mobile; ";
    }
} else {
    // $own_image = esc_attr( $ccw_options_cs['s99_desktop_img'] );
    $own_image = esc_url( $ccw_options_cs['s99_desktop_img'] );

    if ( '' !== $s99_img_height_desktop ) {
        $img_css .= "height: $s99_img_height_desktop; ";
    }
    
    if ( '' !== $s99_img_width_desktop ) {
        $img_css .= "width: $s99_img_width_desktop; ";
    }
}

if ( '' == $own_image ) {
    $own_image = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );
}

?>

<div class="ccw_plugin chatbot" style="<?php echo $p1 ?>; <?php echo $p2 ?>;">
    <div class="ccw_style_99 animated <?php echo $an_on_load .' '. $an_on_hover ?>">
        <a target="_blank" href="<?php echo $redirect_a ?>" class="img-icon-a nofocus">   
            <img class="own-img ccw-analytics" id="style-9" data-ccw="style-99-own-image" style="<?php echo $img_css ?>" src="<?php echo $own_image ?>" alt="WhatsApp chat">
        </a>
    </div>
</div>
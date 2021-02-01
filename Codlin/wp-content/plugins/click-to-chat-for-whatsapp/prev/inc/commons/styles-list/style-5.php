<?php
/**
 * plan icon - similar to sytle-3, an icon
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s5_color = esc_attr( $ccw_options_cs['s5_color'] );
$s5_hover_color = esc_attr( $ccw_options_cs['s5_hover_color'] );
$s5_icon_size = esc_attr( $ccw_options_cs['s5_icon_size'] );
?>
<div class="ccw_plugin">
    <div class="style-5 chatbot nofocus animated <?php echo $an_on_load .' '. $an_on_hover ?>" style="<?php echo $p1 ?>; <?php echo $p2 ?>;">
            <a target="_blank" class="nofocus icon icon-whatsapp2 icon-2 ccw-analytics" id="stye-5" data-ccw="style-5" 
                href="<?php echo $redirect_a ?>" 
                style = "color: <?php echo $s5_color ?>; font-size: <?php echo $s5_icon_size ?>;"
                onmouseover = "this.style.color = '<?php echo $s5_hover_color ?>' "
                onmouseout  = "this.style.color = '<?php echo $s5_color ?>' " >   
            </a>
    </div>
</div>
<?php
/**
 * Style-1 - new method. 
 *  default button, looks like theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="ccw_plugin chatbot" style="<?php echo $p1 ?>; <?php echo $p2 ?>;">
    <div class="style1 animated <?php echo $an_on_load .' '. $an_on_hover ?> ">
        <button onclick="<?php echo $redirect ?>"><?php echo $val ?></button>    
    </div>
</div>
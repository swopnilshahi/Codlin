<?php
/**
 * Style - 5
 * image with content slider
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s5_options = get_option( 'ht_ctc_s5' );

$s5_line_1 = esc_attr( $s5_options['s5_line_1'] );
$s5_line_2 = esc_attr( $s5_options['s5_line_2'] );
$s5_line_1_color = esc_attr( $s5_options['s5_line_1_color'] );
$s5_line_2_color = esc_attr( $s5_options['s5_line_2_color'] );
$s5_background_color = esc_attr( $s5_options['s5_background_color'] );
$s5_border_color = esc_attr( $s5_options['s5_border_color'] );
$s5_img = esc_attr( $s5_options['s5_img'] );
$s5_img_height = esc_attr( $s5_options['s5_img_height'] );
$s5_img_width = esc_attr( $s5_options['s5_img_width'] );
$s5_content_height = esc_attr( $s5_options['s5_content_height'] );
$s5_content_width = esc_attr( $s5_options['s5_content_width'] );
$s5_img_position = esc_attr( $s5_options['s5_img_position'] );


// default image - if user not added any image
if ( '' == $s5_img ) {
    $s5_img = plugins_url( './new/inc/assets/img/new_style8.jpg', HT_CTC_PLUGIN_FILE );
}

if ( '' == $s5_line_1 ) {
    $s5_line_1 = $call_to_action;
}


$s5_cta_style = "display: -ms-flexbox; display: -webkit-flex; display: flex;";


$s5_img_style = '';
$s5_img_style .= 'height: '.$s5_img_height.'; width: '.$s5_img_width.'; z-index: 999999;  ';
if ( 'right' == $s5_img_position ) {
    $s5_img_style .= 'order: 1;';
}

$s5_content_style = '';
$s5_content_style .= 'flex-direction: column; justify-content: center; align-items: center;    ';
$s5_content_style .= ' background-color: '.$s5_background_color.'; border: 1px solid '.$s5_border_color.'; height: '.$s5_content_height.'; width: '.$s5_content_width.';  ';
if ( 'right' == $s5_img_position ) {
    $s5_content_style .= 'margin-right: -4px;';
} elseif ( 'left' == $s5_img_position ) {
    $s5_content_style .= 'margin-left: -4px;';
}


// adding styles.. 
$s5_css_code = '
    .ht-ctc-style-5 .s5_img {
        box-shadow: 2px 5px 10px rgba(0,0,0,.5);
    }
    .ht-ctc-style-5 .s5_content {
        box-shadow: 2px 5px 10px rgba(0,0,0,.5);
        border-radius: 5px;
    }
    .ht-ctc-style-5 .s5_content span {
        padding: 5px;
        overflow: hidden;
    }
    .ht-ctc-style-5 .s5_content .heading {
        font-size: 20px;
    }
    .ht-ctc-style-5 .s5_content .description {
        font-size: 12px;
    }
    .ht-ctc-style-5 .s5_content.right {
        animation: 1s s5_translate_right;
    }
    .ht-ctc-style-5 .s5_content.left {
        animation: 1s s5_translate_left;
    }
    
    @keyframes s5_translate_right {
        0% {
            transform: translateX(55px)
        }
        100% {
            transform: translateX(0px)
        }
    }
    
    @keyframes s5_translate_left {
        0% {
            transform: translateX(-55px)
        }
        100% {
            transform: translateX(0px)
        }
    }
    ';

    
$o = '';
$o .= '<style>';
$o .= '.ht-ctc-style-5 .s5_content { display: none; } .ht-ctc-style-5 .s5_cta:hover .s5_content { display: flex; } ';
$o .= $s5_css_code;
$o .= '</style>';

echo $o;

?>

<div class="ht-ctc-style-5 ctc-analytics" style="cursor: pointer; z-index: 99999999;" >

    <div class="s5_cta" style="<?php echo $s5_cta_style ?>"   >
        <img class="s5_img ctc-analytics" src="<?php echo $s5_img ?>" style="<?php echo $s5_img_style ?>" alt="whatsapp">
        <div class="s5_content ctc-analytics <?php echo $s5_img_position ?>" style="<?php echo $s5_content_style ?>" >
            <span class="heading ctc-analytics" style="color: <?php echo $s5_line_1_color ?>"><?php echo $s5_line_1 ?></span>
            <span class="description ctc-analytics" style="color: <?php echo $s5_line_2_color ?>"><?php echo $s5_line_2 ?></span>
        </div>
    </div>

</div>

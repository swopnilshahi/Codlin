<?php
/**
 * List of Styles
 * 
 * @uses chatbot.php, chatbot-mobile.php
 * 
 * @var values  -  is initiated in chat.php
 * $values = ht_ccw()->variables->get_option;
 * 
 * @package ccw
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$ccw_options_cs = get_option('ccw_options_cs');

//  if it is mobile device, or tab is_mobile is 1, if not 2 or any thing
$is_mobile = ht_ccw()->device_type->is_mobile;

$return_type = esc_attr( $values['return_type'] );
$group_id = esc_attr( $values['group_id'] );
$page_url = get_permalink();
$text = esc_attr( $values['initial'] );

$initial_text = str_replace( '{{url}}', $page_url, $text );


// $an_on_load = "animated bounce infinite";
$an_on_load = esc_attr( $ccw_options_cs['an_on_load'] );

// if yes - add's 'ccw-an' class to styles
// for class ccw-an - animated in javascript
$an_on_hover = esc_attr( $ccw_options_cs['an_on_hover'] );



/**
 * $redirect - redirect link for onclick attribute - window.open - direct link - using window.open
 * 
 * $redirect_a   -  full url - for 'a' tags - direct link - instead of calling another file using redirect_page
 */
$redirect = "";

if( 1 == $is_mobile ) {

    // selected style for mobile devices
    $style = esc_attr( $values['stylemobile'] );

    
    if ( 'group_chat' == $return_type ) {
        $redirect = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
        $redirect_a = "https://chat.whatsapp.com/$group_id";
    } else {
        $redirect = "window.open('https://api.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
        $redirect_a = "https://api.whatsapp.com/send?phone=$num&text=$initial_text";
    }
} else {

    // selected style for desktop devices
    $style = esc_attr( $values['style'] );


    if ( isset( $values['app_first'] ) ) {

        // App First - so mobile based url
        if ( 'group_chat' == $return_type ) {
            $redirect = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
            $redirect_a = "https://chat.whatsapp.com/$group_id";
        } else {
            $redirect = "window.open('https://api.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
            $redirect_a = "https://api.whatsapp.com/send?phone=$num&text=$initial_text";
        }


    } else {

        // General - Desktop url
        if ( 'group_chat' == $return_type ) {
            $redirect = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
            $redirect_a = "https://chat.whatsapp.com/$group_id";
        } else {
            $redirect = "window.open('https://web.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
            $redirect_a = "https://web.whatsapp.com/send?phone=$num&text=$initial_text";
        }

    }
    
    
}


// if ( isset ( $_POST['subject'] ) ) {
//     $num = esc_attr( $values['number'] );
//     $subject = sanitize_text_field( $_POST['subject'] );
//     $url = "$redirect_a&text=$subject";
    
//     if ( headers_sent() ) {
//         die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
//     } else {
//         header('Location: ' . $url);
//         die();
//     } 
// }

// floating style template path
$path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'prev/inc/commons/styles-list/style-' . $style. '.php';

$version = HT_CTC_VERSION;
$comment = "<!-- Click to Chat - prev - https://holithemes.com/plugins/click-to-chat/  v$version -->";
echo $comment;

if ( is_file( $path ) ) {
    include_once $path;
}
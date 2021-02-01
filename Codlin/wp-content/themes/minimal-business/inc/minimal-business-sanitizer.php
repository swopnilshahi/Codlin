<?php
/**
 * Sanitization functions.
 *
 * @package Minimal_Business
 */

function minimal_business_sanitize_option($input){

        $option = array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
            );     
        if(array_key_exists($input, $option)){
            return $input;
        }
        else
            return '';
}

function minimal_business_header_menu_layout( $control ) {

    if ( $control->manager->get_setting('minimal_business_header_feature')->value() == 'header-callto') {
        return true;
    } else {
        return false;
    }
}

function minimal_business_header_button_layout( $control ) {

    if ( $control->manager->get_setting('minimal_business_header_feature')->value() == 'header-button') {
        return true;
    } else {
        return false;
    }
}

function minimal_business_banner_layout( $control ) {

    if ( $control->manager->get_setting('minimal_business_banner_layout')->value() == 'layout-2') {
        return true;
    } else {
        return false;
    }
}

function minimal_business_slider_layout_active( $control ) {

    if ( $control->manager->get_setting('minimal_business_banner_layout')->value() == 'layout-1') {
        return true;
    } else {
        return false;
    }
}

// Startup_Business Category Sanitizer

function minimal_business_sanitize_category_select($input){
    
    $minimal_business_cat_list = minimal_business_category_lists();
    if(array_key_exists($input,$minimal_business_cat_list)){
        return $input;
    }
    else{
        return '';
    }
}

// sanitizer for call to action
function minimal_business_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

//integer sanitize
function minimal_business_integer_sanitize($input){
        return intval( $input );
   }


if ( ! function_exists( 'minimal_business_sanitize_dropdown_pages' ) ) :

    /**
     * Sanitize dropdown pages.
     *
     * @since 1.0.0
     *
     * @param int                  $page_id Page ID.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return int|string Page ID if the page is published; otherwise, the setting default.
     */
    function minimal_business_sanitize_dropdown_pages( $page_id, $setting ) {

        // Ensure $input is an absolute integer.
        $page_id = absint( $page_id );

        // If $page_id is an ID of a published page, return it; otherwise, return the default.
        return ( 'publish' === get_post_status( $page_id ) ? $page_id : $setting->default );

    }

endif;

function minimal_business_radio_sanitize_archive_sidebar($input) {

  $valid_keys = array(
        'sidebar-left' =>  esc_html__('Sidebar Left','minimal-business'),
        'sidebar-right' =>  esc_html__('Sidebar Right','minimal-business'),
        'sidebar-both' =>  esc_html__('Sidebar Both','minimal-business'),
        'sidebar-no' =>  esc_html__('Sidebar No','minimal-business'),
  );

      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }

}



function minimal_business_layout_call_back($input) {

  $valid_keys = array(
        'layout-1' =>  esc_html__('Layout 1','minimal-business'),
        'layout-2' =>  esc_html__('Layout 2','minimal-business'),
  );

      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }

}


// logo alignment
function minimal_business_webpagelayout($input) {
    
    $valid_keys = array(
        'fullwidth' => esc_html__('Full Width', 'minimal-business'),
        'boxed' => esc_html__('Boxed', 'minimal-business')
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }

}   


if ( ! function_exists( 'minimal_business_sanitize_dropdown_pages' ) ) :

    /**
     * Sanitize dropdown pages.
     *
     * @since 1.0.0
     *
     * @param int                  $page_id Page ID.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return int|string Page ID if the page is published; otherwise, the setting default.
     */
    function minimal_business_sanitize_dropdown_pages( $page_id, $setting ) {

        // Ensure $input is an absolute integer.
        $page_id = absint( $page_id );

        // If $page_id is an ID of a published page, return it; otherwise, return the default.
        return ( 'publish' === get_post_status( $page_id ) ? $page_id : $setting->default );

    }

endif;

if ( ! function_exists( 'minimal_business_sanitize_select' ) ) :

    /**
     * Sanitize select.
     *
     * @since 1.0.0
     *
     * @param mixed                $input The value to sanitize.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return mixed Sanitized value.
     */
    function minimal_business_sanitize_select( $input, $setting ) {

        // Ensure input is a slug.
        $input = sanitize_key( $input );

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

    }

endif;


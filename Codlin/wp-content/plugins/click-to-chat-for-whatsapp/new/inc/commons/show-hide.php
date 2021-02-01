<?php
/**
 * 
 * @included from - class-ht-ctc-{chat/group/share}.php
 * 
 * sets $display - yes to show styles or no to hide styles
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$this_page_id = get_the_ID();


// yes to display style and no to hide styles
// @uses at 'class-ht-ctc-{chat/group/share}.php'
$display = 'yes';


// show / hide 
if ( 'show' == $options['show_or_hide'] ) {
    // show based no 

    // in show - default display is no
    $display = 'no';

    $pages_list_toshow = esc_html( $options['list_showon_pages'] );
    $pages_list_toshow_array = explode(',', $pages_list_toshow);

    if( ( is_single() || is_page() ) && in_array( $this_page_id, $pages_list_toshow_array ) ) {
        $display = 'yes';
        return;
    }

    if ( is_single() && isset( $options['showon_posts'] ) ) {
        $display = 'yes';
        return;
    }
    
    if ( is_page() && isset( $options['showon_page'] ) ) {
        if ( ( !is_home() ) && ( !is_front_page() ) ) {
        $display = 'yes';
            return;
        }
    }
    
    // is_home and is_front_page - combined. 
    if ( ( is_home() || is_front_page() )  && (  isset( $options['showon_homepage'] ) )    ) {
        $display = 'yes';
        return;
    }
    
        
    if ( is_category() && isset( $options['showon_category'] ) ) {
        $display = 'yes';
        return;
    }
    
    if ( is_archive() && isset( $options['showon_archive'] ) ) {
        $display = 'yes';
        return;
    }
    
    if ( is_404() && isset( $options['showon_404'] ) ) {
        $display = 'yes';
        return;
    }

    // show on woocommerce single product pages.
    if ( isset( $options['showon_wooproduct'] ) ) {
        if ( function_exists( 'is_product' ) ) {
            if ( is_product() ) {
                $display = 'yes';
                return; 
            }
        }
    }
    
    
    // Hide styles on this catergorys - list
    $list_showon_cat = esc_html( $options['list_showon_cat'] );
    
    // avoid calling foreach, explode when hide on categorys list is empty
    if( $list_showon_cat ) {
    
        //  Get current post Categorys list and create an array for that..
        $current_categorys_array = array();
        $current_categorys = get_the_category();
        foreach ( $current_categorys as $category ) {
            $current_categorys_array[] = strtolower($category->name);
        }
    
        $list_showon_cat_array = explode(',', $list_showon_cat);
    
        foreach ( $list_showon_cat_array as $category ) {
            $category_trim = trim($category);
            if ( in_array( strtolower($category_trim), $current_categorys_array ) ) {
                $display = 'yes';
                return;
            }
        }
    }

} else {

    // hide based on

    // in hide - default display is yes
    $display = 'yes';


    $pages_list_tohide = esc_html( $options['list_hideon_pages'] );
    $pages_list_tohide_array = explode(',', $pages_list_tohide);

    if( ( is_single() || is_page() ) && in_array( $this_page_id, $pages_list_tohide_array ) ) {
        $display = 'no';
        return;
    }
    
    if ( is_single() && isset( $options['hideon_posts'] ) ) {
        $display = 'no';
        return;
    }
    
    if ( is_page() && isset( $options['hideon_page'] ) ) {
        if ( ( !is_home() ) && ( !is_front_page() ) ) {
        $display = 'no';
            return;
        }
    }
    
    
    // is_home and is_front_page - combined. 
    if (   ( is_home() || is_front_page() )  && ( isset( $options['hideon_homepage'] ) ) ) {
        $display = 'no';
        return;
    }
    
    if ( is_category() && isset( $options['hideon_category'] ) ) {
        $display = 'no';
        return;
    }
    
    if ( is_archive() && isset( $options['hideon_archive'] ) ) {
        $display = 'no';
        return;
    }
    
    if ( is_404() && isset( $options['hideon_404'] ) ) {
        $display = 'no';
        return;
    }
    
    // hide on woocommerce single product pages.
    if ( isset( $options['hideon_wooproduct'] ) ) {
        if ( function_exists( 'is_product' ) ) {
            if ( is_product() ) {
                $display = 'no';
                return; 
            }
        }
    }
    
    // Hide styles on this catergorys - list
    $list_hideon_cat = esc_html( $options['list_hideon_cat'] );
    
    // avoid calling foreach, explode when hide on categorys list is empty
    if( $list_hideon_cat ) {
    
        //  Get current post Categorys list and create an array for that..
        $current_categorys_array = array();
        $current_categorys = get_the_category();
        foreach ( $current_categorys as $category ) {
            $current_categorys_array[] = strtolower($category->name);
        }
    
        $list_hideon_cat_array = explode(',', $list_hideon_cat);
    
        foreach ( $list_hideon_cat_array as $category ) {
            $category_trim = trim($category);
            if ( in_array( strtolower($category_trim), $current_categorys_array ) ) {
                $display = 'no';
                return;
            }
        }
    }

}
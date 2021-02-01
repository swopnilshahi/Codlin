<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Minimal_Business
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

function minimal_business_body_classes( $classes ) {

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    $sidebar = get_theme_mod('minimal_business_archive_setting_sidebar_option','sidebar-right');

    if ( is_archive ()  || is_category() ) {
        $classes[] = $sidebar;
    }

    global $post;

    $post_id = "";
    if(is_front_page()){
        $post_id = get_option('page_on_front');
    }else{
        if($post)
        $post_id = $post->ID;
    }
    $classes[] = get_post_meta( $post_id, 'minimal_business_sidebar_layout', true );


    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }
    return $classes;

}
add_filter( 'body_class', 'minimal_business_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function minimal_business_pingback_header() {
    
    if ( is_singular() && pings_open() ) {
       printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'minimal_business_pingback_header' );

//Content Legth 
if ( ! function_exists( 'minimal_business_the_excerpt' ) ) :

    /**
     * Generate excerpt.
     *
     * @since 1.0.0
     *
     * @param int     $length Excerpt length in words.
     * @param WP_Post $post_obj WP_Post instance (Optional).
     * @return string Excerpt.
     */
    function minimal_business_the_excerpt( $length = 0, $post_obj = null ) {

        global $post;

        if ( is_null( $post_obj ) ) {
            $post_obj = $post;
        }

        $length = absint( $length );

        if ( 0 === $length ) {
            return;
        }

        $source_content = $post_obj->post_content;

        if ( ! empty( $post_obj->post_excerpt ) ) {
            $source_content = $post_obj->post_excerpt;
        }

        $source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
        $trimmed_content = wp_trim_words( $source_content, $length, '&hellip;' );
        return $trimmed_content;

    }

endif;

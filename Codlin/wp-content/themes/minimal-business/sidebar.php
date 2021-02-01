<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Minimal_Business
 */

global $post;

$post_class = 'sidebar-right';

if ( is_singular() ){
	$post_class =  get_post_meta( $post->ID, 'minimal_business_sidebar_layout', true );
	if ( empty( $post_class ) ){
		$post_class = 'sidebar-right';
	}
} else{
	$post_class =  get_theme_mod('minimal_business_archive_setting_sidebar_option','sidebar-right');
}

if ( 'sidebar-no' == $post_class || ! is_active_sidebar( 'minimal-business-sidebar-right' ) ) {
	return;
}

if( $post_class == 'sidebar-right' || $post_class == 'sidebar-both' ){
	?>
	<div id="secondary" class="col-sm-4 "> <!-- secondary starting from here -->
		<?php dynamic_sidebar( 'minimal-business-sidebar-right' );   ?>
	</div>

<?php } ?>










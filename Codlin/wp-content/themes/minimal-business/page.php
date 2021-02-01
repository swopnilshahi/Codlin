<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Minimal_Business
 */

get_header();
?>
   <div class="container">
		   	<div class="row">
				<?php
					global $post;
					$sidebar = get_post_meta($post->ID, 'minimal_business_sidebar_layout', true);

					if ( empty( $sidebar ) ){
						$sidebar = 'sidebar-right';
					}
					$custom_class = 'col-sm-8';
					if( 'sidebar-no' == $sidebar ){
						$custom_class = 'col-sm-12';
					} elseif ( 'sidebar-both' == $sidebar ) {
						$custom_class = 'col-sm-4';
					}else{
						$custom_class = 'col-sm-8';
					}
					if($sidebar=='sidebar-both' || $sidebar=='sidebar-left'){
						get_sidebar( 'left' );
					}					
				?>   

				<div id="primary" class="content-area <?php echo esc_attr( $custom_class );?>">					
					<main id="main" class="site-main">
						<?php while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
					</main><!-- #main -->
				</div><!-- #primary -->				
	            <?php if($sidebar=='sidebar-both' || $sidebar=='sidebar-right' ){
					get_sidebar('right');
				}
				?>
	   </div>
	</div>
<?php get_footer(); ?>


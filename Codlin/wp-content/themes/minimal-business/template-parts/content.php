<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Minimal_Business
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (has_post_thumbnail()): ?>
    	<figure>
    		<a href="<?php the_permalink();?>">
                <?php $archive_image = wp_get_attachment_image_src(get_post_thumbnail_id(), ' ' );?>
                <img src="<?php echo esc_url($archive_image[0]); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
    		</a>
    	</figure>
	<?php endif; ?>
	
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h2 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php if (get_theme_mod('minimal_archive_section_date','no')=='yes') { ?>
				<?php minimal_business_posted_on(); ?>
			<?php }?>  
			<?php if (get_theme_mod('minimal_archive_section_author','no')=='yes') { ?>
				<?php  echo esc_url(the_author_posts_link()); ?>
		    <?php }?> 		
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->  
	<div class="entry-content">
     	<?php if ( is_singular() ) :
            the_content();
    	else:
            the_excerpt();
        ?>
	        <?php if (get_theme_mod('minimal_archive_section_redmore_optons','no')=='yes') { 
        	$archive_section_button_text = get_theme_mod('minimal_business_archive_submit',esc_html__('Read More','minimal-business') );
        	if($archive_section_button_text){ ?>
				<a href="<?php the_permalink(); ?>" class="btn"><?php echo esc_html($archive_section_button_text); ?></a>
				<?php } 
			} ?>  

        <?php endif;
        
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minimal-business' ),
            'after'  => '</div>',
        ) ); 
        ?>
	</div>
    

</article><!-- #post-<?php the_ID(); ?> -->
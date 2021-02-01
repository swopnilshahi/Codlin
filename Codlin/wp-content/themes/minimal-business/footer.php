<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Minimal_Business
 */

?>

	</div><!-- #content -->

	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' )  || is_active_sidebar( 'footer-4' ) ) : ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

			<section class="widget-area">
				<div class="container">
					<div class="row">
						<?php
						$column_count = 0;
						$class_coloumn =12;
						for ( $i = 1; $i <= 4; $i++ ) {
						if ( is_active_sidebar( 'footer-' . $i ) ) {
							$column_count++;
							$class_coloumn = 12/$column_count;
						}
						} ?>
						<?php $column_class = 'col-sm-' . absint( $class_coloumn );
						for ( $i = 1; $i <= 4 ; $i++ ) {
						if ( is_active_sidebar( 'footer-' . $i ) ) { ?>
							<div class="<?php echo esc_attr( $column_class ); ?>">
							<?php dynamic_sidebar( 'footer-' . $i ); ?>
							</div>
						<?php }
						} ?>

                    </div>

                 </div>	

			</section>

		<?php endif;?> 

		<section class="site-generator"> <!-- site-generator starting from here -->

			<div class="container">

				<span class="copy-right">

					<span class="copy-right">

							<span class="copyright-text"><?php echo esc_html( get_theme_mod( 'minimal_business_copyright_text',esc_html__('All Rights Reserved','minimal-business')));?>
							</span>
							
						<?php 

							printf( esc_html__( 'Theme by %1$s.', 'minimal-business' ), '<a href="'.esc_url( 'https://theme404.com/' ).'" rel="designer">'.'404 THEME'.'</a>' ); ?>
						 
					</span>

				</span>
				
			</div> 

		</section>
		<?php $minimal_business_scroll_to_top = get_theme_mod( 'minimal_business_scroll_to_top', 'no' );
		if ( 'yes' == $minimal_business_scroll_to_top ): ?>

	        <div class="back-to-top">
	            <a href="#masthead" title="<?php echo esc_attr__('Go to Top', 'minimal-business');?>" class="fa-angle-up"></a>
	        </div>		

        <?php endif; ?>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

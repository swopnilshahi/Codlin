<?php

/**
*  Service Section 
*
* @package Minimal_Business
*/

 if (get_theme_mod('minimal_business_service_option','no')=='yes') { 
 	
 
    $service_section_button_text = esc_html(get_theme_mod('minimal_business_service_readmore',esc_html__('Learn More','minimal-business')));

    $minimal_business_service_page  = get_theme_mod('minimal_business_service_page',0);


   ?>
	<section class="service-section">

		<div class="container">
            
			 <?php   if( !empty( $minimal_business_service_page ) ): 

                $args = array (                                 
                    'page_id'           => absint( $minimal_business_service_page ),
                    'post_status'       => 'publish',
                    'post_type'         => 'page',
                );
              
             $loop = new WP_Query($args);
              if ( $loop->have_posts() ) : ?>

				<div class="header-wrapper">

				 	<?php while ($loop->have_posts()) : $loop->the_post();?> 

					<header class="entry-header heading">
						<h2 class="entry-title">  <?php the_title(); ?> </h2>
					</header>
					<div class="section-detail">
						<?php $excerpt = minimal_business_the_excerpt( 14 ); ?>
						<p><?php echo wp_kses_post( $excerpt )?></p>
					</div>

					 <?php endwhile; 
					 wp_reset_postdata();?>

	           </div>

	           <?php endif;
              
              endif;

              ?>
             <?php 
			 	$service_category = get_theme_mod( 'minimal_business_service_section_cat',0 );

				if ( empty( $service_category ) ){
				  return;
				}	

			    $service_cat_id = get_category_by_slug( $service_category )->term_id;

			    $number = get_theme_mod('minimal_business_service_num',10);
			    
				if ( !empty( $service_category) ) {
				$loop = new WP_Query(array('post_type'=>'post','posts_per_page'=>absint( $number ),'category_name'=>esc_html( $service_category ) ) );
				} else{
				$loop = new WP_Query( array( 'post_type'=>'post','posts_per_page'=>absint( $number ), ) );
				} 

			if($loop->have_posts()): ?>

				<div class="row">

					<?php

					while($loop->have_posts()) {
	                 	$cats = get_the_category(get_the_ID());
	                 	$originalDate = get_the_date();
	             	 	$author_name =  get_the_author();
						$loop->the_post();
						$image = wp_get_attachment_image_src( get_post_thumbnail_id(),'minimal-business-service-image', true );
						?>

						<div class="col-sm-4">

							<div class="service-item">

								<figure class="service-icon">
									<img src="<?php echo esc_url($image[0]);?>" />
								</figure>

								<div class="title-wrapper">

									 <div class="events-news">

				                       <?php  minimal_business_cat(); ?>

		             			 	</div>

									<h2 class="entry-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>

									 <div class="post-attributes">
					                      <?php if($author_name) { ?>
					                      <span class="post-author"> 
					                        <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>">
					                          <?php the_author(); ?>
					                        </a> 
					                      </span>
					                      <?php }if($originalDate) { ?>
					                      <span class="post-date"> 
					                        <?php esc_html_e(' On ', 'minimal-business'); ?>
					                        <?php echo esc_html($originalDate); ?> 
					                      </span>
					                      <?php } ?>
				                    </div>
			                  
									<div class="entry-content">
										<?php $excerpt = minimal_business_the_excerpt( 15 ); ?>
										<p><?php echo wp_kses_post( $excerpt )?></p>
									</div>

								</div>

							</div>

						</div>

					<?php } ?>

				</div>

			<?php endif; ?>
			
			 <?php 
			 if (get_theme_mod('minimal_business_service_readmore_option','no')=='yes') { 

				 if($service_section_button_text){ ?>
					<a class="box-button" href="<?php echo esc_url(get_category_link( $service_cat_id ));?>"><?php echo esc_html($service_section_button_text); ?></a>
				<?php } ?>

			 <?php }?> 

		</div>

	</section>

 <?php }?>  
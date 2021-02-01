<?php

/**
* Call To Action Section
*
* @package Minimal_Business
*/
 if (get_theme_mod('minimal_business_callto_option','no')=='yes') { 

	$minimal_business_readmore_button = get_theme_mod( 'minimal_business_callto_readmore', esc_html__('Creat Your Profile Page Now', 'minimal-business') );
	$minimal_business_first_button_url = get_theme_mod( 'minimal_business_call_to_link', esc_url( home_url( '/' ).'#focus' ) );

	 $minimal_business_callto_page  = get_theme_mod('minimal_business_call_to_page',0);
	
	?>
	<section class="profile-section">

		<div class="container">

			<header class="entry-header heading">
				<?php $section_title =  get_theme_mod('minimal_business_section_title',esc_html__('Are You An Artist or Agent?','minimal-business'));
				if(!empty( $section_title ) ):    ?>
					<h2 class="entry-title"><?php echo esc_html( $section_title );?></h2>
				<?php endif; ?>
			</header>

             <?php   if( !empty( $minimal_business_callto_page ) ): 

                $args = array (                                 
                    'page_id'           => absint( $minimal_business_callto_page ),
                    'post_status'       => 'publish',
                    'post_type'         => 'page',
                );
              
             $loop = new WP_Query($args);
              if ( $loop->have_posts() ) : ?>

                    <div class="signup-content">

                        <?php while ($loop->have_posts()) : $loop->the_post();?>    

                        <header class="inner-heading">

                	       <h2 class="entry-title"> <?php the_title(); ?> </h2> 

                        </header>

                        <form class="Call-to">

                            <div class="call-to-content">

                               <?php the_content(); ?>
                                   
                            </div>

                        </form>

                        <?php endwhile;
                         wp_reset_postdata();?>

                    </div>

             <?php endif;
              
              endif;

              ?>
			<?php 
			if( !empty( $minimal_business_readmore_button ) ) { ?>
				<div class="box-button">
					<a href="<?php echo esc_url($minimal_business_first_button_url); ?>">
						<?php echo esc_html($minimal_business_readmore_button); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</section>
    
 <?php }?>  

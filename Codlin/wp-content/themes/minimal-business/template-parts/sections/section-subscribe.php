<?php

/**
 * Subscribe  Section Section 
 *
 * @package Minimal_Business
*/

 if (get_theme_mod('minimal_business_subscribe_option','no')=='yes') { 

    $minimal_business_page  = get_theme_mod('minimal_business_subscribe_page',0);

 ?>
    <section class="signup-section" style="background-image: url('<?php echo esc_url(get_theme_mod('minimal_business_page_subcribe_bg_image','')); ?>') ";>
        <div class="container">

            <?php   if( !empty( $minimal_business_page ) ): 

                $args = array (                                 
                    'page_id'           => absint( $minimal_business_page ),
                    'post_status'       => 'publish',
                    'post_type'         => 'page',
                );
              
             $loop = new WP_Query($args);
             
              if ( $loop->have_posts() ) : ?>
                
                    <div class="signup-content">

                        <?php while ($loop->have_posts()) : $loop->the_post();?>    

                        <header class="entry-header heading">

                	       <h2 class="entry-title"> <?php the_title(); ?> </h2> 

                        </header>

                        <form class="signup-form">

                            <div id="mc_embed_signup_scroll">

                               <?php the_content(); ?>
                                   
                            </div>

                        </form>

                        <?php endwhile;
                         wp_reset_postdata();?>

                    </div>

             <?php endif;
              
              endif;

              ?>

        </div>
    </section>


  <?php }?>  	
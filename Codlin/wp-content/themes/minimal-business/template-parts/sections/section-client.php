<?php

/**
*  Client Section 
*
* @package Minimal_Business
*/

if(get_theme_mod('minimal_business_client_option','no') == 'yes'):
   $client_client_cat = get_theme_mod('minimal_business_client_section_cat',0);
    $number = get_theme_mod( 'minimal_business_client_num', 5 );
    $minimal_business_client_layout = get_theme_mod('minimal_business_client_layout','layout-1');
    if ( !empty( $client_client_cat) ) { 
    $args_query = new WP_Query(array('post_type'=>'post','posts_per_page'=>absint( $number ),'category_name'=>esc_html( $client_client_cat ) ) );
          }
    else{
            $args_query = new WP_Query( array( 'post_type'=>'post','posts_per_page'=>absint( $number ) ) );
        } 
    if ($args_query->have_posts()) :?>      

          <section id="client-section" class="<?php echo esc_attr($minimal_business_client_layout); ?> ">
              <div class="container">
                  <div class="row">
                        <div class="carousel2-content">

                           <?php if($minimal_business_client_layout != 'layout-2'){ ?>

                             <div class="affiliation-slider owl-carousel owl-theme">

                               <?php  } 
                               
                                  while ($args_query->have_posts()):
                                      $args_query->the_post();
                                      $client_slider_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'minimal-business-client-thumb',true);
                                      ?>

                                      <div class="client-block">
                                             <div class="cat-caption">
                                                    <?php if(has_post_thumbnail()): ?>
                                                    <div class="client-news-image">
                                                      <img src="<?php echo esc_url($client_slider_image[0]); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                                                    </div>
                                                    <?php endif; ?>
                                               </div>
                                        </div>  

                                      <?php
                                  endwhile;
                                  wp_reset_postdata();
                                  ?>
                              </div>

                        </div>
                  </div>
              </div>    
            </section>
            
        <?php 
      endif;
endif;
  ?>
<?php
/**
* Banner Section
*
* @package Miniaml_Business
*/
if ( get_theme_mod( 'minimal_business_banner_option','no' ) == 'yes' ) {  ?>
    <?php  $banner_layout = get_theme_mod('minimal_business_banner_layout','layout-1'); 
    if ( 'layout-2' ==  $banner_layout ){ ?>
        <?php $minimal_business_page    = get_theme_mod('minimal_business_page',0);
        if( !empty( $minimal_business_page ) ): 
            $args = array (                                 
                'page_id'           => absint($minimal_business_page ),
                'post_status'       => 'publish',
                'post_type'         => 'page',
            );
            $loops = new WP_Query($args);
            if ( $loops->have_posts() ) : ?>            
                <div class="banner-section ">
                    <?php while ($loops->have_posts()) : $loops->the_post();?> 
                        <?php if( has_post_thumbnail() ): ?> 
                            <figure class="banner-img">
                                <?php the_post_thumbnail(); ?>
                            </figure>             
                            <div class="container">
                                <div class="banner-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title"> <?php the_title(); ?> </h2>
                                    </header>
                                    <div class="entry-content">
                                         <?php  the_content(); ?>   
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile;
                    wp_reset_postdata();?>
                </div>
            <?php endif; 
        endif;
        } else{ 
            $slider_category = ( get_theme_mod( 'minimal_business_slider_section_cat',0 ) );
            $slider_readmore = get_theme_mod( 'minimal_business_slider_readmore',esc_html__('Read More','minimal-business') );
            $number = get_theme_mod('minimal_business_slider_num',5 );
            $minimal_business_slider_layout = get_theme_mod('minimal_business_slider_layout','layout-1');
        ?>  
            <section class="featured-slider " id="home"> 
                <div id="owl-slider-demo" class="owl-carousel owl-theme <?php echo esc_attr($minimal_business_slider_layout); ?>">
                    <?php if( !empty( $slider_category) ) {
                        $loop = new WP_Query(
                            array(
                            'category_name' => esc_html($slider_category),
                            'posts_per_page' => absint( $number ),  
                            )
                        );
                    } else{
                        $loop = new WP_Query( array( 'post_type'=>'post','posts_per_page'=>absint( $number ), ) );
                    }
                    ?>
                    <?php if( $loop->have_posts() ) {
                        while($loop->have_posts()) {
                            $loop->the_post();
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'minimal-business-slider-image', true );
                                ?>
                                <div class="slider-content">
                                    <?php if( has_post_thumbnail() ): ?>
                                        <figure class="slider-image">
                                            <img src="<?php echo esc_url($image[0]);?>" />
                                        </figure>
                                    <?php endif; ?>
                                    <div class="slider-text">
                                        <div class="container">
                                            <h3 class="slider-title"> <?php the_title();?></h3>
                                                <p> <?php echo esc_html(wp_trim_words(get_the_content(),22,'&hellip;')); ?></p>
                                            <div class="slider-btn">
                                                <?php if(!empty($slider_readmore)){ ?>
                                                    <a href="<?php the_permalink();?>" class="box-button"><?php echo esc_html( $slider_readmore );?></a>
                                                <?php }
                                                ?>
                                                <a href="<?php echo esc_url(get_theme_mod( 'minimal_business_contact_us_link','#') ); ?>" class="box-button">
                                                <?php echo esc_html(get_theme_mod('minimal_business_slider_contact_now',esc_html__('Cotact Us','minimal-business') ) ); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                        }
                        wp_reset_postdata();
                    } ?>
                </div>
            </section>
        <?php } 
} 


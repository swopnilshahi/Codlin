<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Template Name: Home Page
 * @package Minimal_Business
 */

get_header(); ?>

        <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">                    
                     <?php
                        /** Banner Section **/
                        get_template_part( 'template-parts/sections/section', 'banner' );

                       /** Callto Section **/
                        get_template_part( 'template-parts/sections/section', 'callto' );

                        /** Feature Section **/
                        get_template_part( 'template-parts/sections/section', 'feature' );

                        /** Service Section **/
                        get_template_part( 'template-parts/sections/section', 'service' );

                        /** Call To Section **/
                        get_template_part( 'template-parts/sections/section', 'subscribe' );

                        /** Client Section **/
                        get_template_part( 'template-parts/sections/section', 'client' );
                    ?>

                    <?php $minimal_business_home_page_content = get_theme_mod( 'minimal_business_home_page_content', 'no' ); 
                        if ( 'yes' == $minimal_business_home_page_content ){
                            while ( have_posts() ) : the_post();
                                the_content();
                            endwhile; // End of the loop.
                        } ?>
                
                </main><!-- #main -->
                
        </div><!-- #primary -->
        
<?php get_footer();?>
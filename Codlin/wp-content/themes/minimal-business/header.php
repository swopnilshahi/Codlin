<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Minimal_Business
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class();  ?>>
	<?php wp_body_open();?>	
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'minimal-business' ); ?></a>	
	<header id="masthead" class="site-header">
		<div class="hgroup-wrap">
			<div class="container">
				<div class="site-branding">
					<?php $site_identity = get_theme_mod( 'site_identity_options', 'title-text' );
						$minimal_business_title = get_bloginfo( 'name', 'display' );						
						$description    = get_bloginfo( 'description', 'display' );	
						if ( 'logo-only' == $site_identity ) { 
							if ( has_custom_logo() ){
								the_custom_logo();
							}
						} elseif ( 'logo-text' == $site_identity ) {
							if ( has_custom_logo() ) {
								the_custom_logo();
							}
							if ( $description ) {
								echo '<p class="site-description">'.esc_html( $description ).'</p>';
							}
						} elseif ( 'title-only' == $site_identity && $minimal_business_title ) {
							if ( is_front_page() && is_home() ) { ?>
								<h1 class="site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								</h1>
							<?php } else { ?>
								<p class="site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								</p>
							<?php }							
						} elseif ( 'title-text' == $site_identity ) {
							if ( $minimal_business_title ) {
								if ( is_front_page() && is_home() ) { ?>
									<h1 class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
									</h1>
								<?php } else { ?>
									<p class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
									</p>
								<?php }
							}
							if ( $description ) {
								echo '<p class="site-description">'.esc_html( $description ).'</p>';	
							}
						} ?>	
				</div><!-- .site-branding -->
				<div class="hgroup-right">
					<nav class="main-navigation"> 
					   <?php  
						$minimal_business_signup_button = get_theme_mod( 'minimal_business_header_callto_text', esc_html__('Sign Up Now', 'minimal-business') ); ?>
						<div class="menu-container">
							<?php $args = array(
								'theme_location' => 'menu-1',
								'fallback_cb' => 'wp_page_menu',
							);						
							wp_nav_menu( $args ); ?>	
						</div>

						<?php if ( get_theme_mod( 'minimal_business_header_option','no' )=='yes' ) { 
							$header_fetaure = get_theme_mod( 'minimal_business_header_feature','header-search');
							if ( 'header-search' ==  $header_fetaure ){ ?>
								<div class="header-search">
									<div class="search-button">
										<a href="JavaScript:Void(0)" class="search-toggle" data-selector="#masthead"></a>
									</div>
									<?php get_search_form(); ?>
								</div>
							<?php } elseif ( 'header-callto' == $header_fetaure ) { 								
								if( !empty( $minimal_business_signup_button ) ) { ?>
									<div class="signup-button box-button">
										<?php echo wp_kses_post($minimal_business_signup_button); ?>
									</div>
								<?php } 
							} elseif ( 'header-button' == $header_fetaure ) {
								$minimal_business_header_button = get_theme_mod( 'minimal_business_header_button', esc_html__( 'Sign Up Now', 'minimal-business' ) );
								$minimal_business_header_button_link = get_theme_mod( 'minimal_business_header_button_link', '' );
								if( !empty( $minimal_business_header_button ) ) { ?>
									<div class="signup-button box-button">
										<a href="<?php echo esc_html( $minimal_business_header_button_link)?>"><?php echo esc_html( $minimal_business_header_button);?></a>
									</div>
								<?php } 
							} else{ ?>
								<div class="header-widget-section">
									<?php dynamic_sidebar( 'header-widget' ); ?>
								</div>
							<?php }
					 	} ?> 
					</nav><!-- .main-navigation -->
				</div>
			</div>
		</div><!-- .container -->
		<?php if (get_theme_mod( 'minimal_business_breadcrumb_option','no' ) == 'yes' ) { 
			if( !is_home() && !is_front_page() ) {
				do_action( 'minimal_business_breadcrumbs_title' ); 
			}
		} ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">

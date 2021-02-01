<?php

/**
 * Minimal_Business  functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Minimal_Business
 */

if ( ! function_exists( 'minimal_business_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function minimal_business_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on startup_business, use a find and replace
		 * to change 'startup_business' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'minimal-business', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		
		add_theme_support( 'post-thumbnails' );
        add_image_size('minimal-business-slider-image', 1600, 744, true);
		add_image_size('minimal-business-service-image', 600, 400, true);
		add_image_size('minimal-business-slider-image', 850, 365, true);
		add_image_size('minimal-business-client-thumb', 200, 100, true);



		//registering the menus for the theme
		register_nav_menus( array(
			'menu-1' 			=> esc_html__( 'Primary Menu','minimal-business' ),
			'social-media'  => esc_html__( 'Social Media', 'minimal-business' ),
			) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'minimal_business_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

	}

endif;

add_action( 'after_setup_theme', 'minimal_business_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function minimal_business_content_width() {

	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	
	$GLOBALS['content_width'] = apply_filters( 'minimal_business_content_width', 640 );
}

add_action( 'after_setup_theme', 'minimal_business_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function minimal_business_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'minimal-business' ),
		'id'            => 'minimal-business-sidebar-right',
		'description'   => esc_html__( 'Add widgets here.', 'minimal-business' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		)
    );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'minimal-business' ),
		'id'            => 'minimal-business-sidebar-left',
		'description'   => esc_html__( 'Add widgets here.', 'minimal-business' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		)
	 );

	register_sidebar( array(
        'name' =>sprintf( esc_html__( 'Footer %d', 'minimal-business' ), 1 ),
        'id' => 'footer-1',
        'description' => esc_html__('Appears in the buttom of footer area','minimal-business'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    	)
     );

    register_sidebar( array(
        'name' => sprintf( esc_html__( 'Footer  %d', 'minimal-business' ), 2 ),
        'id' => 'footer-2',
        'description' => esc_html__('Appears in the buttom of footer area','minimal-business'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
   		 )
     );

    register_sidebar( array(
        'name' => sprintf( esc_html__( 'Footer  %d', 'minimal-business' ), 3 ),
        'id' => 'footer-3',
        'description' => esc_html__('Appears in the buttom of footer area','minimal-business'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
   		 )
     );

    register_sidebar( array(
        'name' => sprintf( esc_html__( 'Footer %d', 'minimal-business' ), 4),
        'id' => 'footer-4',
        'description' => esc_html__('Appears in the buttom of footer area','minimal-business'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
   		 )
     );

	$minimal_business_header_feature = get_theme_mod( 'minimal_business_header_feature', 'header-search' );    
	if ( 'header-widget' == $minimal_business_header_feature  ){
	    register_sidebar( array(
	        'name' => sprintf( esc_html__( 'Header Widget', 'minimal-business' ), 4),
	        'id' => 'header-widget',
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title' => '<h3 class="widget-title">',
	        'after_title' => '</h3>',
	   		 )
     	);
	}

}
add_action( 'widgets_init', 'minimal_business_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function minimal_business_scripts() {

	$minimal_business_font_args = array(
		
        'family' => 'Open+Sans:400,600,700,800,300|PT+Sans:400,700|Lato:400,700,300|BenchNine:300|Roboto+Slab:300|Source+Sans+Pro:400,300,600,700|Raleway:400,500,600,700,800,300|Roboto:300,400,500,700|Poppins:300,400,500,600,700',
    );

    wp_enqueue_style( 'minimal-business-google-fonts', add_query_arg( $minimal_business_font_args, "//fonts.googleapis.com/css" ) );

	// Load OWl Carousel
    wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri().'/assest/css/owl.carousel.css',array(), 'v2.2.1', 'all' );
    // Load OWL Theme
    wp_enqueue_style( 'owl-theme-css', get_template_directory_uri().'/assest/css/owl.theme.css',array(), 'v2.2.0', 'all' );
    // Bootstrap CSS
    wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/assest/css/bootstrap.min.css',array(), 'v3.3.5', 'all' );
    // Mean Menu CSS
    wp_enqueue_style( 'meanmenu-css', get_template_directory_uri().'/assest/css/meanmenu.css',array(), 'v2.0.2', 'all' );

    // Font Awesome  CSS
    wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assest/css/font-awesome.min.css',array(), '4.6.3 ', 'all' );

   	wp_enqueue_style( 'minimal-business-style', get_stylesheet_uri() );

    // Mean Menu JS
   	wp_enqueue_script( 'meanmenu.js', get_template_directory_uri().'/assest/js/jquery.meanmenu.js', array( 'jquery' ), 'v2.0.2', true );
   	
   	// Bootstrap JS
	wp_enqueue_script( 'jquery-bootstrap', get_template_directory_uri().'/assest/js/bootstrap.min.js', array( 'jquery' ), ' v3.3.5', true );

	// Load OWl Carousel
	wp_enqueue_script( 'jquery-owl-carousel', get_template_directory_uri().'/assest/js/owl.carousel.js', array( 'jquery' ), 'v2.2.1', true );

	wp_enqueue_script( 'minimal-business-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'minimal-business-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    wp_enqueue_script( 'minimal-business-custom',get_template_directory_uri().'/assest/js/custom.js', array('jquery'), '',true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}

add_action( 'wp_enqueue_scripts', 'minimal_business_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Custom Customizer file.
 */
require get_template_directory() . '/inc/minimal-business-customizer.php';

/**
 * Load Custom functions file.
 */

require get_template_directory() . '/inc/minimal-business-function.php';

/**
 *  minimal-business Metabox
 */
require  get_template_directory()  . '/inc/metabox.php';


/** Follow Widget **/
require get_template_directory() . '/inc/widgets/widgets-follow.php';

/** Widget Fields **/
require get_template_directory() . '/inc/widgets/widgets-field.php';


/** TGM Plugins Activations  **/

require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Load Jetpack compatibility file.     
 */

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';	
}
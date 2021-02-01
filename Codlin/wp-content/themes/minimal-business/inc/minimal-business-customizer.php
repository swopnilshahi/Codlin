<?php
/**
 * Theme Customizer Custom
 *
 * @package Minimal_Business
 */

function minimal_business_custom_customize_register( $wp_customize ) { 

	require get_template_directory() . '/inc/minimal-business-sanitizer.php';

	//Minimal Business  Category Posts List.

    $minimal_business_category_lists = minimal_business_category_lists();

    /****************  Add Deafult  Pannel   ***********************/
    
	$wp_customize->add_panel('minimal_business_default_setups',
		array(
			'priority' => 10,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Default/Basic Setting','minimal-business'),
	));

	/****************  Add Default Sections to General Panel ************/
	$wp_customize->get_section('title_tagline')->panel = 'minimal_business_default_setups'; //priority 20
	$wp_customize->get_section('colors')->panel = 'minimal_business_default_setups'; //priority 40
	$wp_customize->get_section('background_image')->panel = 'minimal_business_default_setups'; //priority 80
	$wp_customize->get_section('static_front_page')->panel = 'minimal_business_default_setups'; //priority 120

  	$wp_customize->get_section( 'header_image' )->panel = 'minimal_business_header_setups';
  	$wp_customize->get_section( 'header_image' )->title = esc_html__( 'Innerpages Header Image', 'minimal-business' );
  	$wp_customize->get_section( 'header_image' )->priority = 25;
    
    // Site Identity 
    $wp_customize->add_setting('site_identity_options', 
        array(
        'default'           => 'title-text',
        'sanitize_callback' => 'minimal_business_sanitize_select'
        )
    );
    $wp_customize->add_control('site_identity_options', 
        array(    
        'priority' => 20,  
        'label'     => esc_html__('Choose Options', 'minimal-business'),
        'section'   => 'title_tagline',
        'settings'  => 'site_identity_options',
        'type'      => 'radio',
        'choices'   =>  array(
              'logo-only'     => esc_html__('Logo Only', 'minimal-business'),
              'logo-text'     => esc_html__('Logo + Tagline', 'minimal-business'),
              'title-only'    => esc_html__('Title Only', 'minimal-business'),
              'title-text'    => esc_html__('Title + Tagline', 'minimal-business')
            )
        )
    );    
	$wp_customize->add_panel('minimal_business_header_setups',
	array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__('General  Setting','minimal-business'),
	));
	$wp_customize->add_section('minimal_business_header_settings',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Header Section Settings','minimal-business'),
			'panel' => 'minimal_business_header_setups'
		));

	// Header Enable/Disable Options
	$wp_customize->add_setting('minimal_business_header_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
	$wp_customize->add_control('minimal_business_header_option',
  		array(
            'description'   =>  esc_html__('Enable/Disable Header Feature Section','minimal-business'),
            'section'       =>  'minimal_business_header_settings',
            'setting'       =>  'minimal_business_header_option',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		    )
		)
	 );
	// Header Search
	$wp_customize->add_setting('minimal_business_header_feature',
        array(
            'default'           => 'header-search',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );      
  	$wp_customize->add_control( 'minimal_business_header_feature',
        array(
            'label'    => esc_html__( 'Header Features Section', 'minimal-business' ),
            'section'  => 'minimal_business_header_settings',
            'type' => 'radio',
            'choices'  => array(
                'header-search' => esc_html__( 'Search', 'minimal-business' ),
                'header-callto' => esc_html__( 'Call To Action', 'minimal-business'),
                'header-button' => esc_html__( 'Button', 'minimal-business'),
                'header-widget' => esc_html__( 'Widget', 'minimal-business'),
            ),
            'priority' => 6
        )
    );
  	// Header Call to Action
	$wp_customize->add_setting('minimal_business_header_callto_text',
		array(
			'default' => esc_html__( 'Sign Up Now', 'minimal-business' ),
			'sanitize_callback' => 'minimal_business_sanitize_text',
			)
		);
	$wp_customize->add_control('minimal_business_header_callto_text',
		array(
			'type' => 'textarea',
			'label' => esc_html__(' Header Call To Text  ','minimal-business'),
			'description' => esc_html__('Enter text or HTML for call to actions','minimal-business'),
			'section' => 'minimal_business_header_settings',
			'active_callback' => 'minimal_business_header_menu_layout',
			'priority' => 7
		)
	);
	// Header Button
	$wp_customize->add_setting('minimal_business_header_button',
		array(
			'default' => esc_html__( 'Sign Up Now', 'minimal-business' ),
			'sanitize_callback' => 'sanitize_text_field',
			)
		);
	$wp_customize->add_control('minimal_business_header_button',
		array(
			'type' => 'text',
			'label' => esc_html__(' Button','minimal-business'),
			'section' => 'minimal_business_header_settings',
			'active_callback' => 'minimal_business_header_button_layout',
			'priority' => 7
		)
	);	
    // Read More link
	$wp_customize->add_setting('minimal_business_header_button_link', 
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',		
		)
	);
	$wp_customize->add_control('minimal_business_header_button_link',
		array(
			'type' => 'text',
			'label' => esc_html__('Button Link','minimal-business'),
			'active_callback' => 'minimal_business_header_button_layout',
			'section' => 'minimal_business_header_settings',
			'setting' => 'minimal_business_header_button_link'
		)
	);


	//starting weblyout
  $wp_customize->add_section('minimal_business_weblayout',
	     array(
	       	'priority' => 50,
	       	'title' => esc_html__('Web Layout', 'minimal-business'),
	       	'panel' => 'minimal_business_header_setups'
		)); 
  $wp_customize->add_setting('minimal_business_weblayout',
	     array(
	        'default' => 'fullwidth',
	        'capability' => 'edit_theme_options',
	        'sanitize_callback' => 'minimal_business_webpagelayout',
	    ));
  $wp_customize->add_control('minimal_business_weblayout',
	     array(
	        'type' => 'radio',
	        'label' => esc_html__('Choose The Layout That You Want', 'minimal-business'),
	        'section' => 'minimal_business_weblayout',
	        'setting' => 'minimal_business_weblayout',
	        'choices' => array(
	        'fullwidth' => esc_html__('Full  Layout', 'minimal-business'),
	        'boxed' => esc_html__('Boxed Layout', 'minimal-business')
	        )
	    ));

	//Breadcrumb  Enable/Disable

	$wp_customize->add_setting('minimal_business_breadcrumb_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
	$wp_customize->add_control('minimal_business_breadcrumb_option',
  		array(
            'description'   =>  esc_html__('Enable/Disable This Section','minimal-business'),
            'section'       =>  'header_image',
            'setting'       =>  'minimal_business_breadcrumb_option',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		          )
		     )
		 );

	// Footer Copyright Section

	$wp_customize->add_section('minimal_business_footer_cpy',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Footer Copy Right Section','minimal-business'),
			'description' => esc_html__('Manage Footer  Section  for Footer Copy Right','minimal-business'),
			'panel' => 'minimal_business_header_setups'
		)
	);
	$wp_customize->add_setting( 'minimal_business_copyright_text',
		array(
			'default' => esc_html__( 'All Rights Reserved', 'minimal-business' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control('minimal_business_copyright_text',
		array(
			'type' => 'text',
			'label' => esc_html__( 'Copyright Text', 'minimal-business' ),
			'section' => 'minimal_business_footer_cpy',
			'priority' => 5
		)
	);
    //Scroll to Top  Enable/Disable
	$wp_customize->add_setting('minimal_business_scroll_to_top',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  	$wp_customize->add_control('minimal_business_scroll_to_top',
  		array(
            'description'   =>  esc_html__('Enable/Disable Scroll to Top','minimal-business'),
            'section'       =>  'minimal_business_footer_cpy',
            'setting'       =>  'minimal_business_scroll_to_top',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		          )
		     )
		 );	


  /** Starting Home Page Section  **/

	$wp_customize->add_panel('minimal_business_homepage_setups',
		array(
			'priority' => 16,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Home Page Setting ','minimal-business'),
			));

    /** Home Page Content */
	$wp_customize->add_section('minimal_business_home_page',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Home Page Content','minimal-business'),
			'panel' => 'minimal_business_homepage_setups'
	));
    //Banner  Enable/Disable
	$wp_customize->add_setting('minimal_business_home_page_content',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  	$wp_customize->add_control('minimal_business_home_page_content',
  		array(
            'description'   =>  esc_html__('Enable/Disable Home Content','minimal-business'),
            'section'       =>  'minimal_business_home_page',
            'setting'       =>  'minimal_business_home_page_content',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		          )
		     )
		 );	

    /** Starting Main Banner */
	$wp_customize->add_section('minimal_business_banner_setups',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Main Banner Section','minimal-business'),
			'description' => esc_html__('Manage Banner Images/Title/Description','minimal-business'),
			'panel' => 'minimal_business_homepage_setups'
		));

    //Banner  Enable/Disable
	$wp_customize->add_setting('minimal_business_banner_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  	$wp_customize->add_control('minimal_business_banner_option',
  		array(
            'description'   =>  esc_html__('Enable/Disable Banner Section','minimal-business'),
            'section'       =>  'minimal_business_banner_setups',
            'setting'       =>  'minimal_business_banner_option',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		          )
		     )
		 );
    $wp_customize->add_setting('minimal_business_banner_layout',
			array(
			    'default'           => 'layout-1',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);  

	$wp_customize->add_control('minimal_business_banner_layout',
	    array(
	        'label'    => esc_html__( 'Available Banner ', 'minimal-business' ),
	        'section'  => 'minimal_business_banner_setups',
	        'type' => 'radio',
	        'choices'  => array(
	                'layout-1' => esc_html__( 'Slider Category', 'minimal-business' ),
	                'layout-2' => esc_html__( 'Page Banner Image', 'minimal-business'),
	        ),
	        'priority' => 2
	    )
	);

	$wp_customize->add_setting('minimal_business_page',
		array(
			'default'           =>  0,
			'sanitize_callback' =>  'minimal_business_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control('minimal_business_page',
		array(
			'priority'=>    3,
			'label'   =>    esc_html__( 'Select Page For Banner Section','minimal-business' ),
			'section' =>    'minimal_business_banner_setups',
			'setting' =>    'minimal_business_page',
			'type'    =>    'dropdown-pages',
			'active_callback' => 'minimal_business_banner_layout'
		)                                     
	);

    //Select Category For Slider Section

	$wp_customize->add_setting('minimal_business_slider_section_cat',
	 	array(
			'default'           =>  0,
			'sanitize_callback' =>  'minimal_business_sanitize_category_select',
				)
			);
	$wp_customize->add_control('minimal_business_slider_section_cat',
        array(
			'priority'      =>  4,
			'label'         =>  esc_html__('Select Category For Slider Section','minimal-business'),
			'section'       =>  'minimal_business_banner_setups',
			'setting'       =>  'minimal_business_slider_section_cat',
			'type'          =>  'select',
			'choices'       =>  $minimal_business_category_lists,
			'active_callback' => 'minimal_business_slider_layout_active'
			)
		);

  $wp_customize->add_setting('minimal_business_slider_layout',
    array(
	      'default'           => 'layout-1',
	      'sanitize_callback' => 'minimal_business_layout_call_back',
    )
  );      
  $wp_customize->add_control('minimal_business_slider_layout',
    array(
	      'label'    => esc_html__( 'Slider Layout', 'minimal-business' ),
	      'section'  => 'minimal_business_banner_setups',
	      'type' => 'radio',
	      'choices'  => array(
	      'layout-1' => esc_html__( 'Layout 1', 'minimal-business' ),
	      'layout-2' => esc_html__( 'Layout 2', 'minimal-business'),
      
    ),
      'active_callback' => 'minimal_business_slider_layout_active',
    'priority' => 5,
    )
  );
    //Slider Read More Text

    $wp_customize->add_setting('minimal_business_slider_readmore',
    	array(
	        'default'           =>  esc_html__('Read  More','minimal-business'),
	        'sanitize_callback' =>  'sanitize_text_field',
        )
    );

    $wp_customize->add_control('minimal_business_slider_readmore',
    	array(
	        'priority'      =>  6,
	        'label'         =>  esc_html__('Read More','minimal-business'),
	        'section'       =>  'minimal_business_banner_setups',
	        'setting'       =>  'minimal_business_slider_readmore',
	        'type'          =>  'text',  
	        'active_callback' => 'minimal_business_slider_layout_active'
        )                                     
    );

    //Slider read more text

    $wp_customize->add_setting('minimal_business_slider_contact_now',
    	array(
	        'default'           =>  esc_html__('Contact Us','minimal-business'),
	        'sanitize_callback' =>  'sanitize_text_field',
        )
    );

    $wp_customize->add_control('minimal_business_slider_contact_now',
    	array(
	        'priority'      =>  7,
	        'label'         =>  esc_html__('Contact Us','minimal-business'),
	        'section'       =>  'minimal_business_banner_setups',
	        'setting'       =>  'minimal_business_slider_contact_now',
	        'type'          =>  'text',  
	        'active_callback' => 'minimal_business_slider_layout_active'
        )                                     
    );

       // Read More link
	$wp_customize->add_setting('minimal_business_contact_us_link', 
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',		
		)
	);
	$wp_customize->add_control('minimal_business_contact_us_link',
		array(
			'priority'      =>  8,
			'type' => 'text',
			'label' => esc_html__('Contact Us Link','minimal-business'),
			'section' => 'minimal_business_banner_setups',
			'setting' => 'minimal_business_contact_us_link',
			'active_callback' => 'minimal_business_slider_layout_active'
		)
	);

  	// Slider Post Number Count
  	$wp_customize->add_setting('minimal_business_slider_num', 
  		array(
	    	'default' => 5,
	        'sanitize_callback' => 'minimal_business_integer_sanitize',
  		)
	);
    
    $wp_customize->add_control('minimal_business_slider_num',
    	array(
	        'type' => 'number',
	        'label' => esc_html__('No. of Slider','minimal-business'),
	        'section' => 'minimal_business_banner_setups',
	        'setting' => 'minimal_business_slider_num',
	        'input_attrs' => array(
			    'min' => 1,
			    'max' => 9,
		   	),
		   	'active_callback' => 'minimal_business_slider_layout_active'
   		)
   	);


    /***********************************  Starting Call To Action  **********************************************/

	$wp_customize->add_section('minimal_business_callto_setups',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__('Call To Section','minimal-business'),
			'description' => esc_html__('Manage Call To Action Section','minimal-business'),
			'panel' => 'minimal_business_homepage_setups'
		));

    //Banner  Enable/Disable
	$wp_customize->add_setting('minimal_business_callto_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  $wp_customize->add_control('minimal_business_callto_option',
  	array(
          'description'   =>  esc_html__('Enable/Disable This Section','minimal-business'),
          'section'       =>  'minimal_business_callto_setups',
          'setting'       =>  'minimal_business_callto_option',
          'priority'      =>  1,
          'type'          =>  'radio',
          'choices'        =>  array(
              'yes'   =>  esc_html__('Yes','minimal-business'),
              'no'    =>  esc_html__('No','minimal-business')
            )
       )
   );

	/* Call To Action  Title */
	$wp_customize->add_setting('minimal_business_section_title',
      	array(
          'default'           =>  esc_html__('Are You An Artist or Agent?','minimal-business'),
          'sanitize_callback' =>  'sanitize_text_field',
          	)
    	  );
	$wp_customize->add_control(	'minimal_business_section_title',
		array(
			'priority'      =>  2,
			'label'         =>  esc_html__('Call To Action Title Text','minimal-business'),
			'section'       =>  'minimal_business_callto_setups',
			'setting'       =>  'minimal_business_section_title',
			'type'          =>  'text',  
		)                                     
	);
  $wp_customize->add_setting('minimal_business_call_to_page',
	  array(
	    'default'           =>  0,
	    'sanitize_callback' =>  'minimal_business_sanitize_dropdown_pages',
	  )
	 );

$wp_customize->add_control('minimal_business_call_to_page',
    array(
	    'priority'=>    3,
	    'label'   =>    esc_html__( 'Select Page For Service Section','minimal-business' ),
	    'description'   =>  esc_html__('This Page Will Display Title And Subtitle','minimal-business'),
	    'section' =>    'minimal_business_callto_setups',
	    'setting' =>    'minimal_business_call_to_page',
	    'type'    =>    'dropdown-pages',
	  )                                     
);
	//Call To Action Read More Text

  $wp_customize->add_setting('minimal_business_callto_readmore',
  	array(
		'default'           =>  esc_html__('Creat Your Profile Page Now','minimal-business'),
		'sanitize_callback' =>  'sanitize_text_field',
		)
	);

  $wp_customize->add_control('minimal_business_callto_readmore',
  	array(
		'priority'      =>  4,
		'label'         =>  esc_html__('Read More Text','minimal-business'),
		'section'       =>  'minimal_business_callto_setups',
		'setting'       =>  'minimal_business_callto_readmore',
		'type'          =>  'text',  
		)                                     
	);

    //Call To Action Link

    $wp_customize->add_setting('minimal_business_call_to_link',
    	array(
            'default'           =>  esc_html__('# ','minimal-business'),
            'sanitize_callback' =>  'esc_url_raw',
		         )
		  );

    $wp_customize->add_control('minimal_business_call_to_link',
    	array(
            'priority'      =>  5,
            'label'         =>  esc_html__('Call To Link','minimal-business'),
            'section'       =>  'minimal_business_callto_setups',
            'setting'       =>  'minimal_business_call_to_link',
            'type'          =>  'text',  
		    )                                     
	 );


   	/***********************************  Starting Service Section **********************************************/

	$wp_customize->add_section('minimal_business_service_setups',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__(' Service Section','minimal-business'),
			'description' => esc_html__('Manage Service Section','minimal-business'),
			'panel' => 'minimal_business_homepage_setups'
		));

    //Service Section  Enable/Disable

	$wp_customize->add_setting('minimal_business_service_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  	$wp_customize->add_control('minimal_business_service_option',
  		array(
            'description'   =>  esc_html__('Enable/Disable This Section','minimal-business'),
            'section'       =>  'minimal_business_service_setups',
            'setting'       =>  'minimal_business_service_option',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		        )
		    )
		);

  $wp_customize->add_setting('minimal_business_service_page',
      array(
		'default'           =>  0,
		'sanitize_callback' =>  'minimal_business_sanitize_dropdown_pages',
    )
  );

  $wp_customize->add_control('minimal_business_service_page',
    array(
		'priority'=>    2,
		'label'   =>    esc_html__( 'Select Page For Service Section','minimal-business' ),
		'description'   =>  esc_html__('This Page Will Display Title And Subtitle','minimal-business'),
		'section' =>    'minimal_business_service_setups',
		'setting' =>    'minimal_business_service_page',
		'type'    =>    'dropdown-pages',
    )                                     
  );

	//Select Category For Service Section

	$wp_customize->add_setting('minimal_business_service_section_cat',
	 	array(
			'default'           =>  0,
			'sanitize_callback' =>  'minimal_business_sanitize_category_select',
				)
			);
	$wp_customize->add_control('minimal_business_service_section_cat',
        array(
			'priority'      =>  3,
			'label'         =>  esc_html__('Select category for Service Section','minimal-business'),
			'section'       =>  'minimal_business_service_setups',
			'setting'       =>  'minimal_business_service_section_cat',
			'type'          =>  'select',
			'choices'       =>  $minimal_business_category_lists
				)
			);


  // Service Section Post Number Count

    $wp_customize->add_setting('minimal_business_service_num', 
      array(
			'default' => 5,
			'sanitize_callback' => 'minimal_business_integer_sanitize',
        ));
    
    $wp_customize->add_control('minimal_business_service_num',
    	array(
			'priority'      =>  4,
			'type' => 'number',
			'label' => esc_html__('No. of Service Post','minimal-business'),
			'section' => 'minimal_business_service_setups',
			'setting' => 'minimal_business_service_num',
			'input_attrs' => array(
			'min' => 1,
			'max' => 9,
     ),
    )); 

	$wp_customize->add_setting('minimal_business_service_readmore',
		array(
			'default'           =>  esc_html__('Learn More','minimal-business'),
			'sanitize_callback' =>  'sanitize_text_field',
		)
	);

	$wp_customize->add_control('minimal_business_service_readmore',
		array(
			'priority'      =>  5,
			'label'         =>  esc_html__('Learn More Text','minimal-business'),
			'section'       =>  'minimal_business_service_setups',
			'setting'       =>  'minimal_business_service_readmore',
			'type'          =>  'text',  
			)                                     
		);	


   	//Enable/Disable Read More

   	$wp_customize->add_setting('minimal_business_service_readmore_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  	$wp_customize->add_control('minimal_business_service_readmore_option',
  		array(
            'description'   =>  esc_html__('Enable/Disable Read More For  This Section','minimal-business'),
            'section'       =>  'minimal_business_service_setups',
            'setting'       =>  'minimal_business_service_readmore_option',
            'priority'      =>  6,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		       )
		)
	);

	/***********************************  Starting Subscribe Section **********************************************/	

	$wp_customize->add_section('minimal_business_subscribe_setups',
		array(
			'priority' => 1,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => esc_html__(' Subscribe Section','minimal-business'),
			'description' => esc_html__('Manage Subscribe Section','minimal-business'),
			'panel' => 'minimal_business_homepage_setups'
		)  
	);

    // Subscribe Section  Enable/Disable

	$wp_customize->add_setting('minimal_business_subscribe_option',
        array(
            'default'           =>  'no',
            'sanitize_callback' =>  'minimal_business_sanitize_option',
            )
        );
  	$wp_customize->add_control('minimal_business_subscribe_option',
  		array(
            'description'   =>  esc_html__('Enable/Disable This Section','minimal-business'),
            'section'       =>  'minimal_business_subscribe_setups',
            'setting'       =>  'minimal_business_subscribe_option',
            'priority'      =>  1,
            'type'          =>  'radio',
            'choices'        =>  array(
                'yes'   =>  esc_html__('Yes','minimal-business'),
                'no'    =>  esc_html__('No','minimal-business')
		        )
		 )
	);
  
  $wp_customize->add_setting('minimal_business_subscribe_page',
    array(
	    'default'           =>  0,
	    'sanitize_callback' =>  'minimal_business_sanitize_dropdown_pages',
    )
  );

  $wp_customize->add_control('minimal_business_subscribe_page',
    array(
	      'priority'=>    3,
	      'label'   =>    esc_html__( 'Select Page For Subscribe Section','minimal-business' ),
	      'section' =>    'minimal_business_subscribe_setups',
	      'setting' =>    'minimal_business_subscribe_page',
	      'type'    =>    'dropdown-pages',
    )                                     
  );

  $wp_customize->add_setting('minimal_business_page_subcribe_bg_image',
    array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
      )
    );
  $wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize,'minimal_business_page_subcribe_bg_image',
         array(
             'label'      => __( ' Subscribe Background Image ', 'minimal-business' ),
             'section'    => 'minimal_business_subscribe_setups',
             'settings'   => 'minimal_business_page_subcribe_bg_image',
             'priority' => 10,
         )
     )
  );

/*********************************** Client  Section  **********************************************/


$wp_customize->add_section('minimal_business_client_section',
  array(
    'priority' => '1',
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => esc_html__('Client Section ','minimal-business'),
    'description' => esc_html__('Manage Client Section Settings','minimal-business'),
    'panel' => 'minimal_business_homepage_setups'
)
);
$wp_customize->add_setting('minimal_business_client_option',
  array(
      'default'           =>  'no',
      'sanitize_callback' =>  'minimal_business_sanitize_option',
      )
  );
$wp_customize->add_control('minimal_business_client_option',
  array(
    'description'   =>  esc_html__('Enable/Disable Client  Section','minimal-business'),
    'section'       =>  'minimal_business_client_section',
    'setting'       =>  'minimal_business_client_option',
    'priority'      =>  1,
    'type'          =>  'radio',
    'choices'        =>  array(
        'yes'   =>  esc_html__('Yes','minimal-business'),
        'no'    =>  esc_html__('No','minimal-business')
          )
     )
);

  //Select Category For Client Section

$wp_customize->add_setting('minimal_business_client_section_cat',
  array(
      'default'           =>  0,
      'sanitize_callback' =>  'minimal_business_sanitize_category_select',
      )
    );
$wp_customize->add_control('minimal_business_client_section_cat',
      array(
      'priority'      =>  4,
      'label'         =>  esc_html__('Select Category For Client Section','minimal-business'),
      'section'       =>  'minimal_business_client_section',
      'setting'       =>  'minimal_business_client_section_cat',
      'type'          =>  'select',
      'choices'       =>  $minimal_business_category_lists,
    )
  );

$wp_customize->add_setting('minimal_business_client_layout',
    array(
      'default'           => 'layout-1',
      'sanitize_callback' => 'minimal_business_layout_call_back',
    )
  );      
$wp_customize->add_control('minimal_business_client_layout',
    array(
      'label'    => esc_html__( 'Client Layout', 'minimal-business' ),
      'section'  => 'minimal_business_client_section',
      'type' => 'radio',
      'choices'  => array(
      'layout-1' => esc_html__( 'Layout 1', 'minimal-business' ),
      'layout-2' => esc_html__( 'Layout 2', 'minimal-business'),
    ),
    'priority' => 8
    )
  );
// Client Post Number Count

$wp_customize->add_setting('minimal_business_client_num', 
  array(
    'default' => 5,
      'sanitize_callback' => 'minimal_business_integer_sanitize',
  )
);
  
$wp_customize->add_control('minimal_business_client_num',
  array(
      'type' => 'number',
      'label' => esc_html__('No. of Client Post','minimal-business'),
      'section' => 'minimal_business_client_section',
      'setting' => 'minimal_business_client_num',
      'input_attrs' => array(
      'min' => 1,
      'max' => 20,
    ),
    'active_callback' => 'minimal_business_slider_layout_active'
  )
);

//Archive Page Settings panel

$wp_customize->add_panel('minimal_business_archive_section', 
	array(
    'capabitity' => 'edit_theme_options',
    'priority' => 38,
    'title' => __('Archive Page Settings', 'minimal-business')
		)
);

  $wp_customize->add_section('minimal_business_archive',
        array(
          'title' => __('Archive Sidebar Settings', 'minimal-business'),
          'panel' => 'minimal_business_archive_section'
          )
      );

  $wp_customize->add_setting('minimal_business_archive_setting_sidebar_option',
      array(
        'default' =>  'sidebar-right',
        'sanitize_callback' =>  'minimal_business_radio_sanitize_archive_sidebar'
        )
      );  

  $wp_customize->add_control('minimal_business_archive_setting_sidebar_option',
      array(
        'description' => __('Choose the sidebar Layout for the archive page','minimal-business'),
        'section' => 'minimal_business_archive',
        'type'    =>  'radio',
        'choices' =>  array(
            'sidebar-left' =>  __('Sidebar Left','minimal-business'),
            'sidebar-right' =>  __('Sidebar Right','minimal-business'),
            'sidebar-both' =>  __('Sidebar Both','minimal-business'),
            'sidebar-no' =>  __('Sidebar No','minimal-business'),
          )
        )
    );

  $wp_customize->add_section('minimal_business_archive_Settings',
    array(
      'title' => __('Archive  Settings', 'minimal-business'),
      'panel' => 'minimal_business_archive_section'
      )
 	 );

  $wp_customize->add_setting('minimal_archive_section_date',
	    array(
	        'default'           =>  'no',
	        'sanitize_callback' =>  'minimal_business_sanitize_option',
	        )
	    );
	$wp_customize->add_control('minimal_archive_section_date',array(
	        'description'   =>  esc_html__('Enable/Disable Date','minimal-business'),
	        'section'       =>  'minimal_business_archive_Settings',
	        'setting'       =>  'minimal_archive_section_date',
	        'priority'      =>  3,
	        'type'          =>  'radio',
	        'choices'        =>  array(
	            'yes'   =>  esc_html__('Yes','minimal-business'),
	            'no'    =>  esc_html__('No','minimal-business')
	            )
	        )
	    );
	$wp_customize->add_setting('minimal_archive_section_author',
	    array(
	        'default'           =>  'no',
	        'sanitize_callback' =>  'minimal_business_sanitize_option',
	        )
	    );
	$wp_customize->add_control('minimal_archive_section_author',array(
	        'description'   =>  esc_html__('Enable/Disable Author','minimal-business'),
	        'section'       =>  'minimal_business_archive_Settings',
	        'setting'       =>  'minimal_archive_section_author',
	        'priority'      =>  3,
	        'type'          =>  'radio',
	        'choices'        =>  array(
	            'yes'   =>  esc_html__('Yes','minimal-business'),
	            'no'    =>  esc_html__('No','minimal-business')
	            )
	        )
	    );
	$wp_customize->add_setting(
	            'minimal_business_archive_submit',array(
	                'default'           =>  esc_html__('Read More ','minimal-business'),
	                'sanitize_callback' =>  'sanitize_text_field',
	                )
	            );

	$wp_customize->add_control(
	            'minimal_business_archive_submit',array(
	                'priority'      =>  4,
	                'label'         =>  esc_html__('Read More ','minimal-business'),
	                'section'       =>  'minimal_business_archive_Settings',
	                'setting'       =>  'minimal_business_archive_submit',
	                'type'          =>  'text',  
	                )                                     
	            );
	$wp_customize->add_setting('minimal_archive_section_redmore_optons',
	    array(
	        'default'           =>  'no',
	        'sanitize_callback' =>  'minimal_business_sanitize_option',
	        )
	    );
	$wp_customize->add_control('minimal_archive_section_redmore_optons',array(
	        'description'   =>  esc_html__('Enable/Disable Read More','minimal-business'),
	        'section'       =>  'minimal_business_archive_Settings',
	        'setting'       =>  'minimal_archive_section_redmore_optons',
	        'priority'      =>  5,
	        'type'          =>  'radio',
	        'choices'        =>  array(
	            'yes'   =>  esc_html__('Yes','minimal-business'),
	            'no'    =>  esc_html__('No','minimal-business')
	            )
	        )
	    );
    
	}
add_action( 'customize_register', 'minimal_business_custom_customize_register' );	
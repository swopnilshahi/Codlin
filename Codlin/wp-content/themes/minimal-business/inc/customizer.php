<?php

/**
 * Minimal_Business Theme Customizer
 *
 * @package Minimal_Business
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function minimal_business_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'minimal_business_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'minimal_business_customize_partial_blogdescription',
		) );
	}

   	/** Separator Class **/
	class minimal_business_Customize_Section_Separator extends WP_Customize_Control {
	    
	    public $type = 'minimal_business_separator';

	    public function render_content() {
	  ?>
	    <div class="customize-section-wrap">
	      <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	      </label>
	    </div>
	  <?php
	    }
	  }

	 /** Fa Icons List **/
  	class minimal_business_Customize_Icons_Control extends WP_Customize_Control {

	    public $type = 'minimal_business_icons';

	    public function render_content() {

		      $saved_icon_value = $this->value();
		  	   ?>
		      <label>
			        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			        <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>

    			        <div class="fa-icons-list">

    				          <div class="selected-icon-preview"><?php if( !empty( $saved_icon_value ) ) { echo '<i class="fa '. esc_attr($saved_icon_value) .'"></i>'; } ?>            
                              </div>
    				          <ul class="icons-list-wrapper">
    					            <?php 
    					              $minimal_business_icons_list = minimal_business_icons_array();
    					              foreach ( $minimal_business_icons_list as $key => $icon_value ) {
    					                if( $saved_icon_value == $icon_value ) {
    					                  echo '<li class="selected"><i class="fa '. esc_attr($icon_value) .'"></i></li>';
    					                } else {
    					                  echo '<li><i class="fa '. esc_attr($icon_value) .'"></i></li>';
    					                }
    					              }
    					            ?>
    				          </ul>

    				          <input type="hidden" class="ap-icon-value" value="" <?php $this->link(); ?>>

    			        </div>

		      </label>
	  <?php
	    }
	 }
	 
}
add_action( 'customize_register', 'minimal_business_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function minimal_business_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function minimal_business_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function minimal_business_customize_preview_js() {
	wp_enqueue_script( 'minimal-business-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'minimal_business_customize_preview_js' );


function minimal_customize_backend_scripts() {
  
	// Load fontawesome
wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assest/css/font-awesome.min.css', array(), '4.4.0' );

wp_enqueue_script( 'minimal-business-customizer-scripts', get_template_directory_uri() . '/inc/js/customizer-scripts.js', array( 'jquery', 'customize-controls' ), '20160714', true );

wp_enqueue_style( 'minimal-business-customizer-style', get_template_directory_uri() . '/inc/css/customizer-style.css' );
	
}
add_action( 'customize_controls_enqueue_scripts', 'minimal_customize_backend_scripts', 10 );

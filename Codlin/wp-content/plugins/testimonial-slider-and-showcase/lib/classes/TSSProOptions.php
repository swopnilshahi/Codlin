<?php
if ( ! class_exists( 'TSSProOptions' ) ) :
	class TSSProOptions {

		function generalSettings() {
			$settings = get_option( TSSPro()->options['settings'] );

			return array(
				'slug' => array(
					'label'       => __( 'Slug', 'testimonial-slider-showcase' ),
					'type'        => 'text',
					'description' => __( 'Slug configuration', 'testimonial-slider-showcase' ),
					'attr'        => "size='10'",
					'value'       => ( ! empty( $settings['slug'] ) ? sanitize_title_with_dashes( $settings['slug'] ) : 'testimonial' )
				)
			);
		}

		function tssFrontEndSubmitFields() {
			$fields       = $this->formAllFields();
			$settings     = get_option( TSSPro()->options['settings'] );
			$activeFields = ( ! empty( $settings['form_fields'] ) ? $settings['form_fields'] : array() );
			$activeFields = array_merge( $activeFields, array_keys( $this->frontEndFields() ) );
			$newFields    = array();
			foreach ( $fields as $key => $value ) {
				if ( in_array( $key, $activeFields ) ) {
					$newFields[ $key ] = $value;
				}
			}

			return $newFields;
		}

		function formAllFields() {
			$fields                                 = $this->singleTestimonialFields();
			$fields['tss_social_media']['frontEnd'] = true;
			$fields                                 = $this->frontEndFields() + $fields + $this->frontEndRecaptcha();

			return $fields;
		}

		function frontEndRecaptcha() {
			return array(
				'tss_recaptcha' => array(
					'type' => 'recaptcha'
				),
			);
		}

		function frontEndFields() {
			return array(
				'tss_name'        => array(
					'label' => __( 'Name', 'testimonial-slider-showcase' ),
					'type'  => 'text'
				),
				'tss_testimonial' => array(
					'label' => __( 'Testimonial', 'testimonial-slider-showcase' ),
					'type'  => 'textarea',
				),
			);
		}

		function get_formFieldControl_fields() {
			$fields   = $this->formAllFields();
			$newField = array();
			foreach ( $fields as $key => $value ) {
				if ( ! in_array( $key, array( 'tss_name', 'tss_testimonial' ) ) ) {
					if ( $key == "tss_recaptcha" ) {
						$newField[ $key ] = __( "reCAPTCHA", 'testimonial-slider-showcase' );
					} else {
						$newField[ $key ] = $value['label'];
					}
				}
			}

			return $newField;
		}

		function othersSettings() {
			$settings = get_option( TSSPro()->options['settings'] );

			return array(
				'custom_css' => array(
					'label'       => __( 'Custom CSS', 'testimonial-slider-showcase' ),
					'type'        => 'custom_css',
					'description' => '<span style="color: red">Please use default customizer to add your css. This option is deprecated</span> ' . __( 'Add your custom css here!!!', 'testimonial-slider-showcase' ),
					'value'       => ( ! empty( $settings['custom_css'] ) ? $settings['custom_css'] : null )
				)
			);
		}

		function scItemMetaFields() {
			return array(
				"tss_item_fields" => array(
					"type"        => "checkbox",
					"label"       => __( "Field selection", 'testimonial-slider-showcase' ),
					"multiple"    => true,
					"alignment"   => "vertical",
					"default"     => array_keys( $this->sc_fieldSelection_fields() ),
					"options"     => $this->sc_fieldSelection_fields(),
					"description" => __( 'Check the field which you want to display',
						'testimonial-slider-showcase' )
				)
			);
		}

		function scLayoutMetaFields() {
			return array(
				'tss_layout'                    => array(
					'label'   => __( 'Layout', 'testimonial-slider-showcase' ),
					'type'    => 'select',
					"class"   => "rt-select2",
					'options' => $this->scLayout()
				),
				'tss_desktop_column'            => array(
					'type'    => 'select',
					'label'   => __( 'Display per row', 'testimonial-slider-showcase' ),
					'class'   => 'rt-select2',
					'default' => 3,
					'options' => $this->scColumns()
				),
				'tss_carousel_speed'            => array(
					"label"       => __( "Speed", 'testimonial-slider-showcase' ),
					"holderClass" => "tss-hidden tss-carousel-item",
					"type"        => "number",
					'default'     => 2000,
					"description" => __( 'Auto play Speed in milliseconds', 'testimonial-slider-showcase' ),
				),
				'tss_carousel_options'          => array(
					"label"       => __( "Carousel Options", 'testimonial-slider-showcase' ),
					"holderClass" => "tss-hidden tss-carousel-item",
					"type"        => "checkbox",
					"multiple"    => true,
					"alignment"   => "vertical",
					"options"     => $this->owlProperty(),
					"default"     => array( 'autoplay', 'arrows', 'dots', 'responsive', 'infinite' ),
				),
				'tss_carousel_autoplay_timeout' => array(
					"label"       => __( "Autoplay timeout", 'testimonial-slider-showcase' ),
					"holderClass" => "tss-hidden tss-carousel-auto-play-timeout",
					"type"        => "number",
					'default'     => 5000,
					"description" => __( 'Autoplay interval timeout', 'testimonial-slider-showcase' ),
				),
				'tss_pagination'                => array(
					"type"        => "checkbox",
					"label"       => __( "Pagination", 'testimonial-slider-showcase' ),
					'holderClass' => "pagination",
					"optionLabel" => __( 'Enable', 'testimonial-slider-showcase' ),
					"option"      => 1
				),
				'tss_posts_per_page'            => array(
					"type"        => "number",
					"label"       => __( "Display per page", 'testimonial-slider-showcase' ),
					'holderClass' => "tss-pagination-item tss-hidden",
					"default"     => 5,
					"description" => __( "If value of Limit setting is not blank (empty), this value should be smaller than Limit value.",
						'testimonial-slider-showcase' )
				),
				'tss_load_more_button_text'     => array(
					"type"        => "text",
					"label"       => __( "Load more button text", 'testimonial-slider-showcase' ),
					'holderClass' => "tss-load-more-item tss-hidden",
					"default"     => __( "Load more", 'testimonial-slider-showcase' )
				),
				'tss_image_size'                => array(
					"type"    => "select",
					"label"   => __( "Image Size", 'testimonial-slider-showcase' ),
					"class"   => "rt-select2",
					"options" => TSSPro()->get_image_sizes()
				),
				'tss_custom_image_size'         => array(
					"type"        => "image_size",
					"label"       => __( "Custom Image Size", 'testimonial-slider-showcase' ),
					'holderClass' => "tss-hidden",
				),
				'tss_image_type'                => array(
					"type"      => "radio",
					"label"     => __( "Image Type", 'testimonial-slider-showcase' ),
					"alignment" => "vertical",
					"default"   => 'normal',
					"options"   => $this->get_image_types()
				),
				'tss_margin'                    => array(
					"type"        => "radio",
					"label"       => __( "Margin", 'testimonial-slider-showcase' ),
					"alignment"   => "vertical",
					"description" => __( "Select the margin for layout", 'testimonial-slider-showcase' ),
					"default"     => "default",
					"options"     => $this->scMarginOpt()
				)
			);
		}

		function scFilterMetaFields() {

			return array(
				'tss_post__in'     => array(
					"label"       => __( "Include only", 'testimonial-slider-showcase' ),
					"type"        => "text",
					"description" => __( 'List of post IDs to show (comma-separated values, for example: 1,2,3)',
						'testimonial-slider-showcase' )
				),
				'tss_post__not_in' => array(
					"label"       => __( "Exclude", 'testimonial-slider-showcase' ),
					"type"        => "text",
					"description" => __( 'List of post IDs to show (comma-separated values, for example: 1,2,3)',
						'testimonial-slider-showcase' )
				),
				'tss_limit'        => array(
					"label"       => __( "Limit", 'testimonial-slider-showcase' ),
					"type"        => "number",
					"description" => __( 'The number of posts to show. Set empty to show all found posts.',
						'testimonial-slider-showcase' )
				),
				'tss_order_by'     => array(
					"label"   => __( "Order By", 'testimonial-slider-showcase' ),
					"type"    => "select",
					"class"   => "rt-select2",
					"default" => "date",
					"options" => $this->scOrderBy()
				),
				'tss_order'        => array(
					"label"     => __( "Order", 'testimonial-slider-showcase' ),
					"type"      => "radio",
					"options"   => $this->scOrder(),
					"default"   => "DESC",
					"alignment" => "vertical",
				),
			);
		}

		function singleTestimonialFields() {
			return array(
				'tss_designation' => array(
					'label' => __( 'Designation', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width'
				),
				'tss_company'     => array(
					'label' => __( 'Company', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width'
				),
				'tss_location'    => array(
					'label' => __( 'Location', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width'
				)
			);
		}

		function scStyleFields() {
			return array(
				'tss_primary_color' => array(
					"type"    => "colorpicker",
					"label"   => __( "Primary Color", 'testimonial-slider-showcase' ),
					"default" => "#0367bf"
				)
			);
		}

		function scTaxonomyRelation() {
			return array(
				'OR'  => "OR Relation",
				'AND' => "AND Relation"
			);
		}

		function overflowOpacity() {
			return array(
				10 => '10%',
				20 => '20%',
				30 => '30%',
				40 => '40%',
				50 => '50%',
				60 => '60%',
				70 => '70%',
				80 => '80%',
				90 => '90%',
			);
		}


		function get_image_types() {
			return array(
				'normal' => "Normal",
				'circle' => "Circle"
			);
		}

		function paginationType() {
			return array(
				'pagination'      => __( "Pagination", 'testimonial-slider-showcase' ),
				'pagination_ajax' => __( "Ajax Number Pagination ( Only for Grid )",
					'testimonial-slider-showcase' ),
				'load_more'       => __( "Load more button (by ajax loading)", 'testimonial-slider-showcase' ),
				'load_on_scroll'  => __( "Load more on scroll (by ajax loading)", 'testimonial-slider-showcase' )
			);
		}

		function scColumns() {
			return array(
				1 => "1 Column",
				2 => "2 Column",
				3 => "3 Column",
				4 => "4 Column",
			);
		}

		function scOrderBy() {
			return array(
				'menu_order' => "Menu Order",
				'title'      => "Name",
				'ID'         => "ID",
				'date'       => "Date"
			);
		}

		function scOrder() {
			return array(
				'ASC'  => __( "Ascending", 'testimonial-slider-showcase' ),
				'DESC' => __( "Descending", 'testimonial-slider-showcase' ),
			);
		}

		function scLayout() {
			return array(
				'layout1'   => "Grid",
				'carousel1' => "Slider",
			);
		}

		function scGridStyle() {
			return array(
				'even'    => "Even",
				'masonry' => "Masonry"
			);
		}

		function imageCropType() {
			return array(
				'soft' => __( "Soft Crop", 'testimonial-slider-showcase' ),
				'hard' => __( "Hard Crop", 'testimonial-slider-showcase' )
			);
		}

		function scFontSize() {
			$num = array();
			for ( $i = 10; $i <= 30; $i ++ ) {
				$num[ $i ] = $i . "px";
			}

			return $num;
		}

		function scMarginOpt() {
			return array(
				'default' => "Bootstrap default",
				'no'      => "No Margin"
			);
		}

		function getSocialMediaList() {
			return array(
				'facebook'   => 'Facebook',
				'twitter'    => 'Twitter',
				'googleplus' => 'Google+',
			);
		}

		function alignment() {
			return array(
				'left'    => "Left",
				'right'   => "Right",
				'center'  => "Center",
				'justify' => "Justify"
			);
		}

		function tlpOverlayBg() {
			return array(
				'0.1' => "10 %",
				'0.2' => "20 %",
				'0.3' => "30 %",
				'0.4' => "40 %",
				'0.5' => "50 %",
				'0.6' => "60 %",
				'0.7' => "70 %",
				'0.8' => "80 %",
				'0.9' => "90 %"
			);
		}

		function owlProperty() {
			return array(
				'loop'               => __( 'Loop', 'testimonial-slider-showcase' ),
				'autoplay'           => __( 'Auto Play', 'testimonial-slider-showcase' ),
				'autoplayHoverPause' => __( 'Pause on mouse hover', 'testimonial-slider-showcase' ),
				'nav'                => __( 'Nav Button', 'testimonial-slider-showcase' ),
				'dots'               => __( 'Pagination', 'testimonial-slider-showcase' ),
				'auto_height'        => __( 'Auto Height', 'testimonial-slider-showcase' )
			);
		}

		function sc_fieldSelection_fields() {

			$fields      = $this->singleTestimonialFields();
			$fieldsArray = array();
			foreach ( $fields as $index => $field ) {
				$fieldsArray[ str_replace( 'tss_', '', $index ) ] = ( $index == 'tss_video' ? __( 'Video', 'testimonial-slider-showcase' ) : $field['label'] );
			}

			$newFields = array(
				'author'      => __( 'Author', 'testimonial-slider-showcase' ),
				'author_img'  => __( "Author Image", 'testimonial-slider-showcase' ),
				'testimonial' => __( "Testimonial", 'testimonial-slider-showcase' ),
			);

			return array_merge( $newFields, $fieldsArray );
		}

		function single_page_field() {
			return $this->sc_fieldSelection_fields();
		}

		function get_pro_feature_list() {
			return $html = '<ol>
								<li>30 Amazing Layouts with Grid, Slider, Isotope & Video.</li>
								<li>Front End Submission</li>
								<li>Layout Preview in Shortcode Settings.</li>
								<li>Taxonomy Ordering</li>
							</ol>
						<a href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" class="rt-admin-btn" target="_blank">Get Pro Version</a>';
		}
	}
endif;
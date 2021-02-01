<?php
if ( ! class_exists( 'TSSProSC' ) ):
	/**
	 *
	 */
	class TSSProSC {
		private $scA = array();

		function __construct() {
			add_shortcode( 'rt-testimonial', array( $this, 'testimonial_shortcode' ) );
		}

		function register_scripts() {
			$caro   = false;
			$script = array();
			$style  = array();
			array_push( $script, 'jquery' );
			foreach ( $this->scA as $sc ) {
				if ( isset( $sc ) && is_array( $sc ) ) {
					if ( $sc['isCarousel'] ) {
						$caro = true;
					}
				}
			}

			if ( count( $this->scA ) ) {
				array_push( $script, 'tss-image-load' );
				if ( $caro ) {
					array_push( $style, 'tss-owl-carousel' );
					array_push( $style, 'tss-owl-carousel-theme' );
					array_push( $script, 'tss-owl-carousel' );
				}
				array_push( $style, 'dashicons' );
				array_push( $script, 'tss' );

				wp_enqueue_style( $style );
				wp_enqueue_script( $script );
			}

		}

		function testimonial_shortcode( $atts ) {
			$rand     = mt_rand();
			$layoutID = "tss-container-" . $rand;
			$html     = null;
			$arg      = array();
			$atts     = shortcode_atts( array(
				'id' => null
			), $atts, 'rt-testimonial' );
			$scID     = $atts['id'];
			if ( $scID && ! is_null( get_post( $scID ) ) ) {
				$scMeta = get_post_meta( $scID );
				$layout = ( ! empty( $scMeta['tss_layout'][0] ) ? $scMeta['tss_layout'][0] : 'layout1' );
				if ( ! in_array( $layout, array_keys( TSSPro()->scLayout() ) ) ) {
					$layout = 'layout1';
				}
				$dCol = ( isset( $scMeta['tss_desktop_column'][0] ) ? absint( $scMeta['tss_desktop_column'][0] ) : 3 );
				$mCol = 1;
				if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
					$dCol = 3;
				}
				$tCol = $dCol;
				$dColItems = $dCol;
				$tColItems = $tCol;
				$mColItems = $mCol;


				$customImgSize = get_post_meta( $scID, 'tss_custom_image_size', true );
				$imgSize       = ( ! empty( $scMeta['tss_image_size'][0] ) ? $scMeta['tss_image_size'][0] : "medium" );

				$isCarousel = preg_match( '/carousel/', $layout );

				/* Argument create */
				$containerDataAttr = false;
				$args              = array();
				$args['post_type'] = TSSPro()->post_type;
				// Common filter
				/* post__in */
				$post__in = ( isset( $scMeta['tss_post__in'][0] ) ? $scMeta['tss_post__in'][0] : null );
				if ( $post__in ) {
					$post__in         = explode( ',', $post__in );
					$args['post__in'] = $post__in;
				}
				/* post__not_in */
				$post__not_in = ( isset( $scMeta['tss_post__not_in'][0] ) ? $scMeta['tss_post__not_in'][0] : null );
				if ( $post__not_in ) {
					$post__not_in         = explode( ',', $post__not_in );
					$args['post__not_in'] = $post__not_in;
				}
				/* LIMIT */
				$limit                  = ( ( empty( $scMeta['tss_limit'][0] ) || $scMeta['tss_limit'][0] === '-1' ) ? 10000000 : (int) $scMeta['tss_limit'][0] );
				$args['posts_per_page'] = $limit;
				$pagination             = ( ! empty( $scMeta['tss_pagination'][0] ) ? true : false );
				if ( $pagination ) {
					$posts_per_page = ( isset( $scMeta['tss_posts_per_page'][0] ) ? intval( $scMeta['tss_posts_per_page'][0] ) : $limit );
					if ( $posts_per_page > $limit ) {
						$posts_per_page = $limit;
					}
					// Set 'posts_per_page' parameter
					$args['posts_per_page'] = $posts_per_page;

					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

					$offset        = $posts_per_page * ( (int) $paged - 1 );
					$args['paged'] = $paged;

					// Update posts_per_page
					if ( intval( $args['posts_per_page'] ) > $limit - $offset ) {
						$args['posts_per_page'] = $limit - $offset;
					}

				}
				if ( $isCarousel ) {
					$args['posts_per_page'] = $limit;
				}

				// Order
				$order_by = ( isset( $scMeta['tss_order_by'][0] ) ? $scMeta['tss_order_by'][0] : null );
				$order    = ( isset( $scMeta['tss_order'][0] ) ? $scMeta['tss_order'][0] : null );
				if ( $order ) {
					$args['order'] = $order;
				}
				if ( $order_by ) {
					$args['orderby'] = $order_by;
				}


				// Validation
				$containerDataAttr .= " data-layout='{$layout}' data-desktop-col='{$dCol}'  data-tab-col='{$tCol}'  data-mobile-col='{$mCol}'";

				$dCol = round( 12 / $dCol );
				$tCol = round( 12 / $tCol );
				$mCol = round( 12 / $mCol );
				if ( $isCarousel ) {
					$dCol = $tCol = $mCol = 12;
				}

				$arg              = array();
				$arg['grid']      = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
				$arg['read_more'] = ! empty( $scMeta['tss_read_more_button_text'][0] ) ? esc_attr( $scMeta['tss_read_more_button_text'][0] ) : null;
				$arg['class'] = " tss-grid-item";
				$preLoader = null;
				if ( $isCarousel ) {
					$arg['class'] .= ' carousel-item';
					$preLoader = 'tss-pre-loader';
				}
				$image_shape = ! empty( $scMeta['tss_image_type'][0] ) ? $scMeta['tss_image_type'][0] : null;
				if ( $image_shape == 'circle' ) {
					$arg['class'] .= ' tss-img-circle';
				}

				$margin = ! empty( $scMeta['tss_margin'][0] ) ? $scMeta['tss_margin'][0] : 'default';
				if ( $margin == 'no' ) {
					$arg['class'] .= ' no-margin';
				} else {
					$arg['class'] .= ' default-margin';
				}

				$image_type = ! empty( $scMeta['tss_image_type'][0] ) ? $scMeta['tss_image_type'][0] : 'normal';
				if ( $image_type == 'circle' ) {
					$arg['class'] .= ' tss-img-circle';
				}

				$arg['items']       = ! empty( $scMeta['tss_item_fields'] ) ? $scMeta['tss_item_fields'] : array();
				$arg['anchorClass'] = null;

				$parentClass = ( ! empty( $scMeta['tss_parent_class'][0] ) ? trim( $scMeta['tss_parent_class'][0] ) : null );

				$args['post_status'] = 'publish';

				// Start layout
				$html .= TSSPro()->layoutStyle( $layoutID, $scMeta, $scID );
				$html .= "<div class='rt-container-fluid tss-wrapper {$parentClass}' id='{$layoutID}' {$containerDataAttr}>";
				$html .= "<div data-title='" . __( "Loading ...", 'testimonial-slider-showcase' ) . "' class='rt-row tss-{$layout} {$preLoader}'>";

				$tssQuery = new WP_Query( $args );
				if ( $tssQuery->have_posts() ) {
					if ( $isCarousel ) {
						$smartSpeed         = ! empty( $scMeta['tss_carousel_speed'][0] ) ? absint( $scMeta['tss_carousel_speed'][0] ) : 250;
						$autoplayTimeout    = ! empty( $scMeta['tss_carousel_autoplay_timeout'][0] ) ? absint( $scMeta['tss_carousel_autoplay_timeout'][0] ) : 5000;
						$cOpt               = ! empty( $scMeta['tss_carousel_options'] ) ? $scMeta['tss_carousel_options'] : array();
						$autoPlay           = ( in_array( 'autoplay', $cOpt ) ? 'true' : 'false' );
						$autoPlayHoverPause = ( in_array( 'autoplayHoverPause', $cOpt ) ? 'true' : 'false' );
						$nav                = ( in_array( 'nav', $cOpt ) ? 'true' : 'false' );
						$dots               = ( in_array( 'dots', $cOpt ) ? 'true' : 'false' );
						$loop               = ( in_array( 'loop', $cOpt ) ? 'true' : 'false' );
						$lazyLoad           = ( in_array( 'lazyLoad', $cOpt ) ? 'true' : 'false' );
						$autoHeight         = ( in_array( 'autoHeight', $cOpt ) ? 'true' : 'false' );
						$rtl                = ( in_array( 'rtl', $cOpt ) ? 'true' : 'false' );

						$html .= "<div class='tss-carousel' 
										data-loop='{$loop}'
			                            data-items-desktop='{$dColItems}'
			                            data-items-tab='{$tColItems}'
			                            data-items-mobile='{$mColItems}'
			                            data-autoplay='{$autoPlay}'
			                            data-autoplay-timeout='{$autoplayTimeout}'
			                            data-autoplay-hover-pause='{$autoPlayHoverPause}'
			                            data-dots='{$dots}'
			                            data-nav='{$nav}'
			                            data-lazyLoad='{$lazyLoad}'
			                            data-autoHeight='{$autoHeight}'
			                            data-rtl='{$rtl}'
			                            data-smapfpspeed='{$smartSpeed}'
										>";
					}

					while ( $tssQuery->have_posts() ) : $tssQuery->the_post();
						$iID                 = get_the_ID();
						$arg['iID']          = $iID;
						$arg['author']       = get_the_title();
						$arg['designation']  = get_post_meta( $iID, 'tss_designation', true );
						$arg['company']      = get_post_meta( $iID, 'tss_company', true );
						$arg['location']     = get_post_meta( $iID, 'tss_location', true );
						$arg['rating']       = get_post_meta( $iID, 'tss_rating', true );
						$arg['video']        = get_post_meta( $iID, 'tss_video', true );
						$arg['social_media'] = get_post_meta( $iID, 'tss_social_media', true );
						$arg['pLink']        = get_permalink();
						$arg['testimonial']  = apply_filters('the_content', get_the_content());
						$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize );
						$html .= TSSPro()->render( 'layouts/' . $layout, $arg );

					endwhile;

					if ( $isCarousel ) {
						$html .= '</div>'; // End isotope / Carousel item holder
					}
				} else {
					$html .= "<p>" . __( "No testimonial found", 'testimonial-slider-showcase' ) . "</p>";
				}
				$html .= "</div>"; // End row

				if ( $pagination && ! $isCarousel ) {
						$htmlUtility = TSSPro()->pagination( $tssQuery->max_num_pages, $args['posts_per_page'] );
						$html .= "<div class='tss-utility'>" . $htmlUtility . "</div>";
				}
				$html .= "</div>"; // tss-container pfp
				wp_reset_postdata();
				$scriptGenerator               = array();
				$scriptGenerator['layout']     = $layoutID;
				$scriptGenerator['rand']       = $rand;
				$scriptGenerator['scMeta']     = $scMeta;
				$scriptGenerator['isCarousel'] = $isCarousel;
				$this->scA[]                   = $scriptGenerator;
				add_action( 'wp_footer', array( $this, 'register_scripts' ) );
			} else {
				$html .= "<p>" . __( "No shortCode found", 'testimonial-slider-showcase' ) . "</p>";
			}

			return $html;
		}
	}
endif;

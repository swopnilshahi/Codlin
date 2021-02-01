<?php
if ( ! class_exists( 'TSSProHelper' ) ) :
	class TSSProHelper {

		function verifyNonce() {
			$nonce     = !empty( $_REQUEST[ $this->nonceId() ] ) ? $_REQUEST[ $this->nonceId() ] : null;
			$nonceText = $this->nonceText();
			if ( ! wp_verify_nonce( $nonce, $nonceText ) ) {
				return false;
			}
			return true;
		}

		function nonceText() {
			return "tss_nonce_text";
		}

		function nonceId() {
			return "tss_nonce";
		}

		function tssTestimonialAllMetaFields(){
			return array_merge(
				TSSPro()->singleTestimonialFields()
			);
		}

		function tssScMetaFields() {
			return array_merge(
				TSSPro()->scLayoutMetaFields(),
				TSSPro()->scFilterMetaFields(),
				TSSPro()->scItemMetaFields(),
				TSSPro()->scStyleFields());
		}

		function rtFieldGenerator( $fields = array() ) {
			$html = null;
			if ( is_array( $fields ) && ! empty( $fields ) ) {
				$TSSProField = new TSSProField();
				foreach ( $fields as $fieldKey => $field ) {
					$html .= $TSSProField->Field( $fieldKey, $field );
				}
			}
			return $html;
		}

		function tssAllSettingsFields() {
			return array_merge(
				TSSPro()->generalSettings(),
				TSSPro()->othersSettings()
			);
		}

		/**
		 * Sanitize field value
		 *
		 * @param array $field
		 * @param null $value
		 *
		 * @return array|null
		 * @internal param $value
		 */
		function sanitize( $field = array(), $value = null ) {
			$newValue = null;
			if ( is_array( $field ) ) {
				$type = ( ! empty( $field['type'] ) ? $field['type'] : 'text' );
				if ( empty( $field['multiple'] ) ) {
					if ( $type == 'text' || $type == 'number' || $type == 'select' || $type == 'checkbox' || $type == 'radio' ) {
						$newValue = sanitize_text_field( $value );
					} else if ( $type == 'price' ) {
						$newValue = ( '' === $value ) ? '' : TSSPro()->format_decimal( $value );
					} else if ( $type == 'url' ) {
						$newValue = esc_url( $value );
					} else if ( $type == 'rating' ) {
						$newValue = absint( $value );
						$newValue = ($newValue > 5 ? 0 : $newValue);
					} else if ( $type == 'video' ) {
						$newValue = esc_url( $value );
					} else if ( $type == 'slug' ) {
						$newValue = sanitize_title_with_dashes( $value );
					} else if ( $type == 'textarea' ) {
						$newValue = wp_kses_post( $value );
					} else if ( $type == 'custom_css' ) {
						$newValue = esc_textarea( $value );
					} else if ( $type == 'colorpicker' ) {
						$newValue = $this->sanitize_hex_color( $value );
					} else if ( $type == 'image_size' ) {
						$newValue = array();
						foreach ( $value as $k => $v ) {
							$newValue[ $k ] = esc_attr( $v );
						}
					} else if ( $type == 'style' ) {
						$newValue = array();
						foreach ( $value as $k => $v ) {
							if ( $k == 'color' ) {
								$newValue[ $k ] = $this->sanitize_hex_color( $v );
							} else {
								$newValue[ $k ] = $this->sanitize( array( 'type' => 'text' ), $v );
							}
						}
					} else if($type == 'socialMedia') {
						if ( is_array( $value ) ) {
							foreach ( $value as $key => $val ) {
								$newValue[$key] = esc_url( $val );
							}
						}
					} else {
						$newValue = array();
					}

				} else {
					$newValue = array();
					if ( ! empty( $value ) ) {
						if ( is_array( $value ) ) {
							foreach ( $value as $key => $val ) {
								if ( $type == 'style' && $key == 0 ) {
									$newValue = $this->sanitize_hex_color( $val );
								} else {
									$newValue[] = sanitize_text_field( $val );
								}
							}
						} else {
							$newValue[] = sanitize_text_field( $value );
						}
					}
				}
			}

			return $newValue;
		}

		function sanitize_hex_color( $color ) {
			if ( function_exists( 'sanitize_hex_color' ) ) {
				return sanitize_hex_color( $color );
			} else {
				if ( '' === $color ) {
					return '';
				}

				// 3 or 6 hex digits, or the empty string.
				if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
					return $color;
				}
			}
		}


		function getFeatureImage(
			$post_id = null,
			$fImgSize = 'medium',
			$customImgSize = array()
		) {
			global $post;
			$img_class = "rt-responsive-img";
			$imgSrc    = $image = null;
			$cSize     = false;
			$post_id   = ( $post_id ? absint( $post_id ) : $post->ID );
			$alt       = esc_url( get_the_title( $post_id ) );
			$thumb_id  = get_post_thumbnail_id( $post_id );
			if ( $fImgSize == 'tss_custom' ) {
				$fImgSize = 'full';
				$cSize    = true;
			}
			if ( $thumb_id ) {
				$image  = wp_get_attachment_image( $thumb_id, $fImgSize, '', array( "class" => $img_class ) );
				$imageS = wp_get_attachment_image_src( $thumb_id, $fImgSize );
				$imgSrc = $imageS[0];
			} else {
				$imgSrc = esc_url( TSSPro()->placeholder_img_src() );
				$image  = "<img alt='{$alt}' class='{$img_class}' src='{$imgSrc}' />";
			}

			if ( $imgSrc && $cSize ) {
				$w = ( ! empty( $customImgSize['width'] ) ? absint( $customImgSize['width'] ) : null );
				$h = ( ! empty( $customImgSize['height'] ) ? absint( $customImgSize['height'] ) : null );
				$c = ( ! empty( $customImgSize['crop'] ) && $customImgSize['crop'] == 'soft' ? false : true );
				if ( $w && $h ) {
					$imgSrc = esc_url( TSSPro()->rtImageReSize( $imgSrc, $w, $h, $c ) );
					$image  = "<img alt='{$alt}' class='{$img_class}' src='{$imgSrc}' />";
				}
			}

			return $image;
		}

		function rtImageReSize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
			$rtResize = new PFProReSizer();

			return $rtResize->process( $url, $width, $height, $crop, $single, $upscale );
		}

		function strip_tags_content( $text, $limit = 0, $tags = '', $invert = false ) {

			preg_match_all( '/<(.+?)[\s]*\/?[\s]*>/si', trim( $tags ), $tags );
			$tags = array_unique( $tags[1] );

			if ( is_array( $tags ) AND count( $tags ) > 0 ) {
				if ( $invert == false ) {
					$text = preg_replace( '@<(?!(?:' . implode( '|', $tags ) . ')\b)(\w+)\b.*?>.*?</\1>@si', '',
						$text );
				} else {
					$text = preg_replace( '@<(' . implode( '|', $tags ) . ')\b.*?>.*?</\1>@si', '', $text );
				}
			} else if ( $invert == false ) {
				$text = preg_replace( '@<(\w+)\b.*?>.*?</\1>@si', '', $text );
			}
			if ( $limit > 0 && strlen( $text ) > $limit ) {
				$text = substr( $text, 0, $limit );
			}

			return $text;
		}

		function TLPhex2rgba( $color, $opacity = false ) {
			$default = 'rgb(0,0,0)';

			//Return default if no color provided
			if ( empty( $color ) ) {
				return $default;
			}

			//Sanitize $color if "#" is provided
			if ( $color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			//Check if color has 6 or 3 characters and get values
			if ( strlen( $color ) == 6 ) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return $default;
			}

			//Convert hexadec to rgb
			$rgb = array_map( 'hexdec', $hex );

			//Check if opacity is set(rgba or rgb)
			if ( $opacity ) {
				if ( abs( $opacity ) > 1 ) {
					$opacity = 1.0;
				}
				$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
			} else {
				$output = 'rgb(' . implode( ",", $rgb ) . ')';
			}

			//Return rgb(a) color string
			return $output;
		}

		function tlp_custom_pagination( $numpages = '', $pagerange = '', $paged = '' ) {

			if ( empty( $pagerange ) ) {
				$pagerange = 2;
			}
			global $paged;
			if ( empty( $paged ) ) {
				$paged = 1;
			}
			if ( $numpages == '' ) {
				global $wp_query;
				$numpages = $wp_query->max_num_pages;
				if ( ! $numpages ) {
					$numpages = 1;
				}
			}

			/**
			 * We construct the pagination arguments to enter into our paginate_links
			 * function.
			 */
			$pagination_args = array(
				'base'               => get_pagenum_link( 1 ) . '%_%',
				'format'             => 'page/%#%',
				'total'              => $numpages,
				'current'            => $paged,
				'show_all'           => false,
				'end_size'           => 1,
				'mid_size'           => $pagerange,
				'prev_next'          => true,
				'prev_text'          => __( '&laquo;' ),
				'next_text'          => __( '&raquo;' ),
				'type'               => 'list',
				'add_args'           => false,
				'add_fragment'       => '',
				'before_page_number' => '',
				'after_page_number'  => ''
			);

			$paginate_links = paginate_links( $pagination_args );
			$html           = null;
			if ( $paginate_links ) {
				$html .= "<nav class='tlp-pagination'>";
				$html .= $paginate_links;
				$html .= "</nav>";
			}

			return $html;

		}

		function pagination( $pages = '', $range = 4, $ajax = false, $scID = '' ) {

			$html      = null;
			$showitems = ( $range * 2 ) + 1;
			global $paged;
			if ( empty( $paged ) ) {
				$paged = 1;
			}
			if ( $pages == '' ) {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if ( ! $pages ) {
					$pages = 1;
				}
			}
			$ajaxClass = null;
			$dataAttr  = null;

			if ( $ajax ) {
				$ajaxClass = ' tss-ajax';
				$dataAttr  = "data-sc-id='{$scID}' data-paged='1'";
			}

			if ( 1 != $pages ) {

				$html .= '<div class="tss-pagination' . $ajaxClass . '" ' . $dataAttr . '>';
				$html .= '<ul class="pagination-list">';
				if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
					$html .= "<li><a data-paged='1' href='" . get_pagenum_link( 1 ) . "' aria-label='First'>&laquo;</a></li>";
				}

				if ( $paged > 1 && $showitems < $pages ) {
					$p = $paged - 1;
					$html .= "<li><a data-paged='{$p}' href='" . get_pagenum_link( $p ) . "' aria-label='Previous'>&lsaquo;</a></li>";
				}


				for ( $i = 1; $i <= $pages; $i ++ ) {
					if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
						$html .= ( $paged == $i ) ? "<li class=\"active\"><span>" . $i . "</span>

    </li>" : "<li><a data-paged='{$i}' href='" . get_pagenum_link( $i ) . "'>" . $i . "</a></li>";

					}

				}

				if ( $paged < $pages && $showitems < $pages ) {
					$p = $paged + 1;
					$html .= "<li><a data-paged='{$p}' href=\"" . get_pagenum_link( $paged + 1 ) . "\"  aria-label='Next'>&rsaquo;</a></li>";
				}

				if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
					$html .= "<li><a data-paged='{$pages}' href='" . get_pagenum_link( $pages ) . "' aria-label='Last'>&raquo;</a></li>";
				}

				$html .= "</ul>";
				$html .= "</div>";
			}

			return $html;

		}

		function rt_pagination( $pages = '', $range = 4 ) {

			$html      = null;
			$showitems = ( $range * 2 ) + 1;
			global $paged;
			if ( empty( $paged ) ) {
				$paged = 1;
			}
			if ( $pages == '' ) {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if ( ! $pages ) {
					$pages = 1;
				}
			}

			if ( 1 != $pages ) {

				$html .= '<div class="rt-pagination">';
				$html .= '<ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Page ' . $paged . ' of ' . $pages . '</span></span></li>';

				if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
					$html .= "<li><a href='" . get_pagenum_link( 1 ) . "' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a></li>";
				}

				if ( $paged > 1 && $showitems < $pages ) {
					$html .= "<li><a href='" . get_pagenum_link( $paged - 1 ) . "' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
				}


				for ( $i = 1; $i <= $pages; $i ++ ) {
					if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
						$html .= ( $paged == $i ) ? "<li class=\"active\"><span>" . $i . "</span>

    </li>" : "<li><a href='" . get_pagenum_link( $i ) . "'>" . $i . "</a></li>";

					}

				}

				if ( $paged < $pages && $showitems < $pages ) {
					$html .= "<li><a href=\"" . get_pagenum_link( $paged + 1 ) . "\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";
				}

				if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
					$html .= "<li><a href='" . get_pagenum_link( $pages ) . "' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
				}

				$html .= "</ul>";
				$html .= "</div>";
			}

			return $html;

		}

		function placeholder_img_src() {
			return TSSPro()->assetsUrl . 'images/placeholder.png';
		}

		function get_image_sizes() {
			global $_wp_additional_image_sizes;

			$sizes = array();
			$interSizes = get_intermediate_image_sizes();
			if(!empty($interSizes)) {
				foreach ( get_intermediate_image_sizes() as $_size ) {
					if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
						$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
						$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
						$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
					} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
						$sizes[ $_size ] = array(
							'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
							'height' => $_wp_additional_image_sizes[ $_size ]['height'],
							'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
						);
					}
				}
			}

			$imgSize = array();
			if(!empty($sizes)) {
				foreach ( $sizes as $key => $img ) {
					$imgSize[ $key ] = ucfirst( $key ) . " ({$img['width']}*{$img['height']})";
				}
			}

			return $imgSize;
		}


		function get_shortCode_list() {
			$list   = array();
			$scList = get_posts( array(
				'post_type'      => TSSPro()->shortCodePT,
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			) );
			if ( $scList && ! empty( $scList ) ) {
				foreach ( $scList as $sc ) {
					$list[ $sc->ID ] = $sc->post_title;
				}
			}

			return $list;
		}

		function doFlush() {
			if ( get_option( TSSPro()->options['flash'] ) ) {
				TSSPro()->flush_rewrite();
				update_option( TSSPro()->options['flash'], false );
			}
		}


		function layoutStyle( $layoutID, $meta, $scId = null ) {
			$css = null;
			$css .= "<style type='text/css' media='all'>";
			// Variable
			if($scId){
				$primaryColor = ( ! empty( $meta['tss_primary_color'][0] ) ? $meta['tss_primary_color'][0] : null );
			}else{
				$primaryColor = ( ! empty( $meta['tss_primary_color'] ) ? $meta['tss_primary_color'] : null );
			}
			if ( $primaryColor ) {
				$css .= "#{$layoutID}.tss-wrapper h4.author-bio{";
				$css .= "color:" . $primaryColor . ";";
				$css .= "}";
				$css .= "#{$layoutID}.tss-wrapper .owl-controls .owl-nav > div,
						#{$layoutID}.tss-wrapper .owl-theme .owl-dots .owl-dot.active span, 
						#{$layoutID}.tss-wrapper .owl-theme .owl-dots .owl-dot:hover span,
						#{$layoutID}.tss-wrapper .owl-theme .owl-dots .owl-dot span{";
				$css .= "background:" . $primaryColor . ";";
				$css .= "}";
			}
			$css .= "</style>";

			return $css;
		}

	}
endif;
<?php
if ( ! class_exists( 'TSSProPostMeta' ) ):

	class TSSProPostMeta {

		function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_testimonial_meta_box' ) );
			add_action( 'save_post', array( $this, 'save_testimonial_meta_data' ), 10, 2 );
			add_action( 'edit_form_after_title', array( $this, 'tss_after_title' ) );
		}

		function tss_after_title( $post ) {

			if ( TSSPro()->post_type !== $post->post_type ) {
				return;
			}
			$html = null;
			$html .= '<div class="postbox" style="margin-bottom: 0;"><div class="inside">';
			$html .= '<p style="text-align: center;"><a style="color: red; text-decoration: none; font-size: 14px;" href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" target="_blank">Get Pro Version</a></p>';
			$html .= '</div></div>';

			echo $html;
		}

		function add_testimonial_meta_box() {
			add_meta_box( 'tss_meta_information', __( 'Testimonial\'s Information', 'tlp-portfolio-pro' ), array(
				$this,
				'tss_meta_information'
			), TSSPro()->post_type, 'normal', 'high' );
		}

		function tss_meta_information() {

			wp_nonce_field( TSSPro()->nonceText(), TSSPro()->nonceId() );
			echo '<div class="tss-meta-wrapper">';
			echo TSSPro()->rtFieldGenerator( TSSPro()->singleTestimonialFields() );
			echo '</div>';
		}

		function save_testimonial_meta_data( $post_id, $post ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			if ( ! TSSPro()->verifyNonce() ) {
				return $post_id;
			}

			if ( TSSPro()->post_type != $post->post_type ) {
				return $post_id;
			}

			$mates = TSSPro()->tssTestimonialAllMetaFields();
			foreach ( $mates as $metaKey => $field ) {
				$rawValue = isset( $_REQUEST[ $metaKey ] ) ? $_REQUEST[ $metaKey ] : null;
				$sanitizedValue = TSSPro()->sanitize( $field, $rawValue );
				if ( empty( $field['multiple'] ) ) {
					update_post_meta( $post_id, $metaKey, $sanitizedValue );
				} else {
					delete_post_meta( $post_id, $metaKey );
					if ( is_array( $sanitizedValue ) && ! empty( $sanitizedValue ) ) {
						foreach ( $sanitizedValue as $item ) {
							add_post_meta( $post_id, $metaKey, $item );
						}
					}
				}
			}

		}

	}
endif;

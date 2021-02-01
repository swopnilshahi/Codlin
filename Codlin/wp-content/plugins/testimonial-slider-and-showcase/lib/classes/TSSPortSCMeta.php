<?php

if ( ! class_exists( 'TSSPortSCMeta' ) ):
	/**
	 *
	 */
	class TSSPortSCMeta {

		function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'rt_tss_sc_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_rt_tss_sc_meta_data' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts_sc' ) );
			add_action( 'edit_form_after_title', array( $this, 'rt_tss_sc_after_title' ) );

			add_action( 'admin_init', array( $this, 'remove_all_meta_box' ) );
		}

		function remove_all_meta_box() {
			if ( is_admin() ) {
				add_filter( "get_user_option_meta-box-order_{" . TSSPro()->shortCodePT . "}",
					array( $this, 'remove_all_meta_boxes_portfolio_sc' ) );
			}
		}

		function remove_all_meta_boxes_portfolio_sc() {
			global $wp_meta_boxes;
			$publishBox                             = $wp_meta_boxes[ TSSPro()->shortCodePT ]['side']['core']['submitdiv'];
			$scBox                                  = $wp_meta_boxes[ TSSPro()->shortCodePT ]['normal']['high']['rt_tss_sc_settings_meta'];
			$wp_meta_boxes[ TSSPro()->shortCodePT ] = array(
				'side'   => array( 'core' => array( 'submitdiv' => $publishBox ) ),
				'normal' => array(
					'high' => array(
						'rt_tss_sc_settings_meta' => $scBox
					)
				)
			);

			return array();
		}

		function rt_tss_sc_after_title( $post ) {
			if ( TSSPro()->shortCodePT !== $post->post_type ) {
				return;
			}
			$html = null;
			$html .= '<div class="postbox" style="margin-bottom: 0;"><div class="inside">';
			$html .= '<p><input type="text" onfocus="this.select();" readonly="readonly" value="[rt-testimonial id=&quot;' . $post->ID . '&quot; title=&quot;' . $post->post_title . '&quot;]" class="large-text code tlp-code-sc">
            <input type="text" onfocus="this.select();" readonly="readonly" value="&#60;&#63;php echo do_shortcode( &#39;[rt-testimonial id=&quot;' . $post->ID . '&quot; title=&quot;' . $post->post_title . '&quot;]&#39; ) &#63;&#62;" class="large-text code tlp-code-sc">
            </p>';
			$html .= '</div></div>';

			echo $html;
		}

		function rt_tss_sc_meta_boxes() {
			add_meta_box(
				'rt_tss_sc_settings_meta',
				__( 'Short Code Generator', 'testimonial-slider-showcase' ),
				array( $this, 'rt_tss_sc_settings_selection' ),
				TSSPro()->shortCodePT,
				'normal',
				'high' );
			add_meta_box(
				'rt_plugin_tss_sc_pro_information',
				__( 'Documentation', 'testimonial-slider-showcase' ),
				array( $this, 'rt_plugin_sc_pro_information' ),
				TSSPro()->shortCodePT,
				'side' );
		}

		function rt_plugin_sc_pro_information( $post ) {

			$html = sprintf( '<div class="rt-document-box">
							<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
							<div class="rt-box-content">
                    			<h3 class="rt-box-title">%1$s</h3>
                    				<p>%2$s</p>
                        			<a href="https://www.radiustheme.com/setup-wp-testimonials-slider-showcase-wordpress/" target="_blank" class="rt-admin-btn">%1$s</a>
                			</div>
						</div>',
				__( "Documentation", 'testimonial-slider-showcase' ),
				__( "Get started by spending some time with the documentation we included step by step process with screenshots with video.", 'testimonial-slider-showcase' )
			);

			$html .= '<div class="rt-document-box">
							<div class="rt-box-icon"><i class="dashicons dashicons-sos"></i></div>
							<div class="rt-box-content">
                    			<h3 class="rt-box-title">Need Help?</h3>
                    				<p>Stuck with something? Please create a 
                        <a href="https://www.radiustheme.com/contact/">ticket here</a> or post on <a href="https://www.facebook.com/groups/234799147426640/">facebook group</a>. For emergency case join our <a href="https://www.radiustheme.com/">live chat</a>.</p>
                        			<a href="https://www.radiustheme.com/contact/" target="_blank" class="rt-admin-btn">Get Support</a>
                			</div>
						</div>';

			if ( $post === 'settings' ) {
				$html .= '<div class="rt-document-box rt-update-pro-btn-wrap">
                <a href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" target="_blank" class="rt-update-pro-btn">Update Pro To Get More Features</a>
            </div>';;
			} else {
				$html .= sprintf( '<div class="rt-document-box"><div class="rt-box-content"><h3 class="rt-box-title">Pro Feature</h3>%s</div></div>', TSSPro()->get_pro_feature_list() );
			}

			echo $html;
		}

		function rt_tss_sc_settings_selection() {
			wp_nonce_field( TSSPro()->nonceText(), TSSPro()->nonceId() );
			$html = null;
			$html .= '<div id="sc-tabs" class="rt-tabs rt-tab-container">';
			$html .= '<ul class="tab-nav rt-tab-nav">
	                            <li><a href="#sc-layout-settings"><i class="dashicons dashicons-layout"></i>' . __( 'Layout', 'testimonial-slider-showcase' ) . '</a></li>
	                            <li><a href="#sc-filtering"><i class="dashicons dashicons-filter"></i>' . __( 'Filtering', 'testimonial-slider-showcase' ) . '</a></li>
	                            <li><a href="#sc-field-selection"><i class="dashicons dashicons-editor-table"></i>' . __( 'Field Selection', 'testimonial-slider-showcase' ) . '</a></li>
	                            <li><a href="#sc-style"><i class="dashicons dashicons-admin-customizer"></i>' . __( 'Styling', 'testimonial-slider-showcase' ) . '</a></li>
	                          </ul>';

			$html .= '<div id="sc-layout-settings" class="rt-tab-content">';
			$html .= '<div class="tab-content">';
			$html .= TSSPro()->rtFieldGenerator( TSSPro()->scLayoutMetaFields() );
			$html .= '</div>';
			$html .= '</div>';

			$html .= '<div id="sc-filtering" class="rt-tab-content">';
			$html .= '<div class="tab-content">';
			$html .= TSSPro()->rtFieldGenerator( TSSPro()->scFilterMetaFields() );
			$html .= '</div>';
			$html .= '</div>';

			$html .= '<div id="sc-field-selection" class="rt-tab-content">';
			$html .= '<div class="tab-content">';
			$html .= TSSPro()->rtFieldGenerator( TSSPro()->scItemMetaFields() );
			$html .= '</div>';
			$html .= '</div>';

			$html .= '<div id="sc-style" class="rt-tab-content">';
			$html .= '<div class="tab-content">';
			$html .= TSSPro()->rtFieldGenerator( TSSPro()->scStyleFields() );
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			echo $html;
		}

		function save_rt_tss_sc_meta_data( $post_id, $post ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! TSSPro()->verifyNonce() ) {
				return $post_id;
			}

			if ( TSSPro()->shortCodePT != $post->post_type ) {
				return $post_id;
			}

			$mates = TSSPro()->tssScMetaFields();
			foreach ( $mates as $metaKey => $field ) {
				$rValue = ! empty( $_REQUEST[ $metaKey ] ) ? $_REQUEST[ $metaKey ] : null;
				$value  = TSSPro()->sanitize( $field, $rValue );
				if ( empty( $field['multiple'] ) ) {
					update_post_meta( $post_id, $metaKey, $value );
				} else {
					delete_post_meta( $post_id, $metaKey );
					if ( is_array( $value ) && ! empty( $value ) ) {
						foreach ( $value as $item ) {
							add_post_meta( $post_id, $metaKey, $item );
						}
					} else {
						update_post_meta( $post_id, $metaKey, "" );
					}
				}
			}

		}

		function admin_enqueue_scripts_sc() {
			global $pagenow, $typenow;
			// validate page
			if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit.php' ) ) ) {
				return;
			}

			if ( $typenow != TSSPro()->shortCodePT ) {
				return;
			}


			wp_enqueue_media();
			// scripts
			wp_enqueue_script( array(
				'jquery',
				'wp-color-picker',
				'tss-select2',
				'tss-owl-carousel',
				'tss-image-load',
				'tss-admin-sc',
				'tss-admin',
			) );

			// styles
			wp_enqueue_style( array(
				'wp-color-picker',
				'tss-select2',
				'tss-admin',
				'tss',
			) );

			wp_localize_script( 'tss-admin', 'tss', array(
				'ajaxurl' => admin_url( 'admin-ajax.php ' ),
				'nonce'   => wp_create_nonce( TSSPro()->nonceText() ),
				'nonceId' => TSSPro()->nonceId()
			) );
		}
	}
endif;
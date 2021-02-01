<?php
if ( ! class_exists( 'TSSProInit' ) ):


	class TSSProInit {
		function __construct() {
			add_action( 'init', array( __CLASS__, 'init' ), 1 );
			add_action( 'admin_menu', array( $this, 'tss_menu_register' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			register_activation_hook( TSS_PLUGIN_ACTIVE_FILE_NAME, array( $this, 'activate' ) );
			register_deactivation_hook( TSS_PLUGIN_ACTIVE_FILE_NAME, array( $this, 'deactivate' ) );
			add_action( 'plugins_loaded', array( $this, 'plugin_loaded' ) );
			add_action( 'wp_ajax_tssSettingsAction', array( $this, 'tssSettingsUpdate' ) );
			add_filter( 'plugin_action_links_' . TSS_PLUGIN_ACTIVE_FILE_NAME,
				array( $this, 'rt_plugin_active_link_marketing' ) );
		}

		public function activate() {
			$this->flush_rewrite();
		}

		public function flush_rewrite() {
			flush_rewrite_rules();
		}

		public function deactivate() {
			$this->flush_rewrite();
		}

		public static function init() {
			$portfolio_args = array(
				'label'               => __( 'Testimonial', 'testimonial-slider-showcase' ),
				'labels'              => array(
					'name'               => __( 'Testimonials', 'testimonial-slider-showcase' ),
					'all_items'          => __( 'All Testimonials', 'testimonial-slider-showcase' ),
					'singular_name'      => __( 'Testimonial', 'testimonial-slider-showcase' ),
					'menu_name'          => __( 'Testimonials Slider', 'testimonial-slider-showcase' ),
					'name_admin_bar'     => __( 'Testimonials Slider', 'testimonial-slider-showcase' ),
					'add_new'            => __( 'Add Testimonial', 'testimonial-slider-showcase' ),
					'add_new_item'       => __( 'Add Testimonial', 'testimonial-slider-showcase' ),
					'edit_item'          => __( 'Edit Testimonial', 'testimonial-slider-showcase' ),
					'new_item'           => __( 'New Testimonial', 'testimonial-slider-showcase' ),
					'view_item'          => __( 'View Testimonial', 'testimonial-slider-showcase' ),
					'search_items'       => __( 'Search Testimonial', 'testimonial-slider-showcase' ),
					'not_found'          => __( 'No Testimonials found', 'testimonial-slider-showcase' ),
					'not_found_in_trash' => __( 'No Testimonials in the trash', 'testimonial-slider-showcase' ),
				),
				'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
				'hierarchical'        => false,
				'public'              => true,
				'rewrite'             => array( 'slug' => TSSPro()->post_type_slug ),
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_icon'           => TSSPro()->assetsUrl . 'images/icon-16x16.png',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( TSSPro()->post_type, $portfolio_args );

			$sc_args = array(
				'label'               => __( 'ShortCode', 'testimonial-slider-showcase' ),
				'description'         => __( 'Testimonial ShortCode generator', 'testimonial-slider-showcase' ),
				'labels'              => array(
					'all_items'          => __( 'ShortCode', 'testimonial-slider-showcase' ),
					'menu_name'          => __( 'ShortCode', 'testimonial-slider-showcase' ),
					'singular_name'      => __( 'ShortCode', 'testimonial-slider-showcase' ),
					'edit_item'          => __( 'Edit ShortCode', 'testimonial-slider-showcase' ),
					'new_item'           => __( 'New ShortCode', 'testimonial-slider-showcase' ),
					'view_item'          => __( 'View ShortCode', 'testimonial-slider-showcase' ),
					'search_items'       => __( 'ShortCode Locations', 'testimonial-slider-showcase' ),
					'not_found'          => __( 'No ShortCode found.', 'testimonial-slider-showcase' ),
					'not_found_in_trash' => __( 'No ShortCode found in trash.', 'testimonial-slider-showcase' )
				),
				'supports'            => array( 'title' ),
				'public'              => false,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => 'edit.php?post_type=' . TSSPro()->post_type,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
			);
			register_post_type( TSSPro()->shortCodePT, $sc_args );

			TSSPro()->doFlush();

			// register scripts
			$scripts                      = array();
			$styles                       = array();
			$scripts['tss-owl-carousel']  = array(
				'src'    => TSSPro()->assetsUrl . 'vendor/owl-carousel/owl.carousel.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false
			);
			$scripts['tss-image-load']    = array(
				'src'    => TSSPro()->assetsUrl . 'js/imagesloaded.pkgd.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false
			);
			$scripts['tss-actual-height'] = array(
				'src'    => TSSPro()->assetsUrl . 'vendor/actual-height/jquery.actual.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false
			);
			$scripts['tss']               = array(
				'src'    => TSSPro()->assetsUrl . 'js/testimonial-slider.js',
				'deps'   => array( 'jquery' ),
				'footer' => true
			);

			// register acf styles
			$styles['tss-owl-carousel']       = TSSPro()->assetsUrl . 'vendor/owl-carousel/owl.carousel.min.css';
			$styles['tss-owl-carousel-theme'] = TSSPro()->assetsUrl . 'vendor/owl-carousel/owl.theme.default.min.css';
			$styles['tss']                    = TSSPro()->assetsUrl . 'css/testimonial-slider.css';

			if ( is_admin() ) {

				$scripts['ace_code_highlighter_js'] = array(
					'src'    => TSSPro()->assetsUrl . "vendor/ace/ace.js",
					'deps'   => null,
					'footer' => true
				);
				$scripts['ace_mode_js']             = array(
					'src'    => TSSPro()->assetsUrl . "vendor/ace/mode-css.js",
					'deps'   => array( 'ace-code-highlighter-js' ),
					'footer' => true
				);
				$scripts['tss-select2']             = array(
					'src'    => TSSPro()->assetsUrl . 'vendor/select2/select2.min.js',
					'deps'   => array( 'jquery' ),
					'footer' => false
				);
				$scripts['tss-admin']               = array(
					'src'    => TSSPro()->assetsUrl . "js/settings.js",
					'deps'   => array( 'jquery' ),
					'footer' => true
				);
				$scripts['tss-admin-sc']            = array(
					'src'    => TSSPro()->assetsUrl . "js/admin-sc.js",
					'deps'   => array( 'jquery' ),
					'footer' => true
				);
				$styles['tss-select2']              = TSSPro()->assetsUrl . 'vendor/select2/select2.min.css';
				$styles['tss-admin']                = TSSPro()->assetsUrl . 'css/settings.css';
			}

			foreach ( $scripts as $handel => $script ) {
				wp_register_script( $handel, $script['src'], $script['deps'], time(),
					$script['footer'] ); // TODO replaced time() function
			}

			foreach ( $styles as $k => $v ) {
				wp_register_style( $k, $v, false, time() );// TODO replaced time() function
			}

		}


		function tssSettingsUpdate() {
			$error = true;
			if ( TSSPro()->verifyNonce() ) {
				unset( $_REQUEST['action'] );
				unset( $_REQUEST['_wp_http_referer'] );
				unset( $_REQUEST['tss_nonce'] );
				$mates = TSSPro()->tssAllSettingsFields();
				foreach ( $mates as $key => $field ) {
					$rValue       = ! empty( $_REQUEST[ $key ] ) ? $_REQUEST[ $key ] : null;
					$value        = TSSPro()->sanitize( $field, $rValue );
					$data[ $key ] = $value;
				}
				$settings = get_option( TSSPro()->options['settings'] );
				if ( ! empty( $settings['slug'] ) && $_REQUEST['slug'] && $settings['slug'] !== $_REQUEST['slug'] ) {
					update_option( TSSPro()->options['flash'], true );
				}
				update_option( TSSPro()->options['settings'], $data );
				$response = array(
					'error' => $error,
					'msg'   => __( 'Settings successfully updated', 'testimonial-slider-showcase' )
				);
			} else {
				$response = array(
					'error' => true,
					'msg'   => __( 'Security Error !!', 'testimonial-slider-showcase' )
				);
			}
			wp_send_json( $response );
			die();
		}


		function tss_menu_register() {
			add_submenu_page( 'edit.php?post_type=' . TSSPro()->post_type,
				__( 'Testimonial Settings', 'testimonial-slider-showcase' ),
				__( 'Settings', 'testimonial-slider-showcase' ), 'administrator', 'tss_settings',
				array( $this, 'settings_page_view' ) );
		}

		function admin_enqueue_scripts() {
			global $pagenow, $typenow;
			// validate page
			if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit.php' ) ) ) {
				//return;
			}
			if ( $typenow != TSSPro()->post_type ) {
				return;
			}
			// scripts
			wp_enqueue_script( array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
				'ace_code_highlighter_js',
				'ace_mode_js',
				'tss-select2',
				'tss-admin',
			) );

			// styles
			wp_enqueue_style( array(
				'tss-select2',
				'tss-admin',
			) );

			wp_localize_script( 'tss-admin', 'tss', array(
				'nonce'   => wp_create_nonce( TSSPro()->nonceText() ),
				'nonceId' => TSSPro()->nonceId()
			) );
		}


		function settings_page_view() {
			TSSPro()->render( 'settings' );
		}

		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since 0.1.0
		 */
		public function plugin_loaded() {
			load_plugin_textdomain( 'testimonial-slider-showcase', false, TSS_LANGUAGE_PATH );
			if ( ! get_option( TSSPro()->options['settings'] ) ) {
				update_option( TSSPro()->options['settings'], TSSPro()->preSettings );
			}
		}


		public function rt_plugin_active_link_marketing( $links ) {
			$links[] = '<a target="_blank" href="' . esc_url( 'http://demo.radiustheme.com/wordpress/plugins/testimonials-slider/' ) . '">Demo</a>';
			$links[] = '<a target="_blank" href="' . esc_url( 'https://www.radiustheme.com/setup-wp-testimonials-slider-showcase-wordpress/' ) . '">Documentation</a>';
			$links[] = '<a target="_blank" style="color: #39b54a;font-weight: 700;" href="'. esc_url( 'https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/' ) .'">Get Pro</a>';

			return $links;
		}

	}
endif;

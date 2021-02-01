<?php
/**
 * Plugin Name: Easy Populate Posts
 * Plugin URI: https://iuliacazan.ro/easy-populate-posts/
 * Description: Populate your site with random generated content. You can configure the post type, description, excerpt, tags, post meta, terms, images, publish date, status, parent, sticky, etc.
 * Text Domain: spp
 * Domain Path: /langs
 * Version: 3.5.2
 * Author: Iulia Cazan
 * Author URI: https://profiles.wordpress.org/iulia-cazan
 * Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JJA37EHZXWUTJ
 * License: GPL2
 *
 * @package spp
 *
 * Copyright (C) 2015-2020 Iulia Cazan
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define( 'SPP_PLUGIN_VERSION', 3.52 );

/**
 * The main class.
 */
class SISANU_Popupate_Posts {

	const PLUGIN_NAME        = 'Easy Populate Posts';
	const PLUGIN_SUPPORT_URL = 'https://wordpress.org/support/plugin/easy-populate-posts/';
	const PLUGIN_TRANSIENT   = 'spp-plugin-notice';

	/**
	 * Class instance.
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @var object
	 */
	public static $max_random = 30;

	/**
	 * Plugin exclude post types.
	 *
	 * @var array
	 */
	public static $exclude_post_type = array();

	/**
	 * Plugin allowed post types.
	 *
	 * @var array
	 */
	public static $allowed_post_types = array();

	/**
	 * Plugin allowed post statuses.
	 *
	 * @var array
	 */
	public static $allowed_post_statuses = array();

	/**
	 * Plugin allowed taxonomies.
	 *
	 * @var array
	 */
	public static $allowed_taxonomies = array();

	/**
	 * Plugin exclude taxonomies.
	 *
	 * @var array
	 */
	public static $exclude_tax_type = array();

	/**
	 * Plugin admin page URL.
	 *
	 * @var string
	 */
	public static $plugin_url = '';

	/**
	 * Plugin default settings.
	 *
	 * @var array
	 */
	public static $default_settings = array();

	/**
	 * Plugin current settings.
	 *
	 * @var array
	 */
	public static $settings = array();

	/**
	 * Get active object instance.
	 *
	 * @access public
	 * @static
	 * @return pbject
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new SISANU_Popupate_Posts();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Run action and filter hooks.
	 *
	 * @access private
	 * @return void
	 */
	private function init() {
		$class = get_called_class();
		add_action( 'init', array( $class, 'load_plugin_settings' ) );

		// Text domain load.
		add_action( 'plugins_loaded', array( $class, 'load_textdomain' ) );

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $class, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $class, 'load_assets' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $class, 'plugin_action_links' ) );
			add_action( 'wp_ajax_spp_save_settings', array( $class, 'spp_save_settings' ) );
			add_action( 'wp_ajax_spp_populate', array( $class, 'spp_populate' ) );
		}

		add_action( 'admin_notices', array( $class, 'plugin_admin_notices' ) );
		add_action( 'wp_ajax_spp-plugin-deactivate-notice', array( $class, 'plugin_admin_notices_cleanup' ) );
		add_action( 'plugins_loaded', array( $class, 'plugin_ver_check' ) );

		add_action( 'added_post_meta', array( $class, 'reset_spp_meta_list' ), 10, 4 );
		add_action( 'updated_post_meta', array( $class, 'reset_spp_meta_list' ), 10, 4 );
		add_action( 'deleted_post_meta', array( $class, 'reset_spp_meta_list' ), 10, 4 );
	}

	/**
	 * Load the plugin settings.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function load_plugin_settings() {
		self::get_plugin_settings();
		self::get_allowed_post_types();
		self::get_allowed_post_statuses();
		self::get_allowed_taxonomies();
	}

	/**
	 * Prepare the plugin settings.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function get_plugin_settings() {
		self::$plugin_url        = admin_url( 'tools.php?page=populate-posts-settings' );
		self::$exclude_post_type = array(
			'nav_menu_item',
			'revision',
			'attachment',
			'custom_css',
			'customize_changeset',
			'oembed_cache',
			'user_request',
			'wp_block',
		);

		self::$exclude_tax_type = array(
			'nav_menu',
			'link_category',
			'post_format',
			'post_tag',
		);

		$upload_dir             = wp_upload_dir();
		$images_initial_string  = plugins_url( '/assets/images/sample1.jpg', __FILE__ ) . chr( 13 ) . plugins_url( '/assets/images/sample2.jpg', __FILE__ ) . chr( 13 ) . plugins_url( '/assets/images/sample3.jpg', __FILE__ ) . chr( 13 ) . plugins_url( '/assets/images/sample4.jpg', __FILE__ );
		self::$default_settings = array(
			'post_type'             => 'post',
			'content_type'          => 0,
			'excerpt'               => 0,
			'date_type'             => 1,
			'has_sticky'            => 2,
			'max_number'            => 10,
			'content_p'             => 0,
			'tags_list'             => 'Star Wars, Rebel, Force, Obi-Wan, Jedi, Senate, Alderaan, Luke',
			'meta_key'              => '',
			'meta_value'            => '',
			'meta_key2'             => '',
			'meta_value2'           => '',
			'meta_key3'             => '',
			'meta_value3'           => '',
			'meta_key4'             => '',
			'meta_value4'           => '',
			'meta_key5'             => '',
			'meta_value5'           => '',
			'taxonomy'              => '',
			'term_id'               => '',
			'term_slug'             => '',
			'taxonomy2'             => '',
			'term_id2'              => '',
			'term_slug2'            => '',
			'title_prefix'          => '',
			'post_parent'           => '',
			'specific_date'         => '',
			'specific_hour'         => '',
			'specific_status'       => '',
			'initial_images'        => $images_initial_string,
			'images_list'           => '',
			'images_path'           => '',
			'legacy_images_path'    => $upload_dir['basedir'] . '/spp_tmp/',
			'start_counter'         => 0,
			'cleanup_on_deactivate' => 0,
		);

		$settings                   = get_option( 'spp_settings', array() );
		$settings['default_images'] = self::$default_settings['initial_images'];
		self::$settings             = wp_parse_args( $settings, self::$default_settings );
	}

	/**
	 * Load scripts and stypes used by the plugin.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function load_assets() {
		wp_register_script(
			'spp-custom',
			plugins_url( '/assets/spp.js', plugin_basename( __FILE__ ) ),
			array( 'jquery' ),
			SPP_PLUGIN_VERSION
		);
		wp_localize_script(
			'spp-custom',
			'sppSettings',
			array(
				'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
				'spinner'     => '<img src="' . plugins_url( '/assets/images/spinner-light-bg.gif', plugin_basename( __FILE__ ) ) . '" class="spp-spinner">',
				'spinnerDark' => '<img src="' . plugins_url( '/assets/images/spinner-dark-bg.gif', plugin_basename( __FILE__ ) ) . '" class="spp-spinner">',
				'beginImages' => self::spp_images_mention(),
				'messages'    => array(
					'settings' => array(
						'init'  => __( 'Saving settings...', 'spp' ),
						'done'  => __( 'Done!', 'spp' ),
						'ready' => __( 'Save Settings', 'spp' ),
					),
					'populate' => array(
						'init'  => __( 'Generating posts...', 'spp' ),
						'done'  => __( 'Done!', 'spp' ),
						'ready' => __( 'Execute Posts Add', 'spp' ),
					),
				),
			)
		);
		wp_enqueue_script( 'spp-custom' );

		wp_enqueue_style(
			'spp-custom',
			plugins_url( '/assets/spp.css', plugin_basename( __FILE__ ) ),
			array(),
			SPP_PLUGIN_VERSION
		);
	}

	/**
	 * Load text domain for internalization.
	 *
	 * @return void
	 */
	public static function load_textdomain() {
		load_plugin_textdomain( 'spp', false, basename( dirname( __FILE__ ) ) . '/langs' );
	}

	/**
	 * Set the class property for all the post types registered in the application.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function get_allowed_post_types() {
		$post_types = get_post_types( array(), 'objects' );
		if ( ! empty( $post_types ) && ! empty( self::$exclude_post_type ) ) {
			foreach ( self::$exclude_post_type as $k ) {
				unset( $post_types[ $k ] );
			}
		}
		self::$allowed_post_types = wp_list_pluck( $post_types, 'label', 'name' );
	}

	/**
	 * Set the class property for of all the post statuses registered in the application.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function get_allowed_post_statuses() {
		global $wp_post_statuses;
		$post_status = $wp_post_statuses;
		unset( $post_status['auto-draft'] );
		unset( $post_status['trash'] );
		unset( $post_status['inherit'] );
		unset( $post_status['request-pending'] );
		unset( $post_status['request-confirmed'] );
		unset( $post_status['request-failed'] );
		unset( $post_status['request-completed'] );
		self::$allowed_post_statuses = wp_list_pluck( $post_status, 'label', 'name' );
	}

	/**
	 * Set the class property for of all the taxonomies registered in the application.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function get_allowed_taxonomies() {
		$tax = get_taxonomies( array(), 'objects' );
		if ( ! empty( $tax ) && ! empty( self::$exclude_tax_type ) ) {
			foreach ( self::$exclude_tax_type as $k ) {
				unset( $tax[ $k ] );
			}
		}
		self::$allowed_taxonomies = wp_list_pluck( $tax, 'label', 'name' );
	}

	/**
	 * Returns all the meta_keys.
	 *
	 * @return array
	 */
	public static function get_post_meta_keys() {
		global $wpdb;
		$trans_id = 'ssp-post-meta-list';
		$list   = get_transient( $trans_id );
		if ( false === $list ) {
			$acf_fields = $wpdb->get_results(
				$wpdb->prepare(
					' SELECT DISTINCT post_title, post_excerpt FROM ' . $wpdb->posts . '
					WHERE 1 = %d AND post_type = %s AND post_status = %s
					AND post_title != %s
					ORDER BY post_title ASC ',
					1,
					'acf-field',
					'publish',
					''
				)
			);

			$result = $wpdb->get_col(
				$wpdb->prepare(
					' SELECT DISTINCT meta_key FROM ' . $wpdb->postmeta . '
					WHERE 1 = %d AND meta_key NOT BETWEEN %s AND %s HAVING meta_key NOT LIKE %s
					ORDER BY meta_key ASC ',
					1,
					'_',
					'_z',
					$wpdb->esc_like( '_' ) . '%'
				)
			);
			if ( ! empty( $result ) ) {
				$result = array_diff(
					$result,
					array(
						'spp_sample',
						'spp_sample_url',
						'_',
						'_encloseme',
						'_edit_last',
						'_edit_lock',
						'_wp_trash_meta_status',
						'_wp_trash_meta_time',
						'_customize_changeset_uuid',
						'_customize_draft_post_name',
						'_customize_restore_dismissed',
						'_menu_item_classes',
						'_menu_item_menu_item_parent',
						'_menu_item_object',
						'_menu_item_object_id',
						'_menu_item_type',
						'_menu_item_url',
					)
				);
			}

			$list = '<select>
			<option value="">' . esc_html__( 'See the list of exisiting post meta', 'spp' ) . '</option>';

			if ( ! empty( $acf_fields ) ) {
				$list .= '<optgroup label="' . esc_html__( 'ACF Fields Post Meta', 'spp' ) . '">';
				foreach ( $acf_fields as $item ) {
					$list .= '<option value="' . esc_attr( $item->post_excerpt ) . '">' . esc_attr( $item->post_excerpt ) . ' (' . esc_attr( $item->post_title ) . ')</option>';
					$result = array_diff( $result, array( $item->post_excerpt, '_' . $item->post_excerpt ) );
				}
				$list .= '</optgroup>';
			}

			if ( ! empty( $result ) ) {
				$list .= '<optgroup label="' . esc_html__( 'Other Post Meta', 'spp' ) . '">';
				foreach ( $result as $item ) {
					$list .= '<option value="' . esc_attr( $item ) . '">' . esc_attr( $item ) . '</option>';
				}
				$list .= '</optgroup>';
			}

			$list .= '</select>';

			set_transient( $trans_id, $list, 30 * MINUTE_IN_SECONDS );
		}

		return $list;
	}

	/**
	 * When the post meta are updated, deleted, created, the transient must be refreshed to reflect the new set.
	 *
	 * @param  string  $meta_id    Post meta id.
	 * @param  integer $post_id    Post ID.
	 * @param  string  $meta_key   Meta key.
	 * @param  mixed   $meta_value Meta value.
	 * @return void
	 */
	public static function reset_spp_meta_list( $meta_id, $post_id, $meta_key, $meta_value ) {
		delete_transient( 'ssp-post-meta-list' );
	}

	/** Add the new menu in general options section that allows to configure the plugin settings */
	public static function admin_menu() {
		add_submenu_page(
			'tools.php',
			'<div class="dashicons dashicons-admin-generic"></div> ' . __( 'Easy Populate Posts', 'spp' ),
			'<div class="dashicons dashicons-admin-generic"></div> ' . __( 'Easy Populate Posts', 'spp' ),
			'manage_options',
			'populate-posts-settings',
			array( get_called_class(), 'populate_posts_settings' )
		);
	}

	/**
	 * Create the plugin images sources from a list of URLs.
	 *
	 * @access public
	 * @static
	 *
	 * @param string $images_list List of images separated by new line.
	 * @return void
	 */
	public static function set_local_images_from_options( $images_list ) {
		if ( ! empty( $images_list ) ) {
			$photos = explode( chr( 13 ), $images_list );
			foreach ( $photos as $p ) {
				$p = trim( $p );
				self::make_image_from_url( $p );
			}
		}
	}

	/**
	 * Read the plugin images ids and return the array.
	 *
	 * @access public
	 * @static
	 * @return array
	 */
	public static function get_local_images() {
		// Identify the attachment already created, so we do not generate the same one.
		$args = array(
			'post_type'   => 'attachment',
			'post_status' => 'any',
			'meta_query'  => array(
				array(
					'key'     => 'spp_sample',
					'value'   => 1,
					'compare' => '=',
				),
			),
			'fields'      => 'ids',
		);

		$posts = new WP_Query( $args );
		if ( ! empty( $posts->posts ) ) {
			return $posts->posts;
		}
		return array();
	}

	/** Return true if the nonce is posted and is valid */
	public static function spp_validate_nonce() {
		if ( ! empty( $_POST ) ) {
			$nonce = filter_input( INPUT_POST, 'spp_settings_nonce', FILTER_DEFAULT );
			if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'spp_settings_save' ) ) {
				esc_html_e( 'Action not allowed.', 'spp' );
				die();
			}
			return true;
		}
		return false;
	}

	/** Return true if the current user can manage options, hence allowed to use the plugin */
	public static function spp_current_user_can() {
		// Verify user capabilities in order to deny the access if the user does not have the capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			esc_html_e( 'Action not allowed.', 'spp' );
			die();
		}
		return true;
	}

	/**
	 * Return the content generated after an ajax call
	 *
	 * @param boolean $return True if the method returns result.
	 * @return void
	 */
	public static function spp_save_settings( $return = true ) {
		if ( self::spp_current_user_can() && self::spp_validate_nonce() ) {
			$spp_del = filter_input( INPUT_POST, 'spp_del', FILTER_VALIDATE_INT );
			if ( ! empty( $spp_del ) ) {
				wp_delete_post( (int) $spp_del );
				$local_images                  = self::get_local_images();
				self::$settings['images_path'] = ( ! empty( $local_images ) ) ? implode( ',', $local_images ) : '';
				update_option( 'spp_settings', self::$settings );

				if ( false !== $return ) {
					self::load_plugin_settings();
					self::spp_show_plugin_images();
					die();
				}
			}

			self::load_plugin_settings();
			$ds     = self::$settings;
			$ds_new = $ds;
			$ints   = array( 'content_type', 'content_p', 'date_type', 'has_sticky', 'max_number', 'post_parent' );
			$pspp   = filter_input( INPUT_POST, 'spp', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
			foreach ( $ds as $key => $value ) {
				if ( isset( $pspp[ $key ] ) ) {
					if ( 'start_counter' === $key ) {
						if ( ! substr_count( $pspp['title_prefix'], '#NO' ) ) {
							$ds_new['start_counter'] = 0;
						} else {
							$ds_new['start_counter'] = $pspp['start_counter'];
						}
					} elseif ( 'images_list' === $key || 'images_path' === $key ) {
						$ds_new['images_list'] = implode( chr( 13 ), array_map( 'sanitize_text_field', explode( chr( 13 ), $pspp['images_list'] ) ) );
						self::set_local_images_from_options( $ds_new['images_list'] );
						$local_images          = self::get_local_images();
						$ds_new['images_path'] = ( ! empty( $local_images ) ) ? implode( ',', $local_images ) : '';
					} else {
						$maybe = maybe_unserialize( $pspp[ $key ] );
						if ( is_array( $maybe ) || is_object( $maybe ) ) {
							$ds_new[ $key ] = maybe_unserialize( $pspp[ $key ] );
						} else {
							$ds_new[ $key ] = sanitize_text_field( $pspp[ $key ] );
						}

						if ( in_array( $key, $ints ) ) {
							$ds_new[ $key ] = abs( (int) $ds_new[ $key ] );
						}
						if ( 'max_number' === $key ) {
							$ds_new[ $key ] = ( $ds_new[ $key ] > self::$max_random ) ? self::$max_random : $ds_new[ $key ];
						}
						if ( 'term_id' === $key || 'term_id2' === $key ) {
							$ds_new[ $key ] = implode( ',', self::spp_cleanup_terms_ids( $ds_new[ $key ] ) );
						}
						if ( 'term_slug' === $key || 'term_slug2' === $key ) {
							$ds_new[ $key ] = implode( ',', self::spp_cleanup_terms_slugs( $ds_new[ $key ] ) );
						}
						if ( 'specific_hour' === $key ) {
							$ds_new[ $key ] = ( empty( $ds_new[ $key ] ) ) ? '00:00:00' : $ds_new[ $key ] . ':00';
						}

						if ( 'cleanup_on_deactivate' === $key ) {
							$ds_new[ $key ] = (int) ! empty( $ds_new[ $key ] );
						}
					}
				}
			}

			update_option( 'spp_settings', $ds_new );
			self::load_plugin_settings();
		}

		if ( false !== $return ) {
			self::load_plugin_settings();
			self::spp_show_plugin_images();
			die();
		}
	}

	/**
	 * Ajax call handler for populating posts.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function spp_populate() {
		if ( self::spp_current_user_can() && self::spp_validate_nonce() ) {
			self::spp_save_settings( false );
			self::execute_add_random_posts();
		}
		die();
	}

	/**
	 * Default text mentioning how the images work.
	 *
	 * @access public
	 * @static
	 * @return string
	 */
	public static function spp_images_mention() {
		return '<em>' . esc_html__( 'Images to be set randomly as featured image.', 'spp' ) . '</em>';
	}

	/**
	 * Output the plugin images.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function spp_show_plugin_images() {
		if ( ! empty( self::$settings['images_path'] ) ) {
			$p = explode( ',', self::$settings['images_path'] );
			if ( count( $p ) !== 0 ) :
				foreach ( $p as $id ) :
					$url     = wp_get_attachment_image_src( $id, 'thumbnail' );
					$img_src = ( ! empty( $url[0] ) ) ? $url[0] : '';
					?>
					<span class="spp_figure"><span class="icon"><span class="dashicons dashicons-no" data-id="<?php echo (int) $id; ?>"></span></span><img src="<?php echo esc_url( $img_src . '?v=' . time() ); ?>"></span>
					<?php
				endforeach;
				echo self::spp_images_mention(); // WPCS: XSS OK.
			endif;
		}
	}

	/** The plugin settings and trigger for the populate of posts */
	public static function populate_posts_settings() {
		?>
		<div class="wrap">
			<h1><span class="dashicons dashicons-admin-generic ic-devops"></span> <?php esc_html_e( 'Easy Populate Posts Settings', 'spp' ); ?></h1>

			<p>
				<?php esc_html_e( 'The is a helper plugin that allows developers to populate the sites with random content (posts with random tags, images, date in the past or in the future, sticky flag), but with specific meta values and taxonomy terms associated if the case.', 'spp' ); ?>
			</p>

			<form id="spp_settings_frm" action="" method="post" class="spp">
				<?php wp_nonce_field( 'spp_settings_save', 'spp_settings_nonce' ); ?>
				<input type="hidden" name="spp_del" id="spp_del" value="">

				<table class="spp-table wp-list-table widefat fixed posts striped" width="100%">
					<tr>
						<td width="70" align="right"><h3><?php esc_html_e( 'Content', 'spp' ); ?></h3></td>
						<td>
							<?php esc_html_e( 'Title Prefix', 'spp' ); ?>
							<em id="title-prefix-note">(<?php esc_html_e( 'use #NO for counter', 'spp' ); ?>)</em><br>
							<input type="text" name="spp[title_prefix]" id="spp_title_prefix" value="<?php echo esc_attr( self::$settings['title_prefix'] ); ?>" size="20">
							<div id="spp_title_prefix_counter" class="hidden">
								<br>
								<table class="spp-table no-padd fixed" width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td><em><?php esc_html_e( 'Start the auto-increment prefix number from this', 'spp' ); ?></em></td>
										<td>
											<input type="number" name="spp[start_counter]" id="spp_start_counter" value="<?php echo esc_attr( self::$settings['start_counter'] ); ?>" size="20" disabled="disabled"></td>

										</tr>
									</table>
							</div>
						</td>
						<td>
							<?php esc_html_e( 'Content', 'spp' ); ?><br>
							<select name="spp[content_type]" id="spp_content_type">
								<option value="0"<?php selected( 0, self::$settings['content_type'] ); ?>><?php esc_attr_e( 'Random', 'spp' ); ?></option>
								<option value="1"<?php selected( 1, self::$settings['content_type'] ); ?>><?php esc_attr_e( 'Star Wars', 'spp' ); ?></option>
								<option value="2"<?php selected( 2, self::$settings['content_type'] ); ?>><?php esc_attr_e( 'Lorem Ipsum', 'spp' ); ?></option>
							</select>
						</td>
						<td>
							<?php esc_html_e( 'Excerpt', 'spp' ); ?><br>
							<select name="spp[excerpt]" id="spp_excerpt">
								<option value="0"<?php selected( 0, self::$settings['excerpt'] ); ?>><?php esc_attr_e( 'No excerpt', 'spp' ); ?></option>
								<option value="1"<?php selected( 1, self::$settings['excerpt'] ); ?>><?php esc_attr_e( 'Excerpt from content', 'spp' ); ?></option>
								<option value="2"<?php selected( 2, self::$settings['excerpt'] ); ?>><?php esc_attr_e( 'Random excerpt', 'spp' ); ?></option>
							</select>
						</td>
						<td>
							<?php esc_html_e( 'Paragraphs', 'spp' ); ?><br>
							<select name="spp[content_p]" id="spp_content_p">
								<option value="0"<?php selected( 0, self::$settings['content_p'] ); ?>><?php esc_attr_e( 'Random', 'spp' ); ?></option>
								<option value="1"<?php selected( 1, self::$settings['content_p'] ); ?>>1</option>
								<option value="2"<?php selected( 2, self::$settings['content_p'] ); ?>>2</option>
								<option value="3"<?php selected( 3, self::$settings['content_p'] ); ?>>3</option>
								<option value="4"<?php selected( 4, self::$settings['content_p'] ); ?>>4</option>
								<option value="5"<?php selected( 5, self::$settings['content_p'] ); ?>>5</option>
							</select>
						</td>

						<td>
							<?php esc_html_e( 'Sticky Post', 'spp' ); ?><br>
							<select name="spp[has_sticky]" id="spp_has_sticky">
								<option value="0"<?php selected( 0, self::$settings['has_sticky'] ); ?>><?php esc_attr_e( 'Random', 'spp' ); ?></option>
								<option value="1"<?php selected( 1, self::$settings['has_sticky'] ); ?>><?php esc_attr_e( 'Yes', 'spp' ); ?></option>
								<option value="2"<?php selected( 2, self::$settings['has_sticky'] ); ?>><?php esc_attr_e( 'No', 'spp' ); ?></option>
							</select>
						</td>
					</tr>

					<tr>
						<td align="right"><h3><?php esc_html_e( 'Post', 'spp' ); ?></h3></td>
						<td>
							<?php esc_html_e( 'Maximum', 'spp' ); ?><br>
							<input type="text" name="spp[max_number]" id="spp_max_number" value="<?php echo esc_attr( self::$settings['max_number'] ); ?>" size="15">
							<em><?php esc_html_e( 'how many to generate', 'spp' ); ?></em>
						</td>
						<td>
							<?php esc_html_e( 'Type', 'spp' ); ?><br>
							<select name="spp[post_type]" id="spp_post_type">
								<?php if ( ! empty( self::$allowed_post_types ) ) : ?>
									<?php foreach ( self::$allowed_post_types as $k => $v ) : ?>
										<option value="<?php echo esc_attr( $k ); ?>"<?php selected( $k, self::$settings['post_type'] ); ?>><?php echo esc_attr( $v ); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</td>
						<td>
							<?php esc_html_e( 'Parent', 'spp' ); ?><br>
							<input type="text" name="spp[post_parent]" id="spp_post_parent" value="<?php echo esc_attr( self::$settings['post_parent'] ); ?>" size="15" placeholder="<?php esc_attr_e( 'Parent ID', 'spp' ); ?>">
							<em><?php esc_html_e( 'for hierarchical type only', 'spp' ); ?></em>
						</td>
						<td>
							<?php esc_html_e( 'Date', 'spp' ); ?><br>
							<select name="spp[date_type]" id="spp_date_type">
								<option value="0"<?php selected( 0, self::$settings['date_type'] ); ?>><?php esc_attr_e( 'Random', 'spp' ); ?></option>
								<option value="3"<?php selected( 3, self::$settings['date_type'] ); ?>><?php esc_attr_e( 'Specific Date & Status', 'spp' ); ?></option>
								<option value="1"<?php selected( 1, self::$settings['date_type'] ); ?>><?php esc_attr_e( 'In the past', 'spp' ); ?></option>
								<option value="2"<?php selected( 2, self::$settings['date_type'] ); ?>><?php esc_attr_e( 'In the future', 'spp' ); ?></option>
							</select>
							<div id="spp_specific_date_wrap"
								<?php if ( 3 !== (int) self::$settings['date_type'] ) : ?>
								style="display:none;"
								<?php endif; ?>>
								<br>
								<table class="spp-table no-padd fixed" width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td width="68%"><input type="date" name="spp[specific_date]" id="spp_specific_date" value="<?php echo esc_attr( self::$settings['specific_date'] ); ?>" pattern="\d{4}-\d{2}-\d{2}" size="15" placeholder="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>"><em><?php esc_html_e( 'Date', 'spp' ); ?></em>
										</td>
										<td><input type="time" name="spp[specific_hour]" id="spp_specific_hour" value="<?php echo esc_attr( self::$settings['specific_hour'] ); ?>" size="15" placeholder="<?php echo esc_attr( gmdate( 'H:i' ) ); ?>"><em><?php esc_html_e( 'Hour', 'spp' ); ?></em>
										</td>
									</tr>
								</table>
							</div>
						</td>
						<td>
							<?php esc_html_e( 'Status', 'spp' ); ?><br>
							<div id="spp_random_date_text0"<?php if ( 0 !== (int) self::$settings['date_type'] ) : ?>
								style="display:none;"
								<?php endif; ?>><em><?php esc_html_e( 'will set a random status, correlated with the publish date', 'spp' ); ?><em></div>

							<div id="spp_random_date_text3"<?php if ( 3 !== (int) self::$settings['date_type'] ) : ?>
								style="display:none;"
								<?php endif; ?>>
								<select name="spp[specific_status]" id="spp_specific_status">
									<option value=""<?php selected( '', self::$settings['specific_status'] ); ?>><?php esc_attr_e( 'Not Specific', 'spp' ); ?></option>
									<?php if ( ! empty( self::$allowed_post_statuses ) ) : ?>
										<?php foreach ( self::$allowed_post_statuses as $k => $v ) : ?>
											<option value="<?php echo esc_attr( $k ); ?>"<?php selected( $k, self::$settings['specific_status'] ); ?>><?php echo esc_attr( $v ); ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</div>

							<div id="spp_random_date_text1"<?php if ( 1 !== (int) self::$settings['date_type'] ) : ?>
								style="display:none;"
								<?php endif; ?>><em><?php esc_html_e( 'defaults to', 'spp' ); ?> <?php esc_html_e( 'published', 'spp' ); ?><em></div>

							<div id="spp_random_date_text2"<?php if ( 2 !== (int) self::$settings['date_type'] ) : ?>
								style="display:none;"
								<?php endif; ?>><em><?php esc_html_e( 'defaults to', 'spp' ); ?> <?php esc_html_e( 'scheduled', 'spp' ); ?><em></div>
						</td>
					</tr>

					<tr>
						<td align="right"><h3><?php esc_html_e( 'Terms', 'spp' ); ?></h3></td>
						<td colspan="5">

							<table class="spp-table fixed" width="100%">
								<tr>
									<td width="100"><?php esc_html_e( 'Random Tags', 'spp' ); ?></td>
									<td colspan="4">
										<input type="text" name="spp[tags_list]" id="spp_tags_list" value="<?php echo esc_attr( self::$settings['tags_list'] ); ?>">
									</td>
									<td><em><?php esc_html_e( 'separated by comma', 'spp' ); ?></em></td>
								</tr>
								<tr>
									<td><?php esc_html_e( 'Taxonomy', 'spp' ); ?></td>
									<td><select name="spp[taxonomy]" id="spp_taxonomy">
										<?php if ( ! empty( self::$allowed_taxonomies ) ) : ?>
											<?php foreach ( self::$allowed_taxonomies as $k => $v ) : ?>
												<option value="<?php echo esc_attr( $k ); ?>"<?php selected( $k, self::$settings['taxonomy'] ); ?>><?php echo esc_attr( $v ); ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select></td>
									<td colspan="2"><input type="text" name="spp[term_slug]" id="spp_term_slug" value="<?php echo esc_attr( str_replace( ',', ', ', self::$settings['term_slug'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'name', 'spp' ); ?>"></td>
									<td><em><?php esc_html_e( 'separate terms names by comma, these will be created if not found', 'spp' ); ?></em></td>
									<td><input type="text" name="spp[term_id]" id="spp_term_id" value="<?php echo esc_attr( self::$settings['term_id'] ); ?>" size="10" placeholder="<?php esc_attr_e( 'term_id', 'spp' ); ?>"></td>
								</tr>

								<tr>
									<td><?php esc_html_e( 'Taxonomy', 'spp' ); ?></td>
									<td><select name="spp[taxonomy2]" id="spp_taxonomy2">
										<?php if ( ! empty( self::$allowed_taxonomies ) ) : ?>
											<?php foreach ( self::$allowed_taxonomies as $k => $v ) : ?>
												<option value="<?php echo esc_attr( $k ); ?>"<?php selected( $k, self::$settings['taxonomy2'] ); ?>><?php echo esc_attr( $v ); ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select></td>
									<td colspan="2"><input type="text" name="spp[term_slug2]" id="spp_term_slug2" value="<?php echo esc_attr( str_replace( ',', ', ', self::$settings['term_slug2'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'name', 'spp' ); ?>"></td>
									<td><em><?php esc_html_e( 'separate terms names by comma, these will be created if not found', 'spp' ); ?></em></td>
									<td><input type="text" name="spp[term_id2]" id="spp_term_id2" value="<?php echo esc_attr( self::$settings['term_id2'] ); ?>" size="10" placeholder="<?php esc_attr_e( 'term_id', 'spp' ); ?>"></td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td align="right"><h3><?php esc_html_e( 'Meta', 'spp' ); ?></h3></td>
						<td colspan="5">

							<table class="spp-table fixed" width="100%">
								<tr>
									<td width="100"><?php esc_html_e( 'Post Meta', 'spp' ); ?></td>
									<td><input type="text" name="spp[meta_key]" id="spp_meta_key" value="<?php echo esc_attr( self::$settings['meta_key'] ); ?>" size="15" placeholder="<?php esc_attr_e( 'key', 'spp' ); ?>"></td>
									<td><input type="text" name="spp[meta_value]" id="spp_meta_value" value="<?php echo esc_attr( maybe_serialize( self::$settings['meta_value'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'value', 'spp' ); ?>"></td>

									<td width="100"><?php esc_html_e( 'Post Meta', 'spp' ); ?> 2</td>
									<td><input type="text" name="spp[meta_key2]" id="spp_meta_key2" value="<?php echo esc_attr( self::$settings['meta_key2'] ); ?>" size="15" placeholder="<?php esc_attr_e( 'key', 'spp' ); ?>"></td>
									<td><input type="text" name="spp[meta_value2]" id="spp_meta_value2" value="<?php echo esc_attr( maybe_serialize( self::$settings['meta_value2'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'value', 'spp' ); ?>"></td>
								</tr>
								<tr>
									<td><?php esc_html_e( 'Post Meta', 'spp' ); ?> 3</td>
									<td><input type="text" name="spp[meta_key3]" id="spp_meta_key3" value="<?php echo esc_attr( self::$settings['meta_key3'] ); ?>" size="15" placeholder="<?php esc_attr_e( 'key', 'spp' ); ?>"></td>
									<td><input type="text" name="spp[meta_value3]" id="spp_meta_value3" value="<?php echo esc_attr( maybe_serialize( self::$settings['meta_value3'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'value', 'spp' ); ?>"></td>

									<td><?php esc_html_e( 'Post Meta', 'spp' ); ?> 4</td>
									<td><input type="text" name="spp[meta_key4]" id="spp_meta_key4" value="<?php echo esc_attr( self::$settings['meta_key4'] ); ?>" size="15" placeholder="<?php esc_attr_e( 'key', 'spp' ); ?>"></td>
									<td><input type="text" name="spp[meta_value4]" id="spp_meta_value4" value="<?php echo esc_attr( maybe_serialize( self::$settings['meta_value4'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'value', 'spp' ); ?>"></td>
								</tr>
								<tr>
									<td><?php esc_html_e( 'Post Meta', 'spp' ); ?> 5</td>
									<td><input type="text" name="spp[meta_key5]" id="spp_meta_key5" value="<?php echo esc_attr( self::$settings['meta_key5'] ); ?>" size="15" placeholder="<?php esc_attr_e( 'key', 'spp' ); ?>"></td>
									<td><input type="text" name="spp[meta_value5]" id="spp_meta_value5" value="<?php echo esc_attr( maybe_serialize( self::$settings['meta_value5'] ) ); ?>" size="10" placeholder="<?php esc_attr_e( 'value', 'spp' ); ?>"></td>
									<td colspan="2"><em><?php esc_html_e( 'Each of the specified post meta is a pair of meta_key and meta_value', 'spp' ); ?></em></td>
									<td><?php echo self::get_post_meta_keys(); // WPCS:XSS OK. ?></td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td align="right"><h3><?php esc_html_e( 'Images', 'spp' ); ?></h3></td>
						<td colspan="3">
							<textarea name="spp[images_list]" id="spp_images_list" cols="20" rows="2"></textarea>
							<br>
							<em><?php esc_html_e( 'Click here to ', 'spp' ); ?> <a onclick="jQuery('#spp_images_list').val( jQuery('#spp_initial_images').html() );"><?php esc_html_e( 'use the plugin sample images', 'spp' ); ?></a>. <br><?php esc_html_e( 'You can add your own images URLs and click the "save settings" button (add URLs of images, separated by new line).', 'spp' ); ?></em>
							<span id="spp_initial_images"><?php echo self::$settings['default_images']; // WPCS: XSS OK. ?></span>
						</td>
						<td colspan="2" align="right">
							<div id="spp_settings_wrap"><?php self::spp_show_plugin_images(); ?></div>
						</td>
					</tr>
				</table>

				<?php
				$class = '';
				if ( ! empty( self::$settings['cleanup_on_deactivate'] ) ) {
					$class = 'spp-will-cleanup';
				}
				?>
				<br>
				<table id="spp-will-cleanup" class="fixed <?php echo esc_attr( $class ); ?>" width="100%">
					<tr>
						<td>
							<label><input type="checkbox" name="spp[cleanup_on_deactivate]" id="spp_cleanup_on_deactivate" <?php checked( self::$settings['cleanup_on_deactivate'], 1 ); ?> onclick="jQuery('#spp-will-cleanup').toggleClass('spp-will-cleanup');"> <b><?php esc_html_e( 'CONTENT CLEANUP ON DEACTIVATE', 'spp' ); ?></b> (<?php esc_html_e( 'please be careful, if you enable this option, when you deactivate the plugin, the content populated with this plugin will be removed, including the generated images', 'spp' ); ?>).</label>
						</td>
						<td width="40%" align="right">
							<button id="spp_save" class="button"><?php esc_html_e( 'Save Settings', 'spp' ); ?></button>
							<button id="spp_execute" class="button button-primary"><?php esc_html_e( 'Execute Posts Add', 'spp' ); ?></button>
						</td>
					</tr>
				</table>

				<br >
				<div id="spp_populate_wrap"></div>
			</form>
		</div>
		<?php
	}

	/**
	 * Cleanup terms by ids.
	 *
	 * @param string $ids List of terms ids separated by comma.
	 * @return array
	 */
	public static function spp_cleanup_terms_ids( $ids = '' ) {
		$taxonomy_ids1 = explode( ',', $ids );
		if ( ! is_array( $taxonomy_ids1 ) ) {
			$taxonomy_ids1 = array( (int) $ids );
		}
		$taxonomy_ids1 = array_map( 'intval', $taxonomy_ids1 );
		$taxonomy_ids1 = array_unique( $taxonomy_ids1 );
		$taxonomy_ids1 = array_filter( $taxonomy_ids1 );
		return $taxonomy_ids1;
	}

	/**
	 * Cleanup terms by slugs.
	 *
	 * @param string $slugs List of terms names separated by comma.
	 * @return array
	 */
	public static function spp_cleanup_terms_slugs( $slugs = '' ) {
		$taxonomy_ids1 = explode( ',', $slugs );
		if ( ! is_array( $taxonomy_ids1 ) ) {
			$taxonomy_ids1 = array( trim( $slugs ) );
		}
		$taxonomy_ids1 = array_map( 'trim', $taxonomy_ids1 );
		$taxonomy_ids1 = array_unique( $taxonomy_ids1 );
		$taxonomy_ids1 = array_filter( $taxonomy_ids1 );
		return $taxonomy_ids1;
	}

	/**
	 * Create a random post title.
	 *
	 * @param array   $text_elements Text elements.
	 * @param integer $min_w         Mimumum words.
	 * @return string
	 */
	public static function get_random_title( $text_elements, $min_w = 4 ) {
		$nn = $text_elements[ mt_rand( 0, count( $text_elements ) - 1 ) ];
		$nn = preg_replace( '[\!\?]', '.', $nn );
		$n  = explode( '.', $nn );
		shuffle( $n );

		$name  = $n[0];
		$words = explode( ' ', $name );
		$max_w = count( $words ) - 1;
		if ( $max_w <= $min_w ) {
			$min_w = $max_w;
		}
		$name = trim( implode( ' ', array_slice( $words, 0, mt_rand( $min_w, $max_w ) ) ) );
		$name = ucfirst( $name );
		return $name;
	}

	/**
	 * Create a random post content.
	 *
	 * @param array   $text_elements Text elements.
	 * @param integer $max_blocks    Mimumum paragraphs.
	 * @param integer $rand          Start for elements.
	 * @return string
	 */
	public static function get_random_description( $text_elements, $max_blocks = 1, $rand = 0 ) {
		$texts = array_slice( $text_elements, (int) $rand, $max_blocks );
		$text  = '<p>' . implode( '</p><p>', $texts ) . '</p>';
		return $text;
	}

	/**
	 * Check if date is valid.
	 *
	 * @param string $date Date string.
	 * @return boolean
	 */
	public static function spp_is_valide_date( $date ) {
		$d = DateTime::createFromFormat( 'Y-m-d H:i:s', $date );
		if ( false !== $d ) {
			return ( $d->format( 'Y-m-d H:i:s' ) === $date );
		}
		return false;
	}

	/**
	 * Get text elements, with all their paragraphs.
	 *
	 * @param integer $settings_content_type Selected content type.
	 * @return string
	 */
	public static function get_text_elements( $settings_content_type = 0 ) {
		$text_elements = array(
			0 => array(
				'I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan Partially, but it also obeys your commands. Oh God, my uncle. How am I ever gonna explain this? What!? A tremor in the Force. The last time I felt it was in the presence of my old master.',
				'Leave that to me. Send a distress signal, and inform the Senate that all on board were killed. I need your help, Luke. She needs your help. I\'m getting too old for this sort of thing. I need your help, Luke. She needs your help. I\'m getting too old for this sort of thing. Look, I ain\'t in this for your revolution, and I\'m not in it for you, Princess. I expect to be well paid. I\'m in it for the money.',
				'Red Five standing by. The plans you refer to will soon be back in our hands. Red Five standing by. I\'m surprised you had the courage to take the responsibility yourself. She must have hidden the plans in the escape pod. Send a detachment down to retrieve them, and see to it personally, Commander. There\'ll be no one to stop us this time! No! Alderaan is peaceful. We have no weapons. You can\'t possibly',
				'What?! Don\'t be too proud of this technological terror you\'ve constructed. The ability to destroy a planet is insignificant next to the power of the Force. I have traced the Rebel spies to her. Now she is my only link to finding their secret base.',
				'Kid, I\'ve flown from one side of this galaxy to the other. I\'ve seen a lot of strange stuff, but I\'ve never seen anything to make me believe there\'s one all-powerful Force controlling everything. There\'s no mystical energy field that controls my destiny. It\'s all a lot of simple tricks and nonsense. Leave that to me. Send a distress signal, and inform the Senate that all on board were killed. Leave that to me. Send a distress signal, and inform the Senate that all on board were killed. Kid, I\'ve flown from one side of this galaxy to the other. I\'ve seen a lot of strange stuff, but I\'ve never seen anything to make me believe there\'s one all-powerful Force controlling everything. There\'s no mystical energy field that controls my destiny. It\'s all a lot of simple tricks and nonsense. Red Five standing by. Red Five standing by.',
				'The plans you refer to will soon be back in our hands. I have traced the Rebel spies to her. Now she is my only link to finding their secret base. A tremor in the Force. The last time I felt it was in the presence of my old master. The plans you refer to will soon be back in our hands. You\'re all clear, kid. Let\'s blow this thing and go home!',
				'Obi-Wan is here. The Force is with him. The plans you refer to will soon be back in our hands. What good is a reward if you ain\'t around to use it? Besides, attacking that battle station ain\'t my idea of courage. It\'s more like... suicide. I have traced the Rebel spies to her. Now she is my only link to finding their secret base.',
				'Oh God, my uncle. How am I ever gonna explain this? I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan No! Alderaan is peaceful. We have no weapons. You can\'t possibly...',
				'She must have hidden the plans in the escape pod. Send a detachment down to retrieve them, and see to it personally, Commander. There\'ll be no one to stop us this time! I care. So, what do you think of her, Han? You are a part of the Rebel Alliance and a traitor! Take her away! Hokey religions and ancient weapons are no match for a good blaster at your side, kid.',
				'He is here. Leave that to me. Send a distress signal, and inform the Senate that all on board were killed. Red Five standing by. Partially, but it also obeys your commands. The more you tighten your grip, Tarkin, the more star systems will slip through your fingers. I\'m surprised you had the courage to take the responsibility yourself.',
				'I call it luck. As you wish. Ye-ha! I can\'t get involved! I\'ve got work to do! It\'s not that I like the Empire, I hate it, but there\'s nothing I can do about it right now. It\'s such a long way from here. I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan',
				'Escape is not his plan. I must face him, alone. She must have hidden the plans in the escape pod. Send a detachment down to retrieve them, and see to it personally, Commander. There\'ll be no one to stop us this time! What!? Alderaan? I\'m not going to Alderaan. I\'ve got to go home. It\'s late, I\'m in for it as it is. In my experience, there is no such thing as luck.',
				'Still, she\'s got a lot of spirit. I don\'t know, what do you think? I want to come with you to Alderaan. There\'s nothing for me here now. I want to learn the ways of the Force and be a Jedi, like my father before me. I need your help, Luke. She needs your help. I\'m getting too old for this sort of thing. Alderaan? I\'m not going to Alderaan. I\'ve got to go home. It\'s late, I\'m in for it as it is. As you wish. Red Five standing by.',
				'I have traced the Rebel spies to her. Now she is my only link to finding their secret base. She must have hidden the plans in the escape pod. Send a detachment down to retrieve them, and see to it personally, Commander. There\'ll be no one to stop us this time! I need your help, Luke. She needs your help. I\'m getting too old for this sort of thing. Obi-Wan is here. The Force is with him. No! Alderaan is peaceful. We have no weapons. You can\'t possibly...',
				'Leave that to me. Send a distress signal, and inform the Senate that all on board were killed. I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan Partially, but it also obeys your commands. Kid, I\'ve flown from one side of this galaxy to the other. I\'ve seen a lot of strange stuff, but I\'ve never seen anything to make me believe there\'s one all-powerful Force controlling everything. There\'s no mystical energy field that controls my destiny. It\'s all a lot of simple tricks and nonsense. A tremor in the Force. The last time I felt it was in the presence of my old master.',
				'I have traced the Rebel spies to her. Now she is my only link to finding their secret base. You\'re all clear, kid. Let\'s blow this thing and go home! Dantooine. They\'re on Dantooine.',
				'I want to come with you to Alderaan. There\'s nothing for me here now. I want to learn the ways of the Force and be a Jedi, like my father before me. I\'m trying not to, kid. Look, I can take you as far as Anchorhead. You can get a transport there to Mos Eisley or wherever you\'re going. I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan Leave that to me. Send a distress signal, and inform the Senate that all on board were killed.',
				'I have traced the Rebel spies to her. Now she is my only link to finding their secret base. Oh God, my uncle. How am I ever gonna explain this? You mean it controls your actions? I find your lack of faith disturbing.',
				'I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan What?! Hey, Luke! May the Force be with you.',
				'Don\'t act so surprised, Your Highness. You weren\'t on any mercy mission this time. Several transmissions were beamed to this ship by Rebel spies. I want to know what happened to the plans they sent you. All right. Well, take care of yourself, Han. I guess that\'s what you\'re best at, ain\'t it? I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan',
			),
			1 => array(
				'Eaque ipsa quae ab illo inventore veritatis et quasi. Sed ut perspiciatis unde omnis iste natus error sit voluptatem. Totam rem aperiam. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat. Nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam.',
				'Architecto beatae vitae dicta sunt explicabo. Cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat. Corrupti quos dolores et quas molestias excepturi sint occaecati.',
				'Architecto beatae vitae dicta sunt explicabo. Non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.',
				'Et harum quidem rerum facilis est et expedita distinctio. Quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Do eiusmod tempor incididunt ut labore et dolore magna aliqua. Do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				'Eaque ipsa quae ab illo inventore veritatis et quasi. Eaque ipsa quae ab illo inventore veritatis et quasi. Non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Fugiat quo voluptas nulla pariatur? Corrupti quos dolores et quas molestias excepturi sint occaecati.',
				'Esse cillum dolore eu fugiat nulla pariatur. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit. Itaque earum rerum hic tenetur a sapiente delectus. Nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam. Ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Esse cillum dolore eu fugiat nulla pariatur.',
				'Non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo. Fugiat quo voluptas nulla pariatur?',
				'Laboris nisi ut aliquip ex ea commodo consequat. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.',
				'At vero eos et accusamus. At vero eos et accusamus. Itaque earum rerum hic tenetur a sapiente delectus. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.',
				'Itaque earum rerum hic tenetur a sapiente delectus. Et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque. Esse cillum dolore eu fugiat nulla pariatur.',
				'Fugiat quo voluptas nulla pariatur? Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat. Et harum quidem rerum facilis est et expedita distinctio.',
				'Cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia. Totam rem aperiam. Excepteur sint occaecat cupidatat non proident, sunt in culpa. Do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				'Eaque ipsa quae ab illo inventore veritatis et quasi. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat. Nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam. Accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo. Architecto beatae vitae dicta sunt explicabo. Non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
				'Itaque earum rerum hic tenetur a sapiente delectus. Cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia. Accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo.',
				'Qui officia deserunt mollit anim id est laborum. Laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. At vero eos et accusamus. Inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
				'Ut enim ad minim veniam, quis nostrud exercitation ullamco. Animi, id est laborum et dolorum fuga. Fugiat quo voluptas nulla pariatur? Sed ut perspiciatis unde omnis iste natus error sit voluptatem. Nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam.',
				'Do eiusmod tempor incididunt ut labore et dolore magna aliqua. Itaque earum rerum hic tenetur a sapiente delectus. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.',
				'Nihil molestiae consequatur, vel illum qui dolorem eum. Nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam. Cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia. Ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Ut enim ad minim veniam, quis nostrud exercitation ullamco. Duis aute irure dolor in reprehenderit in voluptate velit.',
				'Totam rem aperiam. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat. Accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo. Eaque ipsa quae ab illo inventore veritatis et quasi. At vero eos et accusamus.',
				'Itaque earum rerum hic tenetur a sapiente delectus. Itaque earum rerum hic tenetur a sapiente delectus. Animi, id est laborum et dolorum fuga. Excepteur sint occaecat cupidatat non proident, sunt in culpa. Fugiat quo voluptas nulla pariatur? Architecto beatae vitae dicta sunt explicabo.',
			),
		);

		if ( 0 === (int) $settings_content_type ) {
			$text_elements = array_merge( $text_elements[0], $text_elements[1] );
		} else {
			$text_elements = $text_elements[ (int) $settings_content_type - 1 ];
		}
		return $text_elements;
	}

	/**
	 * Get random tags.
	 *
	 * @param string $tags_list List of tags.
	 * @return array
	 */
	public static function get_random_tags( $tags_list = '' ) {
		$tags = array();
		if ( ! empty( $tags_list ) ) {
			$t = explode( ',', $tags_list );
			$total_tags = count( $t );
			if ( 1 === $total_tags ) {
				$tags = $t;
			} else {
				shuffle( $t );
				$tags = array_slice( $t, 0, mt_rand( 1, count( $t ) - 1 ) );
			}
		}
		return $tags;
	}

	/**
	 * Assess and maybe create new taxonomy terms, and return the list of ids.
	 *
	 * @param  string       $tax   Taxonomy slug/name.
	 * @param  string|array $names Terms list.
	 * @return array
	 */
	public static function assess_create_taxonomy_terms( $tax, $names ) {
		$ids = array();
		if ( ! empty( $names ) ) {
			if ( is_scalar( $names ) ) {
				$names = explode( ',', $names );
			}
			foreach ( $names as $val ) {
				$term = term_exists( trim( $val ), $tax );
				if ( 0 !== $term && null !== $term ) {
					if ( ! empty( $term['term_id'] ) && is_numeric( $term['term_id'] ) ) {
						$ids[] = (int) $term['term_id'];
					}
				} else {
					$add = wp_insert_term( $val, $tax );
					if ( ! empty( $add['term_id'] ) && is_numeric( $add['term_id'] ) ) {
						$ids[] = (int) $add['term_id'];
					}
				}
			}
		}
		return $ids;
	}

	/**
	 * Select a random placeholder.
	 *
	 * @param  string $string The list of placeholders separated by comma.
	 * @return string
	 */
	public static function select_random_image( $string = '' ) {
		global $select_random_placeholder;
		$list   = ( ! is_array( $string ) ) ? explode( ',', $string ) : $string;
		$usable = $list;
		if ( empty( $select_random_placeholder ) ) {
			$select_random_placeholder = array();
		} else {
			$diff = array_diff( $list, $select_random_placeholder );
			if ( ! empty( $diff ) ) {
				$list = array_values( $diff );
			} else {
				$list = $usable;
				$select_random_placeholder = array();
			}
		}
		$index = array_rand( $list, 1 );
		$item  = ( ! empty( $list[ $index ] ) ) ? $list[ $index ] : $usable[0];
		$select_random_placeholder[] = $item;
		return $item;
	}

	/**
	 * Execute the content populate and outputs the result.
	 *
	 * @return void
	 */
	public static function execute_add_random_posts() {
		$text_elements = self::get_text_elements( self::$settings['content_type'] );
		$photos        = array();
		if ( ! empty( self::$settings['images_path'] ) ) {
			$photos = explode( ',', self::$settings['images_path'] );
		}

		$taxonomy_ids1 = false;
		if ( ! empty( self::$settings['taxonomy'] ) && ! empty( self::$settings['term_id'] ) ) {
			$taxonomy_ids1 = self::spp_cleanup_terms_ids( self::$settings['term_id'] );
		}

		$taxonomy_ids2 = false;
		if ( ! empty( self::$settings['taxonomy2'] ) && ! empty( self::$settings['term_id2'] ) ) {
			$taxonomy_ids2 = self::spp_cleanup_terms_ids( self::$settings['term_id2'] );
		}

		$taxonomy_slugs1 = false;
		if ( ! empty( self::$settings['taxonomy'] ) && ! empty( self::$settings['term_slug'] ) ) {
			$taxonomy_slugs1 = self::spp_cleanup_terms_slugs( self::$settings['term_slug'] );
			$taxonomy_slugs1 = self::assess_create_taxonomy_terms( self::$settings['taxonomy'], $taxonomy_slugs1 );
		}
		$taxonomy_slugs2 = false;
		if ( ! empty( self::$settings['taxonomy2'] ) && ! empty( self::$settings['term_slug2'] ) ) {
			$taxonomy_slugs2 = self::spp_cleanup_terms_slugs( self::$settings['term_slug2'] );
			$taxonomy_slugs2 = self::assess_create_taxonomy_terms( self::$settings['taxonomy2'], $taxonomy_slugs2 );
		}

		$now           = current_time( 'timestamp' );
		$return_result = '<ol>';
		$last          = 0;
		for ( $i = 0; $i < self::$settings['max_number']; $i ++ ) {
			shuffle( $text_elements );
			$name = self::get_random_title( $text_elements );

			if ( ! empty( $name ) ) {
				$max_blocks  = ( 0 === (int) self::$settings['content_p'] ) ? mt_rand( 1, 6 ) : self::$settings['content_p'];
				$description = self::get_random_description( $text_elements, (int) $max_blocks );

				$tags = array();
				if ( ! empty( self::$settings['tags_list'] ) ) {
					$tags = self::get_random_tags( self::$settings['tags_list'] );
				}

				/** Date and status related. */
				if ( ! empty( self::$settings['specific_date'] ) ) {
					// This is the explict date selected by the user.
					$hour = empty( self::$settings['specific_hour'] ) ? '00:00:00' : self::$settings['specific_hour'] . ':00';
					$date = self::$settings['specific_date'] . ' ' . $hour;
					$date = substr( $date, 0, 19 );
					$time = strtotime( $date );
				} else {
					$now_pref = - 1;
					if ( 2 === (int) self::$settings['date_type'] ) {
						$now_pref = 1;
					} elseif ( 0 === (int) self::$settings['date_type'] ) {
						$now_pref = mt_rand( - 1, 0 );
						$now_pref = ( 0 === $now_pref ) ? 1 : - 1;
					}
					$time = $now + $now_pref * mt_rand( 1, 60 ) * DAY_IN_SECONDS;
					$date = gmdate( 'Y-m-d H:i:s', $time );
				}

				$status = ( $time > $now ) ? 'future' : 'publish';
				if ( 'future' !== $status && ! empty( self::$settings['specific_status'] ) ) {
					$status = self::$settings['specific_status'];
				}

				$prefix = '';
				if ( ! empty( self::$settings['title_prefix'] ) ) {
					$last = self::$settings['start_counter'];
					if ( substr_count( self::$settings['title_prefix'], '#NO' ) ) {
						$prefix = str_replace( '#NO', $last, self::$settings['title_prefix'] ) . ' ';
						self::$settings['start_counter'] ++;
						update_option( 'spp_settings', self::$settings );
						$time += $last;
						$date  = gmdate( 'Y-m-d H:i:s', $time );
					} else {
						if ( ! empty( $last ) ) {
							// Reset the counter.
							self::$settings['start_counter'] = 0;
							update_option( 'spp_settings', self::$settings );
						}
						$prefix = self::$settings['title_prefix'] . ' ';
					}
				}
				$name = ( ! empty( $prefix ) ) ? $prefix . lcfirst( $name ) : $name;

				$excerpt = '';
				if ( ! empty( self::$settings['excerpt'] ) ) {
					if ( 2 === (int) self::$settings['excerpt'] ) {
						$excerpt = wp_trim_words( self::get_random_description( $text_elements, 1, mt_rand( 0, count( $text_elements ) - 1 ) ), 25, '.' );
					} else {
						$excerpt = wp_trim_words( $description, 25, '.' );
					}
				}

				$cat_terms = array();
				if ( ! empty( $taxonomy_slugs1 ) && 'category' === self::$settings['taxonomy'] ) {
					$cat_terms = array_merge( $cat_terms, $taxonomy_slugs1 );
					$taxonomy_slugs1 = false;
				}
				if ( ! empty( $taxonomy_slugs2 ) && 'category' === self::$settings['taxonomy2'] ) {
					$cat_terms = array_merge( $cat_terms, $taxonomy_slugs2 );
					$taxonomy_slugs2 = false;
				}

				$post = array(
					'post_content'  => $description,
					'post_excerpt'  => $excerpt,
					'post_name'     => sanitize_title( $name ),
					'post_title'    => $name,
					'post_status'   => $status,
					'post_type'     => self::$settings['post_type'],
					'post_date'     => $date,
					'tags_input'    => $tags,
					'post_parent'   => (int) self::$settings['post_parent'],
					'post_category' => $cat_terms,
				);

				$post_id = wp_insert_post( $post );

				if ( ! empty( $post_id ) ) {
					update_post_meta( $post_id, 'spp_sample', 1 );

					if ( 0 === self::$settings['has_sticky'] ) {
						if ( 1 === mt_rand( 0, 1 ) ) {
							stick_post( $post_id );
						}
					} elseif ( 1 === self::$settings['has_sticky'] ) {
						stick_post( $post_id );
					}

					if ( ! empty( self::$settings['meta_key'] ) ) {
						update_post_meta( $post_id, self::$settings['meta_key'], self::$settings['meta_value'] );
					}
					if ( ! empty( self::$settings['meta_key2'] ) ) {
						update_post_meta( $post_id, self::$settings['meta_key2'], self::$settings['meta_value2'] );
					}
					if ( ! empty( self::$settings['meta_key3'] ) ) {
						update_post_meta( $post_id, self::$settings['meta_key3'], self::$settings['meta_value3'] );
					}
					if ( ! empty( self::$settings['meta_key4'] ) ) {
						update_post_meta( $post_id, self::$settings['meta_key4'], self::$settings['meta_value4'] );
					}
					if ( ! empty( self::$settings['meta_key5'] ) ) {
						update_post_meta( $post_id, self::$settings['meta_key5'], self::$settings['meta_value5'] );
					}

					if ( ! empty( $taxonomy_slugs1 ) ) {
						wp_set_object_terms( $post_id, $taxonomy_slugs1, self::$settings['taxonomy'], true );
					}
					if ( ! empty( $taxonomy_slugs2 ) ) {
						wp_set_object_terms( $post_id, $taxonomy_slugs2, self::$settings['taxonomy2'], true );
					}

					if ( $taxonomy_ids1 ) {
						wp_set_object_terms( $post_id, $taxonomy_ids1, self::$settings['taxonomy'], true );
					}
					if ( $taxonomy_ids2 ) {
						wp_set_object_terms( $post_id, $taxonomy_ids2, self::$settings['taxonomy2'], true );
					}

					$photo_src = '';
					if ( ! empty( $photos ) ) {
						$photo = self::select_random_image( $photos );
						if ( ! empty( $photo ) ) {
							// Set the image as post featured image.
							update_post_meta( (int) $post_id, '_thumbnail_id', $photo );
							$src       = wp_get_attachment_image_src( $photo, 'thumbnail' );
							$photo_src = ( ! empty( $src[0] ) ) ? $src[0] : '';
						}
					}

					$image_embed = ( ! empty( $photo_src ) ) ? '<img src="' . esc_url( $photo_src ) . '" width="80" style="float: left; margin-right: 10px;">' : '';
					$return_result .= '
					<li>
						<hr>' . $image_embed . '<h2>' . $name . '</h2>
						<a href="' . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . '">' . __( 'Edit post', 'spp' ) . '</a>
						| ' . __( 'Status', 'spp' ) . ' <em class="tag-preview">' . $status . '</em>,
						' . __( 'Date', 'spp' ) . ' <em class="tag-preview">' . $date . '</em> ';
					if ( count( $tags ) !== 0 ) {
						$return_result .= ', ' . __( 'Tags', 'spp' ) . ' <em class="tag-preview">' . implode( ', ', $tags ) . '</em> ';
					}

					$post_categories = get_the_terms( $post_id, 'category' );
					if ( ! empty( $post_categories ) && ! is_wp_error( $post_categories ) ) {
						$categories     = wp_list_pluck( $post_categories, 'name' );
						$return_result .= ', ' . __( 'Categories', 'spp' ) . ' : <em class="tag-preview">' . implode( ', ', $categories ) . '</em> ';
					}

					$return_result .= $description . '
						<div class="clear"></div>
					</li>
					';
				}
			}
		}
		$return_result .= '</ol>';
		echo $return_result; // WPCS: XSS OK.

		++ $last;
		?>
		<script>
			jQuery(document).ready(function(){
				jQuery('#spp_start_counter').val(<?php echo (int) $last; ?>);
			});
		</script>
		<?php
	}

	/**
	 * Make media image from URL and returns the new ID.
	 *
	 * @param string $file_url An image URL.
	 * @return integer
	 */
	public static function make_image_from_url( $file_url = '' ) {
		$attach_id = 0;
		if ( ! empty( $file_url ) ) {
			if ( ! empty( intval( $file_url ) ) ) {
				update_post_meta( $file_url, 'spp_sample', 1 );
				return (int) $file_url;
			}

			$url_hash = str_replace( 'https:', '', $file_url );
			$url_hash = str_replace( 'http:', '', $url_hash );
			$url_hash = md5( $url_hash );
			// Identify the attachment already created, so we do not generate the same one.
			$args  = array(
				'post_type'   => 'attachment',
				'post_status' => 'any',
				'meta_query'  => array(
					'relation' => 'AND',
					array(
						'key'     => 'spp_sample',
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'     => 'spp_sample_url',
						'value'   => $url_hash,
						'compare' => '=',
					),
				),
				'fields' => 'ids',
			);
			$posts = new WP_Query( $args );
			if ( ! empty( $posts->posts ) ) {
				// This means that this image was already uploaded.
				return (int) reset( $posts->posts );
			}

			// Attempt to create a new image.
			$new_file_content = '';

			// Let's fetch the remote image.
			$response = wp_remote_get( $file_url );
			$code     = wp_remote_retrieve_response_code( $response );
			if ( 200 === $code ) {
				// Seems that we got a successful response from the remore URL.
				$content_type = wp_remote_retrieve_header( $response, 'content-type' );
				if ( ! empty( $content_type ) && substr_count( $content_type, 'image/' ) ) {
					// Seems that the content type is an image, let's get the body as the file content.
					$new_file_content = wp_remote_retrieve_body( $response );
				}
			} else {
				if ( empty( $new_file_content ) && substr_count( $file_url, get_site_url() ) ) {
					$new_file_content = @file_get_contents( $file_url );
				}

				if ( empty( $new_file_content ) ) {
					// Maybe try the non-https version.
					$file_url = str_replace( 'https', 'http', $file_url );
					$response = wp_remote_get( $file_url );
					$code     = wp_remote_retrieve_response_code( $response );
					if ( 200 === $code ) {
						// Seems that we got a successful response from the remore URL.
						$content_type = wp_remote_retrieve_header( $response, 'content-type' );
						if ( ! empty( $content_type ) && substr_count( $content_type, 'image/' ) ) {
							// Seems that the content type is an image, let's get the body as the file content.
							$new_file_content = wp_remote_retrieve_body( $response );
						}
					}
				}
			}
			if ( empty( $new_file_content ) ) {
				$new_file_content = @file_get_contents( $file_url );
			}

			if ( ! empty( $new_file_content ) ) {
				$parts        = wp_parse_url( $file_url );
				$new_filename = basename( $parts['path'] );
				$upload       = wp_upload_bits( $new_filename, null, $new_file_content );
				if ( empty( $upload['error'] ) ) {
					// Prepare an array of post data for the attachment.
					$attachment = array(
						'guid'           => $upload['url'],
						'post_mime_type' => $upload['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', $new_filename ),
						'post_status'    => 'inherit',
						'comment_status' => 'closed',
						'ping_status'    => 'closed',
						'post_type'      => 'attachment',
					);

					// Insert the attachment.
					$attach_id = wp_insert_attachment( $attachment, $upload['file'] );
					if ( ! empty( $attach_id ) ) {
						$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
						wp_update_attachment_metadata( $attach_id, $attach_data );
						update_post_meta( $attach_id, 'spp_sample', 1 );
						update_post_meta( $attach_id, 'spp_sample_url', $url_hash );
					}
				}
			}
		}
		return $attach_id;
	}

	/**
	 * Cleanup populated posts.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function cleanup_plugin_posts() {
		// Identify the plugin populated posts and attempt to remove these.
		$args  = array(
			'post_type'      => 'any',
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => 'spp_sample',
					'value'   => 1,
					'compare' => '=',
				),
			),
			'fields'         => 'ids',
			'posts_per_page' => -1,
		);
		$posts = new WP_Query( $args );
		if ( ! empty( $posts->posts ) ) {
			foreach ( $posts->posts as $id ) {
				wp_delete_post( $id );
			}
		}
	}

	/**
	 * Append the plugin URL.
	 *
	 * @param array $links The plugin links.
	 * @return array
	 */
	public static function plugin_action_links( $links ) {
		$all   = array();
		$all[] = '<a href="' . esc_url( self::$plugin_url ) . '">Settings</a>';
		$all[] = '<a href="https://iuliacazan.ro/easy-populate-posts">Plugin URL</a>';
		$all   = array_merge( $all, $links );
		return $all;
	}

	/**
	 * The actions to be executed when the plugin is activated.
	 *
	 * @return void
	 */
	public static function activate_plugin() {
		update_option( 'spp_settings', self::$settings );
		set_transient( self::PLUGIN_TRANSIENT, true );
	}

	/**
	 * The actions to be executed when the plugin is deactivated.
	 *
	 * @return void
	 */
	public static function deactivate_plugin() {
		self::plugin_admin_notices_cleanup( false );
		if ( ! empty( self::$settings['cleanup_on_deactivate'] ) ) {
			self::cleanup_plugin_posts();
		}
		delete_option( 'spp_settings' );
		// Attempt to remove the legacy temporary images, the new version is handling the images differently.
		if ( file_exists( self::$settings['legacy_images_path'] )
			&& is_dir( self::$settings['legacy_images_path'] ) ) {
			$dir = opendir( self::$settings['legacy_images_path'] );
			@rmdir( self::$settings['legacy_images_path'], true );
			while ( ( false !== ( $file = readdir( $dir ) ) ) ) {
				if ( '.' !== $file && '..' !== $file ) {
					@unlink( self::$settings['legacy_images_path'] . $file );
				}
			}
			closedir( $dir );
			@rmdir( self::$settings['legacy_images_path'] );
		}
	}

	/**
	 * The actions to be executed when the plugin is updated.
	 *
	 * @return void
	 */
	public static function plugin_ver_check() {
		$opt = str_replace( '-', '_', self::PLUGIN_TRANSIENT ) . '_db_ver';
		$dbv = get_option( $opt, 0 );
		if ( SPP_PLUGIN_VERSION !== (float) $dbv ) {
			update_option( $opt, SPP_PLUGIN_VERSION );
			self::activate_plugin();
		}
	}

	/**
	 * Execute notices cleanup.
	 *
	 * @param  boolean $ajax Is AJAX call.
	 * @return void
	 */
	public static function plugin_admin_notices_cleanup( $ajax = true ) {
		// Delete transient, only display this notice once.
		delete_transient( self::PLUGIN_TRANSIENT );

		if ( true === $ajax ) {
			// No need to continue.
			wp_die();
		}
	}

	/**
	 * Admin notices.
	 *
	 * @return void
	 */
	public static function plugin_admin_notices() {
		$maybe_trans = get_transient( self::PLUGIN_TRANSIENT );
		if ( ! empty( $maybe_trans ) ) {
			?>
			<style>.notice.<?php echo esc_attr( self::PLUGIN_TRANSIENT ); ?>{background:rgba(250,203,53,0.2);border-left-color:rgb(250,203,53)}.notice.<?php echo esc_attr( self::PLUGIN_TRANSIENT ); ?> img{max-width: 100%}</style>
			<script>(function($) { $(document).ready(function() { var $notice = $('.notice.<?php echo esc_attr( self::PLUGIN_TRANSIENT ); ?>'); var $button = $notice.find('.notice-dismiss'); $notice.unbind('click'); $button.unbind('click'); $notice.on('click', '.notice-dismiss', function(e) { $.get( $notice.data('dismissurl') ); }); }); })(jQuery);</script>

			<div class="updated notice is-dismissible <?php echo esc_attr( self::PLUGIN_TRANSIENT ); ?>"
				data-dismissurl="<?php echo esc_url( admin_url( 'admin-ajax.php?action=spp-plugin-deactivate-notice' ) ); ?>">
				<p>
					<?php
					echo wp_kses_post(
						sprintf(
							// Translators: %1$s - image URL, %2$s - icon URL, %3$s - donate URL, %4$s - link style, %5$s - icon style, %6$s - rating.
							__( '<a href="%3$s" target="_blank"%4$s><img src="%1$s"></a><img src="%2$s"%5$s> <h3>Thank you for activating the plugin Easy Populate Posts!</h3>If you find the plugin useful and would like to support my work, please consider making a <a href="%3$s" target="_blank">donation</a>. It would make me very happy if you would leave a %6$s rating.', 'spp' ) . ' ' . __( 'A huge thanks in advance!', 'spp' ),
							esc_url( plugin_dir_url( __FILE__ ) . '/assets/images/buy-me-a-coffee.png' ),
							esc_url( plugin_dir_url( __FILE__ ) . '/assets/images/icon-128x128.gif' ),
							'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JJA37EHZXWUTJ&item_name=Support for development and maintenance (' . self::PLUGIN_NAME . ')',
							' style="float:right; margin:20px"',
							' style="float:left; margin-right:20px; margin-top:10px; width:86px"',
							'<a href="' . self::PLUGIN_SUPPORT_URL . 'reviews/?rate=5#new-post" class="rating" target="_blank" title="' . esc_attr( 'A huge thanks in advance!', 'spp' ) . '">★★★★★</a>'
						)
					);
					?>
					<div class="clear"></div>
				</p>
			</div>
			<?php
		}
	}
}

$sisanu_popupate_posts = SISANU_Popupate_Posts::get_instance();

register_activation_hook( __FILE__, array( $sisanu_popupate_posts, 'activate_plugin' ) );
register_deactivation_hook( __FILE__, array( $sisanu_popupate_posts, 'deactivate_plugin' ) );

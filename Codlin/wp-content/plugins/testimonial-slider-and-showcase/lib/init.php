<?php
if ( ! class_exists( 'TSSPro' ) ) {
	class TSSPro {
		public $post_type;
		public $shortCodePT;
		public $preSettings;
		public $taxonomies = array();

		protected static $_instance;

		function __construct() {
			$this->options        = array(
				'settings'          => 'tss_settings',
				'version'           => TSS_VERSION,
				'installed_version' => 'tss_installed_version',
				'flash'             => 'tss_flash'
			);
			$this->shortCodePT    = "tss-sc";
			$settings             = get_option( $this->options['settings'] );
			$this->post_type      = 'testimonial';
			$this->post_type_slug = ! empty( $settings['slug'] ) ? sanitize_title_with_dashes( $settings['slug'] ) : 'testimonial';
			$this->incPath        = dirname( __FILE__ );
			$this->functionsPath  = $this->incPath . '/functions/';
			$this->classesPath    = $this->incPath . '/classes/';
			$this->widgetsPath    = $this->incPath . '/widgets/';
			$this->viewsPath      = $this->incPath . '/views/';
			$this->templatePath   = $this->incPath . '/template/';
			$this->modelsPath     = $this->incPath . '/models/';

			$this->assetsUrl = TSS_PLUGIN_URL . '/assets/';
			$this->loadModel( $this->modelsPath );
			$this->loadClass( $this->classesPath );
			$this->preSettings = array(
				'slug'  => 'testimonial'
			);
		}

		/**
		 * Load Model class
		 *
		 * @param $dir
		 */
		function loadModel( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
				}
			}
		}

		function loadClass( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}

			$classes = array();

			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$className = str_replace( ".php", "", $item );
					$classes[] = new $className;
				}
			}

			if ( $classes ) {
				foreach ( $classes as $class ) {
					$this->objects[] = $class;
				}
			}
		}

		function loadWidget( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$class = str_replace( ".php", "", $item );

					if ( method_exists( $class, 'register_widget' ) ) {
						$caller = new $class;
						$caller->register_widget();
					} else {
						register_widget( $class );
					}
				}
			}
		}

		function render( $viewName, $args = array() ) {
			$path     = str_replace( ".", "/", $viewName );
			$viewPath = $this->viewsPath . $path . '.php';
			if ( ! file_exists( $viewPath ) ) {
				return;
			}
			if ( ! empty( $args ) ) {
				extract( $args );
			}
			$pageReturn = include $viewPath;
			if ( $pageReturn AND $pageReturn <> 1 ) {
				return $pageReturn;
			}
		}

		/**
		 * Dynamicaly call any  method from models class
		 * by pluginFramework instance
		 */
		function __call( $name, $args ) {
			if ( ! is_array( $this->objects ) ) {
				return;
			}
			foreach ( $this->objects as $object ) {
				if ( method_exists( $object, $name ) ) {
					$count = count( $args );
					if ( $count == 0 ) {
						return $object->$name();
					} elseif ( $count == 1 ) {
						return $object->$name( $args[0] );
					} elseif ( $count == 2 ) {
						return $object->$name( $args[0], $args[1] );
					} elseif ( $count == 3 ) {
						return $object->$name( $args[0], $args[1], $args[2] );
					} elseif ( $count == 4 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3] );
					} elseif ( $count == 5 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4] );
					} elseif ( $count == 6 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4], $args[5] );
					}
				}
			}
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}

	function TSSPro() {
		return TSSPro::instance();
	}

	TSSPro();
}
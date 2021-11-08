<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Setup Class
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'SPFTESTIMONIAL' ) ) {
	class SPFTESTIMONIAL {

		// constants.
		public static $version = '2.1.1';
		public static $premium = true;
		public static $dir     = null;
		public static $url     = null;
		public static $inited  = array();
		public static $fields  = array();
		public static $args    = array(
			'options'           => array(),
			'customize_options' => array(),
			'metaboxes'         => array(),
			'profile_options'   => array(),
			'shortcoders'       => array(),
			'taxonomy_options'  => array(),
			'widgets'           => array(),
		);

		// shortcode instances.
		public static $shortcode_instances = array();

		// init.
		public static function init() {

			// init action.
			do_action( 'spftestimonial_init' );

			// set constants.
			self::constants();

			// include files.
			self::includes();

			add_action( 'after_setup_theme', array( 'SPFTESTIMONIAL', 'setup' ) );
			add_action( 'init', array( 'SPFTESTIMONIAL', 'setup' ) );
			add_action( 'switch_theme', array( 'SPFTESTIMONIAL', 'setup' ) );
			add_action( 'admin_enqueue_scripts', array( 'SPFTESTIMONIAL', 'add_admin_enqueue_scripts' ), 20 );

		}

		/** Setup */
		public static function setup() {

			// setup options.
			$params = array();
			if ( ! empty( self::$args['options'] ) ) {
				foreach ( self::$args['options'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPFTESTIMONIAL_Options::instance( $key, $params );

						if ( ! empty( $value['show_in_customizer'] ) ) {
							self::$args['customize_options'][ $key ] = $value;
							self::$inited[ $key ]                    = null;
						}
					}
				}
			}

			// setup customize options.
			$params = array();
			if ( ! empty( self::$args['customize_options'] ) ) {
				foreach ( self::$args['customize_options'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPFTESTIMONIAL_Customize_Options::instance( $key, $params );

					}
				}
			}

			// setup metaboxes.
			$params = array();
			if ( ! empty( self::$args['metaboxes'] ) ) {
				foreach ( self::$args['metaboxes'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPFTESTIMONIAL_Metabox::instance( $key, $params );

					}
				}
			}

			// setup profile options.
			$params = array();
			if ( ! empty( self::$args['profile_options'] ) ) {
				foreach ( self::$args['profile_options'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPFTESTIMONIAL_Profile_Options::instance( $key, $params );

					}
				}
			}

			// setup shortcoders.
			$params = array();
			if ( ! empty( self::$args['shortcoders'] ) ) {

				foreach ( self::$args['shortcoders'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPFTESTIMONIAL_Shortcoder::instance( $key, $params );

					}
				}

				// Once editor setup for gutenberg and media buttons.
				if ( ! empty( SPFTESTIMONIAL::$shortcode_instances ) ) {
					SPFTESTIMONIAL_Shortcoder::once_editor_setup();
				}
			}

			// setup taxonomy options.
			$params = array();
			if ( ! empty( self::$args['taxonomy_options'] ) ) {
				foreach ( self::$args['taxonomy_options'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPFTESTIMONIAL_Taxonomy_Options::instance( $key, $params );

					}
				}
			}

			// create widgets.
			if ( ! empty( self::$args['widgets'] ) && class_exists( 'WP_Widget_Factory' ) ) {

				$wp_widget_factory = new WP_Widget_Factory();

				foreach ( self::$args['widgets'] as $key => $value ) {
					if ( ! isset( self::$inited[ $key ] ) ) {
						self::$inited[ $key ] = true;
						$wp_widget_factory->register( SPFTESTIMONIAL_Widget::instance( $key, $value ) );
					}
				}
			}

			do_action( 'spftestimonial_loaded' );

		}

		// Create options.
		public static function createOptions( $id, $args = array() ) {
			self::$args['options'][ $id ] = $args;
		}

		// create customize options.
		public static function createCustomizeOptions( $id, $args = array() ) {
			self::$args['customize_options'][ $id ] = $args;
		}

		// create metabox options.
		public static function createMetabox( $id, $args = array() ) {
			self::$args['metaboxes'][ $id ] = $args;
		}

		// create shortcoder options.
		public static function createShortcoder( $id, $args = array() ) {
			self::$args['shortcoders'][ $id ] = $args;
		}

		// create taxonomy options.
		public static function createTaxonomyOptions( $id, $args = array() ) {
			self::$args['taxonomy_options'][ $id ] = $args;
		}

		// create profile options.
		public static function createProfileOptions( $id, $args = array() ) {
			self::$args['profile_options'][ $id ] = $args;
		}

		// create widget.
		public static function createWidget( $id, $args = array() ) {
			self::$args['widgets'][ $id ] = $args;
			self::set_used_fields( $args );
		}

		// create section.
		public static function createSection( $id, $sections ) {
			self::$args['sections'][ $id ][] = $sections;
			self::set_used_fields( $sections );
		}

		// constants.
		public static function constants() {

			// we need this path-finder code for set URL of framework.
			$dirname        = wp_normalize_path( dirname( dirname( __FILE__ ) ) );
			$theme_dir      = wp_normalize_path( get_parent_theme_file_path() );
			$plugin_dir     = wp_normalize_path( WP_PLUGIN_DIR );
			$located_plugin = ( preg_match( '#' . self::sanitize_dirname( $plugin_dir ) . '#', self::sanitize_dirname( $dirname ) ) ) ? true : false;
			$directory      = ( $located_plugin ) ? $plugin_dir : $theme_dir;
			$directory_uri  = ( $located_plugin ) ? WP_PLUGIN_URL : get_parent_theme_file_uri();
			$foldername     = str_replace( $directory, '', $dirname );
			$protocol_uri   = ( is_ssl() ) ? 'https' : 'http';
			$directory_uri  = set_url_scheme( $directory_uri, $protocol_uri );

			self::$dir = $dirname;
			self::$url = $directory_uri . $foldername;

		}

		public static function include_plugin_file( $file, $load = true ) {

			$path     = '';
			$file     = ltrim( $file, '/' );
			$override = apply_filters( 'spftestimonial_override', 'spftestimonial-override' );

			if ( file_exists( get_parent_theme_file_path( $override . '/' . $file ) ) ) {
				$path = get_parent_theme_file_path( $override . '/' . $file );
			} elseif ( file_exists( get_theme_file_path( $override . '/' . $file ) ) ) {
				$path = get_theme_file_path( $override . '/' . $file );
			} elseif ( file_exists( self::$dir . '/' . $override . '/' . $file ) ) {
				$path = self::$dir . '/' . $override . '/' . $file;
			} elseif ( file_exists( self::$dir . '/' . $file ) ) {
				$path = self::$dir . '/' . $file;
			}

			if ( ! empty( $path ) && ! empty( $file ) && $load ) {

				global $wp_query;

				if ( is_object( $wp_query ) && function_exists( 'load_template' ) ) {

					load_template( $path, true );

				} else {

					require_once $path;

				}
			} else {

				return self::$dir . '/' . $file;

			}

		}

		public static function is_active_plugin( $file = '' ) {
			return in_array( $file, (array) get_option( 'active_plugins', array() ) );
		}

		// Sanitize dirname.
		public static function sanitize_dirname( $dirname ) {
			return preg_replace( '/[^A-Za-z]/', '', $dirname );
		}

		// Set plugin url.
		public static function include_plugin_url( $file ) {
			return self::$url . '/' . ltrim( $file, '/' );
		}

		// General includes.
		public static function includes() {

			// includes helpers.
			self::include_plugin_file( 'functions/actions.php' );
			self::include_plugin_file( 'functions/deprecated.php' );
			self::include_plugin_file( 'functions/helpers.php' );
			self::include_plugin_file( 'functions/sanitize.php' );
			self::include_plugin_file( 'functions/validate.php' );

			// includes free version classes.
			self::include_plugin_file( 'classes/abstract.class.php' );
			self::include_plugin_file( 'classes/fields.class.php' );
			self::include_plugin_file( 'classes/options.class.php' );

			// includes premium version classes.
			if ( self::$premium ) {
				self::include_plugin_file( 'classes/customize-options.class.php' );
				self::include_plugin_file( 'classes/metabox.class.php' );
				self::include_plugin_file( 'classes/profile-options.class.php' );
				self::include_plugin_file( 'classes/shortcoder.class.php' );
				self::include_plugin_file( 'classes/taxonomy-options.class.php' );
				self::include_plugin_file( 'classes/widgets.class.php' );
			}

		}

		// Include field.
		public static function maybe_include_field( $type = '' ) {
			if ( ! class_exists( 'SPFTESTIMONIAL_Field_' . $type ) && class_exists( 'SPFTESTIMONIAL_Fields' ) ) {
				self::include_plugin_file( 'fields/' . $type . '/' . $type . '.php' );
			}
		}

		// Get all of fields.
		public static function set_used_fields( $sections ) {

			if ( ! empty( $sections['fields'] ) ) {

				foreach ( $sections['fields'] as $field ) {

					if ( ! empty( $field['fields'] ) ) {
						self::set_used_fields( $field );
					}

					if ( ! empty( $field['tabs'] ) ) {
						self::set_used_fields( array( 'fields' => $field['tabs'] ) );
					}

					if ( ! empty( $field['accordions'] ) ) {
						self::set_used_fields( array( 'fields' => $field['accordions'] ) );
					}

					if ( ! empty( $field['type'] ) ) {
						self::$fields[ $field['type'] ] = $field;
					}
				}
			}

		}

		//
		// Enqueue admin and fields styles and scripts.
		public static function add_admin_enqueue_scripts() {

			// check for developer mode.
			$min = ( apply_filters( 'spftestimonial_dev_mode', false ) || WP_DEBUG ) ? '' : '.min';

			// admin utilities.
			wp_enqueue_media();

			// wp color picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// cdn styles.
			wp_enqueue_style( 'spftestimonial-fa', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css', array(), SP_TPRO_VERSION, 'all' );

			// framework core styles.
			wp_enqueue_style( 'spftestimonial', SPFTESTIMONIAL::include_plugin_url( 'assets/css/spftestimonial' . $min . '.css' ), array(), SP_TPRO_VERSION, 'all' );

			// rtl styles.
			if ( is_rtl() ) {
				wp_enqueue_style( 'spftestimonial-rtl', SPFTESTIMONIAL::include_plugin_url( 'assets/css/spftestimonial-rtl' . $min . '.css' ), array(), SP_TPRO_VERSION, 'all' );
			}

			// framework core scripts.
			wp_enqueue_script( 'spftestimonial-plugins', SPFTESTIMONIAL::include_plugin_url( 'assets/js/spftestimonial-plugins' . $min . '.js' ), array(), SP_TPRO_VERSION, true );
			wp_enqueue_script( 'spftestimonial', SPFTESTIMONIAL::include_plugin_url( 'assets/js/spftestimonial' . $min . '.js' ), array( 'spftestimonial-plugins' ), SP_TPRO_VERSION, true );

			wp_localize_script(
				'spftestimonial', 'spftestimonial_vars', array(
					'color_palette' => apply_filters( 'spftestimonial_color_palette', array() ),
					'i18n'          => array(
						// global localize.
						'confirm'             => esc_html__( 'Are you sure?', 'testimonial-pro' ),
						'reset_notification'  => esc_html__( 'Restoring options.', 'testimonial-pro' ),
						'import_notification' => esc_html__( 'Importing options.', 'testimonial-pro' ),

						// chosen localize.
						'typing_text'         => esc_html__( 'Please enter %s or more characters', 'testimonial-pro' ),
						'searching_text'      => esc_html__( 'Searching...', 'testimonial-pro' ),
						'no_results_text'     => esc_html__( 'No results match', 'testimonial-pro' ),
					),
				)
			);

			// load admin enqueue scripts and styles.
			$enqueued = array();

			if ( ! empty( self::$fields ) ) {
				foreach ( self::$fields as $field ) {
					if ( ! empty( $field['type'] ) ) {
						$classname = 'SPFTESTIMONIAL_Field_' . $field['type'];
						self::maybe_include_field( $field['type'] );
						if ( class_exists( $classname ) && method_exists( $classname, 'enqueue' ) ) {
							$instance = new $classname( $field );
							if ( method_exists( $classname, 'enqueue' ) ) {
								$instance->enqueue();
							}
							unset( $instance );
						}
					}
				}
			}

			do_action( 'spftestimonial_enqueue' );

		}

		//
		// Add a new framework field.
		public static function field( $field = array(), $value = '', $unique = '', $where = '', $parent = '' ) {

			// Check for unallow fields.
			if ( ! empty( $field['_notice'] ) ) {

				$field_type = $field['type'];

				$field            = array();
				$field['content'] = sprintf( esc_html__( 'Ooops! This field type (%s) can not be used here, yet.', 'testimonial-pro' ), '<strong>' . $field_type . '</strong>' );
				$field['type']    = 'notice';
				$field['style']   = 'danger';

			}

			$depend     = '';
			$hidden     = '';
			$unique     = ( ! empty( $unique ) ) ? $unique : '';
			$class      = ( ! empty( $field['class'] ) ) ? ' ' . $field['class'] : '';
			$is_pseudo  = ( ! empty( $field['pseudo'] ) ) ? ' spftestimonial-pseudo-field' : '';
			$field_type = ( ! empty( $field['type'] ) ) ? $field['type'] : '';

			if ( ! empty( $field['dependency'] ) ) {

				$dependency      = $field['dependency'];
				$hidden          = ' hidden';
				$data_controller = '';
				$data_condition  = '';
				$data_value      = '';
				$data_global     = '';

				if ( is_array( $dependency[0] ) ) {
					$data_controller = implode( '|', array_column( $dependency, 0 ) );
					$data_condition  = implode( '|', array_column( $dependency, 1 ) );
					$data_value      = implode( '|', array_column( $dependency, 2 ) );
					$data_global     = implode( '|', array_column( $dependency, 3 ) );
				} else {
					$data_controller = ( ! empty( $dependency[0] ) ) ? $dependency[0] : '';
					$data_condition  = ( ! empty( $dependency[1] ) ) ? $dependency[1] : '';
					$data_value      = ( ! empty( $dependency[2] ) ) ? $dependency[2] : '';
					$data_global     = ( ! empty( $dependency[3] ) ) ? $dependency[3] : '';
				}

				$depend .= ' data-controller="' . $data_controller . '"';
				$depend .= ' data-condition="' . $data_condition . '"';
				$depend .= ' data-value="' . $data_value . '"';
				$depend .= ( ! empty( $data_global ) ) ? ' data-depend-global="true"' : '';

			}

			if ( ! empty( $field_type ) ) {

				echo '<div class="spftestimonial-field spftestimonial-field-' . $field_type . $is_pseudo . $class . $hidden . '"' . $depend . '>';

				if ( ! empty( $field['title'] ) ) {
					$subtitle = ( ! empty( $field['subtitle'] ) ) ? '<p class="spftestimonial-text-subtitle">' . $field['subtitle'] . '</p>' : '';
					echo '<div class="spftestimonial-title"><h4>' . $field['title'] . '</h4>' . $subtitle . '</div>';
				}

				echo ( ! empty( $field['title'] ) ) ? '<div class="spftestimonial-fieldset">' : '';

				$value = ( ! isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
				$value = ( isset( $field['value'] ) ) ? $field['value'] : $value;

				self::maybe_include_field( $field_type );

				$classname = 'SPFTESTIMONIAL_Field_' . $field_type;

				if ( class_exists( $classname ) ) {
					$instance = new $classname( $field, $value, $unique, $where, $parent );
					$instance->render();
				} else {
					echo '<p>' . esc_html__( 'This field class is not available!', 'testimonial-pro' ) . '</p>';
				}
			} else {
				echo '<p>' . esc_html__( 'This type is not found!', 'testimonial-pro' ) . '</p>';
			}

			echo ( ! empty( $field['title'] ) ) ? '</div>' : '';
			echo '<div class="clear"></div>';
			echo '</div>';

		}

	}

	SPFTESTIMONIAL::init();
}

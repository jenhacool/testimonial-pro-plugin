<?php
/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://shapedplugin.com
 * @since             1.0
 * @package           TestimonialPro
 *
 * Plugin Name:       Testimonial Pro
 * Plugin URI:        https://shapedplugin.com/plugin/testimonial-pro/
 * Description:       Most Customizable and Powerful Testimonials Showcase Plugin for WordPress that allows you to manage and display Testimonials or Reviews on any page or widget.
 * Version:           2.2.5
 * Author:            ShapedPlugin
 * Author URI:        https://shapedplugin.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       testimonial-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SP_TESTIMONIAL_PRO_FILE', __FILE__ );

/**
 * The code that runs during plugin updates.
 * This action is documented in includes/class-testimonial-pro-updates.php
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-testimonial-pro-updates.php';

require_once plugin_dir_path( __FILE__ ) . 'admin/views/tp-metabox/classes/setup.class.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/views/class-testimonial-pro-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/views/class-testimonial-pro-metaboxs.php';

if ( ! class_exists( 'SP_Testimonial_PRO' ) ) {
	/**
	 * Handles core plugin hooks and action setup.
	 *
	 * @package testimonial-pro
	 * @since 2.0
	 */
	class SP_Testimonial_PRO {
		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '2.2.5';

		/**
		 * @var SP_TPRO_Testimonial $testimonial
		 */
		public $testimonial;

		/**
		 * @var SP_TPRO_Shortcode $shortcode
		 */
		public $shortcode;

		/**
		 * @var SP_TPRO_Form $shortcode
		 */
		public $form;

		/**
		 * @var SP_TPRO_Taxonomy $taxonomy
		 */
		public $taxonomy;

		/**
		 * @var SP_TPRO_Help $help
		 */
		public $help;

		/**
		 * @var SP_TPRO_Router $router
		 */
		public $router;

		/**
		 * @var null
		 * @since 2.0
		 */
		protected static $_instance = null;

		/**
		 * @return SP_Testimonial_PRO
		 * @since 2.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * SP_Testimonial_PRO constructor.
		 */
		function __construct() {
			// Define constants.
			$this->define_constants();

			// Required class file include.
			spl_autoload_register( array( $this, 'autoload' ) );

			// Include required files.
			$this->includes();

			// instantiate classes.
			$this->instantiate();

			// Initialize the filter hooks.
			$this->init_filters();

			// Initialize the action hooks.
			$this->init_actions();
		}

		/**
		 * Initialize WordPress filter hooks
		 *
		 * @return void
		 */
		function init_filters() {
			add_filter( 'plugin_action_links', array( $this, 'add_plugin_action_links' ), 10, 2 );
			add_filter( 'manage_spt_testimonial_form_posts_columns', array( $this, 'add_testimonial_form_column' ) );
			add_filter( 'manage_spt_shortcodes_posts_columns', array( $this, 'add_shortcode_column' ) );
			add_filter( 'manage_spt_testimonial_posts_columns', array( $this, 'add_testimonial_column' ) );
			add_filter( 'plugin_row_meta', array( $this, 'after_testimonial_pro_row_meta' ), 10, 4 );
		}

		/**
		 * Initialize WordPress action hooks
		 *
		 * @return void
		 */
		function init_actions() {
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
			add_action( 'manage_spt_testimonial_form_posts_custom_column', array( $this, 'add_testimonial_form_code' ), 10, 2 );
			add_action( 'manage_spt_shortcodes_posts_custom_column', array( $this, 'add_shortcode_form' ), 10, 2 );
			add_action( 'manage_spt_testimonial_posts_custom_column', array( $this, 'add_testimonial_extra_column' ), 10, 2 );

			// License Page.
			$manage_license = new Testimonial_Pro_License( SP_TESTIMONIAL_PRO_FILE, SP_TPRO_VERSION, 'ShapedPlugin', SP_TPRO_STORE_URL, SP_TPRO_ITEM_ID, SP_TPRO_ITEM_SLUG );

			// Admin Menu.
			add_action( 'admin_init', array( $manage_license, 'testimonial_pro_activate_license' ) );
			add_action( 'admin_init', array( $manage_license, 'testimonial_pro_deactivate_license' ) );

			add_action( 'testimonial_pro_weekly_scheduled_events', array( $manage_license, 'check_license_status' ) );
			// this code for testing.
			// add_action( 'admin_init', array( $manage_license, 'check_license_status' ) );

			// Init Updater.
			add_action( 'admin_init', array( $manage_license, 'init_updater' ), 0 );

			// Display notices to admins.
			add_action( 'admin_notices', array( $manage_license, 'license_active_notices' ) );
			add_action( 'in_plugin_update_message-' . SP_TPRO_BASENAME, array( $manage_license, 'plugin_row_license_missing' ), 10, 2 );

			// Redirect after active.
			add_action( 'activated_plugin', array( $this, 'redirect_to' ) );
		}

		/**
		 * Define constants
		 *
		 * @since 1.1
		 */
		public function define_constants() {
			$this->define( 'SP_TPRO_ITEM_NAME', 'Testimonial Pro' );
			$this->define( 'SP_TPRO_ITEM_SLUG', 'testimonial-pro' );
			$this->define( 'SP_TPRO_ITEM_ID', 2422 );
			$this->define( 'SP_TPRO_STORE_URL', 'https://shapedplugin.com' );
			$this->define( 'SP_TPRO_PRODUCT_URL', 'https://shapedplugin.com/plugin/testimonial-pro/' );
			$this->define( 'SP_TPRO_VERSION', $this->version );
			$this->define( 'SP_TPRO_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'SP_TPRO_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'SP_TPRO_BASENAME', plugin_basename( __FILE__ ) );
		}

		/**
		 * Define constant if not already set
		 *
		 * @param string      $name
		 * @param string|bool $value
		 */
		public function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Load TextDomain for plugin.
		 */
		public function load_text_domain() {
			load_textdomain( 'testimonial-pro', WP_LANG_DIR . '/testimonial-pro/languages/testimonial-pro-' . apply_filters( 'plugin_locale', get_locale(), 'testimonial-pro' ) . '.mo' );
			load_plugin_textdomain( 'testimonial-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Add plugin action menu
		 *
		 * @param array  $links
		 * @param string $file
		 *
		 * @return array
		 */
		public function add_plugin_action_links( $links, $file ) {

			$manage_license     = new Testimonial_Pro_License( SP_TESTIMONIAL_PRO_FILE, SP_TPRO_VERSION, 'ShapedPlugin', SP_TPRO_STORE_URL, SP_TPRO_ITEM_ID, SP_TPRO_ITEM_SLUG );
			$license_key_status = $manage_license->get_license_status();
			$license_status     = ( is_object( $license_key_status ) ? $license_key_status->license : '' );

			if ( SP_TPRO_BASENAME == $file ) {
				if ( 'valid' == $license_status ) {
					$new_links = array(
						sprintf( '<a href="%s">%s</a>', admin_url( 'post-new.php?post_type=spt_testimonial' ), __( 'Add Testimonial', 'testimonial-pro' ) ),
						sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=spt_shortcodes' ), __( 'Manage Views', 'testimonial-pro' ) ),
					);
				} else {
					$new_links = array(
						sprintf( '<a style="color: red; font-weight: 600;" href="%s">%s</a>', admin_url( 'edit.php?post_type=spt_testimonial&page=tpro_settings#tab=1' ), __( 'Activate license', 'testimonial-pro' ) ),
					);
				}
				return array_merge( $new_links, $links );
			}

			return $links;
		}

		/**
		 * Add plugin row meta link
		 *
		 * @since 2.0
		 *
		 * @param $plugin_meta
		 * @param $file
		 *
		 * @return array
		 */
		public function after_testimonial_pro_row_meta( $plugin_meta, $file ) {
			if ( SP_TPRO_BASENAME === $file ) {
				$plugin_meta[] = '<a href="https://shapedplugin.com/support/" target="_blank">' . __( 'Support', 'testimonial-pro' ) . '</a>';
				$plugin_meta[] = '<a href="https://demo.shapedplugin.com/testimonial/" target="_blank">' . __( 'Live Demo', 'testimonial-pro' ) . '</a>';
			}

			return $plugin_meta;
		}

		/**
		 * Autoload class files on demand
		 *
		 * @param string $class requested class name
		 */
		function autoload( $class ) {
			$name = explode( '_', $class );
			if ( isset( $name[2] ) ) {
				$class_name = strtolower( $name[2] );
				$filename   = SP_TPRO_PATH . '/class/' . $class_name . '.php';

				if ( file_exists( $filename ) ) {
					require_once $filename;
				}
			}
		}

		/**
		 * Instantiate all the required classes
		 *
		 * @since 2.0
		 */
		function instantiate() {

			$this->testimonial = SP_TPRO_Testimonial::getInstance();
			$this->shortcode   = SP_TPRO_Shortcode::getInstance();
			$this->form        = SP_TPRO_Form::getInstance();
			$this->taxonomy    = SP_TPRO_Taxonomy::getInstance();
			$this->help        = SP_TPRO_Help::getInstance();

			do_action( 'sp_tpro_instantiate', $this );
		}

		/**
		 * Page router instantiate.
		 *
		 * @since 2.0
		 */
		function page() {
			$this->router = SP_TPRO_Router::instance();

			return $this->router;
		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		function includes() {
			$this->page()->sp_tpro_function();
			$this->router->includes();
		}

		/**
		 * ShortCode Column
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		function add_shortcode_column() {
			$new_columns['cb']        = '<input type="checkbox" />';
			$new_columns['title']     = __( 'Title', 'testimonial-pro' );
			$new_columns['shortcode'] = __( 'Shortcode', 'testimonial-pro' );
			$new_columns['']          = '';
			$new_columns['date']      = __( 'Date', 'testimonial-pro' );

			return $new_columns;
		}

		/**
		 * Testimonial Form Column
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		function add_testimonial_form_column() {
			$new_columns['cb']        = '<input type="checkbox" />';
			$new_columns['title']     = __( 'Title', 'testimonial-pro' );
			$new_columns['status']    = __( 'Status', 'testimonial-pro' );
			$new_columns['shortcode'] = __( 'Shortcode', 'testimonial-pro' );
			$new_columns['']          = '';
			$new_columns['date']      = __( 'Date', 'testimonial-pro' );

			return $new_columns;
		}

		/**
		 * Shortcode code.
		 *
		 * @param $column
		 * @param $post_id
		 */
		function add_shortcode_form( $column, $post_id ) {

			switch ( $column ) {

				case 'shortcode':
					$column_field = '<input  class="stpro_input" style="width: 230px;padding: 4px 8px;" type="text"  readonly="readonly" value="[sp_testimonial ' . 'id=&quot;' . $post_id . '&quot;' . ']"/><div class="sptpro-after-copy-text"><i class="fa fa-check-circle"></i> Shortcode Copied to Clipboard! </div>';
					echo $column_field;
					break;

			} // end switch

		}

		/**
		 * Testimonial form code.
		 *
		 * @param $column
		 * @param $post_id
		 */
		function add_testimonial_form_code( $column, $post_id ) {
			$form_data = get_post_meta( $post_id, 'sp_tpro_form_options', true );
			switch ( $column ) {

				case 'status':
					switch ( $form_data['testimonial_approval_status'] ) {
						case 'publish':
							$color = '#018a01';
							break;
						case 'pending':
							$color = '#ce0505';
							break;
						case 'private':
							$color = '#059ece';
							break;
						case 'draft':
							$color = '#ababab';
							break;
					}
					$column_field = '<span style="color: ' . $color . ';">' . ucfirst( $form_data['testimonial_approval_status'] ) . '</span>';
					echo $column_field;
					break;
				case 'shortcode':
					$column_field = '<input class="stpro_input" style="width: 230px;padding: 4px 8px;cursor: pointer;" type="text" onClick="this.select();" readonly="readonly" value="[sp_testimonial_form ' . 'id=&quot;' . $post_id . '&quot;' . ']"/> <div class="sptpro-after-copy-text"><i class="fa fa-check-circle"></i> Shortcode Copied to Clipboard! </div>';
					echo $column_field;
					break;

			} // end switch

		}

		/**
		 * Testimonial Column
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		function add_testimonial_column() {
			$new_columns['cb']                       = '<input type="checkbox" />';
			$new_columns['title']                    = __( 'Title', 'testimonial-pro' );
			$new_columns['image']                    = __( 'Image', 'testimonial-pro' );
			$new_columns['name']                     = __( 'Name', 'testimonial-pro' );
			$new_columns['taxonomy-testimonial_cat'] = __( 'Groups', 'testimonial-pro' );
			$new_columns['rating']                   = __( 'Rating', 'testimonial-pro' );
			$new_columns['']                         = '';
			$new_columns['date']                     = __( 'Date', 'testimonial-pro' );

			return $new_columns;
		}

		/**
		 * Testimonial extra column.
		 *
		 * @param $column
		 * @param $post_id
		 */
		function add_testimonial_extra_column( $column, $post_id ) {

			switch ( $column ) {

				case 'rating':
					$testimonial_data = get_post_meta( $post_id, 'sp_tpro_meta_options', true );
					if ( isset( $testimonial_data['tpro_rating'] ) ) {
						$rating_star = $testimonial_data['tpro_rating'];
						$fill_star   = '<i style="color: #f3bb00;" class="fa fa-star"></i>';
						$empty_star  = '<i class="fa fa-star"></i>';
						switch ( $rating_star ) {
							case 'one_star':
								$column_field = '<span style="font-size: 16px; color: #d4d4d4;">' . $fill_star . $empty_star . $empty_star . $empty_star . $empty_star . '</span>';
								break;
							case 'two_star':
								$column_field = '<span style="font-size: 16px; color: #d4d4d4;">' . $fill_star . $fill_star . $empty_star . $empty_star . $empty_star . '</span>';
								break;
							case 'three_star':
								$column_field = '<span style="font-size: 16px; color: #d4d4d4;">' . $fill_star . $fill_star . $fill_star . $empty_star . $empty_star . '</span>';
								break;
							case 'four_star':
								$column_field = '<span style="font-size: 16px; color: #d4d4d4;">' . $fill_star . $fill_star . $fill_star . $fill_star . $empty_star . '</span>';
								break;
							case 'five_star':
								$column_field = '<span style="font-size: 16px; color: #d4d4d4;">' . $fill_star . $fill_star . $fill_star . $fill_star . $fill_star . '</span>';
								break;
							default:
								$column_field = '<span aria-hidden="true">—</span>';
								break;
						}

						echo $column_field;
					}

					break;
				case 'image':
					add_image_size( 'sp_tpro_client_small_img', 50, 50, true );

					$thumb_id                 = get_post_thumbnail_id( $post_id );
					$testimonial_client_image = wp_get_attachment_image_src( $thumb_id, 'sp_tpro_client_small_img' );
					if ( $testimonial_client_image !== '' && is_array( $testimonial_client_image ) ) {
						echo '<img  src="' . $testimonial_client_image[0] . '" width="' . $testimonial_client_image[1] . '"  height="' . $testimonial_client_image[2] . '"/>';
					} else {
						echo '<span aria-hidden="true">—</span>';
					}
					break;
				default:
					break;
				case 'name':
					$testimonial_data = get_post_meta( $post_id, 'sp_tpro_meta_options', true );
					if ( isset( $testimonial_data['tpro_name'] ) ) {
						$testimonial_client_name = $testimonial_data['tpro_name'];
						if ( $testimonial_client_name !== '' ) {
							echo $testimonial_client_name;
						} else {
							echo '<span aria-hidden="true">—</span>';
						}
					}
					break;

			} // end switch

		}

		/**
		 * Redirect after active.
		 *
		 * @return void
		 */
		public function redirect_to( $plugin ) {
			if ( SP_TPRO_BASENAME === $plugin ) {
				exit( wp_redirect( admin_url( 'edit.php?post_type=spt_testimonial&page=tpro_settings#tab=1' ) ) );
			}
		}

	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1
 */
function sp_testimonial_pro() {
	return SP_Testimonial_PRO::instance();
}
if ( class_exists( 'SP_Testimonial_PRO' ) ) {
	sp_testimonial_pro();
}

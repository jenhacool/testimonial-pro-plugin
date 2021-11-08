<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; }  // if direct access

/**
 * Scripts and styles
 */
class SP_TPRO_Front_Scripts {

	/**
	 * @var null
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * @return SP_TPRO_Front_Scripts
	 * @since 1.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Initialize the class
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
	}

	/**
	 * Plugin Scripts and Styles
	 */
	function front_scripts() {
		$setting_options = get_option( 'sp_testimonial_pro_options' );
		// CSS Files.
		if ( $setting_options['tpro_dequeue_slick_css'] ) {
			wp_enqueue_style( 'tpro-slick', SP_TPRO_URL . 'public/assets/css/slick.min.css', array(), SP_TPRO_VERSION );
		}
		if ( $setting_options['tpro_dequeue_fa_css'] ) {
			wp_enqueue_style( 'tpro-font-awesome', SP_TPRO_URL . 'public/assets/css/font-awesome.min.css', array(), SP_TPRO_VERSION );
		}
		if ( $setting_options['tpro_dequeue_magnific_popup_css'] ) {
			wp_enqueue_style( 'tpro-magnific-popup', SP_TPRO_URL . 'public/assets/css/magnific-popup.min.css', array(), SP_TPRO_VERSION );
		}
		wp_register_style( 'tpro-chosen', SP_TPRO_URL . 'public/assets/css/chosen.min.css', array(), SP_TPRO_VERSION );
		wp_register_style( 'tpro-remodal', SP_TPRO_URL . 'public/assets/css/remodal.min.css', array(), SP_TPRO_VERSION );
		wp_register_style( 'tpro-remodal-default-theme', SP_TPRO_URL . 'public/assets/css/remodal-default-theme.min.css', array(), SP_TPRO_VERSION );
		wp_enqueue_style( 'tpro-style', SP_TPRO_URL . 'public/assets/css/style.min.css', array(), SP_TPRO_VERSION );
		wp_enqueue_style( 'tpro-custom', SP_TPRO_URL . 'public/assets/css/custom.css', array(), SP_TPRO_VERSION );
		wp_enqueue_style( 'tpro-responsive', SP_TPRO_URL . 'public/assets/css/responsive.min.css', array(), SP_TPRO_VERSION );

		include SP_TPRO_PATH . '/includes/custom-css.php';
		wp_add_inline_style( 'tpro-custom', $custom_css );

		// JS Files.
		wp_register_script( 'tpro-slick-min-js', SP_TPRO_URL . 'public/assets/js/slick.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-isotope-js', SP_TPRO_URL . 'public/assets/js/jquery.isotope.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_enqueue_script( 'tpro-validate-js', SP_TPRO_URL . 'public/assets/js/jquery.validate.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		if ( $setting_options['tpro_dequeue_magnific_popup_js'] ) {
			wp_enqueue_script( 'tpro-magnific-popup-js', SP_TPRO_URL . 'public/assets/js/jquery.magnific-popup.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		}
		wp_register_script( 'tpro-remodal-js', SP_TPRO_URL . 'public/assets/js/remodal.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_enqueue_script( 'tpro-infite-scroll', SP_TPRO_URL . 'public/assets/js/infinite-scroll.pkgd.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-curtail-min-js', SP_TPRO_URL . 'public/assets/js/jquery.curtail.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-chosen-jquery', SP_TPRO_URL . 'public/assets/js/chosen.jquery.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-chosen-config', SP_TPRO_URL . 'public/assets/js/chosen-config.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-recaptcha-js', '//www.google.com/recaptcha/api.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_enqueue_script( 'jquery-masonry', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_enqueue_script( 'tpro-scripts', SP_TPRO_URL . 'public/assets/js/scripts.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-slick-active', SP_TPRO_URL . 'public/assets/js/sp-slick-active.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-slick-ticker-active', SP_TPRO_URL . 'public/assets/js/sp-slick-ticker-active.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		wp_register_script( 'tpro-filter-config', SP_TPRO_URL . 'public/assets/js/filter-config.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );
		// wp_register_script( 'tpro-read-more-config', SP_TPRO_URL . 'public/assets/js/read-more-config.min.js', array( 'jquery' ), SP_TPRO_VERSION, true );

	}

}
new SP_TPRO_Front_Scripts();

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Admin Scripts and styles
 */
class SP_TPRO_Admin_Scripts {

	/**
	 * @var null
	 * @since 2.0
	 */
	protected static $_instance = null;

	/**
	 * @return SP_TPRO_Admin_Scripts
	 * @since 2.0
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

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue admin scripts
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'testimonial-pro-admin', SP_TPRO_URL . 'admin/assets/css/admin.css', array(), SP_TPRO_VERSION );

		$screen = get_current_screen();
		if ( $screen->id == 'spt_testimonial_page_tpro_help' ) {
			wp_enqueue_style( 'tpro-font-awesome', SP_TPRO_URL . 'public/assets/css/font-awesome.min.css', array(), SP_TPRO_VERSION );
			wp_enqueue_style( 'testimonial-pro-help', SP_TPRO_URL . 'admin/assets/css/help.css', array(), SP_TPRO_VERSION );
		}
		if ( $screen->post_type == 'spt_testimonial' ) {
			wp_enqueue_style( 'testimonial-pro-order', SP_TPRO_URL . 'admin/assets/css/order.css', array(), SP_TPRO_VERSION );
		}
	}

}

new SP_TPRO_Admin_Scripts();

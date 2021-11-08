<?php
/**
 * This is to register the shortcode post type.
 *
 * @package testimonial-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SP_TPRO_Shortcode {

	private static $_instance;

	/**
	 * SP_TPRO_Shortcode constructor.
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @return SP_TPRO_Shortcode
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Shortcode Post Type
	 */
	function register_post_type() {
		register_post_type(
			'spt_shortcodes', array(
				'label'               => __( 'Manage Views', 'testimonial-pro' ),
				'description'         => __( 'Manage Views', 'testimonial-pro' ),
				'public'              => false,
				'has_archive'         => false,
				'publicaly_queryable' => false,
				'show_ui'             => true,
				'show_in_menu'        => 'edit.php?post_type=spt_testimonial',
				'hierarchical'        => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'capability_type'     => 'post',
				'labels'              => array(
					'name'               => __( 'Manage Views', 'testimonial-pro' ),
					'singular_name'      => __( 'Manage View', 'testimonial-pro' ),
					'menu_name'          => __( 'Manage Views', 'testimonial-pro' ),
					'add_new'            => __( 'Add New', 'testimonial-pro' ),
					'add_new_item'       => __( 'Add New View', 'testimonial-pro' ),
					'edit'               => __( 'Edit', 'testimonial-pro' ),
					'edit_item'          => __( 'Edit View', 'testimonial-pro' ),
					'new_item'           => __( 'New View', 'testimonial-pro' ),
					'search_items'       => __( 'Search View', 'testimonial-pro' ),
					'not_found'          => __( 'No View Found', 'testimonial-pro' ),
					'not_found_in_trash' => __( 'No View Found in Trash', 'testimonial-pro' ),
					'parent'             => __( 'Parent View', 'testimonial-pro' ),
				),
			)
		);
	}
}

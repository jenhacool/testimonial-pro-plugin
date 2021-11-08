<?php
/**
 * This is to register the form post type.
 *
 * @package testimonial-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SP_TPRO_Form {

	private static $_instance;

	/**
	 * SP_TPRO_Form constructor.
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @return SP_TPRO_Form
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Form Post Type
	 */
	function register_post_type() {
		register_post_type(
			'spt_testimonial_form', array(
				'label'               => __( 'Forms', 'testimonial-pro' ),
				'description'         => __( 'Generate forms for Frontend.', 'testimonial-pro' ),
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
					'name'               => __( 'Testimonial Forms', 'testimonial-pro' ),
					'singular_name'      => __( 'Testimonial Form', 'testimonial-pro' ),
					'menu_name'          => __( 'Testimonial Forms', 'testimonial-pro' ),
					'add_new'            => __( 'Add New', 'testimonial-pro' ),
					'add_new_item'       => __( 'Add New Form', 'testimonial-pro' ),
					'edit'               => __( 'Edit', 'testimonial-pro' ),
					'edit_item'          => __( 'Edit Form', 'testimonial-pro' ),
					'new_item'           => __( 'New Form', 'testimonial-pro' ),
					'search_items'       => __( 'Search Forms', 'testimonial-pro' ),
					'not_found'          => __( 'No Form Found', 'testimonial-pro' ),
					'not_found_in_trash' => __( 'No Form Found in Trash', 'testimonial-pro' ),
					'parent'             => __( 'Parent Form', 'testimonial-pro' ),
				),
			)
		);
	}
}

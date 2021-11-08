<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SP_TPRO_Taxonomy {

	/**
	 * @var
	 * @since 1.0
	 */
	private static $_instance;

	/**
	 * @return SP_TPRO_Taxonomy
	 * @since 1.0
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * SP_TPRO_Taxonomy constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Register post type
	 *
	 * @since 1.0
	 */
	function register_taxonomy() {
		$settings = get_option('sp_testimonial_pro_options');
		$singular_name = isset( $settings['tpro_singular_name'] ) ? $settings['tpro_singular_name'] : 'Testimonial';
		$group_singular_name = isset( $settings['tpro_group_singular_name'] ) ? $settings['tpro_group_singular_name'] : 'Group';
		$group_plural_name = isset( $settings['tpro_group_plural_name'] ) ? $settings['tpro_group_plural_name'] : 'Groups';

		$labels = array(
			'menu_name'         => $group_plural_name,
			'name'              => $group_plural_name,
			'singular_name'     => $group_singular_name,
			'search_items'      => esc_html__( 'Search ' . $group_singular_name . '', 'testimonial-pro' ),
			'all_items'         => esc_html__( 'All ' . $group_plural_name . '', 'testimonial-pro' ),
			'parent_item'       => esc_html__( 'Parent ' . $group_singular_name . '', 'testimonial-pro' ),
			'parent_item_colon' => esc_html__( 'Parent ' . $group_singular_name . ':', 'testimonial-pro' ),
			'edit_item'         => esc_html__( 'Edit ' . $group_singular_name . '', 'testimonial-pro' ),
			'update_item'       => esc_html__( 'Update ' . $group_singular_name . '', 'testimonial-pro' ),
			'add_new_item'      => esc_html__( 'Add New ' . $group_singular_name . '', 'testimonial-pro' ),
			'new_item_name'     => esc_html__( 'New ' . $group_singular_name . ' Name', 'testimonial-pro' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => false,
		);

		register_taxonomy( 'testimonial_cat', array( 'spt_testimonial' ), $args );
	}

}

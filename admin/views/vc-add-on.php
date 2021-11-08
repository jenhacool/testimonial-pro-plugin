<?php
/**
 * Visual Composer Map
 */
if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {

	class SP_TPRO_VC_Element {

		/**
		 * SP_TPRO_VC_Element constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'sp_tpro_vc_map' ) );
		}

		// ShortCode List.
		private function shortcodes_list() {
			$shortcodes = get_posts( array(
				'post_type'      => 'spt_shortcodes',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			) );

			if ( count( $shortcodes ) < 1 ) {
				return array();
			}

			$result = array();

			foreach( $shortcodes as $shortcode ) {
				$result[ esc_html( $shortcode->post_title ) ] = $shortcode->ID;
			}

			return $result;
		}

		/**
		 * Integrate with visual composer
		 */
		public function sp_tpro_vc_map() {
			// Check if Visual Composer is installed.
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
				return;
			}

			vc_map( array(
				'name'        => esc_html__( 'Testimonial Pro', 'testimonial-pro' ),
				'base'        => 'sp_testimonial',
				'icon'        => SP_TPRO_URL . 'admin/assets/images/icon-32.png',
				'class'       => '',
				'description' => esc_html__( 'Display Testimonials.', 'testimonial-pro' ),
				'category'    => esc_html__( 'ShapedPlugin', 'testimonial-pro' ),
				'params'      => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Testimonial Shortcodes:', 'testimonial-pro' ),
						'description' => esc_html__( 'Select a shortcode.', 'testimonial-pro' ),
						'param_name'  => 'id',
						'value'       => $this->shortcodes_list(),
					),
				),
			) );

		}
	}
	new SP_TPRO_VC_Element;
}

<?php
/**
 * This file render the shortcode to the frontend
 *
 * @package testimonial-pro
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Testimonial Pro - Shortcode Render class
 *
 * @since 2.0
 */
if ( ! class_exists( 'TPRO_Shortcode_Render' ) ) {
	class TPRO_Shortcode_Render {

		/**
		 * @var TPRO_Shortcode_Render single instance of the class
		 *
		 * @since 2.0
		 */
		protected static $_instance = null;


		/**
		 * TPRO_Shortcode_Render Instance
		 *
		 * @since 2.0
		 * @static
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * TPRO_Shortcode_Render constructor.
		 */
		public function __construct() {
			add_shortcode( 'testimonial_pro', array( $this, 'shortcode_render' ) );
			add_shortcode( 'sp_testimonial', array( $this, 'shortcode_render' ) );
		}

		/**
		 * @param $attributes
		 *
		 * @return string
		 * @since 2.0
		 */
		public function shortcode_render( $attributes ) {
			$manage_license     = new Testimonial_Pro_License( SP_TESTIMONIAL_PRO_FILE, SP_TPRO_VERSION, 'ShapedPlugin', SP_TPRO_STORE_URL, SP_TPRO_ITEM_ID, SP_TPRO_ITEM_SLUG );
			$license_key_status = $manage_license->get_license_status();
			$license_status     = ( is_object( $license_key_status ) && $license_key_status ? $license_key_status->license : '' );
			$if_license_status  = array( 'valid', 'expired' );
			$first_version      = get_option( 'testimonial_pro_first_version' );
			if ( ! in_array( $license_status, $if_license_status ) && 1 === version_compare( $first_version, '2.2.3' ) ) {
				if ( current_user_can( apply_filters( 'testimonial_pro_user_role_permission', 'manage_options' ) ) ) {
					$activation_notice = sprintf(
						'<div class="testimonial-pro-license-notice" style="background: #ffebee;color: #444;padding: 18px 16px;border: 1px solid #d0919f;border-radius: 4px;font-size: 18px;line-height: 28px;">Please <strong><a href="%1$s">activate</a></strong> the license key to get the output of the <strong>Testimonial Pro</strong> plugin.</div>',
						esc_url( admin_url( 'edit.php?post_type=spt_testimonial&page=tpro_settings#tab=1' ) )
					);
				}
				return $activation_notice;
			}

			if ( empty( $attributes['id'] ) ) {
				return;
			}

			$post_id = $attributes['id'];

			$setting_options = get_option( 'sp_testimonial_pro_options' );
			$shortcode_data  = get_post_meta( $post_id, 'sp_tpro_shortcode_options', true );

			//
			// General Settings.
			//
			$layout                    = isset( $shortcode_data['layout'] ) ? $shortcode_data['layout'] : 'slider';
			$filter_style              = isset( $shortcode_data['filter_style'] ) ? $shortcode_data['filter_style'] : 'even';
			$theme_style               = isset( $shortcode_data['theme_style'] ) ? $shortcode_data['theme_style'] : 'theme-one';
			$display_testimonials_from = isset( $shortcode_data['display_testimonials_from'] ) ? $shortcode_data['display_testimonials_from'] : 'latest';
			$specific_testimonial      = isset( $shortcode_data['specific_testimonial'] ) ? $shortcode_data['specific_testimonial'] : '';
			$exclude_testimonial       = isset( $shortcode_data['exclude_testimonial'] ) ? $shortcode_data['exclude_testimonial'] : '';
			$category_list             = isset( $shortcode_data['category_list'] ) ? $shortcode_data['category_list'] : '';
			$category_operator         = isset( $shortcode_data['category_operator'] ) ? $shortcode_data['category_operator'] : 'IN';
			$total_testimonials        = isset( $shortcode_data['number_of_total_testimonials'] ) ? $shortcode_data['number_of_total_testimonials'] : '10';
			$testimonial_per_page      = isset( $shortcode_data['tp_per_page'] ) ? $shortcode_data['tp_per_page'] : '10';
			$random_order              = isset( $shortcode_data['random_order'] ) ? $shortcode_data['random_order'] : '';
			$tpro_order_by             = isset( $shortcode_data['testimonial_order_by'] ) ? $shortcode_data['testimonial_order_by'] : 'menu_order';
			$order_by                  = $random_order ? 'rand' : $tpro_order_by;
			$preloader                 = isset( $shortcode_data['preloader'] ) ? $shortcode_data['preloader'] : '';

			//
			// Stylization.
			//
			$video_icon = isset( $shortcode_data['video_icon'] ) ? $shortcode_data['video_icon'] : true;

			$testimonial_margin = isset( $shortcode_data['testimonial_margin'] ) ? $shortcode_data['testimonial_margin'] : '0';
			$section_title      = $shortcode_data['section_title'];

			// Pagination.
			$pagination_data = ( isset( $shortcode_data['pagination'] ) ? $shortcode_data['pagination'] : 'true' );
			switch ( $pagination_data ) {
				case 'true':
					$pagination_dots   = 'true';
					$pagination_mobile = 'true';
					break;
				case 'hide_on_mobile':
					$pagination_dots   = 'true';
					$pagination_mobile = 'false';
					break;
				case 'false':
					$pagination_dots   = 'false';
					$pagination_mobile = 'false';
					break;
			}

			$columns                = isset( $shortcode_data['columns'] ) ? $shortcode_data['columns'] : '';
			$columns_large_desktop  = isset( $columns['large_desktop'] ) ? $columns['large_desktop'] : '1';
			$columns_desktop        = isset( $columns['desktop'] ) ? $columns['desktop'] : '1';
			$columns_laptop         = isset( $columns['laptop'] ) ? $columns['laptop'] : '1';
			$columns_tablet         = isset( $columns['tablet'] ) ? $columns['tablet'] : '1';
			$columns_mobile         = isset( $columns['mobile'] ) ? $columns['mobile'] : '1';
			$slider_direction       = isset( $shortcode_data['slider_direction'] ) ? $shortcode_data['slider_direction'] : 'ltr';
			$rtl_mode               = ( 'rtl' == $slider_direction ) ? 'true' : 'false';
			$the_rtl                = ( 'slider' == $layout ) ? 'dir="' . $slider_direction . '"' : '';
			$slider_draggable       = $shortcode_data['slider_draggable'] == true ? 'true' : 'false';
			$slider_draggable_thumb = $shortcode_data['slider_draggable'] == true ? 'true' : 'false';
			$slider_swipe           = $shortcode_data['slider_swipe'] == true ? 'true' : 'false';
			$tpro_swipe_to_slide    = isset( $shortcode_data['swipe_to_slide'] ) ? $shortcode_data['swipe_to_slide'] : 'false';
			$swipe_to_slide         = ( true == $tpro_swipe_to_slide ) ? 'true' : 'false';
			$slider_swipe_thumb     = $shortcode_data['slider_swipe'] == true ? 'true' : 'false';

			// Schema settings.
			$tpro_schema_markup    = isset( $shortcode_data['tpro_schema_markup'] ) ? $shortcode_data['tpro_schema_markup'] : '';
			$tpro_global_item_name = isset( $shortcode_data['tpro_global_item_name'] ) && ! empty( $shortcode_data['tpro_global_item_name'] ) ? $shortcode_data['tpro_global_item_name'] : get_the_title( $post_id );

			// Auto Play.
			$slider_auto_play_data = ( isset( $shortcode_data['slider_auto_play'] ) ? $shortcode_data['slider_auto_play'] : 'true' );
			switch ( $slider_auto_play_data ) {
				case 'true':
					$slider_auto_play        = 'true';
					$slider_auto_play_mobile = 'true';
					break;
				case 'off_on_mobile':
					$slider_auto_play        = 'true';
					$slider_auto_play_mobile = 'false';
					break;
				case 'false':
					$slider_auto_play        = 'false';
					$slider_auto_play_mobile = 'false';
					break;
				default:
					$slider_auto_play        = 'true';
					$slider_auto_play_mobile = 'false';
					break;
			}
			$slider_auto_play_speed        = isset( $shortcode_data['slider_auto_play_speed'] ) ? $shortcode_data['slider_auto_play_speed'] : '3000';
			$slider_scroll_speed           = isset( $shortcode_data['slider_scroll_speed'] ) ? $shortcode_data['slider_scroll_speed'] : '600';
			$slide_to_scroll               = isset( $shortcode_data['slide_to_scroll'] ) ? $shortcode_data['slide_to_scroll'] : '1';
			$slide_to_scroll_large_desktop = isset( $slide_to_scroll['large_desktop'] ) ? $slide_to_scroll['large_desktop'] : '1';
			$slide_to_scroll_desktop       = isset( $slide_to_scroll['desktop'] ) ? $slide_to_scroll['desktop'] : '1';
			$slide_to_scroll_laptop        = isset( $slide_to_scroll['laptop'] ) ? $slide_to_scroll['laptop'] : '1';
			$slide_to_scroll_tablet        = isset( $slide_to_scroll['tablet'] ) ? $slide_to_scroll['tablet'] : '1';
			$slide_to_scroll_mobile        = isset( $slide_to_scroll['mobile'] ) ? $slide_to_scroll['mobile'] : '1';
			$slider_row                    = isset( $shortcode_data['slider_row'] ) ? $shortcode_data['slider_row'] : '';
			$row_large_desktop             = isset( $slider_row['large_desktop'] ) ? $slider_row['large_desktop'] : '1';
			$row_desktop                   = isset( $slider_row['desktop'] ) ? $slider_row['desktop'] : '1';
			$row_laptop                    = isset( $slider_row['laptop'] ) ? $slider_row['laptop'] : '1';
			$row_tablet                    = isset( $slider_row['tablet'] ) ? $slider_row['tablet'] : '1';
			$row_mobile                    = isset( $slider_row['mobile'] ) ? $slider_row['mobile'] : '1';
			$slider_pause_on_hover         = $shortcode_data['slider_pause_on_hover'] == true ? 'true' : 'false';
			$slider_pause_on_hover_thumb   = $shortcode_data['slider_pause_on_hover'] == true ? 'true' : 'false';
			$slider_infinite               = $shortcode_data['slider_infinite'] == true ? 'true' : 'false';
			$slider_animation              = isset( $shortcode_data['slider_animation'] ) ? $shortcode_data['slider_animation'] : '';

			switch ( $slider_animation ) {
				case 'slide':
					$slider_fade_effect = 'false';
					break;
				case 'fade':
					$slider_fade_effect = 'true';
					break;
			}

			if ( $slider_animation == 'slide' ) {
				$slider_fade_effect_thumb = 'false';
			} elseif ( $slider_animation == 'fade' ) {
				$slider_fade_effect_thumb = 'true';
			}

			// Navigation.
			$navigation_data = ( isset( $shortcode_data['navigation'] ) ? $shortcode_data['navigation'] : 'true' );
			switch ( $navigation_data ) {
				case 'true':
					$navigation_arrows = 'true';
					$navigation_mobile = 'true';
					break;
				case 'hide_on_mobile':
					$navigation_arrows = 'true';
					$navigation_mobile = 'false';
					break;
				case 'false':
					$navigation_arrows = 'false';
					$navigation_mobile = 'false';
					break;
			}
			$navigation_position                     = isset( $shortcode_data['navigation_position'] ) ? $shortcode_data['navigation_position'] : 'vertical_center';
			$testimonial_title                       = isset( $shortcode_data['testimonial_title'] ) ? $shortcode_data['testimonial_title'] : '';
			$testimonial_title_tag                   = isset( $shortcode_data['testimonial_title_tag'] ) ? $shortcode_data['testimonial_title_tag'] : 'h3';
			$testimonial_text                        = isset( $shortcode_data['testimonial_text'] ) ? $shortcode_data['testimonial_text'] : '';
			$client_image_margin                     = isset( $shortcode_data['client_image_margin'] ) ? $shortcode_data['client_image_margin'] : array(
				'top'    => '0',
				'right'  => '0',
				'bottom' => '22',
				'left'   => '0',
			);
			$client_image_margin_tow                 = isset( $shortcode_data['client_image_margin_tow'] ) ? $shortcode_data['client_image_margin_tow'] : array(
				'top'    => '0',
				'right'  => '22',
				'bottom' => '0',
				'left'   => '0',
			);
			$testimonial_client_name                 = isset( $shortcode_data['testimonial_client_name'] ) ? $shortcode_data['testimonial_client_name'] : '';
			$testimonial_client_name_tag             = isset( $shortcode_data['testimonial_client_name_tag'] ) ? $shortcode_data['testimonial_client_name_tag'] : 'h4';
			$testimonial_client_rating               = isset( $shortcode_data['testimonial_client_rating'] ) ? $shortcode_data['testimonial_client_rating'] : '';
			$testimonial_client_rating_alignment     = isset( $shortcode_data['testimonial_client_rating_alignment'] ) ? $shortcode_data['testimonial_client_rating_alignment'] : 'center';
			$testimonial_client_rating_alignment_two = isset( $shortcode_data['testimonial_client_rating_alignment_two'] ) ? $shortcode_data['testimonial_client_rating_alignment_two'] : $testimonial_client_rating_alignment;
			$testimonial_client_rating_margin        = isset( $shortcode_data['testimonial_client_rating_margin'] ) ? $shortcode_data['testimonial_client_rating_margin'] : array(
				'top'    => '0',
				'right'  => '0',
				'bottom' => '6',
				'left'   => '0',
			);
			$client_designation                      = isset( $shortcode_data['client_designation'] ) ? $shortcode_data['client_designation'] : '';
			$client_company_name                     = isset( $shortcode_data['client_company_name'] ) ? $shortcode_data['client_company_name'] : '';
			$testimonial_read_more_text              = isset( $shortcode_data['testimonial_read_more_text'] ) ? $shortcode_data['testimonial_read_more_text'] : 'Read More';
			$testimonial_read_less_text              = isset( $shortcode_data['testimonial_read_less_text'] ) ? $shortcode_data['testimonial_read_less_text'] : 'Read Less';
			$testimonial_read_more_ellipsis          = isset( $shortcode_data['testimonial_read_more_ellipsis'] ) ? $shortcode_data['testimonial_read_more_ellipsis'] : '...';
			$thumbnail_slider                        = isset( $shortcode_data['thumbnail_slider'] ) && $shortcode_data['thumbnail_slider'] == true ? 'true' : 'false';
			$identity_linking_website                = isset( $shortcode_data['identity_linking_website'] ) ? $shortcode_data['identity_linking_website'] : '';
			$slider_mode                             = isset( $shortcode_data['slider_mode'] ) ? $shortcode_data['slider_mode'] : 'standard';

			$testimonial_client_location    = isset( $shortcode_data['testimonial_client_location'] ) ? $shortcode_data['testimonial_client_location'] : '';
			$testimonial_client_phone       = isset( $shortcode_data['testimonial_client_phone'] ) ? $shortcode_data['testimonial_client_phone'] : '';
			$testimonial_client_email       = isset( $shortcode_data['testimonial_client_email'] ) ? $shortcode_data['testimonial_client_email'] : '';
			$testimonial_client_date_format = isset( $shortcode_data['testimonial_client_date_format'] ) ? $shortcode_data['testimonial_client_date_format'] : '';
			$testimonial_client_date        = isset( $shortcode_data['testimonial_client_date'] ) ? $shortcode_data['testimonial_client_date'] : '';
			$testimonial_client_website     = isset( $shortcode_data['testimonial_client_website'] ) ? $shortcode_data['testimonial_client_website'] : '';
			$testimonial_inner_padding      = $shortcode_data['testimonial_inner_padding'];
			$testimonial_info_inner_padding = $shortcode_data['testimonial_info_inner_padding'];
			$pagination_margin              = isset( $shortcode_data['pagination_margin'] ) ? $shortcode_data['pagination_margin'] : array(
				'top'    => '21',
				'right'  => '0',
				'bottom' => '0',
				'left'   => '0',
			);
			$grid_pagination                = isset( $shortcode_data['grid_pagination'] ) ? $shortcode_data['grid_pagination'] : '';
			$pagination_type                = isset( $shortcode_data['tp_pagination_type'] ) ? $shortcode_data['tp_pagination_type'] : 'no_ajax';
			$load_more_label                = isset( $shortcode_data['load_more_label'] ) ? $shortcode_data['load_more_label'] : 'Load More';

			$grid_pagination_margin = isset( $shortcode_data['grid_pagination_margin'] ) ? $shortcode_data['grid_pagination_margin'] : array(
				'top'    => '20',
				'right'  => '0',
				'bottom' => '20',
				'left'   => '0',
			);
			$filter_margin          = isset( $shortcode_data['filter_margin'] ) ? $shortcode_data['filter_margin'] : array(
				'top'    => '0',
				'right'  => '0',
				'bottom' => '24',
				'left'   => '0',
			);
			$all_tab_text           = isset( $shortcode_data['all_tab_text'] ) ? $shortcode_data['all_tab_text'] : 'All';
			$all_tab_show           = isset( $shortcode_data['all_tab'] ) ? $shortcode_data['all_tab'] : true;
			$social_profile         = isset( $shortcode_data['social_profile'] ) ? $shortcode_data['social_profile'] : '';
			$social_profile_margin  = isset( $shortcode_data['social_profile_margin'] ) ? $shortcode_data['social_profile_margin'] : array(
				'top'    => '15',
				'right'  => '0',
				'bottom' => '6',
				'left'   => '0',
			);
			$navigation_icons       = isset( $shortcode_data['navigation_icons'] ) ? $shortcode_data['navigation_icons'] : 'angle';
			$website_link_target    = isset( $shortcode_data['website_link_target'] ) ? $shortcode_data['website_link_target'] : '_blank';

			/**
			 * Image Settings.
			 */
			$client_image        = isset( $shortcode_data['client_image'] ) ? $shortcode_data['client_image'] : false;
			$image_sizes         = isset( $shortcode_data['image_sizes'] ) ? $shortcode_data['image_sizes'] : 'custom';
			$image_custom_size   = isset( $shortcode_data['image_custom_size'] ) ? $shortcode_data['image_custom_size'] : '';
			$client_image_width  = isset( $image_custom_size['width'] ) ? $image_custom_size['width'] : '120';
			$client_image_height = isset( $image_custom_size['height'] ) ? $image_custom_size['height'] : '120';
			$image_crop          = isset( $image_custom_size['crop'] ) ? $image_custom_size['crop'] : 'soft-crop';
			$client_image_crop   = ( 'hard-crop' == $image_crop ) ? true : false;
			$image_paddings      = isset( $shortcode_data['image_padding'] ) ? $shortcode_data['image_padding'] : '';
			$image_padding       = isset( $image_paddings['all'] ) ? $image_paddings['all'] : '0';
			$image_border        = isset( $shortcode_data['image_border'] ) ? $shortcode_data['image_border'] : '';
			$image_border_width  = isset( $image_border['all'] ) ? $image_border['all'] : '0';
			$image_border_style  = isset( $image_border['style'] ) ? $image_border['style'] : 'solid';
			$image_border_color  = isset( $image_border['color'] ) ? $image_border['color'] : '#dddddd';
			$image_grayscale     = isset( $shortcode_data['image_grayscale'] ) ? $shortcode_data['image_grayscale'] : 'none';

			$star_icon                         = isset( $shortcode_data['tpro_star_icon'] ) ? $shortcode_data['tpro_star_icon'] : 'fa fa-star';
			$adaptive_height                   = isset( $shortcode_data['adaptive_height'] ) && true == $shortcode_data['adaptive_height'] ? 'true' : 'false';
			$client_image_style                = isset( $shortcode_data['client_image_style'] ) ? $shortcode_data['client_image_style'] : '';
			$client_image_position             = isset( $shortcode_data['client_image_position'] ) ? $shortcode_data['client_image_position'] : 'center';
			$client_image_position_two         = isset( $shortcode_data['client_image_position_two'] ) ? $shortcode_data['client_image_position_two'] : 'left';
			$testimonial_info_position_two     = isset( $shortcode_data['testimonial_info_position_two'] ) ? $shortcode_data['testimonial_info_position_two'] : '';
			$client_image_position_three       = isset( $shortcode_data['client_image_position_three'] ) ? $shortcode_data['client_image_position_three'] : 'left-top';
			$testimonial_characters_limit      = isset( $shortcode_data['testimonial_characters_limit'] ) ? $shortcode_data['testimonial_characters_limit'] : '100';
			$testimonial_content_type          = isset( $shortcode_data['testimonial_content_type'] ) ? $shortcode_data['testimonial_content_type'] : '';
			$testimonial_read_more_link_action = isset( $shortcode_data['testimonial_read_more_link_action'] ) ? $shortcode_data['testimonial_read_more_link_action'] : '';
			$testimonial_read_more             = isset( $shortcode_data['testimonial_read_more'] ) ? $shortcode_data['testimonial_read_more'] : '';

			switch ( $filter_style ) {
				case 'even':
					$filter_mode = 'fitRows';
					break;
				case 'masonry':
					$filter_mode = 'masonry';
					break;
			}

			/**
			 * Typography
			 */
			$section_title_font_load                   = isset( $shortcode_data['section_title_font_load'] ) ? $shortcode_data['section_title_font_load'] : '';
			$section_title_typography                  = isset( $shortcode_data['section_title_typography'] ) ? $shortcode_data['section_title_typography'] : '';
			$testimonial_title_font_load               = isset( $shortcode_data['testimonial_title_font_load'] ) ? $shortcode_data['testimonial_title_font_load'] : '';
			$testimonial_title_typography              = isset( $shortcode_data['testimonial_title_typography'] ) ? $shortcode_data['testimonial_title_typography'] : array(
				'font-family'    => 'Open Sans',
				'font-weight'    => '600',
				'type'           => 'google',
				'font-size'      => '20',
				'line-height'    => '30',
				'text-align'     => 'center',
				'text-transform' => 'none',
				'letter-spacing' => 0,
				'color'          => '#333333',
				'margin-top'     => '0',
				'margin-right'   => '0',
				'margin-bottom'  => '18',
				'margin-left'    => '0',
			);
			$testimonial_title_typography_two          = isset( $shortcode_data['testimonial_title_typography_two'] ) ? $shortcode_data['testimonial_title_typography_two'] : $testimonial_title_typography;
			$testimonial_title_typography_three        = isset( $shortcode_data['testimonial_title_typography_three'] ) ? $shortcode_data['testimonial_title_typography_three'] : $testimonial_title_typography;
			$testimonial_title_typography_four         = isset( $shortcode_data['testimonial_title_typography_four'] ) ? $shortcode_data['testimonial_title_typography_four'] : $testimonial_title_typography;
			$testimonial_text_font_load                = isset( $shortcode_data['testimonial_text_font_load'] ) ? $shortcode_data['testimonial_text_font_load'] : '';
			$testimonial_text_typography               = isset( $shortcode_data['testimonial_text_typography'] ) ? $shortcode_data['testimonial_text_typography'] : '';
			$testimonial_text_typography_two           = isset( $shortcode_data['testimonial_text_typography_two'] ) ? $shortcode_data['testimonial_text_typography_two'] : $testimonial_text_typography;
			$testimonial_text_typography_three         = isset( $shortcode_data['testimonial_text_typography_three'] ) ? $shortcode_data['testimonial_text_typography_three'] : $testimonial_text_typography;
			$testimonial_text_typography_four          = isset( $shortcode_data['testimonial_text_typography_four'] ) ? $shortcode_data['testimonial_text_typography_four'] : $testimonial_text_typography;
			$client_name_font_load                     = isset( $shortcode_data['client_name_font_load'] ) ? $shortcode_data['client_name_font_load'] : '';
			$client_name_typography                    = isset( $shortcode_data['client_name_typography'] ) ? $shortcode_data['client_name_typography'] : '';
			$client_name_typography_two                = isset( $shortcode_data['client_name_typography_two'] ) ? $shortcode_data['client_name_typography_two'] : $client_name_typography;
			$designation_company_font_load             = isset( $shortcode_data['designation_company_font_load'] ) ? $shortcode_data['designation_company_font_load'] : '';
			$client_designation_company_typography     = isset( $shortcode_data['client_designation_company_typography'] ) ? $shortcode_data['client_designation_company_typography'] : '';
			$client_designation_company_typography_two = isset( $shortcode_data['client_designation_company_typography_two'] ) ? $shortcode_data['client_designation_company_typography_two'] : $client_designation_company_typography;
			$location_font_load                        = isset( $shortcode_data['location_font_load'] ) ? $shortcode_data['location_font_load'] : '';
			$client_location_typography                = isset( $shortcode_data['client_location_typography'] ) ? $shortcode_data['client_location_typography'] : '';
			$client_location_typography_two            = isset( $shortcode_data['client_location_typography_two'] ) ? $shortcode_data['client_location_typography_two'] : $client_location_typography;
			$phone_font_load                           = isset( $shortcode_data['phone_font_load'] ) ? $shortcode_data['phone_font_load'] : '';
			$client_phone_typography                   = isset( $shortcode_data['client_phone_typography'] ) ? $shortcode_data['client_phone_typography'] : '';
			$client_phone_typography_two               = isset( $shortcode_data['client_phone_typography_two'] ) ? $shortcode_data['client_phone_typography_two'] : $client_phone_typography;
			$email_font_load                           = isset( $shortcode_data['email_font_load'] ) ? $shortcode_data['email_font_load'] : '';
			$client_email_typography                   = isset( $shortcode_data['client_email_typography'] ) ? $shortcode_data['client_email_typography'] : '';
			$client_email_typography_two               = isset( $shortcode_data['client_email_typography_two'] ) ? $shortcode_data['client_email_typography_two'] : $client_email_typography;
			$date_font_load                            = isset( $shortcode_data['date_font_load'] ) ? $shortcode_data['date_font_load'] : '';
			$testimonial_date_typography               = isset( $shortcode_data['testimonial_date_typography'] ) ? $shortcode_data['testimonial_date_typography'] : '';
			$testimonial_date_typography_two           = isset( $shortcode_data['testimonial_date_typography_two'] ) ? $shortcode_data['testimonial_date_typography_two'] : $testimonial_date_typography;
			$website_font_load                         = isset( $shortcode_data['website_font_load'] ) ? $shortcode_data['website_font_load'] : '';
			$client_website_typography                 = isset( $shortcode_data['client_website_typography'] ) ? $shortcode_data['client_website_typography'] : '';
			$client_website_typography_two             = isset( $shortcode_data['client_website_typography_two'] ) ? $shortcode_data['client_website_typography_two'] : $client_website_typography;
			$filter_font_load                          = isset( $shortcode_data['filter_font_load'] ) ? $shortcode_data['filter_font_load'] : '';
			$filter_typography                         = isset( $shortcode_data['filter_typography'] ) ? $shortcode_data['filter_typography'] : '';

			if ( $setting_options['tpro_dequeue_google_fonts'] ) {
				/**
				 * Google font link enqueue
				 */
				$custom_id         = uniqid();
				$enqueue_fonts     = array();
				$tpro_typography   = array();
				$tpro_typography[] = $section_title_typography;
				$tpro_typography[] = $testimonial_title_typography;
				$tpro_typography[] = $testimonial_title_typography_two;
				$tpro_typography[] = $testimonial_title_typography_three;
				$tpro_typography[] = $testimonial_title_typography_four;
				$tpro_typography[] = $testimonial_text_typography;
				$tpro_typography[] = $testimonial_text_typography_two;
				$tpro_typography[] = $testimonial_text_typography_three;
				$tpro_typography[] = $testimonial_text_typography_four;
				$tpro_typography[] = $client_name_typography;
				$tpro_typography[] = $client_name_typography_two;
				$tpro_typography[] = $client_designation_company_typography;
				$tpro_typography[] = $client_designation_company_typography_two;
				$tpro_typography[] = $client_location_typography;
				$tpro_typography[] = $client_location_typography_two;
				$tpro_typography[] = $client_phone_typography;
				$tpro_typography[] = $client_phone_typography_two;
				$tpro_typography[] = $client_email_typography;
				$tpro_typography[] = $client_email_typography_two;
				$tpro_typography[] = $testimonial_date_typography;
				$tpro_typography[] = $testimonial_date_typography_two;
				$tpro_typography[] = $client_website_typography;
				$tpro_typography[] = $client_website_typography_two;
				$tpro_typography[] = $filter_typography;
				if ( ! empty( $tpro_typography ) ) {
					foreach ( $tpro_typography as $font ) {
						if ( isset( $font['type'] ) && $font['type'] == 'google' ) {
							$variant         = ( isset( $font['font-weight'] ) && $font['font-weight'] !== 'noraml' ) ? ':' . $font['font-weight'] : '';
							$enqueue_fonts[] = $font['font-family'] . $variant;
						}
					}
				}
				if ( ! empty( $enqueue_fonts ) ) {
					wp_enqueue_style( 'sp-tpro-google-fonts' . $custom_id, esc_url( add_query_arg( 'family', urlencode( implode( '|', $enqueue_fonts ) ), '//fonts.googleapis.com/css' ) ), array(), SP_TPRO_VERSION, false );
				}
			}

			// Enqueue Script.
			if ( 'slider' == $layout ) {
				if ( $setting_options['tpro_dequeue_slick_js'] ) {
					wp_enqueue_script( 'tpro-slick-min-js' );
				}
				if ( 'false' == $thumbnail_slider ) {
					if ( 'ticker' == $slider_mode ) {
						wp_enqueue_script( 'tpro-slick-ticker-active' );
					} else {
						wp_enqueue_script( 'tpro-slick-active' );
					}
				}
			} elseif ( 'filter' == $layout ) {
				if ( $setting_options['tpro_dequeue_isotope_js'] ) {
					wp_enqueue_script( 'tpro-isotope-js' );
				}
				wp_enqueue_script( 'tpro-filter-config' );
			}

			if ( 'content_with_limit' == $testimonial_content_type && $testimonial_read_more && 'expand' == $testimonial_read_more_link_action ) {
				wp_enqueue_script( 'tpro-curtail-min-js' );
				// wp_enqueue_script( 'tpro-read-more-config' );
				$tpro_read_more_config = compact( 'testimonial_characters_limit', 'testimonial_read_more_text', 'testimonial_read_less_text', 'testimonial_read_more_ellipsis' );
			} elseif ( $testimonial_read_more && $testimonial_read_more_link_action == 'popup' ) {
				wp_enqueue_style( 'tpro-remodal' );
				wp_enqueue_style( 'tpro-remodal-default-theme' );
				wp_enqueue_script( 'tpro-remodal-js' );
			}

			if ( 'filter' == $layout ) {
				$tpro_filter_config = compact( 'filter_mode' );
			}

			$outline = '';

			// Dynamic CSS.
			ob_start();
			require SP_TPRO_PATH . '/public/views/content/style.php';
			ob_end_flush();
			$tpargs = array(
				'post_type'      => 'spt_testimonial',
				'posts_per_page' => $total_testimonials,
				'fields'         => 'ids',
			);
			if ( 'specific_testimonials' === $display_testimonials_from && ! empty( $specific_testimonial ) ) {
				// $specific_testimonial_ids = $specific_testimonial;
				// $exclude_testimonial_ids  = null;
				$order_by           = 'menu_order' == $order_by ? 'post__in' : $order_by;
				$tpargs['post__in'] = $specific_testimonial;
				$tpargs['orderby']  = $order_by;
			} elseif ( 'exclude' === $display_testimonials_from && ! empty( $exclude_testimonial ) ) {
				// $exclude_testimonial_ids  = $exclude_testimonial;
				// $specific_testimonial_ids = null;
				$tpargs['post__not_in'] = $exclude_testimonial;
			} elseif ( 'category' === $display_testimonials_from && ! empty( $category_list ) ) {
				$tpargs['tax_query'][] = array(
					'taxonomy' => 'testimonial_cat',
					'field'    => 'term_id',
					'terms'    => $category_list,
					'operator' => $category_operator,
				);
			}
			$all_post_ids = get_posts( $tpargs );
			if ( $layout == 'grid' && $grid_pagination || $layout == 'masonry' && $grid_pagination || $layout == 'list' && $grid_pagination ) {
				// if ( is_front_page() ) {
				// $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
				// } else {
				// $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				// }
				// if ( is_front_page() ) {
				// $paged  = 'page' .  $post_id;
				// $paged = isset( $_GET["$paged"] ) ? $_GET["$paged"] : 1;
				// } else {
					$paged = 'paged' . $post_id;
					$paged = isset( $_GET[ "$paged" ] ) ? $_GET[ "$paged" ] : 1;
				// }
				$args = array(
					'post_type'      => 'spt_testimonial',
					'orderby'        => $order_by,
					'order'          => $shortcode_data['testimonial_order'],
					'posts_per_page' => $testimonial_per_page,
					'post__in'       => $all_post_ids,
					'paged'          => $paged,
				);
			} else {
				$args            = array(
					'post_type'      => 'spt_testimonial',
					'orderby'        => $order_by,
					'order'          => $shortcode_data['testimonial_order'],
					'posts_per_page' => $total_testimonials,
					'post__in'       => $all_post_ids,
				);
				$pagination_type = '';
			}

			/*
			 if ( 'category' === $display_testimonials_from && ! empty( $category_list ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'testimonial_cat',
					'field'    => 'term_id',
					'terms'    => $category_list,
					'operator' => $category_operator,
				);
			} */

			$post_query = new WP_Query( $args );

			$testimonial_read_more_class = '';

			if ( $tpro_schema_markup ) {
				include SP_TPRO_PATH . '/public/views/content/schema.php';
			}

			if ( $thumbnail_slider == 'true' ) {

				$outline .= '<div id="sp-testimonial-pro-wrapper-' . $post_id . '" class="sp-testimonial-pro-wrapper sp-tpro-thumbnail-slider sp_tpro_nav_position_' . $navigation_position . '">';
				if ( $preloader ) {
					$preloader_style = ( $preloader ) ? '' : 'display: none;';
					$outline        .= '<div class="tpro-preloader" id="tpro-preloader-' . $post_id . '" style="' . $preloader_style . '"><img src="' . SP_TPRO_URL . 'admin/assets/images/preloader.gif"/></div>';
				}
				$data_attr  = '';
				$data_attr .= 'data-testimonial=\'{
					"thumbnailSlider": ' . $thumbnail_slider . '
				}\'';
				$data_attr .= 'data-preloader=\'' . $preloader . '\'';

				if ( 'content_with_limit' == $testimonial_content_type && $testimonial_read_more && 'expand' == $testimonial_read_more_link_action ) {
					$outline .= '<div class="sp-tpro-rm-config">' . json_encode( $tpro_read_more_config ) . '</div>';
				}

				if ( $section_title ) {
					$outline .= '<h2 class="sp-testimonial-pro-section-title">' . get_the_title( $post_id ) . '</h2>';
				}

				$outline .= '<script>
					jQuery(document).ready(function() {
						jQuery("#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section-thumb").slick({
						slidesToShow: 5,
						slidesToScroll: 1,
						asNavFor: "#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section-content",
						arrows: false,
						dots: false,
						centerMode: true,
						centerPadding: 0,
						focusOnSelect: true,
						pauseOnFocus: false,
						autoplay: ' . $slider_auto_play . ',
						autoplaySpeed: ' . $slider_auto_play_speed . ',
						speed: ' . $slider_scroll_speed . ',
						pauseOnHover: ' . $slider_pause_on_hover_thumb . ',
						swipe: ' . $slider_swipe_thumb . ',
						swipeToSlide: ' . $swipe_to_slide . ',
						draggable: ' . $slider_draggable_thumb . ',
						rtl: ' . $rtl_mode . ',
						});
						jQuery("#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section-content").slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: ' . $navigation_arrows . ',
						adaptiveHeight: ' . $adaptive_height . ',
						prevArrow: "<div class=\'slick-prev\'><i class=\'fa fa-' . $navigation_icons . '-left\'></i></div>",
						nextArrow: "<div class=\'slick-next\'><i class=\'fa fa-' . $navigation_icons . '-right\'></i></div>",
						dots: ' . $pagination_dots . ',
						fade: ' . $slider_fade_effect_thumb . ',
						pauseOnFocus: false,
						asNavFor: "#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section-thumb",
						autoplay: ' . $slider_auto_play . ',
						autoplaySpeed: ' . $slider_auto_play_speed . ',
						speed: ' . $slider_scroll_speed . ',
						pauseOnHover: ' . $slider_pause_on_hover_thumb . ',
						swipe: ' . $slider_swipe_thumb . ',
						swipeToSlide: ' . $swipe_to_slide . ',
						draggable: ' . $slider_draggable_thumb . ',
						rtl: ' . $rtl_mode . ',
						responsive: [
								{
								breakpoint: 1280,
								settings: {
									slidesToShow: ' . $columns_desktop . '
								}
								},
								{
								breakpoint: 980,
								settings: {
									slidesToShow: ' . $columns_laptop . '
								}
								},
								{
								breakpoint: 736,
								settings: {
									slidesToShow: ' . $columns_tablet . '
								}
								},
								{
								breakpoint: 480,
								settings: {
									slidesToShow: ' . $columns_mobile . ',
									dots: ' . $pagination_mobile . ',
									arrows: ' . $navigation_mobile . ',
									autoplay: ' . $slider_auto_play_mobile . ',
								}
								}
							]
						});

					});

				</script>';

				$outline .= '<div id="sp-testimonial-pro-' . $post_id . '" ' . $the_rtl . ' ' . $data_attr . ' class="sp-testimonial-pro-section sp-testimonial-pro-section-thumb">';

				if ( $post_query->have_posts() ) {
					while ( $post_query->have_posts() ) :
						$post_query->the_post();

						$outline .= '<div class="sp-testimonial-pro-item">';

						if ( $client_image && has_post_thumbnail( $post_query->post->ID ) ) {
							$image_id         = get_post_thumbnail_id();
							$image_full_url   = wp_get_attachment_image_src( $image_id, 'full' );
							$image_url        = wp_get_attachment_image_src( $image_id, $image_sizes );
							$image_resize_url = '';
							if ( ( 'custom' === $image_sizes ) && ( ! empty( $client_image_width ) && $image_full_url[1] >= $client_image_width ) && ( ! empty( $client_image_height ) ) && $image_full_url[2] >= $client_image_height ) {
								$image_resize_url = sp_tpro_resize( $image_full_url[0], $client_image_width, $client_image_height, $client_image_crop );
							}
							$image_src = ! empty( $image_resize_url ) ? $image_resize_url : $image_url[0];
							$outline  .= sprintf( '<div class="tpro-client-image tpro-image-style-' . $client_image_style . '"><img src="%1$s"></div>', $image_src );
						}

						$outline .= '</div>'; // sp-testimonial-pro-item.

					endwhile;
				}
				$outline .= '</div>'; // sp-testimonial-pro.

				if ( $testimonial_read_more ) {
					$testimonial_read_more_class = 'true';
				}
				$outline .= '<div id="sp-testimonial-pro-' . $post_id . '" ' . $the_rtl . ' class="sp-testimonial-pro-section sp-testimonial-pro-read-more tpro-readmore-' . $testimonial_read_more_link_action . '-' . $testimonial_read_more_class . ' sp-testimonial-pro-section-content tpro-style-' . $theme_style . '">';

				if ( $post_query->have_posts() ) {
					while ( $post_query->have_posts() ) :
						$post_query->the_post();

						$outline          .= '<div class="sp-testimonial-pro-item">';
						$testimonial_data  = get_post_meta( get_the_ID(), 'sp_tpro_meta_options', true );
						$tpro_rating_star  = ( isset( $testimonial_data['tpro_rating'] ) ? $testimonial_data['tpro_rating'] : '' );
						$tpro_designation  = ( isset( $testimonial_data['tpro_designation'] ) ? $testimonial_data['tpro_designation'] : '' );
						$tpro_name         = ( isset( $testimonial_data['tpro_name'] ) ? $testimonial_data['tpro_name'] : '' );
						$tpro_company_name = ( isset( $testimonial_data['tpro_company_name'] ) ? $testimonial_data['tpro_company_name'] : '' );
						$tpro_website      = ( isset( $testimonial_data['tpro_website'] ) ? $testimonial_data['tpro_website'] : '' );
						$tpro_location     = ( isset( $testimonial_data['tpro_location'] ) ? $testimonial_data['tpro_location'] : '' );
						$tpro_phone        = ( isset( $testimonial_data['tpro_phone'] ) ? $testimonial_data['tpro_phone'] : '' );
						$tpro_email        = ( isset( $testimonial_data['tpro_email'] ) ? $testimonial_data['tpro_email'] : '' );

						$t_cat_terms = get_the_terms( get_the_ID(), 'testimonial_cat' );
						if ( $t_cat_terms && ! is_wp_error( $t_cat_terms ) && ! empty( $t_cat_terms ) ) {
							$t_cat_name = array();
							foreach ( $t_cat_terms as $t_cat_term ) {
								$t_cat_name[] = $t_cat_term->name;
							}
							$tpro_itemreviewed = $t_cat_name[0];
						} else {
							$tpro_itemreviewed = $tpro_global_item_name;
						}

						$full_content         = apply_filters( 'the_content', get_the_content() );
						$stringall            = strlen( $full_content );
						$striphtml            = strip_tags( $full_content );
						$stringnohtml         = strlen( $striphtml );
						$differ               = ( $stringall - $stringnohtml );
						$short_content        = substr( $full_content, 0, $differ + $testimonial_characters_limit );
						$count                = strlen( $full_content );
						$testimonial_ellipsis = $count >= $testimonial_characters_limit ? $testimonial_read_more_ellipsis : '';
						$review_text          = ( 'full_content' == $testimonial_content_type || $testimonial_read_more && 'expand' == $testimonial_read_more_link_action ) ? $full_content : $short_content . $testimonial_ellipsis;

						switch ( $testimonial_read_more_link_action ) {
							case 'expand':
								$read_more_data = '<a href="#" class="tpro-read-more"></a>';
								break;
							case 'popup':
								$read_more_data = sprintf( '<a href="#" data-remodal-target="sp-tpro-testimonial-id-%1$s" class="tpro-read-more">%2$s</a>', get_the_ID(), $testimonial_read_more_text );
								break;
						}
						$read_more_link      = ( $count >= $testimonial_characters_limit && $testimonial_read_more && 'content_with_limit' == $testimonial_content_type ) ? $read_more_data : '';
						$review_content_data = sprintf( '<div class="tpro-client-testimonial"><div class="tpro-testimonial-text">%1$s</div>%2$s</div>', apply_filters( 'the_content', $review_text ), $read_more_link );
						$review_content      = $testimonial_text ? $review_content_data : '';

						$review_title_data = sprintf( '<div class="tpro-testimonial-title"><' . $testimonial_title_tag . ' class="sp-tpro-testimonial-title">%1$s</' . $testimonial_title_tag . '></div>', get_the_title() );
						$review_title      = $testimonial_title ? $review_title_data : '';

						$client_name_data = sprintf( '<%2$s class="tpro-client-name">%1$s</%2$s>', $tpro_name, $testimonial_client_name_tag );
						$client_name      = $testimonial_client_name ? $client_name_data : '';

						$outline .= $review_title . $review_content . $client_name;

						if ( $testimonial_client_rating && '' !== $tpro_rating_star ) {
							include SP_TPRO_PATH . '/public/views/content/rating.php';
						}

						if ( $client_designation && '' !== $tpro_designation || $client_company_name && '' !== $tpro_company_name ) {
							$outline .= '<div class="tpro-client-designation-company">';
							if ( $identity_linking_website && '' !== $tpro_website ) {
								$outline .= '<a target="' . $website_link_target . '" href="' . esc_url( $tpro_website ) . '">';
							}
							if ( $client_designation && '' !== $tpro_designation ) {
								$outline .= $tpro_designation;
							}
							if ( $client_designation && '' !== $tpro_designation && $client_company_name && '' !== $tpro_company_name ) {
								$outline .= ' - ';
							}
							if ( $client_company_name && '' !== $tpro_company_name ) {
								$outline .= $tpro_company_name;
							}
							if ( $identity_linking_website && '' !== $tpro_website ) {
								$outline .= '</a>';
							}
							$outline .= '</div>';
						}
						if ( $testimonial_client_location && '' !== $tpro_location ) {
							$outline .= '<div class="tpro-client-location">' . $tpro_location . '</div>';
						}
						if ( $testimonial_client_phone && '' !== $tpro_phone ) {
							$outline .= '<div class="tpro-client-phone">' . $tpro_phone . '</div>';
						}
						if ( $testimonial_client_email && '' !== $tpro_email ) {
							$outline .= '<div class="tpro-client-email">' . $tpro_email . '</div>';
						}
						if ( $testimonial_client_date ) {
							$outline .= '<div class="tpro-testimonial-date">' . get_the_date( $testimonial_client_date_format ) . '</div>';
						}
						if ( $testimonial_client_website && '' !== $tpro_website ) {
							$outline .= '<div class="tpro-client-website"><a target="' . $website_link_target . '" href="' . esc_url( $tpro_website ) . '">' . $tpro_website . '</a></div>';
						}

						include SP_TPRO_PATH . '/public/views/content/social-profile.php';

						// Modal Start.
						if ( $testimonial_read_more && $testimonial_read_more_link_action == 'popup' ) {
							if ( $client_image && has_post_thumbnail( $post_query->post->ID ) ) {
								$image_id         = get_post_thumbnail_id();
								$image_full_url   = wp_get_attachment_image_src( $image_id, 'full' );
								$image_url        = wp_get_attachment_image_src( $image_id, $image_sizes );
								$image_resize_url = '';
								if ( ( 'custom' === $image_sizes ) && ( ! empty( $client_image_width ) && $image_full_url[1] >= $client_image_width ) && ( ! empty( $client_image_height ) ) && $image_full_url[2] >= $client_image_height ) {
									$image_resize_url = sp_tpro_resize( $image_full_url[0], $client_image_width, $client_image_height, $client_image_crop );
								}
								$image_src = ! empty( $image_resize_url ) ? $image_resize_url : $image_url[0];
							}
							include SP_TPRO_PATH . '/public/views/content/popup.php';
						} // Modal End.

						$outline .= '</div>'; // sp-testimonial-pro-item.

					endwhile;
				}

				$outline .= '</div>';
				$outline .= '</div>';

			} else {
				$outline .= '<div id="sp-testimonial-pro-wrapper-' . $post_id . '" class="sp-testimonial-pro-wrapper sp_tpro_nav_position_' . $navigation_position . '">';

				if ( $preloader ) {
					$preloader_style = ( $preloader ) ? '' : 'display: none;';
					$outline        .= '<div class="tpro-preloader" id="tpro-preloader-' . $post_id . '" style="' . $preloader_style . '"><img src="' . SP_TPRO_URL . 'admin/assets/images/preloader.gif"/></div>';
				}

				$data_attr  = '';
				$data_attr .= 'data-testimonial=\'{
					"videoIcon": ' . $video_icon . ',
					"thumbnailSlider": ' . $thumbnail_slider . '
				}\'';
				$data_attr .= 'data-preloader=\'' . $preloader . '\'';
				switch ( $layout ) {
					case 'slider':
						if ( 'ticker' == $slider_mode ) {
							$data_attr .= 'data-slick=\'{"pauseOnHover": ' . $slider_pause_on_hover . ', "slidesToShow": ' . $columns_large_desktop . ', "speed": ' . $slider_scroll_speed . ', "rtl": ' . $rtl_mode . ', "infinite": ' . $slider_infinite . ', "responsive": [ {"breakpoint": 1280, "settings": { "slidesToShow": ' . $columns_desktop . ' } }, {"breakpoint": 980, "settings": { "slidesToShow": ' . $columns_laptop . ' } }, {"breakpoint": 736, "settings": { "slidesToShow": ' . $columns_tablet . ' } }, {"breakpoint": 480, "settings": { "slidesToShow": ' . $columns_mobile . ' } } ] }\'';
						} else {
							$data_attr .= 'data-arrowicon="' . $navigation_icons . '" data-slick=\'{"dots": ' . $pagination_dots . ', "adaptiveHeight": ' . $adaptive_height . ', "rows": ' . $row_large_desktop . ', "pauseOnHover": ' . $slider_pause_on_hover . ', "slidesToShow": ' . $columns_large_desktop . ', "speed": ' . $slider_scroll_speed . ', "arrows": ' . $navigation_arrows . ', "autoplay": ' . $slider_auto_play . ', "autoplaySpeed": ' . $slider_auto_play_speed . ', "swipe": ' . $slider_swipe . ', "swipeToSlide": ' . $swipe_to_slide . ', "draggable": ' . $slider_draggable . ', "rtl": ' . $rtl_mode . ', "infinite": ' . $slider_infinite . ', "slidesToScroll": ' . $slide_to_scroll_large_desktop . ', "fade": ' . $slider_fade_effect . ', "responsive": [ {"breakpoint": 1280, "settings": { "slidesToShow": ' . $columns_desktop . ', "slidesToScroll": ' . $slide_to_scroll_desktop . ', "rows": ' . $row_desktop . ' } }, {"breakpoint": 980, "settings": { "slidesToShow": ' . $columns_laptop . ', "slidesToScroll": ' . $slide_to_scroll_laptop . ', "rows": ' . $row_laptop . ' } }, {"breakpoint": 736, "settings": { "slidesToShow": ' . $columns_tablet . ', "slidesToScroll": ' . $slide_to_scroll_tablet . ', "rows": ' . $row_tablet . ' } }, {"breakpoint": 480, "settings": { "slidesToShow": ' . $columns_mobile . ', "slidesToScroll": ' . $slide_to_scroll_mobile . ', "rows": ' . $row_mobile . ', "dots": ' . $pagination_mobile . ', "autoplay": ' . $slider_auto_play_mobile . ', "arrows": ' . $navigation_mobile . ' } } ] }\'';
						}
						break;
					case 'filter':
						$outline .= '<div class="sp-tpro-config">' . json_encode( $tpro_filter_config ) . '</div>';
						break;
				}

				if ( 'content_with_limit' == $testimonial_content_type && $testimonial_read_more && 'expand' == $testimonial_read_more_link_action ) {
					$outline .= '<div class="sp-tpro-rm-config">' . json_encode( $tpro_read_more_config ) . '</div>';
				}

				if ( $section_title ) {
					$outline .= '<h2 class="sp-testimonial-pro-section-title">' . get_the_title( $post_id ) . '</h2>';
				}

				if ( $testimonial_read_more ) {
					$testimonial_read_more_class = 'true';
				}
				$outline .= '<div id="sp-testimonial-pro-' . $post_id . '" ' . $the_rtl . ' ' . $data_attr . ' class="sp-testimonial-pro-section ' . $pagination_type . ' tpro-layout-' . $layout . '-' . $slider_mode . ' sp-testimonial-pro-read-more tpro-readmore-' . $testimonial_read_more_link_action . '-' . $testimonial_read_more_class . ' ';

				if ( $layout == 'masonry' ) {
					$outline .= 'sp_testimonial_pro_masonry ';
				} elseif ( $layout == 'filter' ) {
					$outline .= 'sp_testimonial_pro_filter ';
				}
				$outline .= 'tpro-style-' . $theme_style . '">';

				if ( $layout == 'filter' ) {
					if ( ! is_tax() ) {

						$terms = get_terms(
							array(
								'taxonomy'   => 'testimonial_cat',
								'hide_empty' => true,
							)
						);
						$count = count( $terms );

						if ( $count > 0 ) {

							$outline .= '<div class="sp-tpro-filter"><ul class="sp-tpro-items-filter">';
							if ( $all_tab_show ) {
								$outline .= '<li><a href="#" class="active"  data-filter="*">' . $all_tab_text . '</a></li>';
							}

							if ( ! empty( $category_list ) && 'category' === $display_testimonials_from ) {
								foreach ( $category_list as $cat_id ) {
									$cat_list = get_term( $cat_id );
									if ( isset( $cat_list->name ) ) {
										$outline .= '<li><a href="#" data-filter=".testimonial_cat-' . $cat_list->slug . '">' . $cat_list->name . '</a></li>';
									}
								}
							} else {
								foreach ( $terms as $term ) {
									if ( isset( $term->name ) ) {
										$outline .= '<li><a href="#" data-filter=".testimonial_cat-' . $term->slug . '">' . $term->name . '</a></li>';
									}
								}
							}
							$outline .= '</ul></div>';
						}
					}
					$outline .= '<div class="sp-tpro-isotope-items">';
				}

				if ( 'grid' == $layout || 'masonry' == $layout || 'list' == $layout ) {
					$outline .= '<div class="sp-tpro-items">';
				}
				if ( $post_query->have_posts() ) {
					while ( $post_query->have_posts() ) :
						$post_query->the_post();

						$testimonial_data  = get_post_meta( get_the_ID(), 'sp_tpro_meta_options', true );
						$tpro_rating_star  = ( isset( $testimonial_data['tpro_rating'] ) ? $testimonial_data['tpro_rating'] : '' );
						$tpro_designation  = ( isset( $testimonial_data['tpro_designation'] ) ? $testimonial_data['tpro_designation'] : '' );
						$tpro_name         = ( isset( $testimonial_data['tpro_name'] ) ? $testimonial_data['tpro_name'] : '' );
						$tpro_company_name = ( isset( $testimonial_data['tpro_company_name'] ) ? $testimonial_data['tpro_company_name'] : '' );
						$tpro_website      = ( isset( $testimonial_data['tpro_website'] ) ? $testimonial_data['tpro_website'] : '' );
						$tpro_location     = ( isset( $testimonial_data['tpro_location'] ) ? $testimonial_data['tpro_location'] : '' );
						$tpro_phone        = ( isset( $testimonial_data['tpro_phone'] ) ? $testimonial_data['tpro_phone'] : '' );
						$tpro_email        = ( isset( $testimonial_data['tpro_email'] ) ? $testimonial_data['tpro_email'] : '' );

						if ( $client_image && has_post_thumbnail( $post_query->post->ID ) ) {

							$video_url         = isset( $testimonial_data['tpro_video_url'] ) ? $testimonial_data['tpro_video_url'] : '';
							$video_before_data = sprintf( '<a href="%1$s" class="sp-tpro-video">', $video_url );
							$video_after_data  = '<i class="fa fa-play-circle-o" aria-hidden="true"></i></a>';
							$video_before      = ! empty( $video_url ) && $video_icon ? $video_before_data : '';
							$video_after       = ! empty( $video_url ) && $video_icon ? $video_after_data : '';

							$image_id         = get_post_thumbnail_id();
							$image_full_url   = wp_get_attachment_image_src( $image_id, 'full' );
							$image_url        = wp_get_attachment_image_src( $image_id, $image_sizes );
							$image_resize_url = '';
							if ( ( 'custom' === $image_sizes ) && ( ! empty( $client_image_width ) && $image_full_url[1] >= $client_image_width ) && ( ! empty( $client_image_height ) ) && $image_full_url[2] >= $client_image_height ) {
								$image_resize_url = sp_tpro_resize( $image_full_url[0], $client_image_width, $client_image_height, $client_image_crop );
							}
							$image_src = ! empty( $image_resize_url ) ? $image_resize_url : $image_url[0];
							$image     = sprintf( '%1$s<img src="%2$s" class="tpro-grayscale-%4$s">%3$s', $video_before, $image_src, $video_after, $image_grayscale );
						}

						$full_content         = apply_filters( 'the_content', get_the_content() );
						$total_char           = substr( $full_content, 0, $testimonial_characters_limit );
						$striphtml            = strlen( strip_tags( $total_char ) );
						$differ               = ( $testimonial_characters_limit - $striphtml );
						$count                = strlen( $full_content );
						$testimonial_ellipsis = $count >= $testimonial_characters_limit ? $testimonial_read_more_ellipsis : '';
						$short_content        = substr( $full_content, 0, $differ + $testimonial_characters_limit );

						$review_text = ( 'full_content' == $testimonial_content_type || $testimonial_read_more && 'expand' == $testimonial_read_more_link_action ) ? $full_content : $short_content . $testimonial_ellipsis;
						switch ( $testimonial_read_more_link_action ) {
							case 'expand':
								$read_more_data = '<a href="#" class="tpro-read-more"></a>';
								break;
							case 'popup':
								$read_more_data = sprintf( '<a href="#" data-remodal-target="sp-tpro-testimonial-id-%1$s" class="tpro-read-more">%2$s</a>', get_the_ID(), $testimonial_read_more_text );
								break;
						}
						$read_more_link      = ( $count >= $testimonial_characters_limit && $testimonial_read_more && 'content_with_limit' == $testimonial_content_type ) ? $read_more_data : '';
						$review_content_data = sprintf( '<div class="tpro-client-testimonial"><div class="tpro-testimonial-text">%1$s</div>%2$s</div>', apply_filters( 'the_content', $review_text ), $read_more_link );
						$review_content      = $testimonial_text ? $review_content_data : '';

						$review_title_data = sprintf( '<div class="tpro-testimonial-title"><' . $testimonial_title_tag . ' class="sp-tpro-testimonial-title">%1$s</' . $testimonial_title_tag . '></div>', get_the_title() );
						$review_title      = $testimonial_title ? $review_title_data : '';

						$client_name_data = sprintf( '<%2$s class="tpro-client-name">%1$s</%2$s>', $tpro_name, $testimonial_client_name_tag );
						$client_name      = $testimonial_client_name ? $client_name_data : '';

						switch ( $layout ) {
							case 'grid':
							case 'masonry':
							case 'filter':
								$layout_class = sprintf( ( join( ' ', get_post_class( 'tpro-col-xl-%1$s tpro-col-lg-%2$s tpro-col-md-%3$s tpro-col-sm-%4$s tpro-col-xs-%5$s' ) ) ), $columns_large_desktop, $columns_desktop, $columns_laptop, $columns_tablet, $columns_mobile );
								break;
							default:
								$layout_class = '';
								break;
						}

						$outline .= sprintf( '<div class="sp-testimonial-pro-item %1$s"><div class="sp-testimonial-pro">', $layout_class );

						$t_cat_terms = get_the_terms( get_the_ID(), 'testimonial_cat' );
						if ( $t_cat_terms && ! is_wp_error( $t_cat_terms ) && ! empty( $t_cat_terms ) ) {
							$t_cat_name = array();
							foreach ( $t_cat_terms as $t_cat_term ) {
								$t_cat_name[] = $t_cat_term->name;
							}
							$tpro_itemreviewed = $t_cat_name[0];
						} else {
							$tpro_itemreviewed = $tpro_global_item_name;
						}

						switch ( $theme_style ) {
							case 'theme-one':
								include SP_TPRO_PATH . '/public/views/templates/theme-one.php';
								break;
							case 'theme-two':
								include SP_TPRO_PATH . '/public/views/templates/theme-two.php';
								break;
							case 'theme-three':
								include SP_TPRO_PATH . '/public/views/templates/theme-three.php';
								break;
							case 'theme-four':
								include SP_TPRO_PATH . '/public/views/templates/theme-four.php';
								break;
							case 'theme-five':
								include SP_TPRO_PATH . '/public/views/templates/theme-five.php';
								break;
							case 'theme-six':
								include SP_TPRO_PATH . '/public/views/templates/theme-six.php';
								break;
							case 'theme-seven':
								include SP_TPRO_PATH . '/public/views/templates/theme-seven.php';
								break;
							case 'theme-eight':
								include SP_TPRO_PATH . '/public/views/templates/theme-eight.php';
								break;
							case 'theme-nine':
								include SP_TPRO_PATH . '/public/views/templates/theme-nine.php';
								break;
							case 'theme-ten':
								include SP_TPRO_PATH . '/public/views/templates/theme-ten.php';
								break;
						}

						$outline .= '</div>'; // sp-testimonial-pro.
						// Modal Start.
						if ( $testimonial_read_more && $testimonial_read_more_link_action == 'popup' ) {
							include SP_TPRO_PATH . '/public/views/content/popup.php';
						}// Modal End.
						$outline .= '</div>'; // sp-testimonial-pro-item.

					endwhile;
				} else {
					$outline .= '<h2 class="sp-not-found-any-testimonial">' . esc_html__( 'No testimonials found', 'testimonial-pro' ) . '</h2>';
				}
				if ( 'filter' === $layout || 'grid' === $layout || 'masonry' === $layout || 'list' === $layout ) {
					$outline .= '</div>'; // sp-tpro-items.
				}

				// Pagination.
				if ( $post_query->max_num_pages > 1 ) {
					if ( $layout == 'grid' && $grid_pagination || $layout == 'masonry' && $grid_pagination || $layout == 'list' && $grid_pagination ) {
						$outline         .= '<div class="tpro-col-xl-1 sp-tpro-pagination-area">';
							$paged_format = '?paged' . $post_id . '=%#%';
							$paged_query  = 'paged' . $post_id;
						$big              = 999999999; // need an unlikely integer.

						$items       = paginate_links(
							array(
								// 'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'    => $paged_format,
								'prev_next' => true,
								// 'current'   => max( 1, get_query_var( $paged_query ) ),
								'current'   => isset( $_GET[ "$paged_query" ] ) ? $_GET[ "$paged_query" ] : 1,
								'total'     => $post_query->max_num_pages,
								'type'      => 'array',
								'prev_text' => '<i class="fa fa-angle-left"></i>',
								'next_text' => '<i class="fa fa-angle-right"></i>',
							)
						);
						$pagination  = "<ul class=\"sp-tpro-pagination\">\n\t<li>";
						$pagination .= join( "</li>\n\t<li>", $items );
						$pagination .= "</li>\n</ul>\n";

						$outline      .= $pagination;
						$tp_error_text = __( 'No more testimonials to load', 'testimonial-pro' );
						$tp_end_text   = __( 'End of content', 'testimonial-pro' );
						$outline      .= '</div>';
						if ( 'ajax_load_more' === $pagination_type || 'infinite_scroll' === $pagination_type ) {
							$outline .= '<div class="page-load-status">
										<div class="loader-ellips infinite-scroll-request">
											<p>
												<span class="loader-ellips__dot"></span>
												<span class="loader-ellips__dot"></span>
												<span class="loader-ellips__dot"></span>
												<span class="loader-ellips__dot"></span>
											</p>
										</div>
										<p class="infinite-scroll-last">' . $tp_end_text . '</p>
										<p class="infinite-scroll-error">' . $tp_error_text . '</p>
									</div>';
						}
						if ( 'ajax_load_more' === $pagination_type ) {
							$outline .= '<div class="tpro-items-load-more"><span>' . $load_more_label . '</span></div>';
						}
					}
				}

				$outline .= '</div>';
				$outline .= '</div>';

			}

			wp_reset_postdata();

			return $outline;

		}

		/**
		 * The font variants for the Advanced Typography.
		 *
		 * @param string $sp_tpro_font_variant The typography field ID with.
		 * @return string
		 * @since 1.0
		 */
		private function tpro_the_font_variants( $sp_tpro_font_variant, $font_style = 'normal' ) {
			$filter_style  = isset( $font_style ) && ! empty( $font_style ) ? $font_style : 'normal';
			$filter_weight = isset( $sp_tpro_font_variant ) && ! empty( $sp_tpro_font_variant ) ? $sp_tpro_font_variant : '400';

			return 'font-style: ' . $filter_style . '; font-weight: ' . $filter_weight . ';';
		}
		/**
		 * Advanced Typography Output.
		 *
		 * @param string $tpro_normal_typography The typography array.
		 * @param string $font_load The typography font load conditions.
		 * @return string
		 * @since 1.0
		 */
		private function tpro_typography_output( $tpro_normal_typography, $font_load ) {
			$typo = '';
			if ( isset( $tpro_normal_typography['color'] ) ) {
				$typo .= 'color: ' . $tpro_normal_typography['color'] . ';';
			}
			if ( isset( $tpro_normal_typography['font-size'] ) ) {
				$typo .= 'font-size: ' . $tpro_normal_typography['font-size'] . 'px;';
			}
			if ( isset( $tpro_normal_typography['line-height'] ) ) {
				$typo .= 'line-height: ' . $tpro_normal_typography['line-height'] . 'px;';
			}
			if ( isset( $tpro_normal_typography['text-transform'] ) ) {
				$typo .= 'text-transform: ' . $tpro_normal_typography['text-transform'] . ';';
			}
			if ( isset( $tpro_normal_typography['letter-spacing'] ) ) {
				$typo .= 'letter-spacing: ' . $tpro_normal_typography['letter-spacing'] . ';';
			}
			if ( isset( $tpro_normal_typography['text-align'] ) ) {
				$typo .= 'text-align: ' . $tpro_normal_typography['text-align'] . ';';
			}
			if ( $font_load ) {
				$typo .= ' font-family: ' . $tpro_normal_typography['font-family'] . ';
			' . $this->tpro_the_font_variants( $tpro_normal_typography['font-weight'], $tpro_normal_typography['font-style'] );
			}
			return $typo;
		}
		/**
		 * Advanced Typography Output.
		 *
		 * @param string $tpro_normal_typography The typography array.
		 * @param string $font_load The typography font load conditions.
		 * @return string
		 * @since 1.0
		 */
		private function tpro_typography_modal_output( $tpro_normal_typography, $font_load ) {
			$typo = 'color: #444444; text-align: center;';
			if ( isset( $tpro_normal_typography['font-size'] ) ) {
				$typo .= 'font-size: ' . $tpro_normal_typography['font-size'] . 'px;';
			}
			if ( isset( $tpro_normal_typography['line-height'] ) ) {
				$typo .= 'line-height: ' . $tpro_normal_typography['line-height'] . 'px;';
			}if ( isset( $tpro_normal_typography['text-transform'] ) ) {
				$typo .= 'text-transform: ' . $tpro_normal_typography['text-transform'] . ';';
			}
			if ( isset( $tpro_normal_typography['letter-spacing'] ) ) {
				$typo .= 'letter-spacing: ' . $tpro_normal_typography['letter-spacing'] . ';';
			}
			if ( $font_load ) {
				$typo .= '
			font-family: ' . $tpro_normal_typography['font-family'] . '; ' . $this->tpro_the_font_variants( $tpro_normal_typography['font-weight'], $tpro_normal_typography['font-style'] ) . ';
			';
			}
			return $typo;
		}
	}

	new TPRO_Shortcode_Render();
}

<?php
$client_image_bg = isset( $shortcode_data['client_image_bg'] ) ? $shortcode_data['client_image_bg'] : '#ffffff';
$video_icon_color = isset( $shortcode_data['video_icon_color'] ) ? $shortcode_data['video_icon_color'] : '#e2e2e2';
$video_icon_overlay = isset( $shortcode_data['video_icon_overlay'] ) ? $shortcode_data['video_icon_overlay'] : 'rgba(51, 51, 51, 0.4)';
$client_image_border_shadow = isset( $shortcode_data['client_image_border_shadow'] ) ? $shortcode_data['client_image_border_shadow'] : 'border';

$outline .= '<style type="text/css">';

if ( $section_title ) {
	$outline         .= '#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section-title{
			margin: 0;
            padding: 0;
		    margin-bottom: ' . $section_title_typography['margin-bottom'] . 'px;';
			$outline .= $this->tpro_typography_output( $section_title_typography, $section_title_font_load );
			$outline .= '}';
}

if ( $layout == 'slider' ) {
	$outline .= '
	#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section {
	    display: none;
	}
	#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section.slick-initialized {
	    display: block;
	}
	';
} elseif ( $layout == 'grid' || $layout == 'masonry' || $layout == 'list' || $layout == 'filter' ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro-item{
		margin-bottom: ' . $testimonial_margin . 'px;
	}';
}
$testimonial_info_border_color = isset( $shortcode_data['testimonial_info_border']['color'] ) ?  $shortcode_data['testimonial_info_border']['color'] : '#e3e3e3';
if ( $layout == 'filter' ) {
	$filter_colors = isset( $shortcode_data['filter_colors'] ) ? $shortcode_data['filter_colors'] : '';
	$filter_border = isset( $shortcode_data['filter_border'] ) ? $shortcode_data['filter_border'] : '';
	if ( isset( $shortcode_data['filter_border'] ) ) {
		$filter_border        = $filter_border['all'] . 'px ' . $filter_border['style'] . ' ' . $filter_border['color'];
		$filter_active_border = $shortcode_data['filter_border']['hover-color'];
	} else {
		$filter_border        = '2px solid #bbbbbb';
		$filter_active_border = '#1595CE';
	}
	$outline     .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section.sp_testimonial_pro_filter .sp-tpro-filter{
		text-align: ' . $shortcode_data['filter_alignment'] . ';
		margin-right:' . $testimonial_margin . 'px;
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section.sp_testimonial_pro_filter ul.sp-tpro-items-filter{
		margin: ' . $filter_margin['top'] . 'px ' . $filter_margin['right'] . 'px ' . $filter_margin['bottom'] . 'px ' . $filter_margin['left'] . 'px;
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section.sp_testimonial_pro_filter ul.sp-tpro-items-filter li a{
		color: ' . $filter_colors['color'] . ';
		border: ' . $filter_border . ';
		background: ' . $filter_colors['background'] . ';';
		$outline .= $this->tpro_typography_output( $filter_typography, $filter_font_load );
		$outline .= '}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section.sp_testimonial_pro_filter ul.sp-tpro-items-filter li a.active{
		color: ' . $filter_colors['active-color'] . ';
		background: ' . $filter_colors['active-background'] . ';
		border-color: ' . $filter_active_border . ';
	}';
}

if ( $testimonial_read_more ) {
	$popup_background      = isset( $shortcode_data['popup_background'] ) ? $shortcode_data['popup_background'] : '#ffffff';
	$read_more_colors      = isset( $shortcode_data['testimonial_readmore_color'] ) ? $shortcode_data['testimonial_readmore_color'] : '';
	$read_more_color       = isset( $read_more_colors['color'] ) ? $read_more_colors['color'] : '';
	$read_more_hover_color = isset( $read_more_colors['hover-color'] ) ? $read_more_colors['hover-color'] : '';
	$outline              .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section a.tpro-read-more{
		color: ' . $read_more_color . ';
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section a.tpro-read-more:hover{
		color: ' . $read_more_hover_color . ';
	}
	.sp-tpro-modal-testimonial-'. $post_id .'.remodal.sp-tpro-modal-testimonial{background: ' . $popup_background . '}';
}

// if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-three' || $theme_style == 'theme-four' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-eight' || $theme_style == 'theme-nine' || $theme_style == 'theme-ten' ) {

if ( $layout !== 'list' ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro-item{
	padding-right:' . $testimonial_margin . 'px; } #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-tpro-items{
	margin-right:-' . $testimonial_margin . 'px; }';
}
// }

if ( $client_image ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image .sp-tpro-video i.fa{
		color: ' . $video_icon_color . ';
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image .sp-tpro-video:before{
		background: ' . $video_icon_overlay . ';
	}';
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-eight' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
			margin: ' . $client_image_margin['top'] . 'px ' . $client_image_margin['right'] . 'px ' . $client_image_margin['bottom'] . 'px ' . $client_image_margin['left'] . 'px;
			text-align: ' . $client_image_position . ';
		}';
	}
	if ( $theme_style == 'theme-ten' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
			margin: ' . $client_image_margin['top'] . 'px ' . $client_image_margin['right'] . 'px ' . $client_image_margin['bottom'] . 'px ' . $client_image_margin['left'] . 'px;
			text-align: ' . $client_image_position . ';
			z-index: 2;
            position: relative;
		}';
	}
	if ( $theme_style == 'theme-nine' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
			margin: ' . $client_image_margin_tow['top'] . 'px ' . $client_image_margin_tow['right'] . 'px ' . $client_image_margin_tow['bottom'] . 'px ' . $client_image_margin_tow['left'] . 'px;
		}';
	}
	if ( $theme_style == 'theme-four' || $theme_style == 'theme-five' ) {
		if ( $client_image_position_two == 'left' ) {
			$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
				float: left;
				margin-right: 25px;
				margin-bottom: 15px;
			}';
		} elseif ( $client_image_position_two == 'right' ) {
			$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
				float: right;
				margin-left: 25px;
				margin-bottom: 15px;
			}';
		} elseif ( $client_image_position_two == 'top' ) {
			$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
				text-align: center;
                margin-bottom: 22px;
			}
			#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image img{
			    display: inline-block;
			}';
		} elseif ( $client_image_position_two == 'bottom' ) {
			$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image{
				text-align: center;
                margin-top: 22px;
			}
			#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image img{
			    display: inline-block;
			}';
		}
	}
	if ( $client_image_border_shadow == 'border' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image img,
		.sp-tpro-modal-testimonial-' . $post_id . ' .tpro-client-image img{
			background: ' . $client_image_bg . ';
			border: ' . $image_border_width . 'px ' . $image_border_style . ' ' . $image_border_color . ';
			padding: ' . $image_padding . 'px;
		}';
	} else {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-image img,
		.sp-tpro-modal-testimonial-' . $post_id . ' .tpro-client-image img{
			background: ' . $client_image_bg . ';
			padding: ' . $image_padding . 'px;
			box-shadow: 0px 0px 7px 0px ' . $shortcode_data['client_image_box_shadow_color'] . ';
            margin: 7px;
		}';
	}
}

if ( $testimonial_title ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title{
			margin: ' . $testimonial_title_typography['margin-top'] . 'px ' . $testimonial_title_typography['margin-right'] . 'px ' . $testimonial_title_typography['margin-bottom'] . 'px ' . $testimonial_title_typography['margin-left'] . 'px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title .sp-tpro-testimonial-title{';
		$outline     .= $this->tpro_typography_output( $testimonial_title_typography, $testimonial_title_font_load );
		$outline     .= 'padding: 0;
	        margin: 0;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-testimonial-title .sp-tpro-testimonial-title{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_title_typography, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title{
			margin: ' . $testimonial_title_typography['margin-top'] . 'px ' . $testimonial_title_typography['margin-right'] . 'px ' . $testimonial_title_typography['margin-bottom'] . 'px ' . $testimonial_title_typography['margin-left'] . 'px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title .sp-tpro-testimonial-title{';
		$outline     .= $this->tpro_typography_output( $testimonial_title_typography_two, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-testimonial-title .sp-tpro-testimonial-title{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_title_typography_two, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}';
	}
	if ( $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title{
			margin: ' . $testimonial_title_typography['margin-top'] . 'px ' . $testimonial_title_typography['margin-right'] . 'px ' . $testimonial_title_typography['margin-bottom'] . 'px ' . $testimonial_title_typography['margin-left'] . 'px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title .sp-tpro-testimonial-title{';
		$outline     .= $this->tpro_typography_output( $testimonial_title_typography_three, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-testimonial-title .sp-tpro-testimonial-title{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_title_typography_three, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}';
	}
	if ( $theme_style == 'theme-eight' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title{
			margin: ' . $testimonial_title_typography['margin-top'] . 'px ' . $testimonial_title_typography['margin-right'] . 'px ' . $testimonial_title_typography['margin-bottom'] . 'px ' . $testimonial_title_typography['margin-left'] . 'px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-title .sp-tpro-testimonial-title{';
		$outline     .= $this->tpro_typography_output( $testimonial_title_typography_four, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-testimonial-title .sp-tpro-testimonial-title{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_title_typography_four, $testimonial_title_font_load );
		$outline     .= '
			padding: 0;
	        margin: 0;
		}';
	}
}

if ( $testimonial_text ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-testimonial{';
		$outline     .= $this->tpro_typography_output( $testimonial_text_typography, $testimonial_text_font_load );
		$outline     .= 'margin: ' . $testimonial_text_typography['margin-top'] . 'px ' . $testimonial_text_typography['margin-right'] . 'px ' . $testimonial_text_typography['margin-bottom'] . 'px ' . $testimonial_text_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-testimonial{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_text_typography, $testimonial_text_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-testimonial{';
		$outline     .= $this->tpro_typography_output( $testimonial_text_typography_two, $testimonial_text_font_load );
		$outline     .= 'margin: ' . $testimonial_text_typography['margin-top'] . 'px ' . $testimonial_text_typography['margin-right'] . 'px ' . $testimonial_text_typography['margin-bottom'] . 'px ' . $testimonial_text_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-testimonial{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_text_typography_two, $testimonial_text_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-testimonial{';
		$outline     .= $this->tpro_typography_output( $testimonial_text_typography_three, $testimonial_text_font_load );
		$outline     .= 'margin: ' . $testimonial_text_typography['margin-top'] . 'px ' . $testimonial_text_typography['margin-right'] . 'px ' . $testimonial_text_typography['margin-bottom'] . 'px ' . $testimonial_text_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-testimonial{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_text_typography_three, $testimonial_text_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-eight' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-testimonial{';
		$outline     .= $this->tpro_typography_output( $testimonial_text_typography_four, $testimonial_text_font_load );
		$outline     .= 'margin: ' . $testimonial_text_typography['margin-top'] . 'px ' . $testimonial_text_typography['margin-right'] . 'px ' . $testimonial_text_typography['margin-bottom'] . 'px ' . $testimonial_text_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-testimonial{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_text_typography_four, $testimonial_text_font_load );
		$outline     .= '}';
	}
}

if ( $testimonial_client_name ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-name{';
		$outline     .= $this->tpro_typography_output( $client_name_typography, $testimonial_text_font_load );
		$outline     .= 'margin: ' . $client_name_typography['margin-top'] . 'px ' . $client_name_typography['margin-right'] . 'px ' . $client_name_typography['margin-bottom'] . 'px ' . $client_name_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-name{';
			$outline .= $this->tpro_typography_modal_output( $client_name_typography, $testimonial_text_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-name{';
		$outline     .= $this->tpro_typography_output( $client_name_typography_two, $testimonial_text_font_load );
		$outline     .= 'margin: ' . $client_name_typography['margin-top'] . 'px ' . $client_name_typography['margin-right'] . 'px ' . $client_name_typography['margin-bottom'] . 'px ' . $client_name_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-name{';
			$outline .= $this->tpro_typography_modal_output( $client_name_typography_two, $testimonial_text_font_load );
		$outline     .= '}';
	}
}

if ( $testimonial_client_rating ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-rating{
			margin: ' . $testimonial_client_rating_margin['top'] . 'px ' . $testimonial_client_rating_margin['right'] . 'px ' . $testimonial_client_rating_margin['bottom'] . 'px ' . $testimonial_client_rating_margin['left'] . 'px;
			text-align: ' . $testimonial_client_rating_alignment . ';
			color: ' . $shortcode_data['testimonial_client_rating_color'] . ';
		}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine'
	) {
		$outline .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-rating{
			margin: ' . $testimonial_client_rating_margin['top'] . 'px ' . $testimonial_client_rating_margin['right'] . 'px ' . $testimonial_client_rating_margin['bottom'] . 'px ' . $testimonial_client_rating_margin['left'] . 'px;
			text-align: ' . $testimonial_client_rating_alignment_two . ';
			color: ' . $shortcode_data['testimonial_client_rating_color'] . ';
		}';
	}
}

if ( $client_designation || $client_company_name ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-designation-company{';
		$outline     .= $this->tpro_typography_output( $client_designation_company_typography, $designation_company_font_load );
		$outline     .= 'margin: ' . $client_designation_company_typography['margin-top'] . 'px ' . $client_designation_company_typography['margin-right'] . 'px ' . $client_designation_company_typography['margin-bottom'] . 'px ' . $client_designation_company_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-designation-company{';
			$outline .= $this->tpro_typography_modal_output( $client_designation_company_typography, $designation_company_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine'
	) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-designation-company{';
		$outline     .= $this->tpro_typography_output( $client_designation_company_typography_two, $designation_company_font_load );
		$outline     .= 'margin: ' . $client_designation_company_typography['margin-top'] . 'px ' . $client_designation_company_typography['margin-right'] . 'px ' . $client_designation_company_typography['margin-bottom'] . 'px ' . $client_designation_company_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-designation-company{';
			$outline .= $this->tpro_typography_modal_output( $client_designation_company_typography_two, $designation_company_font_load );
		$outline     .= '}';
	}
}
if ( $testimonial_client_location ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-location{';
		$outline     .= $this->tpro_typography_output( $client_location_typography, $location_font_load );
		$outline     .= 'margin: ' . $client_location_typography['margin-top'] . 'px ' . $client_location_typography['margin-right'] . 'px ' . $client_location_typography['margin-bottom'] . 'px ' . $client_location_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-location{';
			$outline .= $this->tpro_typography_modal_output( $client_location_typography, $location_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-location{';
		$outline     .= $this->tpro_typography_output( $client_location_typography_two, $location_font_load );
		$outline     .= 'margin: ' . $client_location_typography['margin-top'] . 'px ' . $client_location_typography['margin-right'] . 'px ' . $client_location_typography['margin-bottom'] . 'px ' . $client_location_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-location{';
			$outline .= $this->tpro_typography_modal_output( $client_location_typography_two, $location_font_load );
		$outline     .= '}';
	}
}
if ( $testimonial_client_phone ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-phone{';
		$outline     .= $this->tpro_typography_output( $client_phone_typography, $phone_font_load );
		$outline     .= 'margin: ' . $client_phone_typography['margin-top'] . 'px ' . $client_phone_typography['margin-right'] . 'px ' . $client_phone_typography['margin-bottom'] . 'px ' . $client_phone_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-phone{';
			$outline .= $this->tpro_typography_modal_output( $client_phone_typography, $phone_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-phone{';
		$outline     .= $this->tpro_typography_output( $client_phone_typography_two, $phone_font_load );
		$outline     .= 'margin: ' . $client_phone_typography['margin-top'] . 'px ' . $client_phone_typography['margin-right'] . 'px ' . $client_phone_typography['margin-bottom'] . 'px ' . $client_phone_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-phone{';
			$outline .= $this->tpro_typography_modal_output( $client_phone_typography_two, $phone_font_load );
		$outline     .= '}';
	}
}
if ( $testimonial_client_email ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-email{';
		$outline     .= $this->tpro_typography_output( $client_email_typography, $email_font_load );
		$outline     .= 'margin: ' . $client_email_typography['margin-top'] . 'px ' . $client_email_typography['margin-right'] . 'px ' . $client_email_typography['margin-bottom'] . 'px ' . $client_email_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-email{';
			$outline .= $this->tpro_typography_modal_output( $client_email_typography, $email_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-email{';
		$outline     .= $this->tpro_typography_output( $client_email_typography_two, $email_font_load );
		$outline     .= 'margin: ' . $client_email_typography['margin-top'] . 'px ' . $client_email_typography['margin-right'] . 'px ' . $client_email_typography['margin-bottom'] . 'px ' . $client_email_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-email{';
			$outline .= $this->tpro_typography_modal_output( $client_email_typography_two, $email_font_load );
		$outline     .= '}';
	}
}
if ( $testimonial_client_date ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-date{';
		$outline     .= $this->tpro_typography_output( $testimonial_date_typography, $date_font_load );
		$outline     .= 'margin: ' . $testimonial_date_typography['margin-top'] . 'px ' . $testimonial_date_typography['margin-right'] . 'px ' . $testimonial_date_typography['margin-bottom'] . 'px ' . $testimonial_date_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-testimonial-date{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_date_typography, $date_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-testimonial-date{';
		$outline     .= $this->tpro_typography_output( $testimonial_date_typography_two, $date_font_load );
		$outline     .= 'margin: ' . $testimonial_date_typography['margin-top'] . 'px ' . $testimonial_date_typography['margin-right'] . 'px ' . $testimonial_date_typography['margin-bottom'] . 'px ' . $testimonial_date_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-testimonial-date{';
			$outline .= $this->tpro_typography_modal_output( $testimonial_date_typography_two, $date_font_load );
		$outline     .= '}';
	}
}
if ( $testimonial_client_website ) {
	if ( $theme_style == 'theme-one' || $theme_style == 'theme-two' || $theme_style == 'theme-four' || $theme_style == 'theme-eight' || $theme_style == 'theme-ten' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-website{';
		$outline     .= $this->tpro_typography_output( $client_website_typography, $website_font_load );
		$outline     .= 'margin: ' . $client_website_typography['margin-top'] . 'px ' . $client_website_typography['margin-right'] . 'px ' . $client_website_typography['margin-bottom'] . 'px ' . $client_website_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-website{';
			$outline .= $this->tpro_typography_modal_output( $client_website_typography, $website_font_load );
		$outline     .= '}';
	}
	if ( $theme_style == 'theme-three' || $theme_style == 'theme-five' || $theme_style == 'theme-six' || $theme_style == 'theme-seven' || $theme_style == 'theme-nine' ) {
		$outline     .= '
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .tpro-client-website{';
		$outline     .= $this->tpro_typography_output( $client_website_typography_two, $website_font_load );
		$outline     .= 'margin: ' . $client_website_typography['margin-top'] . 'px ' . $client_website_typography['margin-right'] . 'px ' . $client_website_typography['margin-bottom'] . 'px ' . $client_website_typography['margin-left'] . 'px;
		}
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-client-website{';
			$outline .= $this->tpro_typography_modal_output( $client_website_typography, $website_font_load );
		$outline     .= '}';
	}
}

$testimonial_border      = isset( $shortcode_data['testimonial_border'] ) ? $shortcode_data['testimonial_border'] : '';
$testimonial_info_border = isset( $shortcode_data['testimonial_info_border'] ) ? $shortcode_data['testimonial_info_border'] : '';
if ( $theme_style == 'theme-two' || $theme_style == 'theme-six' ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
	    background: ' . $shortcode_data['testimonial_bg'] . ';
	}';
	if ( $client_image !== true ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
			padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
		}';
	}
} elseif ( $theme_style == 'theme-three' ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
	    background: ' . $shortcode_data['testimonial_bg'] . ';
	}';
	if ( $client_image !== true ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
			padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
		}';
	}
} elseif ( $theme_style == 'theme-four' ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
	    background: ' . $shortcode_data['testimonial_bg_two'] . ';
	}';
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
	}';
} elseif ( $theme_style == 'theme-five' ) {
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
	    background: ' . $shortcode_data['testimonial_bg'] . ';
	}';
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
			padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
		}';
} elseif ( $theme_style == 'theme-seven' ) {
	$tpro_border_width  = $testimonial_border['all'] + 13;
	$tpro_border_height = $testimonial_border['all'] + 17;
	$tpro_margin_top    = $tpro_border_height + 10;
	$outline           .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
		border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
	    background: ' . $shortcode_data['testimonial_bg_three'] . ';
	    margin-top: ' . $tpro_margin_top . 'px;
	}';
	$outline           .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		bottom: 100%;
	    left: 30px;
	    border: solid transparent;
	    content: "";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
	    border-color: transparent;
	    border-bottom-color: ' . $shortcode_data['testimonial_bg_three'] . ';
	    border-width: 0 13px 17px 13px;
	    margin-left: 0;
	}

	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
	    border-color: transparent;
	    border-bottom-color: ' . $testimonial_border['color'] . ';
	    border-width: 0 ' . $tpro_border_width . 'px ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px;
	    margin-left: -' . $testimonial_border['all'] . 'px;
	}';

	if ( $client_image !== true ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
			padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
		}';
	}
} elseif ( $theme_style == 'theme-eight' ) {

	if ( $shortcode_data['testimonial_info_position'] == 'bottom' ) {
		$tpro_border_width  = $testimonial_border['all'] + 13;
		$tpro_border_height = $testimonial_border['all'] + 17;

		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
			border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
		    background: ' . $shortcode_data['testimonial_bg_three'] . ';
		    padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			position: relative;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			border-top: 0 solid;
			border-bottom: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			top: 100%;
		    right: 50%;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-top-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 17px 13px 0 13px;
		    margin-right: -13px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-top-color: ' . $testimonial_border['color'] . ';
		    border-width: ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px 0 ' . $tpro_border_width . 'px;
		    margin-right: -' . $tpro_border_width . 'px;
		}';
	} elseif ( $shortcode_data['testimonial_info_position'] == 'top' ) {
		$tpro_border_width  = $testimonial_border['all'] + 13;
		$tpro_border_height = $testimonial_border['all'] + 17;

		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
			border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
		    background: ' . $shortcode_data['testimonial_bg_three'] . ';
		    padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			position: relative;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			border-top: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-bottom: 0 solid;
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			bottom: 100%;
		    right: 50%;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-bottom-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 0 13px 17px 13px;
		    margin-right: -13px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-bottom-color: ' . $testimonial_border['color'] . ';
		    border-width: 0 ' . $tpro_border_width . 'px ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px;
		    margin-right: -' . $tpro_border_width . 'px;
		}';
	} elseif ( $shortcode_data['testimonial_info_position'] == 'right' ) {
		$tpro_border_width  = $testimonial_border['all'] + 13;
		$tpro_border_height = $testimonial_border['all'] + 17;

		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
			border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
		    background: ' . $shortcode_data['testimonial_bg_three'] . ';
		    padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			position: relative;
			display: table-cell;
			vertical-align: top;
			width: 100%;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			border-top: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-bottom: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-left: 0 solid;
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		    display: table-cell;
            vertical-align: top;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			left: 100%;
		    top: 50px;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-left-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 13px 0 13px 17px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-left-color: ' . $testimonial_border['color'] . ';
		    border-width: ' . $tpro_border_width . 'px 0 ' . $tpro_border_width . 'px ' . $tpro_border_height . 'px;
		    margin-top: -' . $testimonial_border['all'] . 'px;
		}';
	} elseif ( $shortcode_data['testimonial_info_position'] == 'left' ) {
		$tpro_border_width  = $testimonial_border['all'] + 13;
		$tpro_border_height = $testimonial_border['all'] + 17;

		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
			border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
		    background: ' . $shortcode_data['testimonial_bg_three'] . ';
		    padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			position: relative;
			display: table-cell;
			vertical-align: top;
			width: 100%;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			border-top: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-bottom: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: 0 solid;
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		    display: table-cell;
            vertical-align: top;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			right: 100%;
		    top: 50px;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-right-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 13px 17px 13px 0;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-right-color: ' . $testimonial_border['color'] . ';
		    border-width: ' . $tpro_border_width . 'px ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px 0;
		    margin-top: -' . $testimonial_border['all'] . 'px;
		}';
	}
} elseif ( $theme_style == 'theme-nine' ) {
	$tpro_border_width  = $testimonial_border['all'] + 13;
	$tpro_border_height = $testimonial_border['all'] + 17;

	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
			border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
		    background: ' . $shortcode_data['testimonial_bg_three'] . ';
		    padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			position: relative;
		}';

	if ( $testimonial_info_position_two == 'bottom_left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			display: flex;
			border-top: 0 solid;
			border-bottom: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-text{
			flex: 1;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			top: 100%;
		    left: 70px;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-top-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 17px 13px 0 13px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-top-color: ' . $testimonial_border['color'] . ';
		    border-width: ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px 0 ' . $tpro_border_width . 'px;
		    margin-left: -' . $testimonial_border['all'] . 'px;
		}';
	} elseif ( $testimonial_info_position_two == 'bottom_right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			display: flex;
			border-top: 0 solid;
			border-bottom: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-text{
			flex: 1;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			top: 100%;
		    right: 70px;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-top-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 17px 13px 0 13px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-top-color: ' . $testimonial_border['color'] . ';
		    border-width: ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px 0 ' . $tpro_border_width . 'px;
		    margin-right: -' . $testimonial_border['all'] . 'px;
		}';
	} elseif ( $testimonial_info_position_two == 'top_left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			display: flex;
			border-top: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-bottom: 0 solid;
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-text{
			flex: 1;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			bottom: 100%;
		    left: 70px;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-bottom-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 0 13px 17px 13px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-bottom-color: ' . $testimonial_border['color'] . ';
		    border-width: 0 ' . $tpro_border_width . 'px ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px;
		    margin-left: -' . $testimonial_border['all'] . 'px;
		}';
	} elseif ( $testimonial_info_position_two == 'top_right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-area{
			display: flex;
			border-top: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-bottom: 0 solid;
			border-left: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-right: ' . $testimonial_info_border['all'] . 'px ' . $testimonial_info_border['style'] . ';
			border-color: ' . $testimonial_info_border_color . ';
		    background: ' . $shortcode_data['testimonial_info_bg'] . ';
		    padding: ' . $testimonial_info_inner_padding['top'] . 'px ' . $testimonial_info_inner_padding['right'] . 'px ' . $testimonial_info_inner_padding['bottom'] . 'px ' . $testimonial_info_inner_padding['left'] . 'px;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-meta-text{
			flex: 1;
		}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after, #sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
			bottom: 100%;
		    right: 70px;
		    border: solid transparent;
		    content: "";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:after {
		    border-color: transparent;
		    border-bottom-color: ' . $shortcode_data['testimonial_bg_three'] . ';
		    border-width: 0 13px 17px 13px;
		}
		#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area:before {
		    border-color: transparent;
		    border-bottom-color: ' . $testimonial_border['color'] . ';
		    border-width: 0 ' . $tpro_border_width . 'px ' . $tpro_border_height . 'px ' . $tpro_border_width . 'px;
		    margin-right: -' . $testimonial_border['all'] . 'px;
		}';
	}
} elseif ( $theme_style == 'theme-ten' ) {
	if ( $client_image_border_shadow == 'border' ) {
		$client_image_total_height_size = $client_image_height + $image_border_width + $image_border_width + $image_padding + $image_padding;
	} elseif ( $client_image_border_shadow == 'box_shadow' ) {
		$client_image_total_height_size = $client_image_height + 14 + $image_padding + $image_padding;
	}

	$client_image_height_size_two = $client_image_total_height_size / 2;
	$client_image_height_size     = $client_image_height_size_two + $testimonial_inner_padding['top'];

	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		border: ' . $testimonial_border['all'] . 'px ' . $testimonial_border['style'] . ' ' . $testimonial_border['color'] . ';
	    background: ' . $shortcode_data['testimonial_bg'] . ';
	    -webkit-border-radius: ' . $shortcode_data['testimonial_border_radius'] . 'px;
	    -moz-border-radius: ' . $shortcode_data['testimonial_border_radius'] . 'px;
	    border-radius: ' . $shortcode_data['testimonial_border_radius'] . 'px;
	    box-shadow: 0px 0px 10px ' . $shortcode_data['testimonial_box_shadow_color'] . ';
        margin: 10px;
        position: relative;
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .sp-tpro-top-background {
	    background: ' . $shortcode_data['testimonial_top_bg'] . ';
	    height: ' . $client_image_height_size . 'px;
	    width: 100%;
	    position: absolute;
	    top: 0;
	    left: 0;
	    z-index: 1;
	    -webkit-border-radius: ' . $shortcode_data['testimonial_border_radius'] . 'px ' . $shortcode_data['testimonial_border_radius'] . 'px 0 0;
	    -moz-border-radius: ' . $shortcode_data['testimonial_border_radius'] . 'px ' . $shortcode_data['testimonial_border_radius'] . 'px 0 0;
	    border-radius: ' . $shortcode_data['testimonial_border_radius'] . 'px ' . $shortcode_data['testimonial_border_radius'] . 'px 0 0;
	}
	';
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
		padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
	}';
}

if ( $client_image && $theme_style == 'theme-two' ) {

	if ( $client_image_border_shadow == 'border' ) {
		$client_image_total_width_size  = $client_image_width + $image_border_width + $image_border_width + $image_padding + $image_padding;
		$client_image_total_height_size = $client_image_height + $image_border_width + $image_border_width + $image_padding + $image_padding;
	} elseif ( $client_image_border_shadow == 'box_shadow' ) {
		$client_image_total_width_size  = $client_image_width + 14 + $image_padding + $image_padding;
		$client_image_total_height_size = $client_image_height + 14 + $image_padding + $image_padding;
	}

	$client_image_width_size       = $client_image_total_width_size / 2;
	$client_image_width_size_right = $client_image_width_size + $testimonial_margin;
	$client_image_height_size      = $client_image_total_height_size / 2;

	$testimonial_inner_padding_left   = $testimonial_inner_padding['left'] + $client_image_width_size;
	$testimonial_inner_padding_right  = $testimonial_inner_padding['right'] + $client_image_width_size;
	$testimonial_inner_padding_top    = $testimonial_inner_padding['top'] + $client_image_width_size;
	$testimonial_inner_padding_bottom = $testimonial_inner_padding['bottom'] + $client_image_width_size;

	// Left site image.
	if ( $client_image_position_two == 'left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-left:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding_left . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    top: 50%;
			    left: -' . $client_image_width_size . 'px;
			    margin-top: -' . $client_image_height_size . 'px;
			}';
	} // Right site image.
	elseif ( $client_image_position_two == 'right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-right:' . $client_image_width_size_right . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding_right . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    top: 50%;
			    right: -' . $client_image_width_size . 'px;
			    margin-top: -' . $client_image_height_size . 'px;
			}';
	} // Top site image
	elseif ( $client_image_position_two == 'top' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-top:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding_top . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    left: 50%;
			    top: -' . $client_image_height_size . 'px;
			    margin-left: -' . $client_image_width_size . 'px;
			}';
	} // Bottom site image
	elseif ( $client_image_position_two == 'bottom' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-bottom:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding_bottom . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    left: 50%;
			    bottom: -' . $client_image_height_size . 'px;
			    margin-left: -' . $client_image_width_size . 'px;
			}';
	}
}

if ( $client_image && $theme_style == 'theme-three' ) {

	if ( $client_image_border_shadow == 'border' ) {
		$client_image_total_width_size  = $client_image_width + $image_border_width + $image_border_width + $image_padding + $image_padding;
		$client_image_total_height_size = $client_image_height + $image_border_width + $image_border_width + $image_padding + $image_padding;
	} elseif ( $client_image_border_shadow == 'box_shadow' ) {
		$client_image_total_width_size  = $client_image_width + 14 + $image_padding + $image_padding;
		$client_image_total_height_size = $client_image_height + 14 + $image_padding + $image_padding;
	}

	$client_image_width_size       = $client_image_total_width_size / 2;
	$client_image_width_size_right = $client_image_width_size + $testimonial_margin;
	$client_image_height_size      = $client_image_total_height_size / 2;

	$testimonial_inner_padding_left   = $testimonial_inner_padding['left'] + $client_image_width_size;
	$testimonial_inner_padding_right  = $testimonial_inner_padding['right'] + $client_image_width_size;
	$testimonial_inner_padding_top    = $testimonial_inner_padding['top'] + $client_image_width_size;
	$testimonial_inner_padding_bottom = $testimonial_inner_padding['bottom'] + $client_image_width_size;

	// Left-Top site image
	if ( $client_image_position_three == 'left-top' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-left:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding_left . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    top: 45px;
			    left: -' . $client_image_width_size . 'px;
			}';
	} // Left-Bottom site image
	elseif ( $client_image_position_three == 'left-bottom' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-left:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding_left . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    bottom: 45px;
			    left: -' . $client_image_width_size . 'px;
			}';
	} // Right-Top site image
	elseif ( $client_image_position_three == 'right-top' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-right:' . $client_image_width_size_right . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding_right . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    top: 45px;
			    right: -' . $client_image_width_size . 'px;
			}';
	} // Right-Bottom site image
	elseif ( $client_image_position_three == 'right-bottom' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-right:' . $client_image_width_size_right . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding_right . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    bottom: 45px;
			    right: -' . $client_image_width_size . 'px;
			}';
	} // Top-Left site image
	elseif ( $client_image_position_three == 'top-left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-top:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding_top . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    left: 45px;
			    top: -' . $client_image_height_size . 'px;
			}';
	} // Top-Left site image
	elseif ( $client_image_position_three == 'top-right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-top:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding_top . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    right: 45px;
			    top: -' . $client_image_height_size . 'px;
			}';
	} // Bottom-Left site image
	elseif ( $client_image_position_three == 'bottom-left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-bottom:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding_bottom . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    left: 45px;
			    bottom: -' . $client_image_height_size . 'px;
			}';
	} // Bottom-Right site image
	elseif ( $client_image_position_three == 'bottom-right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-bottom:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding_bottom . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    right: 45px;
			    bottom: -' . $client_image_height_size . 'px;
			}';
	}
}

if ( $client_image && $theme_style == 'theme-six' ) {

	if ( $client_image_border_shadow == 'border' ) {
		$client_image_total_width_size  = $client_image_width + $image_border_width + $image_border_width + $image_padding + $image_padding;
		$client_image_total_height_size = $client_image_height + $image_border_width + $image_border_width + $image_padding + $image_padding;
	} elseif ( $client_image_border_shadow == 'box_shadow' ) {
		$client_image_total_width_size  = $client_image_width + 14 + $image_padding + $image_padding;
		$client_image_total_height_size = $client_image_height + 14 + $image_padding + $image_padding;
	}

	$client_image_width_size       = $client_image_total_width_size / 2;
	$client_image_width_size_right = $client_image_width_size + $testimonial_margin;
	$client_image_height_size      = $client_image_total_height_size / 2;

	$testimonial_inner_padding_left   = $testimonial_inner_padding['left'] + $client_image_width_size;
	$testimonial_inner_padding_right  = $testimonial_inner_padding['right'] + $client_image_width_size;
	$testimonial_inner_padding_top    = $testimonial_inner_padding['top'] + $client_image_width_size;
	$testimonial_inner_padding_bottom = $testimonial_inner_padding['bottom'] + $client_image_width_size;

	// Left-Top site image
	if ( $client_image_position_three == 'left-top' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-left:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding_left . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    top: 30px;
			    left: -' . $client_image_width_size . 'px;
			}';
	} // Left-Bottom site image
	elseif ( $client_image_position_three == 'left-bottom' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-left:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding_left . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    bottom: 30px;
			    left: -' . $client_image_width_size . 'px;
			}';
	} // Right-Top site image
	elseif ( $client_image_position_three == 'right-top' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-right:' . $client_image_width_size_right . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding_right . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    top: 30px;
			    right: -' . $client_image_width_size . 'px;
			}';
	} // Right-Bottom site image
	elseif ( $client_image_position_three == 'right-bottom' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-right:' . $client_image_width_size_right . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding_right . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    bottom: 30px;
			    right: -' . $client_image_width_size . 'px;
			}';
	} // Top-Left site image
	elseif ( $client_image_position_three == 'top-left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-top:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding_top . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    left: 30px;
			    top: -' . $client_image_height_size . 'px;
			}';
	} // Top-Left site image
	elseif ( $client_image_position_three == 'top-right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-top:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding_top . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    right: 30px;
			    top: -' . $client_image_height_size . 'px;
			}';
	} // Bottom-Left site image
	elseif ( $client_image_position_three == 'bottom-left' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-bottom:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding_bottom . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    left: 30px;
			    bottom: -' . $client_image_height_size . 'px;
			}';
	} // Bottom-Right site image
	elseif ( $client_image_position_three == 'bottom-right' ) {
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro{
				margin-bottom:' . $client_image_width_size . 'px;
				position: relative;
				padding: ' . $testimonial_inner_padding['top'] . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding_bottom . 'px ' . $testimonial_inner_padding['left'] . 'px;
			}';
		$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
				position: absolute;
			    right: 30px;
			    bottom: -' . $client_image_height_size . 'px;
			}';
	}
}

if ( $client_image && $theme_style == 'theme-seven' ) {

	if ( $client_image_border_shadow == 'border' ) {
		$client_image_total_height_size = $client_image_height + $image_border_width + $image_border_width + $image_padding + $image_padding;
	} elseif ( $client_image_border_shadow == 'box_shadow' ) {
		$client_image_total_height_size = $client_image_height + 14 + $image_padding + $image_padding;
	}

	$client_image_height_size        = $client_image_total_height_size / 100;
	$client_image_height_size_top    = $client_image_height_size * 75;
	$client_image_height_size_bottom = $client_image_height_size * 25;

	$testimonial_inner_padding_top = $testimonial_inner_padding['top'] + $client_image_height_size_bottom;

	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-testimonial-content-area{
		position: relative;
		padding: ' . $testimonial_inner_padding_top . 'px ' . $testimonial_inner_padding['right'] . 'px ' . $testimonial_inner_padding['bottom'] . 'px ' . $testimonial_inner_padding['left'] . 'px;
	}';
	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .sp-testimonial-pro .tpro-client-image{
		position: absolute;
	    right: 30px;
	    top: -' . $client_image_height_size_top . 'px;
	}';
}

// $pagination_dots
if ( $pagination_dots == true && $layout == 'slider' ) {
	$pagination_colors       = isset( $shortcode_data['pagination_colors'] ) ? $shortcode_data['pagination_colors'] : '';
	$pagination_color        = isset( $pagination_colors['color'] ) ? $pagination_colors['color'] : '';
	$pagination_active_color = isset( $pagination_colors['active-color'] ) ? $pagination_colors['active-color'] : '';
	$outline                .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-dots{
		margin: ' . $pagination_margin['top'] . 'px ' . $pagination_margin['right'] . 'px ' . $pagination_margin['bottom'] . 'px ' . $pagination_margin['left'] . 'px;
	}';

	$outline .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-dots li button{
		background: ' . $pagination_color . ';
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-dots li.slick-active button{
		background: ' . $pagination_active_color . ';
	}';
}

if ( $navigation_arrows == true && $layout == 'slider' || $navigation_mobile == true && $layout == 'slider' ) {
	$navigation_colors        = isset( $shortcode_data['navigation_color'] ) ? $shortcode_data['navigation_color'] : '';
	$navigation_icon_size     = isset( $shortcode_data['navigation_icon_size'] ) ? $shortcode_data['navigation_icon_size'] : '20';
	$navigation_bg            = isset( $navigation_colors['background'] ) ? $navigation_colors['background'] : '';
	$navigation_hover_bg      = isset( $navigation_colors['hover-background'] ) ? $navigation_colors['hover-background'] : '';
	$navigation_color         = isset( $navigation_colors['color'] ) ? $navigation_colors['color'] : '';
	$navigation_hover_color   = isset( $navigation_colors['hover-color'] ) ? $navigation_colors['hover-color'] : '';
	$navigation_border        = isset( $shortcode_data['navigation_border'] ) ? $shortcode_data['navigation_border'] : '';
	$line_height         	  = 32 - ( (int) $navigation_border['all'] * 2 );
	$navigation_border_radius = isset( $shortcode_data['navigation_border_radius'] ) ? $shortcode_data['navigation_border_radius'] : '';
	$navigation_border_radius_size = isset( $navigation_border_radius['all'] ) ? $navigation_border_radius['all'] : '0';
	$navigation_border_radius_unit = isset( $navigation_border_radius['unit'] ) ? $navigation_border_radius['unit'] : 'px';
	$outline                 .= '#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-prev,
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-next{
		background: ' . $navigation_bg . ';
		color: ' . $navigation_color . ';
		font-size: ' . $navigation_icon_size . 'px;
		border: ' . $navigation_border['all'] . 'px ' . $navigation_border['style'] . ' ' . $navigation_border['color'] . ';
		border-radius: ' . $navigation_border_radius_size . '' . $navigation_border_radius_unit . ';
		line-height: ' . $line_height . 'px;
	}
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-prev:hover,
	#sp-testimonial-pro-' . $post_id . '.sp-testimonial-pro-section .slick-next:hover{
		background: ' . $navigation_hover_bg . ';
		color: ' . $navigation_hover_color . ';
		border-color: ' . $navigation_border['hover-color'] . ';
	}';

	if ( $layout == 'slider' && $navigation_arrows == true || $layout == 'slider' && $navigation_mobile == true ) {

		if ( $section_title ) {
			if ( $navigation_position == 'top_right' || $navigation_position == 'top_center' || $navigation_position == 'top_left' ) {
				$outline .= '#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_right,
				#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_center,
				#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_left {
					padding-top: 4px;
				}';

			}
		} else {
			if ( $navigation_position == 'top_right' || $navigation_position == 'top_center' || $navigation_position == 'top_left' ) {
				$outline .= '#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_right,
					#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_center,
					#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_left {
					    padding-top: 46px;
					}';
			}
		}
		if ( $navigation_position == 'bottom_right' || $navigation_position == 'bottom_center' || $navigation_position == 'bottom_left'
		) {
			$outline .= '#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_bottom_right,
					#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_bottom_center,
					#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_bottom_left {
					    padding-bottom: 46px;
					}';
		}
		if ( $navigation_position == 'top_right' ) {
			$nav_margin_right = $testimonial_margin + '38';
			$outline         .= '
			#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_right .slick-next {
				right: ' . $testimonial_margin . 'px;
			}

			#sp-testimonial-pro-wrapper-' . $post_id . '.sp_tpro_nav_position_top_right .slick-prev {
				right: ' . $nav_margin_right . 'px;
			}
			';
		}
		if ( $navigation_position == 'bottom_right' ) {
				$nav_margin_right = $testimonial_margin + '38';
				$outline         .= '
				#sp-testimonial-pro-wrapper-' . $post_id . ' .slick-next {
				    right: ' . $testimonial_margin . 'px;
				}
				#sp-testimonial-pro-wrapper-' . $post_id . ' .slick-prev {
				    right: ' . $nav_margin_right . 'px;
				}
				#sp-testimonial-pro-wrapper-' . $post_id . ' .slick-prev {
				    right: ' . $nav_margin_right . 'px;
				}
				';
		}

		if ( $navigation_position == 'vertical_center' ) {
			$outline .= '
				#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section{
				    padding: 0 60px;
				}
				/* xs */
				@media (max-width: 600px) {
					#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section{
						padding: 0 30px;
					}
				}
				';
		}
		if ( $navigation_position == 'vertical_center' || $navigation_position == 'vertical_center_inner' ) {

				$outline .= '
				#sp-testimonial-pro-wrapper-' . $post_id . ' .slick-next {
				    right: ' . $testimonial_margin . 'px;
				}

				#sp-testimonial-pro-wrapper-' . $post_id . ' .slick-prev {
				    left: 0;
				}
				';
		}
		if ( $navigation_position == 'vertical_center_inner_hover' ) {

				$outline .= '
				#sp-testimonial-pro-wrapper-' . $post_id . ':hover .slick-next {
				    right: ' . $testimonial_margin . 'px;
				}

				#sp-testimonial-pro-wrapper-' . $post_id . ':hover .slick-prev {
				    left: 0;
				}
				';
		}
	}
}//$navigation

if ( $layout == 'grid' || $layout == 'masonry' || $layout == 'list' ) {
	if ( $grid_pagination ) {
		$grid_pagination_colors = isset( $shortcode_data['grid_pagination_colors'] ) ? $shortcode_data['grid_pagination_colors'] : '';
		$grid_pagination_border = isset( $shortcode_data['grid_pagination_border'] ) ? $shortcode_data['grid_pagination_border'] : '';
		$outline               .= '
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .page-load-status,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-items-load-more,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .sp-tpro-pagination-area {
		     text-align: ' . $shortcode_data['grid_pagination_alignment'] . ';
		}
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-items-load-more,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section ul.sp-tpro-pagination {
		     margin: ' . $grid_pagination_margin['top'] . 'px ' . $grid_pagination_margin['right'] . 'px '
					. $grid_pagination_margin['bottom'] . 'px ' . $grid_pagination_margin['left'] . 'px;
		}
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-items-load-more span,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section ul.sp-tpro-pagination li a,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section ul.sp-tpro-pagination li span {
		     color: ' . $grid_pagination_colors['color'] . ';
		     background: ' . $grid_pagination_colors['background'] . ';
             border: ' . $grid_pagination_border['all'] . 'px ' . $grid_pagination_border['style'] . ' ' . $grid_pagination_border['color'] . ';
		}
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-items-load-more span:hover ,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section ul.sp-tpro-pagination li span.current,
		#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section ul.sp-tpro-pagination li a:hover{
		    background: ' . $grid_pagination_colors['hover-background'] . ';
            color: ' . $grid_pagination_colors['hover-color'] . ';
            border-color: ' . $grid_pagination_border['hover-color'] . ';
		}';
		if ( $shortcode_data['grid_pagination_alignment'] == 'right' ) {
			$outline .= '#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section ul.sp-tpro-pagination{
				padding-right:' . $testimonial_margin . 'px;
			}';
		}
	}
}
if ( $social_profile ) {
	$social_profile_position   = isset( $shortcode_data['social_profile_position'] ) ? $shortcode_data['social_profile_position'] : '';
	$social_icon_color         = isset( $shortcode_data['social_icon_color'] ) ? $shortcode_data['social_icon_color'] : '';
	$social_icon_custom_color  = isset( $shortcode_data['social_icon_custom_color'] ) ? $shortcode_data['social_icon_custom_color'] : '';
	$social_icon_border        = isset( $shortcode_data['social_icon_border'] ) ? $shortcode_data['social_icon_border'] : '';
	$social_icon_border_radius = isset( $shortcode_data['social_icon_border_radius'] ) ? $shortcode_data['social_icon_border_radius'] : '';
		$outline              .= '#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-social-profile{
			text-align: ' . $social_profile_position . ';
		}';

	$outline .= '#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-social-profile,
	.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-social-profile{
		margin: ' . $social_profile_margin['top'] . 'px ' . $social_profile_margin['right'] . 'px ' . $social_profile_margin['bottom'] . 'px ' . $social_profile_margin['left'] . 'px;
	}
	#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-social-profile a,
	.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-social-profile a{';
	if ( $social_icon_custom_color ) {
		$outline .= 'color: ' . $social_icon_color['color'] . ';
			background: ' . $social_icon_color['background'] . ';
			border: ' . $social_icon_border['all'] . 'px ' . $social_icon_border['style'] . ' ' . $social_icon_border['color'] . ';';
	}
		$outline .= '-webkit-border-radius: ' . $social_icon_border_radius['all'] . '' . $social_icon_border_radius['unit'] . ';
		-moz-border-radius: ' . $social_icon_border_radius['all'] . '' . $social_icon_border_radius['unit'] . ';
		border-radius: ' . $social_icon_border_radius['all'] . '' . $social_icon_border_radius['unit'] . ';
	}';
	if ( $social_icon_custom_color ) {
		$outline .= '#sp-testimonial-pro-wrapper-' . $post_id . ' .sp-testimonial-pro-section .tpro-social-profile a:hover,
		.sp-tpro-modal-testimonial-' . $post_id . '.sp-tpro-modal-testimonial .tpro-social-profile a:hover{
			color: ' . $social_icon_color['hover-color'] . ';
			background: ' . $social_icon_color['hover-background'] . ';
			border-color: ' . $social_icon_border['hover-color'] . ';
		}';
	}
}

$outline .= '</style>';

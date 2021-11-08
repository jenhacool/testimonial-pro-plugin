<?php
/**
 * Theme Nine
 */

if ( $testimonial_info_position_two == 'bottom_right' || $testimonial_info_position_two == 'bottom_left' ) {
	$outline .= '<div class="tpro-testimonial-content-area">';
	$outline .= $review_title . $review_content;
	$outline .= '</div>';
}

$outline .= '<div class="tpro-testimonial-meta-area">';

if ( has_post_thumbnail( $post_query->post->ID ) && $client_image && 'bottom_left' == $testimonial_info_position_two || has_post_thumbnail( $post_query->post->ID ) && $client_image && 'top_left' == $testimonial_info_position_two ) {
	$outline .= sprintf( '<div class="tpro-client-image tpro-image-style-%1$s">%2$s</div>', $client_image_style, $image );
}

$outline .= '<div class="tpro-testimonial-meta-text">';
$outline .= $client_name;

if ( $testimonial_client_rating && '' !== $tpro_rating_star ) {
	include SP_TPRO_PATH . '/public/views/content/rating.php';
}

if ( $client_designation && '' !== $tpro_designation || $client_company_name && '' !== $tpro_company_name
) {
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

require SP_TPRO_PATH . '/public/views/content/social-profile.php';

$outline .= '</div>'; // tpro-testimonial-meta-text.

if ( has_post_thumbnail( $post_query->post->ID ) && $client_image && 'bottom_right' == $testimonial_info_position_two || has_post_thumbnail( $post_query->post->ID ) && $client_image && 'top_right' == $testimonial_info_position_two ) {
	$outline .= sprintf( '<div class="tpro-client-image tpro-image-style-%1$s">%2$s</div>', $client_image_style, $image );
}

$outline .= '</div>';

if ( $testimonial_info_position_two == 'top_right' || $testimonial_info_position_two == 'top_left' ) {
	$outline .= '<div class="tpro-testimonial-content-area">';
	$outline .= $review_title . $review_content;
	$outline .= '</div>';
}

<?php
/**
 * Theme Ten
 */

$outline .= '<div class="sp-tpro-top-background"></div>';

if ( has_post_thumbnail( $post_query->post->ID ) && $client_image ) {
	$outline .= sprintf( '<div class="tpro-client-image tpro-image-style-%1$s tpro-image-position-%3$s">%2$s</div>', $client_image_style, $image, $client_image_position_two );
}

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

$outline .= $review_title . $review_content;

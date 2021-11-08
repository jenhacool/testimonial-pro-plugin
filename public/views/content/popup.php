<?php
$outline .= sprintf(
	'<div class="remodal sp-tpro-modal-testimonial-%1$s sp-tpro-modal-testimonial" data-remodal-id="sp-tpro-testimonial-id-%2$s">
<a data-remodal-action="close" class="remodal-close"></a><div class="sp-testimonial-pro-item"><div class="sp-testimonial-pro">', $post_id, get_the_ID()
);

if ( has_post_thumbnail( $post_query->post->ID ) && $client_image ) {
	$outline .= sprintf( '<div class="tpro-client-image tpro-image-style-%1$s" itemprop="image"><img src="%2$s"></div>', $client_image_style, $image_src );
}
$outline .= $review_title;
if ( $testimonial_text ) {
	$outline .= sprintf( '<div class="tpro-client-testimonial">%1$s</div>', apply_filters( 'the_content', get_the_content() ) );
}
$outline .= $client_name;

if ( $testimonial_client_rating && '' !== $tpro_rating_star ) {
	include SP_TPRO_PATH . '/public/views/content/rating.php';
}

if ( $client_designation && '' !== $tpro_designation || $client_company_name && '' !== $tpro_company_name
) {
	$outline .= '<div class="tpro-client-designation-company">';
	if ( $client_designation && '' !== $tpro_designation ) {
		$outline .= $tpro_designation;
	}
	if ( $client_designation && '' !== $tpro_designation && $client_company_name && '' !== $tpro_company_name ) {
		$outline .= ' - ';
	}
	if ( $client_company_name && '' !== $tpro_company_name ) {
		$outline .= $tpro_company_name;
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
	$outline .= '<div class="tpro-client-website"><a href="' . esc_url( $tpro_website ) . '">' . $tpro_website . '</a></div>';
}

require SP_TPRO_PATH . '/public/views/content/social-profile.php';

$outline .= '</div>'; // sp-testimonial-pro.
$outline .= '</div>'; // sp-testimonial-pro-item.

$outline .= '</div>';

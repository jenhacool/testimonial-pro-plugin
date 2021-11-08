<?php
if ( $social_profile ) {

	$social_profiles = isset( $testimonial_data['tpro_social_profiles'] ) ? $testimonial_data['tpro_social_profiles'] : '';
	$outline        .= '<div class="tpro-social-profile">';
	if ( $social_profiles ) {
		foreach ( $social_profiles as $profile ) {
			$social_name = isset( $profile['social_name'] ) ? $profile['social_name'] : '';
			$social_url  = isset( $profile['social_url'] ) ? $profile['social_url'] : '';
			if ( ! empty( $social_name && $social_url ) ) {
				$outline .= '<a href="' . esc_url( $social_url ) . '" class="tpro-'. $social_name .'" target="_blank">' . tpro_social_icon( $social_name ) . '</a>';
			}
		}
	}
	$outline .= '</div>';
}

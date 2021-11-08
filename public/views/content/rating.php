<?php
switch ( $star_icon ) {
	case 'fa fa-star':
		$full_star_icon  = '<i class="fa fa-star" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-star-o" aria-hidden="true"></i>';
		break;
	case 'fa fa-heart':
		$full_star_icon  = '<i class="fa fa-heart" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
		break;
	case 'fa fa-thumbs-up':
		$full_star_icon  = '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
		break;
	case 'fa fa-hourglass':
		$full_star_icon  = '<i class="fa fa-hourglass" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-hourglass-o" aria-hidden="true"></i>';
		break;
	case 'fa fa-circle':
		$full_star_icon  = '<i class="fa fa-circle" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-circle-thin" aria-hidden="true"></i>';
		break;
	case 'fa fa-square':
		$full_star_icon  = '<i class="fa fa-square" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-square-o" aria-hidden="true"></i>';
		break;
	case 'fa fa-flag':
		$full_star_icon  = '<i class="fa fa-flag" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-flag-o" aria-hidden="true"></i>';
		break;
	case 'fa fa-smile-o':
		$full_star_icon  = '<i class="fa fa-smile-o" aria-hidden="true"></i>';
		$empty_star_icon = '<i class="fa fa-frown-o" aria-hidden="true"></i>';
		break;
}
$outline .= '<div class="tpro-client-rating">';
switch ( $tpro_rating_star ) {
	case 'five_star':
		$outline .= sprintf( '%1$s%1$s%1$s%1$s%1$s', $full_star_icon );
		break;
	case 'four_star':
		$outline .= sprintf( '%1$s%1$s%1$s%1$s%2$s', $full_star_icon, $empty_star_icon );
		break;
	case 'three_star':
		$outline .= sprintf( '%1$s%1$s%1$s%2$s%2$s', $full_star_icon, $empty_star_icon );
		break;
	case 'two_star':
		$outline .= sprintf( '%1$s%1$s%2$s%2$s%2$s', $full_star_icon, $empty_star_icon );
		break;
	case 'one_star':
		$outline .= sprintf( '%1$s%2$s%2$s%2$s%2$s', $full_star_icon, $empty_star_icon );
		break;
}
$outline .= '</div>';

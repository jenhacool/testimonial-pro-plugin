<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Functions
 */
class SP_Testimonial_Pro_Functions {

	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_filter( 'post_updated_messages', array( $this, 'sp_tpro_change_default_post_update_message' ) );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );
		add_action( 'admin_action_sp_tpro_duplicate_shortcode', array( $this, 'sp_tpro_duplicate_shortcode' ) );
		add_filter( 'post_row_actions', array( $this, 'sp_tpro_duplicate_shortcode_link' ), 10, 2 );
	}

	/**
	 * Post update messages for Shortcode Generator
	 */
	function sp_tpro_change_default_post_update_message( $message ) {
		$screen = get_current_screen();
		if ( 'spt_shortcodes' == $screen->post_type ) {
			$message['post'][1]  = $title = esc_html__( 'View updated.', 'testimonial-pro' );
			$message['post'][4]  = $title = esc_html__( 'View updated.', 'testimonial-pro' );
			$message['post'][6]  = $title = esc_html__( 'View published.', 'testimonial-pro' );
			$message['post'][8]  = $title = esc_html__( 'View submitted.', 'testimonial-pro' );
			$message['post'][10] = $title = esc_html__( 'View draft updated.', 'testimonial-pro' );
		} elseif ( 'spt_testimonial' == $screen->post_type ) {
			$message['post'][1]  = $title = esc_html__( 'Testimonial updated.', 'testimonial-pro' );
			$message['post'][4]  = $title = esc_html__( 'Testimonial updated.', 'testimonial-pro' );
			$message['post'][6]  = $title = esc_html__( 'Testimonial published.', 'testimonial-pro' );
			$message['post'][8]  = $title = esc_html__( 'Testimonial submitted.', 'testimonial-pro' );
			$message['post'][10] = $title = esc_html__( 'Testimonial draft updated.', 'testimonial-pro' );
		}

		return $message;
	}


	/**
	 * Shortcode converter function
	 */
	function testimonial_pro_id( $id ) {
		echo do_shortcode( '[testimonial_pro id="' . $id . '"]' );
	}

	/**
	 * Review Text
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function admin_footer( $text ) {
		$screen = get_current_screen();
		if ( 'spt_testimonial' == get_post_type() || $screen->id == 'spt_testimonial_page_tpro_help' || $screen->id == 'spt_testimonial_page_tpro_settings' || $screen->taxonomy == 'testimonial_cat' || $screen->post_type == 'spt_shortcodes' ) {
			$url  = 'https://shapedplugin.com/plugin/testimonial-pro/#reviews';
			$text = sprintf( __( 'If you like <strong>Testimonial Pro</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'testimonial-pro' ), $url );
		}

		return $text;
	}

	/*
	 * Function creates testimonial slider duplicate as a draft.
	 */
	function sp_tpro_duplicate_shortcode() {
		global $wpdb;
		if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'sp_tpro_duplicate_shortcode' == $_REQUEST['action'] ) ) ) {
			wp_die( __( 'No shortcode to duplicate has been supplied!', 'testimonial-pro' ) );
		}

		/*
		 * Nonce verification
		 */
		if ( ! isset( $_GET['sp_tpro_duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['sp_tpro_duplicate_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		/*
		 * Get the original shortcode id
		 */
		$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original shortcode data then.
		 */
		$post = get_post( $post_id );

		$current_user    = wp_get_current_user();
		$new_post_author = $current_user->ID;

		/*
		 * if shortcode data exists, create the shortcode duplicate
		 */
		if ( isset( $post ) && $post != null ) {

			/*
			 * new shortcode data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order,
			);

			/*
			 * insert the shortcode by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );

			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies( $post->post_type ); // returns array of taxonomy names for post type, ex array("category", "post_tag");.
			foreach ( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
			}

			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
			if ( count( $post_meta_infos ) != 0 ) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ( $post_meta_infos as $meta_info ) {
					$meta_key = $meta_info->meta_key;
					if ( $meta_key == '_wp_old_slug' ) {
						continue;
					}
					$meta_value      = addslashes( $meta_info->meta_value );
					$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query .= implode( ' UNION ALL ', $sql_query_sel );
				$wpdb->query( $sql_query );
			}

			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect( admin_url( 'edit.php?post_type=' . $post->post_type ) );
			exit;
		} else {
			wp_die( __( 'Shortcode creation failed, could not find original post: ', 'testimonial-pro' ) . $post_id );
		}
	}

	/*
	 * Add the duplicate link to action list for post_row_actions
	 */
	function sp_tpro_duplicate_shortcode_link( $actions, $post ) {
		if ( current_user_can( 'edit_posts' ) && $post->post_type == 'spt_shortcodes' ) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url( 'admin.php?action=sp_tpro_duplicate_shortcode&post=' . $post->ID, basename( __FILE__ ), 'sp_tpro_duplicate_nonce' ) . '" rel="permalink">' . __( 'Duplicate', 'testimonial-pro' ) . '</a>';
		}
		return $actions;
	}

	/**
	 * Social profile list.
	 *
	 * @return void
	 */
	public function social_profile_list() {

		$social_list_one = array(
			'facebook'       => array(
				'name' => esc_html__( 'Facebook', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-facebook"></i>',
			),
			'twitter'        => array(
				'name' => esc_html__( 'Twitter', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-twitter"></i>',
			),
			'linkedin'       => array(
				'name' => esc_html__( 'LinkedIn', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-linkedin"></i>',
			),
			'skype'          => array(
				'name' => esc_html__( 'Skype', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-skype"></i>',
			),
			'dropbox'        => array(
				'name' => esc_html__( 'Dropbox', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-dropbox"></i>',
			),
			'wordpress'      => array(
				'name' => esc_html__( 'WordPress', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-wordpress"></i>',
			),
			'vimeo'          => array(
				'name' => esc_html__( 'Vimeo', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-vimeo"></i>',
			),
			'slideshare'     => array(
				'name' => esc_html__( 'SlideShare', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-slideshare"></i>',
			),
			'vk'             => array(
				'name' => esc_html__( 'VK', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-vk"></i>',
			),
			'tumblr'         => array(
				'name' => esc_html__( 'Tumblr', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-tumblr"></i>',
			),
			'yahoo'          => array(
				'name' => esc_html__( 'Yahoo', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-yahoo"></i>',
			),
			'pinterest'      => array(
				'name' => esc_html__( 'Pinterest', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-pinterest"></i>',
			),
			'youtube'        => array(
				'name' => esc_html__( 'Youtube', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-youtube"></i>',
			),
			'stumbleupon'    => array(
				'name' => esc_html__( 'StumbleUpon', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-stumbleupon"></i>',
			),
			'reddit'         => array(
				'name' => esc_html__( 'Reddit', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-reddit-alien"></i>',
			),
			'quora'          => array(
				'name' => esc_html__( 'Quora', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-quora"></i>',
			),
			'yelp'           => array(
				'name' => esc_html__( 'Yelp', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-yelp"></i>',
			),
			'weibo'          => array(
				'name' => esc_html__( 'Weibo', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-weibo"></i>',
			),
			'product-hunt'   => array(
				'name' => esc_html__( 'ProductHunt', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-product-hunt"></i>',
			),
			'hacker-news'    => array(
				'name' => esc_html__( 'HackerNews', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-hacker-news"></i>',
			),
			'soundcloud'     => array(
				'name' => esc_html__( 'Soundcloud', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-soundcloud"></i>',
			),
			'whatsapp'       => array(
				'name' => esc_html__( 'WhatsApp', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-whatsapp"></i>',
			),
			'medium'         => array(
				'name' => esc_html__( 'Medium', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-medium"></i>',
			),
			'vine'           => array(
				'name' => esc_html__( 'Vine', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-vine"></i>',
			),
			'slack'          => array(
				'name' => esc_html__( 'Slack', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-slack"></i>',
			),
			'instagram'      => array(
				'name' => esc_html__( 'Instagram', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-instagram"></i>',
			),
			'dribbble'       => array(
				'name' => esc_html__( 'Dribble', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-dribbble"></i>',
			),
			'flickr'         => array(
				'name' => esc_html__( 'Flickr', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-flickr"></i>',
			),
			'foursquare'     => array(
				'name' => esc_html__( 'FourSquare', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-foursquare"></i>',
			),
			'behance'        => array(
				'name' => esc_html__( 'Behance', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-behance"></i>',
			),
			'snapchat'       => array(
				'name' => esc_html__( 'SnapChat', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-snapchat-ghost"></i>',
			),
			'github'         => array(
				'name' => esc_html__( 'Github', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-github"></i>',
			),
			'bitbucket'      => array(
				'name' => esc_html__( 'Bitbucket', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-bitbucket"></i>',
			),
			'stack-overflow' => array(
				'name' => esc_html__( 'Stack Overflow', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-stack-overflow"></i>',
			),
			'codepen'        => array(
				'name' => esc_html__( 'Codepen', 'testimonial-pro' ),
				'icon' => '<i class="fa fa-codepen"></i>',
			),
		);
		$social_list_two = apply_filters(
			'sp_testimonial_social_profile_list',
			array()
		);
		$social_list     = array_merge( $social_list_one, $social_list_two );
		return $social_list;
	}

	/**
	 * Social profile name list.
	 *
	 * @return void
	 */
	public function social_profile_name_list() {

		$function    = new SP_Testimonial_Pro_Functions();
		$social_list = $function->social_profile_list();

		if ( ! empty( $social_list ) ) {
			$social_name_option = '';
			foreach ( $social_list as $social_id => $social_value ) {
				$social_name_option .= '<option value="' . $social_id . '">' . $social_value['name'] . '</option>';
			}
			return $social_name_option;
		}
	}

}

new SP_Testimonial_Pro_Functions();

/**
 *
 * Multi Language Support
 *
 * @since 2.0
 */

// Polylang plugin support for multi language support.
if ( class_exists( 'Polylang' ) ) {

	add_filter( 'pll_get_post_types', 'sp_tpro_testimonial_polylang', 10, 2 );

	function sp_tpro_testimonial_polylang( $post_types, $is_settings ) {
		if ( $is_settings ) {
			// hides 'spt_testimonial,spt_shortcodes' from the list of custom post types in Polylang settings.
			unset( $post_types['spt_testimonial'] );
			unset( $post_types['spt_shortcodes'] );
		} else {
			// enables language and translation management for 'spt_testimonial,spt_shortcodes'.
			$post_types['spt_testimonial'] = 'spt_testimonial';
			$post_types['spt_shortcodes']  = 'spt_shortcodes';
		}
		return $post_types;
	}

	add_filter( 'pll_get_taxonomies', 'sp_tpro_cat_polylang', 10, 2 );

	function sp_tpro_cat_polylang( $taxonomies, $is_settings ) {
		if ( $is_settings ) {
			unset( $taxonomies['testimonial_cat'] );
		} else {
			$taxonomies['testimonial_cat'] = 'testimonial_cat';
		}
		return $taxonomies;
	}
}

/**
 * Redirect function.
 *
 * @param [type] $url
 * @return void
 */
function tpro_redirect( $url ) {
	$string  = '<script type="text/javascript">';
	$string .= 'window.location = "' . $url . '"';
	$string .= '</script>';
	echo $string;
}

/**
 * The social icons.
 *
 * @param string $social_name.
 * @return void
 */
function tpro_social_icon( $social_name ) {
	$function         = new SP_Testimonial_Pro_Functions();
	$social_icon_list = $function->social_profile_list();
	foreach ( $social_icon_list as $social_icon_id => $social_icon ) {
		if ( $social_icon_id == $social_name ) {
			return $social_icon['icon'];
		}
	}
}

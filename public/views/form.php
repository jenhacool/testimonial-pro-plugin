<?php

/**
 * Frontend form.
 *
 * @package TestimonialPro
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * FrontEnd form Shortcode Render class
 *
 * @since 2.0
 */
if ( ! class_exists( 'TPRO_Frontend_Form' ) ) {
	class TPRO_Frontend_Form {


		/**
		 * Construct.
		 */
		public function __construct() {
			 add_shortcode( 'sp_testimonial_form', array( $this, 'frontend_form' ) );
		}

		/**
		 * @param $attributes
		 *
		 * @return string
		 * @since 2.0
		 */
		public function frontend_form( $attributes ) {

			$form_id               = $attributes['id'];
			$setting_options       = get_option( 'sp_testimonial_pro_options' );
			$form_elements         = get_post_meta( $form_id, 'sp_tpro_form_elements_options', true );
			$form_element          = isset( $form_elements['form_elements'] ) ? $form_elements['form_elements'] : array();
			$form_data             = get_post_meta( $form_id, 'sp_tpro_form_options', true );
			$captcha_site_key_v3   = isset( $setting_options['captcha_site_key_v3'] ) ? $setting_options['captcha_site_key_v3'] : '';
			$captcha_version       = isset( $setting_options['captcha_version'] ) ? $setting_options['captcha_version'] : 'v2';
			$captcha_secret_key_v3 = isset( $setting_options['captcha_secret_key_v3'] ) ? $setting_options['captcha_secret_key_v3'] : '';
			// Form Scripts and Styles.
			if ( in_array( 'recaptcha', $form_element ) && ( $setting_options['captcha_site_key'] !== '' || $captcha_site_key_v3 !== '' ) && ( $setting_options['captcha_secret_key'] !== '' || $captcha_secret_key_v3 !== '' ) ) {
				if ( 'v2' === $captcha_version ) {
					wp_enqueue_script( 'tpro-recaptcha-js' );
				} else {
					wp_enqueue_script( 'tpro-recaptcha-v3-js', '//www.google.com/recaptcha/api.js?render=' . $captcha_site_key_v3, array(), SP_TPRO_VERSION, true );
					wp_add_inline_script(
						'tpro-recaptcha-v3-js',
						'grecaptcha.ready(function() {
						grecaptcha.execute("' . $captcha_site_key_v3 . '", {action: "submit"}).then(function(token) {
						   document.getElementById("token").value = token;
						});
					});'
					);
				}
			}
			wp_enqueue_script( 'tpro-chosen-jquery' );
			wp_enqueue_script( 'tpro-chosen-config' );
			wp_enqueue_style( 'tpro-chosen' );

			$form_fields                = $form_data['form_fields'];
			$full_name                  = $form_fields['full_name'];
			$full_name_required         = $full_name['required'] ? 'required' : '';
			$email_address              = $form_fields['email_address'];
			$email_address_required     = $email_address['required'] ? 'required' : '';
			$identity_position          = $form_fields['identity_position'];
			$identity_position_required = $identity_position['required'] ? 'required' : '';
			$company_name               = $form_fields['company_name'];
			$company_name_required      = $company_name['required'] ? 'required' : '';
			$testimonial_title          = $form_fields['testimonial_title'];
			$testimonial_title_required = $testimonial_title['required'] ? 'required' : '';
			$testimonial                = $form_fields['testimonial'];
			$testimonial_required       = $testimonial['required'] ? 'required' : '';
			$featured_image             = $form_fields['featured_image'];
			$featured_image_required    = $featured_image['required'] ? 'required' : '';
			$location                   = $form_fields['location'];
			$location_required          = $location['required'] ? 'required' : '';
			$phone_mobile               = $form_fields['phone_mobile'];
			$phone_mobile_required      = $phone_mobile['required'] ? 'required' : '';
			$website                    = $form_fields['website'];
			$website_required           = $website['required'] ? 'required' : '';
			$video_url                  = $form_fields['video_url'];
			$video_url_required         = $video_url['required'] ? 'required' : '';
			$groups                     = $form_fields['groups'];
			$groups_list                = isset( $groups['groups_list'] ) ? $groups['groups_list'] : '';
			$groups_multiple_selection  = $groups['multiple_selection'] ? 'multiple="multiple" ' : '';
			$rating                     = $form_fields['rating'];
			$recaptcha                  = $form_fields['recaptcha'];
			$submit_btn                 = $form_fields['submit_btn'];
			$social_profile             = $form_fields['social_profile'];
			$social_profile_list        = isset( $social_profile['social_profile_list'] ) && ! empty( $social_profile['social_profile_list'] ) ? $social_profile['social_profile_list'] : '';
			$tpro_function              = new SP_Testimonial_Pro_Functions();

			// Testimonial submit form.
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['action'] ) && $_POST['action'] == 'testimonial_form' ) {

				if (
					isset( $_POST['testimonial_form_nonce'] ) || wp_verify_nonce( $_POST['testimonial_form_nonce'], 'testimonial_form' )
				) {
					$tpro_client_name            = isset( $_POST['tpro_client_name'] ) ? wp_strip_all_tags( $_POST['tpro_client_name'] ) : '';
					$tpro_client_email           = isset( $_POST['tpro_client_email'] ) ? sanitize_email( $_POST['tpro_client_email'] ) : '';
					$tpro_client_designation     = isset( $_POST['tpro_client_designation'] ) ? sanitize_text_field( $_POST['tpro_client_designation'] ) : '';
					$tpro_company_name           = isset( $_POST['tpro_client_company_name'] ) ? sanitize_text_field( $_POST['tpro_client_company_name'] ) : '';
					$tpro_location               = isset( $_POST['tpro_client_location'] ) ? sanitize_text_field( $_POST['tpro_client_location'] ) : '';
					$tpro_phone                  = isset( $_POST['tpro_client_phone'] ) ? preg_replace( '/[^0-9+-]/', '', $_POST['tpro_client_phone'] ) : '';
					$tpro_website                = isset( $_POST['tpro_client_website'] ) ? esc_url( $_POST['tpro_client_website'] ) : '';
					$tpro_video_url              = isset( $_POST['tpro_client_video_url'] ) ? esc_url( $_POST['tpro_client_video_url'] ) : '';
					$tpro_client_testimonial_cat = isset( $_POST['tpro_client_testimonial_cat'] ) ? $_POST['tpro_client_testimonial_cat'] : '';
					$tpro_testimonial_title      = isset( $_POST['tpro_testimonial_title'] ) ? sanitize_text_field( $_POST['tpro_testimonial_title'] ) : '';
					$tpro_testimonial_text       = isset( $_POST['tpro_client_testimonial'] ) ? sanitize_textarea_field( $_POST['tpro_client_testimonial'] ) : '';
					$tpro_rating_star            = isset( $_POST['tpro_client_rating'] ) ? sanitize_key( $_POST['tpro_client_rating'] ) : '';
					$tpro_social_profiles        = isset( $_POST['tpro_social_profiles'] ) ? $_POST['tpro_social_profiles'] : '';

					// ADD THE FORM INPUT TO $testimonial_form ARRAY.
					$testimonial_form = array(
						'post_title'   => $tpro_testimonial_title,
						'post_content' => $tpro_testimonial_text,
						'post_status'  => $form_data['testimonial_approval_status'],
						'post_type'    => 'spt_testimonial',
						'meta_input'   => array(
							'sp_tpro_meta_options' => array(
								'tpro_name'            => $tpro_client_name,
								'tpro_email'           => $tpro_client_email,
								'tpro_designation'     => $tpro_client_designation,
								'tpro_company_name'    => $tpro_company_name,
								'tpro_location'        => $tpro_location,
								'tpro_phone'           => $tpro_phone,
								'tpro_website'         => $tpro_website,
								'tpro_video_url'       => $tpro_video_url,
								'tpro_rating'          => $tpro_rating_star,
								'tpro_social_profiles' => $tpro_social_profiles,
							),
						),
					);

					$tpro_redirect = $form_data['tpro_redirect'];
					if ( in_array( 'recaptcha', $form_element ) && ( $setting_options['captcha_site_key'] !== '' || $captcha_site_key_v3 !== '' ) && ( $setting_options['captcha_secret_key'] !== '' || $captcha_secret_key_v3 !== '' ) ) {
						// Empty MSG.
						$captcha_error_msg = '';
						$validation_msg    = '';

						if ( isset( $_POST['submit'] ) && ! empty( $_POST['submit'] ) ) {
							// Recaptcha v3.
							if ( 'v3' === $captcha_version ) {
								$response_token = isset( $_POST['token'] ) ? $_POST['token'] : '';
								$secret         = $captcha_secret_key_v3;
							}else{
								$response_token = isset( $_POST['g-recaptcha-response'] ) ? $_POST['g-recaptcha-response'] : '';
								$secret         = $setting_options['captcha_secret_key'];
							}
							if ( ! empty( $response_token ) ) {
								$pid = wp_insert_post( $testimonial_form );
								// get verify response data.
								$verifyResponse = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response_token );
								$responseData   = json_decode( $verifyResponse['body'], true );
								$responseData2  = json_decode( $responseData['success'], true );
								if ( $responseData2 == true ) {
									// Save The Testimonial.
									if ( $pid ) {
										wp_set_post_terms( $pid, $tpro_client_testimonial_cat, 'testimonial_cat' );

										// Thanks message.
										switch ( $tpro_redirect ) {
											case 'to_a_page':
												tpro_redirect( get_page_link( $form_data['tpro_redirect_to_page'] ) );
												break;
											case 'custom_url':
												tpro_redirect( esc_url( $form_data['tpro_redirect_custom_url'] ) );
												break;
											default:
												$validation_msg .= $form_data['successful_message'];
												break;
										}
									}
								} else {
									$captcha_error_msg .= esc_html__( 'Robot verification failed, please try again.', 'testimonial-pro' );
								}
							} else {
								$captcha_error_msg .= esc_html__( 'Please click on the reCAPTCHA box.', 'testimonial-pro' );
							}
						}
					} else {
						// Empty MSG.
						$validation_msg = '';

						// Save The Testimonial.
						$pid = wp_insert_post( $testimonial_form );

						if ( $pid ) {
							wp_set_post_terms( $pid, $tpro_client_testimonial_cat, 'testimonial_cat' );

							// Thanks message.
							switch ( $tpro_redirect ) {
								case 'to_a_page':
									tpro_redirect( get_page_link( $form_data['tpro_redirect_to_page'] ) );
									break;
								case 'custom_url':
									tpro_redirect( esc_url( $form_data['tpro_redirect_custom_url'] ) );
									break;
								default:
									$validation_msg .= $form_data['successful_message'];
									break;
							}
						}
					}
					// Client Image.
					if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
						require_once ABSPATH . 'wp-admin' . '/includes/image.php';
						require_once ABSPATH . 'wp-admin' . '/includes/file.php';
						require_once ABSPATH . 'wp-admin' . '/includes/media.php';
					}
					if ( $_FILES ) {
						foreach ( $_FILES as $file => $array ) {
							if ( $_FILES[ $file ]['error'] !== UPLOAD_ERR_OK ) {
							} else {
								$attach_id = media_handle_upload( $file, $pid );

								if ( $attach_id > 0 ) {
									// Set post image.
									update_post_meta( $pid, '_thumbnail_id', $attach_id );
								}
							}
						}
					}

					/**
					 * Email notification.
					 */
					if ( $form_data['submission_email_notification'] ) {

						$tpro_category = '';
						if ( $tpro_client_testimonial_cat ) {
							foreach ( $tpro_client_testimonial_cat as $term ) {
								$tpro_category_name[] = get_the_category_by_ID( $term );
							};
							$tpro_category = implode( ', ', $tpro_category_name );
						}

						// $tpro_rating_star = $testimonial_data['tpro_rating'];
						$tpro_empty_star = '<span style="color: #d4d4d4;font-size: 17px;">&#x2605;</span>';
						$tpro_fil_star   = '<span style="color: #FF9800;font-size: 17px;">&#x2605;</span>';
						switch ( $tpro_rating_star ) {
							case 'one_star':
								$tpro_rating = $tpro_fil_star . $tpro_empty_star . $tpro_empty_star . $tpro_empty_star . $tpro_empty_star;
								break;
							case 'two_star':
								$tpro_rating = $tpro_fil_star . $tpro_fil_star . $tpro_empty_star . $tpro_empty_star . $tpro_empty_star;
								break;
							case 'three_star':
								$tpro_rating = $tpro_fil_star . $tpro_fil_star . $tpro_fil_star . $tpro_empty_star . $tpro_empty_star;
								break;
							case 'four_star':
								$tpro_rating = $tpro_fil_star . $tpro_fil_star . $tpro_fil_star . $tpro_fil_star . $tpro_empty_star;
								break;
							case 'five_star':
								$tpro_rating = $tpro_fil_star . $tpro_fil_star . $tpro_fil_star . $tpro_fil_star . $tpro_fil_star;
								break;
							default:
								$tpro_rating = '';
								break;
						}

						$subject = $form_data['submission_email_subject'];
						$heading = $form_data['submission_email_heading'];

						$email_to_list    = $form_data['submission_email_notification_to'];
						$email_to         = explode( ',', $email_to_list );
						$admin_email      = get_option( 'admin_email' );
						$site_name        = get_bloginfo( 'name' );
						$site_description = '- ' . get_bloginfo( 'description' );

						$message  = '';
						$message .= '<div style="background-color: #f6f6f6;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;">';
						$message .= '<div style="width: 100%;margin: 0;padding: 70px 0 70px 0;">';
						$message .= '<div style="background-color: #ffffff;border: 1px solid #e9e9e9;border-radius: 2px!important;padding: 20px 20px 10px 20px;width: 520px;margin: 0 auto;">';
						$message .= '<h1 style="color: #000000;margin: 0;padding: 28px 24px;font-size: 32px;font-weight: 500;text-align: center;">' . $heading . '</h1>';
						$message .= '<div style="padding: 30px 20px 40px;">';

						$message_content = $form_data['submission_email_body'];

						$message_content = str_replace( '{name}', $tpro_client_name, $message_content );
						$message_content = str_replace( '{email}', $tpro_client_email, $message_content );
						$message_content = str_replace( '{position}', $tpro_client_designation, $message_content );
						$message_content = str_replace( '{company_name}', $tpro_company_name, $message_content );
						$message_content = str_replace( '{location}', $tpro_location, $message_content );
						$message_content = str_replace( '{phone}', $tpro_phone, $message_content );
						$message_content = str_replace( '{website}', $tpro_website, $message_content );
						$message_content = str_replace( '{video_url}', $tpro_video_url, $message_content );
						$message_content = str_replace( '{testimonial_title}', $tpro_testimonial_title, $message_content );
						$message_content = str_replace( '{testimonial_text}', $tpro_testimonial_text, $message_content );
						$message_content = str_replace( '{groups}', $tpro_category, $message_content );
						$message_content = str_replace( '{rating}', $tpro_rating, $message_content );

						$message_content = apply_filters( 'testimonial_pro_email_preview_template_tags', $message_content );

						$message .= wpautop( $message_content );

						$message .= '</div>';

						$message .= '<div style="border-top:1px solid #efefef;padding:20px 0;clear:both;text-align:center"><small style="font-size:11px">' . $site_name . ' ' . $site_description . '</small></div>';

						$message .= '</div>';
						$message .= '</div>';
						$message .= '</div>';

						if ( ! empty( $tpro_client_email ) ) {
							$email_header = array(
								'Content-Type: text/html; charset=UTF-8',
								'From: "' . $tpro_client_name . '" < ' . $tpro_client_email . ' >',
							);
						} else {
							$email_header = array(
								'Content-Type: text/html; charset=UTF-8',
								'From: "' . $tpro_client_name . '" < ' . $admin_email . ' >',
							);
						}

						// Send email to.
						wp_mail( $email_to, $subject, $message, $email_header );
					}
				} else {
					wp_die( esc_html__( 'Our site is protected!', 'testimonial-pro' ) );
				}
			} // END THE IF STATEMENT THAT STARTED THE WHOLE FORM.

			$output = '';
			ob_start();
			$label_color         = isset( $form_data['label_color'] ) ? $form_data['label_color'] : '';
			$submit_button_color = isset( $form_data['submit_button_color'] ) ? $form_data['submit_button_color'] : '';
			$output             .= '<style>#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-form-field label{
				font-size: 16px;
				color: ' . $label_color . ';
			}
			#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-form-submit-button input[type=\'submit\']{
				color: ' . $submit_button_color['color'] . ';
				background: ' . $submit_button_color['background'] . ';
			}
			#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-form-submit-button input[type=\'submit\']:hover{
				color: ' . $submit_button_color['hover-color'] . ';
				background: ' . $submit_button_color['hover-background'] . ';
			}
			#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-client-rating:not(:checked)>label{
				color: #d4d4d4;
			}
			#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-client-rating>input:checked~label {
				color: #f3bb00;
			}
			#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-client-rating:not(:checked)>label:hover,
			#testimonial_form_' . $form_id . '.sp-tpro-fronted-form .sp-tpro-client-rating:not(:checked)>label:hover~label {
				color: #de7202;
			}</style>';
			ob_end_flush();
			$output .= '<div id="testimonial_form_' . $form_id . '" class="sp-tpro-fronted-form">
				<form id="testimonial_form" name="testimonial_form" method="post" action="" enctype="multipart/form-data">';

			if ( ! empty( $validation_msg ) && 'top' == $form_data['tpro_message_position'] ) {
				$output .= '<div class="sp-tpro-form-validation-msg">' . stripslashes( $validation_msg ) . '</div>';
			}

			foreach ( $form_fields as $field_id => $form_field ) {
				switch ( $field_id ) {
					case 'full_name':
						if ( in_array( 'name', $form_element ) ) {
							$full_name_label = isset( $full_name['label'] ) ? $full_name['label'] : '';
							$output         .= '<div class="sp-tpro-form-field">';
							if ( $full_name_label ) {
								$output .= '<label for="tpro_client_name">' . esc_html( $full_name_label ) . '</label><br>';
							}
							$output .= '<input type="text" id="tpro_client_name" name="tpro_client_name" ' . esc_html( $full_name_required ) . ' placeholder="' . esc_html( $full_name['placeholder'] ) . '"/>
								</div>';
						}
						break;
					case 'email_address':
						if ( in_array( 'email', $form_element ) ) {
							$email_address_label = isset( $email_address['label'] ) ? $email_address['label'] : '';
							$output             .= '<div class="sp-tpro-form-field">';
							if ( $email_address_label ) {
								$output .= '<label for="tpro_client_email">' . esc_html( $email_address_label ) . '</label><br>';
							}
							$output .= '<input type="email" name="tpro_client_email" id="tpro_client_email" ' . esc_html( $email_address_required ) . ' placeholder="' . esc_html( $email_address['placeholder'] ) . '"/>
								</div>';
						}
						break;
					case 'identity_position':
						if ( in_array( 'position', $form_element ) ) {
							$identity_position_label = isset( $identity_position['label'] ) ? $identity_position['label'] : '';
							$output                 .= '<div class="sp-tpro-form-field">';
							if ( $identity_position_label ) {
								$output .= '<label for="tpro_client_designation">' . esc_html( $identity_position_label ) . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_client_designation" id="tpro_client_designation" ' . esc_html( $identity_position_required ) . ' placeholder="' . esc_html( $identity_position['placeholder'] ) . '"/>
								</div>';
						}
						break;
					case 'company_name':
						if ( in_array( 'company', $form_element ) ) {
							$company_name_label = isset( $company_name['label'] ) ? $company_name['label'] : '';
							$output            .= '<div class="sp-tpro-form-field">';
							if ( $company_name_label ) {
								$output .= '<label for="tpro_client_company_name">' . esc_html( $company_name_label ) . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_client_company_name" id="tpro_client_company_name" ' . esc_html( $company_name_required ) . ' placeholder="' . esc_html( $company_name['placeholder'] ) . '"/>
							</div>';
						}
						break;
					case 'testimonial_title':
						if ( in_array( 'testimonial_title', $form_element ) ) {
							$testimonial_title_label = isset( $testimonial_title['label'] ) ? $testimonial_title['label'] : '';
							$output                 .= '<div class="sp-tpro-form-field">';
							if ( $testimonial_title_label ) {
								$output .= '<label for="tpro_testimonial_title">' . esc_html( $testimonial_title_label ) . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_testimonial_title" id="tpro_testimonial_title" ' . esc_html( $testimonial_title_required ) . ' placeholder="' . esc_html( $testimonial_title['placeholder'] ) . '"/>
								</div>';
						}
						break;
					case 'testimonial':
						if ( in_array( 'testimonial', $form_element ) ) {
							$testimonial_label = isset( $testimonial['label'] ) ? $testimonial['label'] : '';
							$output           .= '<div class="sp-tpro-form-field">';
							if ( $testimonial_label ) {
								$output .= '<label for="tpro_client_testimonial">' . esc_html( $testimonial_label ) . '</label><br>';
							}
							$output .= '<textarea rows="7" type="text" name="tpro_client_testimonial" id="tpro_client_testimonial" ' . esc_html( $testimonial_required ) . ' placeholder="' . esc_html( $testimonial['placeholder'] ) . '"></textarea>
								</div>';
						}
						break;
					case 'groups':
						if ( in_array( 'groups', $form_element ) ) {
							$group_label = isset( $groups['label'] ) ? $groups['label'] : '';
							$output     .= '<div class="sp-tpro-form-field">';
							if ( $group_label ) {
								$output .= '<label for="tpro_client_testimonial_cat">' . esc_html( $group_label ) . '</label><br>';
							}
							if ( ! empty( $groups_list ) ) {
								$output .= '<select name="tpro_client_testimonial_cat[]" id="tpro_client_testimonial_cat" class="chosen-select" data-placeholder="' . $groups['placeholder'] . '"  ' . $groups_multiple_selection . ' data-depend-id="tpro_client_testimonial_cat">';
								foreach ( $groups_list as $group_id ) {
									$term    = get_term( $group_id );
									$output .= '<option value="' . $term->term_id . '">' . $term->name . '</option>';
								}
								$output .= '</select>';
							} else {
								$terms = get_terms(
									'testimonial_cat',
									array(
										'hide_empty' => 0,
									)
								);
								if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
									$output .= '<select name="tpro_client_testimonial_cat[]" id="tpro_client_testimonial_cat" class="chosen-select" data-placeholder="' . $groups['placeholder'] . '" ' . $groups_multiple_selection . ' data-depend-id="tpro_client_testimonial_cat">';
									foreach ( $terms as $term ) {
										$output .= '<option value="' . $term->term_id . '">' . $term->name . '</option>';
									}
									$output .= '</select>';
								};
							}

							$output .= '</div>';
						}
						break;
					case 'featured_image':
						if ( in_array( 'image', $form_element ) ) {
							$featured_image_label = isset( $featured_image['label'] ) ? $featured_image['label'] : '';
							$output              .= '<div class="sp-tpro-form-field">';
							if ( $featured_image_label ) {
								$output .= '<label for="tpro_client_image">' . $featured_image_label . '</label><br>';
							}
							$output .= '<input type="file" name="tpro_client_image" id="tpro_client_image" ' . $featured_image_required . ' accept="image/jpeg,image/jpg,image/png,"/>';
							$output .= '</div>';
						}
						break;
					case 'location':
						if ( in_array( 'location', $form_element ) ) {
							$location_label = isset( $location['label'] ) ? $location['label'] : '';
							$output        .= '<div class="sp-tpro-form-field">';
							if ( $location_label ) {
								$output .= '<label for="tpro_client_location">' . $location_label . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_client_location" id="tpro_client_location" ' . $location_required . ' placeholder="' . $location['placeholder'] . '"/>';
							$output .= '</div>';
						}
						break;
					case 'phone_mobile':
						if ( in_array( 'phone_mobile', $form_element ) ) {
							$phone_mobile_label = isset( $phone_mobile['label'] ) ? $phone_mobile['label'] : '';
							$output            .= '<div class="sp-tpro-form-field">';
							if ( $phone_mobile_label ) {
								$output .= '<label for="tpro_client_phone">' . $phone_mobile_label . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_client_phone" id="tpro_client_phone" ' . $phone_mobile_required . ' placeholder="' . $phone_mobile['placeholder'] . '"/>';
							$output .= '</div>';
						}
						break;
					case 'website':
						if ( in_array( 'website', $form_element ) ) {
							$website_label = isset( $website['label'] ) ? $website['label'] : '';
							$output       .= '<div class="sp-tpro-form-field">';
							if ( $website_label ) {
								$output .= '<label for="tpro_client_website">' . $website_label . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_client_website" id="tpro_client_website" ' . $website_required . ' placeholder="' . $website['placeholder'] . '"/>';
							$output .= '</div>';
						}
						break;
					case 'video_url':
						if ( in_array( 'video_url', $form_element ) ) {
							$video_label = isset( $video_url['label'] ) ? $video_url['label'] : '';
							$output     .= '<div class="sp-tpro-form-field">';
							if ( $video_label ) {
								$output .= '<label for="tpro_client_video_url">' . $video_label . '</label><br>';
							}
							$output .= '<input type="text" name="tpro_client_video_url" id="tpro_client_video_url" ' . $video_url_required . ' placeholder="' . $video_url['placeholder'] . '"/>';
							$output .= '</div>';
						}
						break;
					case 'social_profile':
						if ( in_array( 'social_profile', $form_element ) ) {
							$social_profile_label = isset( $social_profile['label'] ) ? $social_profile['label'] : '';
							$output              .= '<div class="sp-tpro-form-field">';
							if ( $social_profile_label ) {
								$output .= '<label for="tpro_social_profile">' . esc_html( $social_profile_label ) . '</label><br>';
							}
							$output .= '<div class="tpro-social-profile-wrapper">
										<div id="tpro-social-profiles">
											<div class="tpro-social-profile-item" data-group="tpro_social_profiles">
												<div class="tpro-social-profile-content">
													<div class="tpro-social-name-field">
														<select class="tpro-social-name" data-name="social_name" placeholder="Select">
														<option value="">Select</option>';
							if ( $social_profile_list ) {
								foreach ( $social_profile_list as $profile ) {
									$output .= '<option value="' . esc_attr( $profile ) . '">' . esc_html( ucfirst( $profile ) ) . '</option>';
								}
							} else {
								$output .= $tpro_function->social_profile_name_list();
							}
							$output .= '</select>
													</div>
													<div class="tpro-social-url-field">
														<input type="text" class="tpro-social-url" data-name="social_url" placeholder="Social URL" >
													</div>
												</div>
												<div class="tpro-social-remove"><i class="tpro-social-profile-remove fa fa-times"></i></div>
											</div>
										</div>
										<span class="tpro-add-new-profile-btn">Add New</span>
									</div>
								</div>';
						}
						break;
					case 'rating':
						if ( in_array( 'rating', $form_element ) ) {
							$rating_label = isset( $rating['label'] ) ? $rating['label'] : '';
							$output      .= '<div class="sp-tpro-form-field">';
							if ( $rating_label ) {
								$output .= '<label for="tpro_client_rating">' . $rating_label . '</label><br>';
							}
							$output .= '<div class="sp-tpro-client-rating">
                                <input type="radio" name="tpro_client_rating" id="_tpro_rating_5" value="five_star">
                                <label for="_tpro_rating_5" title="Five Stars"><i class="fa fa-star"></i></label>

                                <input type="radio" name="tpro_client_rating" id="_tpro_rating_4" value="four_star">
                                <label for="_tpro_rating_4" title="Four Stars"><i class="fa fa-star"></i></label>

                                <input type="radio" name="tpro_client_rating" id="_tpro_rating_3" value="three_star">
                                <label for="_tpro_rating_3" title="Three Stars"><i class="fa fa-star"></i></label>

                                <input type="radio" name="tpro_client_rating" id="_tpro_rating_2" value="two_star">
                                <label for="_tpro_rating_2" title="Two Star"><i class="fa fa-star"></i></label>

                                <input type="radio" name="tpro_client_rating" id="_tpro_rating_1" value="one_star">
                                <label for="_tpro_rating_1" title="One Star"><i class="fa fa-star"></i></label>
                            </div><br>';
							$output .= '</div>';
						}
						break;
					case 'recaptcha':
						if ( in_array( 'recaptcha', $form_element ) && $setting_options['captcha_site_key'] !== '' && $setting_options['captcha_secret_key'] !== '' && 'v2' === $captcha_version ) {
							$recaptcha_label = isset( $recaptcha['label'] ) ? $recaptcha['label'] : '';
							$output         .= '<div class="sp-tpro-form-field">';
							if ( $recaptcha_label ) {
								$output .= '<label for="tpro_recaptcha">' . $recaptcha_label . '</label><br>';
							}
							$output .= '<div class="g-recaptcha" data-sitekey="' . $setting_options['captcha_site_key'] . '"></div>';
							if ( ! empty( $captcha_error_msg ) ) {
								$output .= '<span class="sp-tpro-form-error-msg">' . $captcha_error_msg . '</span>';
							}
							$output .= '</div>';
						}
						break;
					case 'submit_btn':
						$output .= '<div class="sp-tpro-form-submit-button">';
						$output .= wp_nonce_field( 'testimonial_form', 'testimonial_form_nonce', true, false );
						if ( 'v3' === $captcha_version ) {
							$output .= '<input type="hidden" id="token" name="token">';
						}
						$output .= '<input type="submit" value="' . esc_html( $submit_btn['label'] ) . '" id="submit" name="submit"/>
								<input type="hidden" name="action" value="testimonial_form"/>
							</div>';
						break;
				}
			}

			if ( ! empty( $validation_msg ) && 'bottom' == $form_data['tpro_message_position'] ) {
				$output .= '<div class="sp-tpro-form-validation-msg">' . stripslashes( $validation_msg ) . '</div>';
			}
				$output .= '</form>
			</div>';
			return $output;
		}
	}

	new TPRO_Frontend_Form();
}

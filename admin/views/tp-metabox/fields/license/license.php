<?php if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.
/**
 *
 * Field: license
 *
 * @since 2.2.4
 * @version 2.2.4
 */
if ( ! class_exists( 'SPFTESTIMONIAL_Field_license' ) ) {
	class SPFTESTIMONIAL_Field_license extends SPFTESTIMONIAL_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {

			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {
			echo $this->field_before();
			$type = ( ! empty( $this->field['attributes']['type'] ) ) ? $this->field['attributes']['type'] : 'text';

			$manage_license       = new Testimonial_Pro_License( SP_TESTIMONIAL_PRO_FILE, SP_TPRO_VERSION, 'ShapedPlugin', SP_TPRO_STORE_URL, SP_TPRO_ITEM_ID, SP_TPRO_ITEM_SLUG );
			$license_key          = $manage_license->get_license_key();
			$license_key_status   = $manage_license->get_license_status();
			$license_status       = ( is_object( $license_key_status ) ? $license_key_status->license : '' );
			$license_notices      = $manage_license->license_notices();
			$license_status_class = '';
			$license_active       = '';
			$license_data         = $manage_license->api_request();

			echo '<div class="testimonial-pro-license text-center">';
			echo '<h3>' . __( 'Testimonial Pro License Key', 'testimonial-pro' ) . '</h3>';
			if ( 'valid' == $license_status ) {
				$license_status_class = 'license-key-active';
				$license_active       = '<span>' . __( 'Active', 'testimonial-pro' ) . '</span>';
				echo '<p>' . __( 'Your license key is active.', 'testimonial-pro' ) . '</p>';
			} elseif ( 'expired' == $license_status ) {
				echo '<p style="color: red;">Your license key expired on ' . date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ) . '. <a href="' . SP_TPRO_STORE_URL . '/checkout/?edd_license_key=' . $license_key . '&download_id=' . SP_TPRO_ITEM_ID . '&utm_campaign=testimonial_pro&utm_source=licenses&utm_medium=expired" target="_blank">Renew license key at discount.</a></p>';
			} else {
				echo '<p>Please activate your license key to make the plugin work. <a href="https://docs.shapedplugin.com/docs/testimonial-pro/getting-started/activating-license-key/" target="_blank">How to activate license key?</a></p>';
			}
			echo '<div class="testimonial-pro-license-area">';
			echo '<div class="testimonial-pro-license-key"><input class="testimonial-pro-license-key-input ' . $license_status_class . '" type="' . $type . '" name="' . $this->field_name() . '" value="' . $this->value . '"' . $this->field_attributes() . ' />' . $license_active . '</div>';
			wp_nonce_field( 'sp_testimonial_pro_nonce', 'sp_testimonial_pro_nonce' );
			if ( 'valid' == $license_status ) {
				echo '<input style="color: #dc3545; border-color: #dc3545;" type="submit" class="button-secondary btn-license-deactivate" name="sp_testimonial_pro_license_deactivate" value="' . __( 'Deactivate', 'testimonial-pro' ) . '"/>';
			} else {
				echo '<input type="submit" class="button-secondary btn-license-save-activate" name="' . $this->unique . '[_nonce][save]" value="' . __( 'Activate', 'testimonial-pro' ) . '"/>';
				echo '<input type="hidden" class="btn-license-activate" name="sp_testimonial_pro_license_activate" value="' . __( 'Activate', 'testimonial-pro' ) . '"/>';
			}
			echo '<br><div class="testimonial-pro-license-error-notices">' . $license_notices . '</div>';
			echo '</div>';
			echo '</div>';
			echo $this->field_after();
		}

	}
}

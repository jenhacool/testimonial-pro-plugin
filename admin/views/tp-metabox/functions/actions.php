<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'spftestimonial_get_icons' ) ) {
  function spftestimonial_get_icons() {

    if( ! empty( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'spftestimonial_icon_nonce' ) ) {

      ob_start();

      SPFTESTIMONIAL::include_plugin_file( 'fields/icon/default-icons.php' );

      $icon_lists = apply_filters( 'spftestimonial_field_icon_add_icons', spftestimonial_get_default_icons() );

      if( ! empty( $icon_lists ) ) {

        foreach ( $icon_lists as $list ) {

          echo ( count( $icon_lists ) >= 2 ) ? '<div class="spftestimonial-icon-title">'. $list['title'] .'</div>' : '';

          foreach ( $list['icons'] as $icon ) {
            echo '<a class="spftestimonial-icon-tooltip" data-spftestimonial-icon="'. $icon .'" title="'. $icon .'"><span class="spftestimonial-icon spftestimonial-selector"><i class="'. $icon .'"></i></span></a>';
          }

        }

      } else {

        echo '<div class="spftestimonial-text-error">'. esc_html__( 'No data provided by developer', 'testimonial-pro' ) .'</div>';

      }

      wp_send_json_success( array( 'content' => ob_get_clean() ) );

    } else {

      wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'testimonial-pro' ) ) );

    }

  }
  add_action( 'wp_ajax_spftestimonial-get-icons', 'spftestimonial_get_icons' );
}

/**
 *
 * Export
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'spftestimonial_export' ) ) {
  function spftestimonial_export() {

    if( ! empty( $_GET['export'] ) && ! empty( $_GET['nonce'] ) && wp_verify_nonce( $_GET['nonce'], 'spftestimonial_backup_nonce' ) ) {

      header('Content-Type: application/json');
      header('Content-disposition: attachment; filename=backup-'. gmdate( 'd-m-Y' ) .'.json');
      header('Content-Transfer-Encoding: binary');
      header('Pragma: no-cache');
      header('Expires: 0');

      echo json_encode( get_option( wp_unslash( $_GET['export'] ) ) );

    }

    die();
  }
  add_action( 'wp_ajax_spftestimonial-export', 'spftestimonial_export' );
}

/**
 *
 * Import Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'spftestimonial_import_ajax' ) ) {
  function spftestimonial_import_ajax() {

    if( ! empty( $_POST['import_data'] ) && ! empty( $_POST['unique'] ) && ! empty( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'spftestimonial_backup_nonce' ) ) {

      $import_data = json_decode( wp_unslash( trim( $_POST['import_data'] ) ), true );

      if( is_array( $import_data ) ) {

        update_option( wp_unslash( $_POST['unique'] ), wp_unslash( $import_data ) );
        wp_send_json_success();

      }

    }

    wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'testimonial-pro' ) ) );

  }
  add_action( 'wp_ajax_spftestimonial-import', 'spftestimonial_import_ajax' );
}

/**
 *
 * Reset Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'spftestimonial_reset_ajax' ) ) {
  function spftestimonial_reset_ajax() {

    if( ! empty( $_POST['unique'] ) && ! empty( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'spftestimonial_backup_nonce' ) ) {
      delete_option( wp_unslash( $_POST['unique'] ) );
      wp_send_json_success();
    }

    wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'testimonial-pro' ) ) );

  }
  add_action( 'wp_ajax_spftestimonial-reset', 'spftestimonial_reset_ajax' );
}

/**
 *
 * Chosen Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'spftestimonial_chosen_ajax' ) ) {
  function spftestimonial_chosen_ajax() {

    if( ! empty( $_POST['term'] ) && ! empty( $_POST['type'] ) && ! empty( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'spftestimonial_chosen_ajax_nonce' ) ) {

      $capability = apply_filters( 'spftestimonial_chosen_ajax_capability', 'manage_options' );

      if( current_user_can( $capability ) ) {

        $type       = $_POST['type'];
        $term       = $_POST['term'];
        $query_args = ( ! empty( $_POST['query_args'] ) ) ? $_POST['query_args'] : array();
        $options    = SPFTESTIMONIAL_Fields::field_data( $type, $term, $query_args );

        wp_send_json_success( $options );

      } else {
        wp_send_json_error( array( 'error' => esc_html__( 'You do not have required permissions to access.', 'testimonial-pro' ) ) );
      }

    } else {
      wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'testimonial-pro' ) ) );
    }

  }
  add_action( 'wp_ajax_spftestimonial-chosen', 'spftestimonial_chosen_ajax' );
}

/**
 *
 * Set icons for wp dialog
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'spftestimonial_set_icons' ) ) {
  function spftestimonial_set_icons() {
    ?>
    <div id="spftestimonial-modal-icon" class="spftestimonial-modal spftestimonial-modal-icon">
      <div class="spftestimonial-modal-table">
        <div class="spftestimonial-modal-table-cell">
          <div class="spftestimonial-modal-overlay"></div>
          <div class="spftestimonial-modal-inner">
            <div class="spftestimonial-modal-title">
              <?php esc_html_e( 'Add Icon', 'testimonial-pro' ); ?>
              <div class="spftestimonial-modal-close spftestimonial-icon-close"></div>
            </div>
            <div class="spftestimonial-modal-header spftestimonial-text-center">
              <input type="text" placeholder="<?php esc_html_e( 'Search a Icon...', 'testimonial-pro' ); ?>" class="spftestimonial-icon-search" />
            </div>
            <div class="spftestimonial-modal-content">
              <div class="spftestimonial-modal-loading"><div class="spftestimonial-loading"></div></div>
              <div class="spftestimonial-modal-load"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  add_action( 'admin_footer', 'spftestimonial_set_icons' );
  add_action( 'customize_controls_print_footer_scripts', 'spftestimonial_set_icons' );
}

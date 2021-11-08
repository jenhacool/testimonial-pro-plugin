<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: textarea
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'SPFTESTIMONIAL_Field_textarea' ) ) {
  class SPFTESTIMONIAL_Field_textarea extends SPFTESTIMONIAL_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      echo $this->field_before();
      echo $this->shortcoder();
      echo '<textarea name="'. $this->field_name() .'"'. $this->field_attributes() .'>'. $this->value .'</textarea>';
      echo $this->field_after();

    }

    public function shortcoder() {

      if( ! empty( $this->field['shortcoder'] ) ) {

        $shortcoders = ( is_array( $this->field['shortcoder'] ) ) ? $this->field['shortcoder'] : array_filter( (array) $this->field['shortcoder'] );

        foreach( $shortcoders as $shortcode_id ) {

          if( isset( SPFTESTIMONIAL::$args['shortcoders'][$shortcode_id] ) ) {

            $setup_args   = SPFTESTIMONIAL::$args['shortcoders'][$shortcode_id];
            $button_title = ( ! empty( $setup_args['button_title'] ) ) ? $setup_args['button_title'] : esc_html__( 'Add Shortcode', 'testimonial-pro' );

            echo '<a href="#" class="button button-primary spftestimonial-shortcode-button" data-modal-id="'. $shortcode_id .'">'. $button_title .'</a>';

          }

        }

      }

    }
  }
}

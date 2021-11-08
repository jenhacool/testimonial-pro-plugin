<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: background
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'SPFTESTIMONIAL_Field_background' ) ) {
  class SPFTESTIMONIAL_Field_background extends SPFTESTIMONIAL_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args                             = wp_parse_args( $this->field, array(
        'background_color'              => true,
        'background_image'              => true,
        'background_position'           => true,
        'background_repeat'             => true,
        'background_attachment'         => true,
        'background_size'               => true,
        'background_origin'             => false,
        'background_clip'               => false,
        'background_blend-mode'         => false,
        'background_gradient'           => false,
        'background_gradient_color'     => true,
        'background_gradient_direction' => true,
        'background_image_preview'      => true,
        'background_image_library'      => 'image',
        'background_image_placeholder'  => esc_html__( 'No background selected', 'testimonial-pro' ),
      ) );

      $default_value                    = array(
        'background-color'              => '',
        'background-image'              => '',
        'background-position'           => '',
        'background-repeat'             => '',
        'background-attachment'         => '',
        'background-size'               => '',
        'background-origin'             => '',
        'background-clip'               => '',
        'background-blend-mode'         => '',
        'background-gradient-color'     => '',
        'background-gradient-direction' => '',
      );

      $default_value = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;

      $this->value = wp_parse_args( $this->value, $default_value );

      echo $this->field_before();

      //
      // Background Color
      if( ! empty( $args['background_color'] ) ) {

        echo '<div class="spftestimonial--block spftestimonial--color">';
        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="spftestimonial--title">'. esc_html__( 'From', 'testimonial-pro' ) .'</div>' : '';

        SPFTESTIMONIAL::field( array(
          'id'      => 'background-color',
          'type'    => 'color',
          'default' => $default_value['background-color'],
        ), $this->value['background-color'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Gradient Color
      if( ! empty( $args['background_gradient_color'] ) && ! empty( $args['background_gradient'] ) ) {

        echo '<div class="spftestimonial--block spftestimonial--color">';
        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="spftestimonial--title">'. esc_html__( 'To', 'testimonial-pro' ) .'</div>' : '';

        SPFTESTIMONIAL::field( array(
          'id'      => 'background-gradient-color',
          'type'    => 'color',
          'default' => $default_value['background-gradient-color'],
        ), $this->value['background-gradient-color'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Gradient Direction
      if( ! empty( $args['background_gradient_direction'] ) && ! empty( $args['background_gradient'] ) ) {

        echo '<div class="spftestimonial--block spftestimonial--gradient">';
        echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="spftestimonial--title">'. esc_html__( 'Direction', 'testimonial-pro' ) .'</div>' : '';

        SPFTESTIMONIAL::field( array(
          'id'          => 'background-gradient-direction',
          'type'        => 'select',
          'options'     => array(
            ''          => esc_html__( 'Gradient Direction', 'testimonial-pro' ),
            'to bottom' => esc_html__( '&#8659; top to bottom', 'testimonial-pro' ),
            'to right'  => esc_html__( '&#8658; left to right', 'testimonial-pro' ),
            '135deg'    => esc_html__( '&#8664; corner top to right', 'testimonial-pro' ),
            '-135deg'   => esc_html__( '&#8665; corner top to left', 'testimonial-pro' ),
          ),
        ), $this->value['background-gradient-direction'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      echo '<div class="clear"></div>';

      //
      // Background Image
      if( ! empty( $args['background_image'] ) ) {

        echo '<div class="spftestimonial--block spftestimonial--media">';

        SPFTESTIMONIAL::field( array(
          'id'          => 'background-image',
          'type'        => 'media',
          'library'     => $args['background_image_library'],
          'preview'     => $args['background_image_preview'],
          'placeholder' => $args['background_image_placeholder']
        ), $this->value['background-image'], $this->field_name(), 'field/background' );

        echo '</div>';

        echo '<div class="clear"></div>';

      }

      //
      // Background Position
      if( ! empty( $args['background_position'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'              => 'background-position',
          'type'            => 'select',
          'options'         => array(
            ''              => esc_html__( 'Background Position', 'testimonial-pro' ),
            'left top'      => esc_html__( 'Left Top', 'testimonial-pro' ),
            'left center'   => esc_html__( 'Left Center', 'testimonial-pro' ),
            'left bottom'   => esc_html__( 'Left Bottom', 'testimonial-pro' ),
            'center top'    => esc_html__( 'Center Top', 'testimonial-pro' ),
            'center center' => esc_html__( 'Center Center', 'testimonial-pro' ),
            'center bottom' => esc_html__( 'Center Bottom', 'testimonial-pro' ),
            'right top'     => esc_html__( 'Right Top', 'testimonial-pro' ),
            'right center'  => esc_html__( 'Right Center', 'testimonial-pro' ),
            'right bottom'  => esc_html__( 'Right Bottom', 'testimonial-pro' ),
          ),
        ), $this->value['background-position'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Repeat
      if( ! empty( $args['background_repeat'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'          => 'background-repeat',
          'type'        => 'select',
          'options'     => array(
            ''          => esc_html__( 'Background Repeat', 'testimonial-pro' ),
            'repeat'    => esc_html__( 'Repeat', 'testimonial-pro' ),
            'no-repeat' => esc_html__( 'No Repeat', 'testimonial-pro' ),
            'repeat-x'  => esc_html__( 'Repeat Horizontally', 'testimonial-pro' ),
            'repeat-y'  => esc_html__( 'Repeat Vertically', 'testimonial-pro' ),
          ),
        ), $this->value['background-repeat'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Attachment
      if( ! empty( $args['background_attachment'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'       => 'background-attachment',
          'type'     => 'select',
          'options'  => array(
            ''       => esc_html__( 'Background Attachment', 'testimonial-pro' ),
            'scroll' => esc_html__( 'Scroll', 'testimonial-pro' ),
            'fixed'  => esc_html__( 'Fixed', 'testimonial-pro' ),
          ),
        ), $this->value['background-attachment'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Size
      if( ! empty( $args['background_size'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'        => 'background-size',
          'type'      => 'select',
          'options'   => array(
            ''        => esc_html__( 'Background Size', 'testimonial-pro' ),
            'cover'   => esc_html__( 'Cover', 'testimonial-pro' ),
            'contain' => esc_html__( 'Contain', 'testimonial-pro' ),
          ),
        ), $this->value['background-size'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Origin
      if( ! empty( $args['background_origin'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'            => 'background-origin',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( 'Background Origin', 'testimonial-pro' ),
            'padding-box' => esc_html__( 'Padding Box', 'testimonial-pro' ),
            'border-box'  => esc_html__( 'Border Box', 'testimonial-pro' ),
            'content-box' => esc_html__( 'Content Box', 'testimonial-pro' ),
          ),
        ), $this->value['background-origin'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Clip
      if( ! empty( $args['background_clip'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'            => 'background-clip',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( 'Background Clip', 'testimonial-pro' ),
            'border-box'  => esc_html__( 'Border Box', 'testimonial-pro' ),
            'padding-box' => esc_html__( 'Padding Box', 'testimonial-pro' ),
            'content-box' => esc_html__( 'Content Box', 'testimonial-pro' ),
          ),
        ), $this->value['background-clip'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      //
      // Background Blend Mode
      if( ! empty( $args['background_blend_mode'] ) ) {
        echo '<div class="spftestimonial--block spftestimonial--select">';

        SPFTESTIMONIAL::field( array(
          'id'            => 'background-blend-mode',
          'type'          => 'select',
          'options'       => array(
            ''            => esc_html__( 'Background Blend Mode', 'testimonial-pro' ),
            'normal'      => esc_html__( 'Normal', 'testimonial-pro' ),
            'multiply'    => esc_html__( 'Multiply', 'testimonial-pro' ),
            'screen'      => esc_html__( 'Screen', 'testimonial-pro' ),
            'overlay'     => esc_html__( 'Overlay', 'testimonial-pro' ),
            'darken'      => esc_html__( 'Darken', 'testimonial-pro' ),
            'lighten'     => esc_html__( 'Lighten', 'testimonial-pro' ),
            'color-dodge' => esc_html__( 'Color Dodge', 'testimonial-pro' ),
            'saturation'  => esc_html__( 'Saturation', 'testimonial-pro' ),
            'color'       => esc_html__( 'Color', 'testimonial-pro' ),
            'luminosity'  => esc_html__( 'Luminosity', 'testimonial-pro' ),
          ),
        ), $this->value['background-blend-mode'], $this->field_name(), 'field/background' );

        echo '</div>';

      }

      echo '<div class="clear"></div>';

      echo $this->field_after();

    }

    public function output() {

      $output    = '';
      $bg_image  = array();
      $important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
      $element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

      // Background image and gradient
      $background_color        = ( ! empty( $this->value['background-color']              ) ) ? $this->value['background-color']              : '';
      $background_gd_color     = ( ! empty( $this->value['background-gradient-color']     ) ) ? $this->value['background-gradient-color']     : '';
      $background_gd_direction = ( ! empty( $this->value['background-gradient-direction'] ) ) ? $this->value['background-gradient-direction'] : '';
      $background_image        = ( ! empty( $this->value['background-image']['url']       ) ) ? $this->value['background-image']['url']       : '';


      if( $background_color && $background_gd_color ) {
        $gd_direction   = ( $background_gd_direction ) ? $background_gd_direction .',' : '';
        $bg_image[] = 'linear-gradient('. $gd_direction . $background_color .','. $background_gd_color .')';
      }

      if( $background_image ) {
        $bg_image[] = 'url('. $background_image .')';
      }

      if( ! empty( $bg_image ) ) {
        $output .= 'background-image:'. implode( ',', $bg_image ) . $important .';';
      }

      // Common background properties
      $properties = array( 'color', 'position', 'repeat', 'attachment', 'size', 'origin', 'clip', 'blend-mode' );

      foreach( $properties as $property ) {
        $property = 'background-'. $property;
        if( ! empty( $this->value[$property] ) ) {
          $output .= $property .':'. $this->value[$property] . $important .';';
        }
      }

      if( $output ) {
        $output = $element .'{'. $output .'}';
      }

      $this->parent->output_css .= $output;

      return $output;

    }

  }
}

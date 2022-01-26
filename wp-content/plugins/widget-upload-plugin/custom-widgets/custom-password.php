<?php

use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Classes;
use Elementor\Controls_Manager;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class CustomPassword extends \ElementorPro\Modules\Forms\Fields\Field_Base {

  public function get_type() {
    return 'custom_password';
  }

  public function get_name() {
    return __( 'Custom Password', 'elementor-pro' );
  }

  public function render( $item, $item_index, $form ) {
    $form->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual elementor-field-custompassword' );
    $form->add_render_attribute( 'input' . $item_index, 'type', 'password', true );

    echo '<input ' . $form->get_render_attribute_string( 'input' . $item_index ) . ' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
    <span toggle="#password-field" class="far fa-eye field-icon toggle-password"></span>
    <div id="pswd_info" class="elementor-field-type-html">
      <ul>
        <li id="length" class="invalid">At least 8 characters in lengths</li>
        <li id="number" class="invalid">At least 1 numeric value</li>
        <li id="capital" class="invalid">At least 1 upper case character</li>
      </ul>
    </div>';
  }

  /**
   * @param Widget_Base $widget
   */
  public function update_controls( $widget ) {

  }

  public function validation( $field, Classes\Form_Record $record, Classes\Ajax_Handler $ajax_handler ) {

    // Given password
    $password = $field['raw_value'];

// Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $number    = preg_match('@[0-9]@', $password);

    if(!$uppercase || !$number || strlen($password) < 8) {
      $ajax_handler->add_error( $field['id'], sprintf( __( 'The Password value must be atleast 8 characters with 1 Uppercase and 1 Numeric.', 'elementor-pro') ) );
    }
  }

  public function sanitize_field( $value, $field ) {
    return sanitize_text_field( $value );
  }

  public function __construct() {
    parent::__construct();
    wp_enqueue_style( "custom-password-field", CUSTOM_WIDGET_URL . 'css/password-field.css' );
    wp_enqueue_script( "custom-password-field-js", CUSTOM_WIDGET_URL . 'js/custom_password_field.js' , ['jquery-core']);
  }

}

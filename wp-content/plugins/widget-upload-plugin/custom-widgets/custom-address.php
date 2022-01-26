<?php

use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Classes;
use Elementor\Controls_Manager;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class GoogleAddressField extends \ElementorPro\Modules\Forms\Fields\Field_Base {

  public function get_type() {
    return 'google_address_field';
  }

  public function get_name() {
    return __( 'Google Address Field', 'elementor-pro' );
  }

  public function render( $item, $item_index, $form ) {
    wp_enqueue_script( 'google-place', 'https://maps.googleapis.com/maps/api/js?key='.$item['api_key'].'&callback=initAutocomplete&libraries=places&v=weekly', ['custom-address-field-js'],'',true );

    $form->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual elementor-field-googleaddress' );
    $form->add_render_attribute( 'input' . $item_index, 'type', 'text', true );
    $form->add_render_attribute( 'input' . $item_index, 'id', 'autocomplete', true );

    echo '<input ' . $form->get_render_attribute_string( 'input' . $item_index ) . ' onFocus="geolocate()" />
    <div class="hidden">
    <input id="street_number" type="hidden" />
    <input id="premise" type="hidden" />
    <input id="route" type="hidden" />
    <input id="addresstext" type="hidden" name="form_fields['.$item['address_id'].']" />
    <input id="locality" type="hidden" name="form_fields['.$item['city_id'].']" />
    <input id="administrative_area_level_1" type="hidden" name="form_fields['.$item['state_id'].']" />
    <input id="country" type="hidden" name="form_fields['.$item['country_id'].']" />
    <input id="postal_code" type="hidden" name="form_fields['.$item['postal_code_id'].']" />
    </div>
    ';
  }

  /**
   * @param Widget_Base $widget
   */
  public function update_controls( $widget ) {
    $elementor = Plugin::elementor();

    $control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

    if ( is_wp_error( $control_data ) ) {
      return;
    }

    $field_controls = [
      'api_key' => [
        'name' => 'api_key',
        'label' => __( 'API Key', 'elementor-pro' ),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'field_type' => $this->get_type(),
        ],
        'tab' => 'content',
        'inner_tab' => 'form_fields_content_tab',
        'tabs_wrapper' => 'form_fields_tabs',
      ],
      'address_id' => [
        'name' => 'address_id',
        'label' => __( 'Address ID', 'elementor-pro' ),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'field_type' => $this->get_type(),
        ],
        'tab' => 'advanced',
        'default' => 'address',
        'inner_tab' => 'form_fields_advanced_tab',
        'tabs_wrapper' => 'form_fields_tabs',
      ],
      'city_id' => [
        'name' => 'city_id',
        'label' => __( 'City ID', 'elementor-pro' ),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'field_type' => $this->get_type(),
        ],
        'default' => 'city',
        'tab' => 'advanced',
        'inner_tab' => 'form_fields_advanced_tab',
        'tabs_wrapper' => 'form_fields_tabs',
      ],
      'state_id' => [
        'name' => 'state_id',
        'label' => __( 'State ID', 'elementor-pro' ),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'field_type' => $this->get_type(),
        ],
        'default' => 'state',
        'tab' => 'advanced',
        'inner_tab' => 'form_fields_advanced_tab',
        'tabs_wrapper' => 'form_fields_tabs',
      ],
      'country_id' => [
        'name' => 'country_id',
        'label' => __( 'Country ID', 'elementor-pro' ),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'field_type' => $this->get_type(),
        ],
        'default' => 'country',
        'tab' => 'advanced',
        'inner_tab' => 'form_fields_advanced_tab',
        'tabs_wrapper' => 'form_fields_tabs',
      ],
      'postal_code_id' => [
        'name' => 'postal_code_id',
        'label' => __( 'Postal code ID', 'elementor-pro' ),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'field_type' => $this->get_type(),
        ],
        'default' => 'postal_code',
        'tab' => 'advanced',
        'inner_tab' => 'form_fields_advanced_tab',
        'tabs_wrapper' => 'form_fields_tabs',
      ]
    ];

    $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
    $widget->update_control( 'form_fields', $control_data );

  }

  public function validation( $field, Classes\Form_Record $record, Classes\Ajax_Handler $ajax_handler ) {

  }

  public function sanitize_field( $value, $field ) {
    return sanitize_textarea_field( $value );
  }

  public function __construct() {
    parent::__construct();
    add_action( 'elementor/element/before_section_end', [ $this, 'update_controls' ], 10, 2 );
    // add_action( 'elementor_pro/forms/process', [ $this, 'set_address_fields_values' ], 10, 2 );
    wp_enqueue_script( "custom-address-field-js", CUSTOM_WIDGET_URL . 'js/custom_addtress_field.js',[],'',true);
   // wp_enqueue_script( 'google-place', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA7mF47PJ1jwNHCQwr4JuzIIWayJ6jyx1c&callback=initAutocomplete&libraries=places&v=weekly', ['custom-address-field-js'],'',true );
  }
}

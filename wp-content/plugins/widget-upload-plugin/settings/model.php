<?php
namespace CustomWidget\Settings;


use Elementor\Controls_Manager;
use Elementor\Core\Settings\Base\Model as BaseModel;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class Model extends BaseModel {

  /**
   * Get element name.
   *
   * Retrieve the element name.
   *
   * @return string The name.
   * @since 2.8.0
   * @access public
   *
   */
  public function get_name() {
    return 'custom-settings';
  }

  /**
   * Get panel page settings.
   *
   * Retrieve the page setting for the current panel.
   *
   * @since 2.8.0
   * @access public
   */
  public function get_panel_page_settings() {
    return [
      'title' => __( 'Custom Settings', 'elementor' ),
    ];
  }

  /**
   * @since 2.8.0
   * @access protected
   */
  protected function _register_controls() {
    $this->start_controls_section( 'eightfold-settings', [
      'tab' => Controls_Manager::TAB_SETTINGS,
      'label' => __( 'Settings', 'elementor' ),
    ] );

    $this->add_control(
      'iframeURL',
      [
        'label' => __( 'Set Embed url for all Eightfold Widgets', 'elementor' ),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 3,
        'default' => __( 'https://app.eightfold.ai', 'elementor' ),
        'placeholder' => __( 'Enter text', 'eleentor' ),
      ]
    );

    $this->end_controls_section();
  }
}

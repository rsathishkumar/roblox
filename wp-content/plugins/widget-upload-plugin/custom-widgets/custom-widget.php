<?php

final class Custom_elementor_Extension {

  private static $_instance = null;


  public static function instance() {

    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;

  }


  public function __construct() {

    add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

  }

  public function init() {

    // Add Plugin actions
   // add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
  }

  public function init_widgets() {

    // Include Widget files
    require_once( __DIR__ . '/custom-upload-widget.php' );

    // Register widget
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_elementor_widget() );

  }

}

add_action('init', 'custom_elementor_init');
function custom_elementor_init() {
  Custom_elementor_Extension::instance();
}
<?php

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;


/**
 * Custom elementor widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Custom_elementor_map_widget extends \Elementor\Widget_Base {

  /**
   * Get widget name.
   *
   * Retrieve oEmbed widget name.
   *
   * @since 1.0.0
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'eightfoldmapwidget';
  }

  /**
   * Get widget title.
   *
   * Retrieve oEmbed widget title.
   *
   * @since 1.0.0
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'Eightfold Map Widget', 'plugin-name' );
  }

  /**
   * Get widget icon.
   *
   * Retrieve oEmbed widget icon.
   *
   * @since 1.0.0
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'iconeightfold icon-eightfoldlocation';
  }

  /**
   * Get widget categories.
   *
   * Retrieve the list of categories the oEmbed widget belongs to.
   *
   * @since 1.0.0
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'eightfold-category' ];
  }

  private function get_available_pages() {
    $pages = get_pages();

    $options = [];

    foreach ( $pages as $page ) {
      $options[ $page->guid ] = $page->post_title;
    }

    return $options;
  }


  /**
   * Register oEmbed widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function _register_controls() {

    $this->start_controls_section(
      'content_section',
      [
        'label' => __( 'Content', 'plugin-name' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'mapheight',
      [
        'label' => __( 'Set Map height', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __( '600', 'plugin-domain' ),
      ]
    );

    $this->add_control(
      'maplocation',
      [
        'label' => __( 'Set Distance range', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __( '2000', 'plugin-domain' ),
      ]
    );

    $this->end_controls_section();

  }

  /**
   * Render oEmbed widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function render() {

    $settings = $this->get_settings_for_display();
    $global_settings = get_option( 'elementor_custom_settings' );
    $embed_url = 'https://app.eightfold.ai';
    if ($global_settings) {
      $embed_url = $global_settings['iframeURL'];
    }

    echo '<iframe noscroll="" scrolling="no"
        name="efPCSWidgetLocationsMap" id="efPCSWidgetLocationsMap"
        src="'.$embed_url.'/careers/embed?widget=locationsMap&config={%22style%22:{%22height%22:%22'.$settings['mapheight'].'px%22},%22locationDistanceKm%22:'.$settings['maplocation'].'}"
        title="efPCSWidgetLocationsMap" style="z-index: 100000000;width :100%;height: '.$settings['mapheight'].'px;border: 0px;overflow-y: hidden;">
    </iframe>';
  }

}

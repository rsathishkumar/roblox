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
class Custom_elementor_chat_widget extends \Elementor\Widget_Base {

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
    return 'eightfoldchatwidget';
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
    return __( 'Chat Widget', 'plugin-name' );
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
    return 'iconeightfold icon-eightfoldchat';
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
      'chatheight',
      [
        'label' => __( 'Set Chat height', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __( '500', 'plugin-domain' ),
      ]
    );

    $this->add_control(
      'chatwidth',
      [
        'label' => __( 'Set Chat width', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __( '330', 'plugin-domain' ),
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

    echo '<iframe id="ef-chatbot"
        src="'.$embed_url.'/careers/chatbot" title="chatbot"
        style="position: fixed;bottom: 0;right: 0;z-index: 100000000;height:'.$settings['chatheight'].'px;width:'.$settings['chatwidth'].'px;border: none"></iframe>
  <script type="text/javascript">window.addEventListener("message", function () {
  switch (event.data) {
    case "efchatbot_destroy_tooltip":
      document.getElementById("ef-chatbot").style.width = "100px";
      document.getElementById("ef-chatbot").style.height = "100px";
      return null;
    case "efchatbot_open_chat_bot":
      document.getElementById("ef-chatbot").style.width = "'.$settings['chatwidth'].'px";
      document.getElementById("ef-chatbot").style.height = "'.$settings['chatheight'].'px";
      return null;
    case "efchatbot_close_chat_bot":
      document.getElementById("ef-chatbot").style.width = "100px";
      document.getElementById("ef-chatbot").style.height = "100px";
      return null;
    default:
      return null;
  }
});</script>';

  }

}

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
class Custom_translate_menu_widget extends \Elementor\Widget_Base {

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
    return 'translatemenuwidget';
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
    return __('Translate menu Widget', 'plugin-name');
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
    return 'elementor-icons-manager__tab__item__icon fas fa-newspaper';
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
    return ['eightfold-category'];
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
      'section_text_style',
      [
        'label' => __('Text Style', 'custom-translator-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'text_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
      ]
    );

    $this->start_controls_tabs( 'tabs_toggle_style' );

    $this->start_controls_tab(
      'tab_toggle_style_normal',
      [
        'label' => __( 'Normal', 'elementor-pro' ),
      ]
    );

    $this->add_control(
      'text_color',
      [
        'label' => __('Language Text Color', 'custom-translator-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'separator' => 'none',
        'selectors' => [
          '{{WRAPPER}} .trp-language-switcher a' => 'color: {{VALUE}}',
          '{{WRAPPER}} .trp-language-switcher div' => 'background-image: linear-gradient(45deg, transparent 50%, {{VALUE}} 50%), linear-gradient(135deg, {{VALUE}} 50%, transparent 50%)',
        ],
      ]
    );

    $this->add_control(
      'background_color',
      [
        'label' => __('Background color', 'custom-translator-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FFFFFF',
        'separator' => 'none',
        'selectors' => [
          '{{WRAPPER}} .trp-language-switcher div' => 'background-color: {{VALUE}}',
        ],

      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_toggle_style_hover',
      [
        'label' => __( 'Hover', 'elementor-pro' ),
      ]
    );

    $this->add_control(
      'text-hover-color',
      [
        'label' => __('Text Hover Color', 'custom-translator-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'separator' => 'none',
        'selectors' => [
          '{{WRAPPER}} .trp-language-switcher > div > a:hover' => 'color: {{VALUE}}',
        ],

      ]
    );

    $this->add_control(
      'background_color_hover',
      [
        'label' => __('Background Hover Color', 'custom-translator-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FFFFFF',
        'separator' => 'none',
        'selectors' => [
          '{{WRAPPER}} .trp-language-switcher div:hover' => 'background-color: {{VALUE}}',
          '{{WRAPPER}} .trp-language-switcher > div > a:hover' => 'background-color: {{VALUE}}',
        ],

      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->add_control(
      'border-style',
      [
        'label' => __( 'Border style', 'custom-translator-widget' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'none',
        'options' => [
          'none' => __( 'None', 'custom-translator-widget' ),
          'solid' => __( 'Solid', 'custom-translator-widget' ),
          'double' => __( 'Double', 'custom-translator-widget' ),
          'dotted' => __( 'Dotted', 'custom-translator-widget' ),
          'dashed' => __( 'Dashed', 'custom-translator-widget' ),
          'groove' => __( 'groove', 'custom-translator-widget' ),
        ],
        'selectors' => [
          '{{WRAPPER}} .trp-language-switcher div' => 'border-style: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'border_color',
      [
        'label' => __('Border color', 'custom-translator-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#dfdfdf',
        'separator' => 'none',
        'selectors' => [
          '{{WRAPPER}} .trp-language-switcher div' => 'border-color: {{VALUE}}',
        ],
        'condition' => [
          'border-style!' => 'none',
        ]
      ]
    );

    $this->add_control(
      'divwidth',
      [
        'label' => __('Width', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __('200', 'resume-upload-widget'),
        'selectors' => [
          '{{WRAPPER}} .trp-ls-shortcode-current-language' => 'width: {{VALUE}}px !important',
          '{{WRAPPER}} .trp-ls-shortcode-language' => 'width: {{VALUE}}px !important'
        ],
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

    echo do_shortcode('[language-switcher]');
  }

}
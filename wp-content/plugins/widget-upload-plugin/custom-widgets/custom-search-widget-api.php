<?php

use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Custom elementor widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Custom_search_widget_api extends \Elementor\Widget_Base
{

  /**
   * Class constructor.
   *
   * @param array $data Widget data.
   * @param array $args Widget arguments.
   */
  public function __construct($data = array(), $args = null)
  {
    parent::__construct($data, $args);

    wp_register_style('search-widget', plugins_url('../css/search-widget-api.css', __FILE__), [], '1.0.0');
    wp_register_script('autocomplete', plugins_url('../js/jquery.autocomplete.js', __FILE__), ['jquery'], '1.0.0');
    wp_register_script('search-widget', plugins_url('../js/search-widget.js', __FILE__), ['autocomplete'], '1.0.0');
  }

  /**
   * A list of style that the widgets is depended in
   **/
  public function get_style_depends()
  {
    return [
      'search-widget'
    ];
  }

  /**
   * A list of scripts that the widgets is depended in
   **/
  public function get_script_depends()
  {
    return [
      'autocomplete',
      'search-widget'
    ];
  }

  /**
   * Get widget name.
   *
   * Retrieve oEmbed widget name.
   *
   * @return string Widget name.
   * @since 1.0.0
   * @access public
   *
   */
  public function get_name()
  {
    return 'custom_search_widget_api';
  }

  /**
   * Get widget title.
   *
   * Retrieve oEmbed widget title.
   *
   * @return string Widget title.
   * @since 1.0.0
   * @access public
   *
   */
  public function get_title()
  {
    return __('Search jobs', 'plugin-name');
  }

  /**
   * Get widget icon.
   *
   * Retrieve oEmbed widget icon.
   *
   * @return string Widget icon.
   * @since 1.0.0
   * @access public
   *
   */
  public function get_icon()
  {
    return 'iconeightfold icon-eightfoldsearch';
  }

  /**
   * Get widget categories.
   *
   * Retrieve the list of categories the oEmbed widget belongs to.
   *
   * @return array Widget categories.
   * @since 1.0.0
   * @access public
   *
   */
  public function get_categories()
  {
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
  protected function _register_controls()
  {

    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Search Style', 'custom-search-job-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'search_placeholder',
      [
        'label' => __('Search Placeholder', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Search', 'search-widget'),
      ]
    );

    $this->add_control(
      'search_icon',
      [
        'label' => __('Search Input Icon', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default' => [
          'value' => 'fa fa-search',
          'library' => 'fa-search',
        ],
      ]
    );

    $this->add_control(
      'search_icon_align',
      [
        'label' => __('Align Fields', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'right',
        'options' => [
          'left' => __('Left', 'custom-search-job-widget'),
          'right' => __('Right', 'custom-search-job-widget'),
        ],
        'selectors' => [
          '{{WRAPPER}} .job-search-btn' => '{{VALUE}}: 15px',
        ],
      ]
    );

    $this->add_control(
      'add_link_search_icon',
      [
        'label' => __('Submit On Icon Click', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'search-widget'),
        'label_off' => __('No', 'search-widget'),
        'return_value' => 'yes',
        'default' => '',
      ]
    );

    $this->add_control(
      'submit-on-select',
      [
        'label' => __('Submit on select option', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'search-widget'),
        'label_off' => __('No', 'search-widget'),
        'return_value' => 'yes',
        'default' => '',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'location_section',
      [
        'label' => __( 'Location Style & API Info', 'custom-search-job-widget' ),
        'type' => \Elementor\Controls_Manager::SECTION,
      ]
    );

    $this->add_control(
      'hide_location',
      [
        'label' => __('Hide Location Field', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'search-widget'),
        'label_off' => __('No', 'search-widget'),
        'return_value' => 'yes',
        'default' => '',
      ]
    );

    $this->add_control(
      'location_icon',
      [
        'label' => __('Location Icon', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'default' => [
          'value' => 'fas fa-map-marker',
          'library' => 'fa-map-marker',
        ],
        'condition' => [
          'hide_location' => '',
        ]
      ]
    );

    $this->add_control(
      'location_placeholder',
      [
        'label' => __('Location Placeholder', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Location', 'search-widget'),
        'condition' => [
          'hide_location' => '',
        ]
      ]
    );

    $this->add_control(
      'location_query_param_value',
      [
        'label' => __('Location Query Param Label', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('location', 'search-widget'),
        'condition' => [
          'hide_location' => '',
        ]
      ]
    );

    $this->add_control(
      'domain_query_param',
      [
        'label' => __('Domain', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('volkscience.com', 'custom-search-job-widget'),
      ]
    );

    $this->add_control(
      'job_search_url',
      [
        'label' => __('Job Search URL', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('/careers', 'custom-search-job-widget'),
      ]
    );

    $this->add_control(
      'show_location_link',
      [
        'label' => __('Show Location API', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Show', 'custom-search-job-widget'),
        'label_off' => __('Hide', 'custom-search-job-widget'),
        'return_value' => 'yes',
        'default' => '',
        'condition' => [
          'hide_location' => '',
        ]
      ]
    );

    $this->add_control(
      'find_my_location_label',
      [
        'label' => __('Find My Location Label', 'search-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Search', 'search-widget'),
        'condition' => [
          'show_location_link' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'location_host',
      [
        'label' => __('Location Host', 'search-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __($_SERVER['HTTP_HOST'], 'search-widget'),
        'condition' => [
          'hide_location' => '',
        ]
      ]
    );

    $this->end_controls_section();
    $this->start_controls_section(
      'Button_section',
      [
        'label' => __( 'Button Style', 'search-' ),
        'type' => \Elementor\Controls_Manager::SECTION,
      ]
    );

    $this->add_control(
      'button_icon',
      [
        'label' => __('Button Icon', 'search-widget'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
      ]
    );

    $this->add_control(
      'button_label',
      [
        'label' => __('Button Label', 'search-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Search', 'search-widget'),
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'general_style',
      [
        'label' => __('General', 'custom-search-job-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'display-style',
      [
        'label' => __('Display style', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'block',
        'options' => [
          'block' => __('block', 'custom-search-job-widget'),
          'inline-block' => __('inline', 'custom-translator-widget'),
        ],
        'selectors' => [
          '{{WRAPPER}} .fields .field' => 'display: {{VALUE}}',
          '{{WRAPPER}} .fields .button-field' => 'display: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'align_fields',
      [
        'label' => __('Align Fields', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'left',
        'options' => [
          'none' => __('None', 'custom-search-job-widget'),
          'left' => __('Left', 'custom-search-job-widget'),
          'right' => __('Right', 'custom-search-job-widget'),
          'center' => __('Center', 'custom-search-job-widget')
        ],
        'selectors' => [
          '{{WRAPPER}} .fields' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_input_style',
      [
        'label' => __('Textbox Style', 'custom-search-job-widget'),
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
        'selectors' => [
          '{{WRAPPER}} .field input',
          '{{WRAPPER}} .field .fa-search',
          '{{WRAPPER}} .field .fa-map-marker-alt',
        ],
      ]
    );


    $this->add_control(
      'border-style',
      [
        'label' => __('Border style', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'solid',
        'options' => [
          'none' => __('None', 'custom-search-job-widget'),
          'solid' => __('Solid', 'custom-search-job-widget'),
          'double' => __('Double', 'custom-search-job-widget'),
          'dotted' => __('Dotted', 'custom-search-job-widget'),
          'dashed' => __('Dashed', 'custom-search-job-widget'),
          'groove' => __('groove', 'custom-search-job-widget'),
        ],
        'selectors' => [
          '{{WRAPPER}} .fields .field input' => 'border-style: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'border_color',
      [
        'label' => __('Border color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'separator' => 'none',
        'selectors' => [
          '{{WRAPPER}} .fields .field input' => 'border-color: {{VALUE}}',
        ],
        'condition' => [
          'border-style!' => 'none',
        ]
      ]
    );

    $this->add_responsive_control(
      'border_width',
      [
        'label' => __('Border Width', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'selectors' => [
          '{{WRAPPER}} .field input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'border_radius',
      [
        'label' => __('Border Radius', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .field input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
        ]
      ]
    );

    $this->add_responsive_control(
      'padding_horizontal',
      [
        'label' => __('Horizontal Padding', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .field' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'padding_vertical',
      [
        'label' => __('Vertical Padding', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .field' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'input_width',
      [
        'label' => __('Textbox Width', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'max' => 600,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .field' => 'width: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'input_padding',
      [
        'label' => __('Padding', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'default' => [
          'top' => '5',
          'bottom' => '5',
          'left' => '5',
          'right' => '5',
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .field input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'find_my_location_style',
      [
        'label' => __('Find My Location Style', 'custom-search-job-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
          'show_location_link' => 'yes',
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'find_my_location_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
        'selector' => '{{WRAPPER}} .field a.getAddress',
      ]
    );

    $this->add_control(
      'find_my_location_color',
      [
        'label' => __('Find My Location Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'separator' => 'none',
        'selectors' => [
          '.field #getAddress' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'show_location_link' => 'yes',
        ]
      ]
    );


    $this->end_controls_section();

    $this->start_controls_section(
      'section_button_style',
      [
        'label' => __('Buttons', 'custom-search-job-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'button_width',
      [
        'label' => __('Button Width', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'auto',
        'options' => [
          'auto' => __('None', 'custom-search-job-widget'),
          '100%' => __('Full Width', 'custom-search-job-widget'),
        ],
        'selectors' => [
          '{{WRAPPER}} .button-field button' => 'width:{{VALUE}};',
        ]
      ]
    );

    $this->add_control(
      'align_button',
      [
        'label' => __('Align Button', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'left',
        'options' => [
          'none' => __('None', 'custom-search-job-widget'),
          'left' => __('Left', 'custom-search-job-widget'),
          'right' => __('Right', 'custom-search-job-widget'),
          'center' => __('Center', 'custom-search-job-widget')
        ],
        'selectors' => [
          '{{WRAPPER}} .button-field' => 'text-align: {{VALUE}}',
        ],
        'condition' => [
          'button_width' => 'auto'
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'button_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_ACCENT,
        ],
        'selector' => '{{WRAPPER}} .button-field button',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(), [
        'name' => 'button_border',
        'selector' => '{{WRAPPER}} .button-field button',
        'exclude' => [
          'color',
        ],
      ]
    );

    $this->start_controls_tabs('tabs_button_style');

    $this->start_controls_tab(
      'tab_button_normal',
      [
        'label' => __('Normal', 'custom-search-job-widget'),
      ]
    );

    $this->add_control(
      'heading_next_submit_button',
      [
        'label' => __('Button', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::HEADING,
      ]
    );

    $this->add_control(
      'button_background_color',
      [
        'label' => __('Background Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_ACCENT,
        ],
        'selectors' => [
          '{{WRAPPER}} .button-field button' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_text_color',
      [
        'label' => __('Text Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'selectors' => [
          '{{WRAPPER}} .button-field button' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_border_color',
      [
        'label' => __('Border Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .button-field button' => 'border-color: {{VALUE}};',
        ],
        'condition' => [
          'button_border_border!' => '',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_button_hover',
      [
        'label' => __('Hover', 'custom-search-job-widget'),
      ]
    );

    $this->add_control(
      'heading_next_submit_button_hover',
      [
        'label' => __('Button', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::HEADING,
      ]
    );

    $this->add_control(
      'button_background_hover_color',
      [
        'label' => __('Background Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .button-field button:hover' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_hover_color',
      [
        'label' => __('Text Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'selectors' => [
          '{{WRAPPER}} .button-field button:hover svg *' => 'fill: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_hover_border_color',
      [
        'label' => __('Border Color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .button-field button:hover' => 'border-color: {{VALUE}};',
        ],
        'condition' => [
          'button_border_border!' => '',
        ],
      ]
    );

    $this->add_control(
      'button_hover_animation',
      [
        'label' => __('Animation', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->add_control(
      'button_border_radius',
      [
        'label' => __('Border Radius', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .button-field button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'button_text_padding',
      [
        'label' => __('Text Padding', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .button-field button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'dropdown_style',
      [
        'label' => __('Dropdown Style', 'custom-search-job-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'option_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_ACCENT,
        ],
        'selector' => '.ui-autocomplete .ui-menu-item-wrapper',
      ]
    );

    $this->add_control(
      'options-font_color',
      [
        'label' => __('Option Font color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'separator' => 'none',
        'selectors' => [
          '.ui-autocomplete .ui-menu-item-wrapper' => 'color: {{VALUE}}  !important',
          '.ui-autocomplete .ui-state-active' => 'color: {{VALUE}}  !important',
        ],
        'condition' => [
          'options-border-style!' => 'none',
        ]
      ]
    );

    $this->add_responsive_control(
      'options_padding',
      [
        'label' => __('Options Padding', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'default' => [
          'top' => '5',
          'bottom' => '5',
          'left' => '5',
          'right' => '5',
          'unit' => 'px',
        ],
        'selectors' => [
          '.ui-autocomplete .ui-menu-item-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'dropdown_options_background',
      [
        'label' => __('Dropdown Background color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_ACCENT,
        ],
        'selectors' => [
          '.ui-autocomplete' => 'background: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_control(
      'dropdown_options-border-style',
      [
        'label' => __('Dropdown Border style', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'none',
        'options' => [
          'none' => __('None', 'custom-search-job-widget'),
          'solid' => __('Solid', 'custom-search-job-widget'),
          'double' => __('Double', 'custom-search-job-widget'),
          'dotted' => __('Dotted', 'custom-search-job-widget'),
          'dashed' => __('Dashed', 'custom-search-job-widget'),
          'groove' => __('groove', 'custom-search-job-widget'),
        ],
        'selectors' => [
          '.ui-autocomplete ' => 'border-style: {{VALUE}} !important',
        ],
      ]
    );

    $this->add_control(
      'dropdown_options-border_color',
      [
        'label' => __('Dropdown Border color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'separator' => 'none',
        'selectors' => [
          '.ui-autocomplete ' => 'border-color: {{VALUE}}  !important',
        ],
        'condition' => [
          'options-border-style!' => 'none',
        ]
      ]
    );

    $this->add_responsive_control(
      'dropdown_options-border_width',
      [
        'label' => __('Dropdown Border Width', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'selectors' => [
          '.ui-autocomplete' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
        ],
      ]
    );

    $this->add_control(
      'options_hover_background',
      [
        'label' => __('Option Hover Background color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_ACCENT,
        ],
        'selectors' => [
          '.ui-autocomplete .ui-state-active' => 'background-color: {{VALUE}} !important;',
        ],
      ]
    );

    $this->add_control(
      'options-border-style',
      [
        'label' => __('Option Border style', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'none',
        'options' => [
          'none' => __('None', 'custom-search-job-widget'),
          'solid' => __('Solid', 'custom-search-job-widget'),
          'double' => __('Double', 'custom-search-job-widget'),
          'dotted' => __('Dotted', 'custom-search-job-widget'),
          'dashed' => __('Dashed', 'custom-search-job-widget'),
          'groove' => __('groove', 'custom-search-job-widget'),
        ],
        'selectors' => [
          '.ui-autocomplete .ui-state-active' => 'border-style: {{VALUE}} !important',
        ],
      ]
    );

    $this->add_control(
      'options-border_color',
      [
        'label' => __('Option Border color', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_ACCENT,
        'separator' => 'none',
        'selectors' => [
          '.ui-autocomplete .ui-state-active' => 'border-color: {{VALUE}}  !important',
        ],
        'condition' => [
          'options-border-style!' => 'none',
        ]
      ]
    );

    $this->add_responsive_control(
      'options-border_width',
      [
        'label' => __('Option Border Width', 'custom-search-job-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'selectors' => [
          '.ui-autocomplete .ui-state-active' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
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
  protected function render()
  {
    $settings = $this->get_settings_for_display();

    $find_my_location_label = $settings['find_my_location_label'];
    $find_my_location = '';
    if ($settings['show_location_link'] != '') {
      $find_my_location = '<a href="javascript:void(0);" class="getAddress">' . $find_my_location_label . '</a>';
    }
    $submit_class = "";
    if ($settings['add_link_search_icon'] == 'yes') {
      $submit_class = "job-search-submit";
    }

    $on_submit_class = "";
    if ($settings['submit-on-select'] == 'yes') {
      $on_submit_class = "on-select-submit";
    }


    // Search input icon
    $migrated = isset($settings['__fa4_migrated']['search_icon']);
    $is_new = !isset($settings['icon']) && \Elementor\Icons_Manager::is_migration_allowed();

    // Button Icon
    $migrated = isset($settings['__fa4_migrated']['button_icon']);
    $is_new = !isset($settings['icon']) && \Elementor\Icons_Manager::is_migration_allowed();
    $button_icon = '';
    if (!empty($settings['icon']) || !empty($settings['button_icon']['value'])) {
      if ($is_new || $migrated) {
        if ( 'svg' === $settings['button_icon']['library'] ) {
          $button_icon = \Elementor\Core\Files\Assets\Svg\Svg_Handler::get_inline_svg( $settings['button_icon']['value']['id'] );
        }
        else {
          $button_icon = '<i class="'.esc_attr($settings['button_icon']['value']).'" aria-hidden="true"></i>';
        }
      }
      else {
        $button_icon = '<i class="'.esc_attr($settings['icon']).'" aria-hidden="true"></i>';
      }
    }

    // Location Icon
    $migrated = isset($settings['__fa4_migrated']['location_icon']);
    $is_new = !isset($settings['icon']) && \Elementor\Icons_Manager::is_migration_allowed();
    $location_icon = '';
    if (!empty($settings['icon']) || !empty($settings['location_icon']['value'])) {
      if ($is_new || $migrated) {
        if ( 'svg' === $settings['location_icon']['library'] ) {
          $location_icon = \Elementor\Core\Files\Assets\Svg\Svg_Handler::get_inline_svg( $settings['location_icon']['value']['id'] );
          $location_icon .= ' ' . $find_my_location;
        }
        else {
          $location_icon = '<i class="'.esc_attr($settings['location_icon']['value']).'" aria-hidden="true"> '.$find_my_location.'</i>';
        }
      }
      else {
        $location_icon = '<i class="'.esc_attr($settings['icon']).'" aria-hidden="true"> '.$find_my_location.'</i>';
      }
    }


    if (!$is_new && empty($settings['icon_align'])) {
      // @todo: remove when deprecated
      // added as bc in 2.6
      //old default
      $settings['icon_align'] = $this->get_settings('icon_align');
    }


    $search_placeholder = $settings['search_placeholder'];
    $location_placeholder = $settings['location_placeholder'];
    $button_label = $settings['button_label'];
    $domain_param = $settings['domain_query_param'];
    $job_search_url = $settings['job_search_url'];
    $location_query_param = $settings['location_query_param_value'];
    $location_host = $settings['location_host'];

    $icon = '';
    $search_string = '';
    ?>

    <div class="fields search-job-widget">
      <div class="field"><label for="keyword_search_input"><span class="label">Keyword: </span><input class="keyword_search <?php echo $on_submit_class; ?>" id="keyword_search_input" placeholder="<?php echo $search_placeholder; ?>"><span class="search-btn <?php echo $submit_class;?> job-search-btn"><?php
          if (!empty($settings['icon']) || !empty($settings['search_icon']['value'])) :
            ?>
            <?php
            if ($is_new || $migrated) :
              \Elementor\Icons_Manager::render_icon($settings['search_icon'], ['aria-hidden' => 'true',]);
            else :
              ?>
              <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
            <?php
            endif;
            ?>
          <?php
          endif;
          ?></span></label></div><?php if ($settings['hide_location'] == '') : ?><div class="field"><label for="location_search_input"><input id="location_search_input" class="location"
                                                        name="<?php echo $location_query_param; ?>"
                                                        placeholder="<?php echo $location_placeholder; ?>"><span class="search-btn"><?php echo $location_icon;?></span></label><input
                type="hidden" name="location_host" value="<?php echo $location_host; ?>"/></div><?php endif; ?><div class="button-field"><input type="hidden" name="domain" value="<?php echo $domain_param; ?>"/><input
                type="hidden" name="job_search_url" value="<?php echo $job_search_url; ?>"/><button class="search_submit" name="search_submit" value="Submit"><?php echo $button_label; ?> <?php echo $button_icon;?></button>
      </div>
    </div>
    <?php
  }

}
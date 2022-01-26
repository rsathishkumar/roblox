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
class Custom_elementor_search_widget extends \Elementor\Widget_Base {

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
    return 'customsearchwidget';
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
    return __( 'Job Search Widget', 'plugin-name' );
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
    return 'iconeightfold icon-eightfoldsearch';
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
        'label' => __( 'Content', 'search-widget' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'iframeheight',
      [
        'label' => __( 'Set Iframe Height', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __( '225', 'search-widget' ),
      ]
    );

    $this->add_control(
      'show_advanced_filter',
      [
        'label' => __( 'Show Advanced Filter', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'search-widget' ),
        'label_off' => __( 'Hide', 'search-widget' ),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'show_location_filter',
      [
        'label' => __( 'Show Location Filter', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'search-widget' ),
        'label_off' => __( 'Hide', 'search-widget' ),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'show_search_filter',
      [
        'label' => __( 'Show Search Filter', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'search-widget' ),
        'label_off' => __( 'Hide', 'search-widget' ),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'buttonText',
      [
        'label' => __( 'Submit Button Label', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Go', 'search-widget' ),
        'placeholder' => __( 'Enter text', 'search-widget' ),
      ]
    );

    $this->add_control(
      'advancedtext',
      [
        'label' => __( 'Advanced Text Label', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Advanced Search', 'search-widget' ),
        'placeholder' => __( 'Enter text', 'search-widget' ),
      ]
    );

    $this->add_control(
      'iframe_background_color',
      [
        'label' => __( 'IFrame Background Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'iframe_background_image',
      [
        'label' => __( 'Image', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
      ]
    );

    $this->add_control(
      'middle_align',
      [
        'label' => __( 'Vertical Align', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'search-widget' ),
        'label_off' => __( 'No', 'search-widget' ),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'center_align',
      [
        'label' => __( 'Center Align', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'search-widget' ),
        'label_off' => __( 'No', 'search-widget' ),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );


    $this->end_controls_section();

    $this->start_controls_section(
      'section_field_style',
      [
        'label' => __( 'Input Fields', 'search-widget' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'cta_text_color',
      [
        'label' => __( 'Text Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'cta_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_TEXT,
        ],
      ]
    );

    $this->add_control(
      'cta_bg_color',
      [
        'label' => __( 'Background Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'cta_border_color',
      [
        'label' => __( 'Border Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#cccccc',
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'field_border_width',
      [
        'label' => __( 'Border Width', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'placeholder' => '0',
        'size_units' => [ 'px' ],
        'default' => [
          'top' => '1',
          'bottom' => '1',
          'left' => '1',
          'right' => '1',
          'unit' => 'px',
        ]
      ]
    );

    $this->add_control(
      'field_border_radius',
      [
        'label' => __( 'Border Radius', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'default' => [
          'top' => '4',
          'bottom' => '4',
          'left' => '4',
          'right' => '4',
          'unit' => 'px',
        ]
      ]
    );

    $this->add_control(
      'hidden_refresh',
      [
        'label' => __( 'View', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'refreshiframe',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_facet_heading_style',
      [
        'label' => __( 'Facet Headings', 'search-widget' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'facet_color',
      [
        'label' => __( 'Text Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'facet_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_TEXT,
        ],
      ]
    );

    $this->add_control(
      'hidden_refresh3',
      [
        'label' => __( 'View', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'refreshiframe',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_tag_style',
      [
        'label' => __( 'Tags', 'search-widget' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'tag_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_TEXT,
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(), [
        'name' => 'tag_border',
        'exclude' => [
          'color',
        ],
        'selector' => '{{WRAPPER}} iframe widget',
      ]
    );

    $this->start_controls_tabs('tag_item_style');

    $this->start_controls_tab(
      'tag_item_normal',
      [
        'label' => __('Normal', 'search-widget'),
      ]
    );

    $this->add_control(
      'tag_color',
      [
        'label' => __( 'Text Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
      ]
    );

    $this->add_control(
      'tag_border_color',
      [
        'label' => __( 'Tag Border Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tag_item_hover',
      [
        'label' => __('Hover', 'search-widget'),
      ]
    );

    $this->add_control(
      'tag_hover_color',
      [
        'label' => __( 'Text Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
      ]
    );

    $this->add_control(
      'tag_hover_border_color',
      [
        'label' => __( 'Tag Border Color', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
      'tag_border_radius',
      [
        'label' => __( 'Border Radius', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'separator' => 'before',
        'default' => [
          'top' => '0',
          'bottom' => '0',
          'left' => '0',
          'right' => '0',
          'unit' => 'px',
        ]
      ]
    );

    $this->add_responsive_control(
      'tag_padding',
      [
        'label' => __('Padding', 'search-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'default' => [
          'top' => '10',
          'bottom' => '10',
          'left' => '10',
          'right' => '10',
          'unit' => 'px',
        ]
      ]
    );

    $this->add_control(
      'hidden_refresh4',
      [
        'label' => __( 'View', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'refreshiframe',
      ]
    );

    $this->end_controls_section();


    $this->start_controls_section(
      'section_button_style',
      [
        'label' => __( 'Buttons', 'search-widget' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'select_button_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_ACCENT,
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(), [
        'name' => 'button_border',
        'exclude' => [
          'color',
        ],
        'selector' => '{{WRAPPER}} iframe widget',
      ]
    );

    $this->add_control(
      'button_border_color',
      [
        'label' => __('Button Border Color', 'search-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'none'
      ]
    );

    $this->start_controls_tabs('button_item_style');

    $this->start_controls_tab(
      'button_item_normal',
      [
        'label' => __('Normal', 'search-widget'),
      ]
    );

    $this->add_control(
      'button_text_normal_item',
      [
        'label' => __('Button Text Color', 'search-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FFFFFF'
      ]
    );

    $this->add_control(
      'background_color_normal_item',
      [
        'label' => __('Background Color', 'search-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#61CE70',
        'separator' => 'none',
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'button_item_hover',
      [
        'label' => __('Hover', 'search-widget'),
      ]
    );

    $this->add_control(
      'button_text_hover_item',
      [
        'label' => __('Button Text Color', 'search-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'none',
      ]
    );

    $this->add_control(
      'background_color_hover_item',
      [
        'label' => __('Background Color', 'search-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'none',
        'separator' => 'after',
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
      'button_border_radius',
      [
        'label' => __( 'Border Radius', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'button_padding',
      [
        'label' => __('Padding', 'search-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'default' => [
          'top' => '10',
          'bottom' => '10',
          'left' => '10',
          'right' => '10',
          'unit' => 'px',
        ]
      ]
    );

    $this->add_control(
      'hidden_refresh2',
      [
        'label' => __( 'View', 'search-widget' ),
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'refreshiframe',
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

    $background_image = '';
    if ($settings['iframe_background_image']['url'] != '') {
      $background_image = 'html, body, #page-wrapper, .smart-apply-container{
      background:url("'.$settings['iframe_background_image']['url'].'") !important;background-size:cover !important;
      }#page-wrapper #EFSmartApplyContainer{background:none !important;}.wrapper-content{background:none !important;}';
    }
    if ($settings['iframe_background_color']) {
      $background_image = 'html, body, #page-wrapper, .smart-apply-container{
      background:'.$settings['iframe_background_color'].' !important;
      }#page-wrapper #EFSmartApplyContainer{background:none !important;}.wrapper-content{background:none !important;}';
    }
    $show_advanced_filter = ($settings['show_advanced_filter'] == 'yes')?1:0;
    $show_location_filter = ($settings['show_location_filter'] == 'yes')?1:0;
    $show_search_filter = ($settings['show_search_filter'] == 'yes')?1:0;
    $vertical_align = ($settings['middle_align'] == 'yes')?1:0;
    $center_align = ($settings['center_align'] == 'yes')?1:0;
    $center_align_css = '';
    if ($center_align == 1) {
      $center_align_css = '@media (min-width: 992px){.col-md-4,.col-md-6 {width: 50%;}.max-width{width:1000px;margin:0 auto;}.panel .row{margin:auto;}}';
    }
    $vertical_align_css = '';
    if ($vertical_align == 1) {
      $vertical_align_css = '#page-wrapper{display:table;width:100%;}.wrapper-content{display:table-cell;vertical-align:middle;}';
    }

    $widget_id = $this->get_id();

    $time = microtime(TRUE);
    $css_file = "/wp-content/uploads/elementor/css/" . $widget_id . "_style.css?q=" . $time;

    $cta_color = $settings['cta_text_color'];
    $cta_background = $settings['cta_bg_color'];
    $cta_border = $settings['cta_border_color'];
    $facet_color = $settings['facet_color'];
    $pill_color = $settings['tag_color'];
    $pill_hover_color = ($settings['tag_hover_color'] == '')?'none':$settings['tag_hover_color'];

    $pill_font_family = $settings['tag_typography_font_family'];
    $pill_font_size = ($settings['tag_typography_font_size']['size']=='')?16:$settings['tag_typography_font_size']['size'];
    $pill_font_size_unit = $settings['tag_typography_font_size']['unit'];
    $pill_font_weight = $settings['tag_typography_font_weight'];
    $pill_font_transform = ($settings['tag_typography_text_transform']=='')?'none':$settings['tag_typography_text_transform'];
    $pill_font_style = ($settings['tag_typography_font_style']=='')?'normal':$settings['tag_typography_font_style'];
    $pill_font_decoration = ($settings['tag_typography_text_decoration']=='')?'none':$settings['tag_typography_text_decoration'];
    $pill_line_height = ($settings['tag_typography_line_height']['size'])==''?'0':$settings['tag_typography_line_height']['size'];
    $pill_line_height_unit = $settings['tag_typography_line_height']['unit'];
    $pill_letter_spacing = ($settings['tag_typography_letter_spacing']['size']=='')?0:$settings['tag_typography_letter_spacing']['size'];
    $pill_letter_spacing_unit = $settings['tag_typography_letter_spacing']['unit'];

    $pill_border_radius_unit = $settings['tag_border_radius']['unit'];
    $pill_border_radius_left = $settings['tag_border_radius']['left'];
    $pill_border_radius_right = $settings['tag_border_radius']['right'];
    $pill_border_radius_top = $settings['tag_border_radius']['top'];
    $pill_border_radius_bottom = $settings['tag_border_radius']['bottom'];
    $pill_padding_top = $settings['tag_padding']['top'];
    $pill_padding_bottom = $settings['tag_padding']['bottom'];
    $pill_padding_left = $settings['tag_padding']['left'];
    $pill_padding_right = $settings['tag_padding']['right'];
    $pill_padding_unit = $settings['tag_padding']['unit'];

    $pill_border_type = $settings['tag_border_border'];
    $pill_border_color = ($settings['tag_border_color']=='')?'none':$settings['tag_border_color'];
    $pill_hover_border_color = ($settings['tag_hover_border_color']=='')?'none':$settings['tag_hover_border_color'];
    if ($settings['tag_border_width']) {
      $pill_border_width_unit = $settings['tag_border_width']['unit'];
      $pill_border_width_left = ($settings['tag_border_width']['left']=='')?0:$settings['tag_border_width']['left'];
      $pill_border_width_right = ($settings['tag_border_width']['right']=='')?0:$settings['tag_border_width']['right'];
      $pill_border_width_top = ($settings['tag_border_width']['top']=='')?0:$settings['tag_border_width']['top'];
      $pill_border_width_bottom = ($settings['tag_border_width']['bottom']=='')?0:$settings['tag_border_width']['bottom'];
    }
    else {
      $pill_border_width_unit = 'px';
      $pill_border_width_left = 0;
      $pill_border_width_right = 0;
      $pill_border_width_top = 0;
      $pill_border_width_bottom = 0;
    }

    $facet_font_family = $settings['facet_typography_font_family'];
    $facet_font_size = ($settings['facet_typography_font_size']['size']=='')?16:$settings['facet_typography_font_size']['size'];
    $facet_font_size_unit = $settings['facet_typography_font_size']['unit'];
    $facet_font_weight = $settings['facet_typography_font_weight'];
    $facet_font_transform = ($settings['facet_typography_text_transform']=='')?'none':$settings['facet_typography_text_transform'];
    $facet_font_style = ($settings['facet_typography_font_style']=='')?'normal':$settings['facet_typography_font_style'];
    $facet_font_decoration = ($settings['facet_typography_text_decoration']=='')?'none':$settings['facet_typography_text_decoration'];
    $facet_line_height = ($settings['facet_typography_line_height']['size'])==''?'0':$settings['facet_typography_line_height']['size'];
    $facet_line_height_unit = $settings['facet_typography_line_height']['unit'];
    $facet_letter_spacing = ($settings['facet_typography_letter_spacing']['size']=='')?0:$settings['facet_typography_letter_spacing']['size'];
    $facet_letter_spacing_unit = $settings['facet_typography_letter_spacing']['unit'];

    $cta_font_family = $settings['cta_typography_font_family'];
    $cta_font_size = ($settings['cta_typography_font_size']['size']=='')?16:$settings['cta_typography_font_size']['size'];
    $cta_font_size_unit = $settings['cta_typography_font_size']['unit'];
    $cta_font_weight = $settings['cta_typography_font_weight'];
    $cta_font_transform = ($settings['cta_typography_text_transform']=='')?'none':$settings['cta_typography_text_transform'];
    $cta_font_style = ($settings['cta_typography_font_style']=='')?'normal':$settings['cta_typography_font_style'];
    $cta_font_decoration = ($settings['cta_typography_text_decoration']=='')?'none':$settings['cta_typography_text_decoration'];
    $cta_line_height = ($settings['cta_typography_line_height']['size'])==''?'0':$settings['cta_typography_line_height']['size'];
    $cta_line_height_unit = $settings['cta_typography_line_height']['unit'];
    $cta_letter_spacing = ($settings['cta_typography_letter_spacing']['size']=='')?0:$settings['cta_typography_letter_spacing']['size'];
    $cta_letter_spacing_unit = $settings['cta_typography_letter_spacing']['unit'];
    $cta_border_width_unit = $settings['field_border_width']['unit'];
    $cta_border_width_left = $settings['field_border_width']['left'];
    $cta_border_width_right = $settings['field_border_width']['right'];
    $cta_border_width_top = $settings['field_border_width']['top'];
    $cta_border_width_bottom = $settings['field_border_width']['bottom'];
    $cta_border_radius_unit = $settings['field_border_radius']['unit'];
    $cta_border_radius_left = $settings['field_border_radius']['left'];
    $cta_border_radius_right = $settings['field_border_radius']['right'];
    $cta_border_radius_top = $settings['field_border_radius']['top'];
    $cta_border_radius_bottom = $settings['field_border_radius']['bottom'];

    $button_text_color = $settings['button_text_normal_item'];
    $button_background_normal_color = $settings['background_color_normal_item'];
    $button_background_hover_color = $settings['background_color_hover_item'];
    $button_text_hover_color = $settings['button_text_hover_item'];
    $button_border_type = $settings['button_border_border'];
    $button_border_color = ($settings['button_border_color']=='')?'none':$settings['button_border_color'];
    if ($settings['button_border_width']) {
      $button_border_width_unit = $settings['button_border_width']['unit'];
      $button_border_width_left = ($settings['button_border_width']['left']=='')?0:$settings['button_border_width']['left'];
      $button_border_width_right = ($settings['button_border_width']['right']=='')?0:$settings['button_border_width']['right'];
      $button_border_width_top = ($settings['button_border_width']['top']=='')?0:$settings['button_border_width']['top'];
      $button_border_width_bottom = ($settings['button_border_width']['bottom']=='')?0:$settings['button_border_width']['bottom'];
    }
    else {
      $button_border_width_unit = 'px';
      $button_border_width_left = 0;
      $button_border_width_right = 0;
      $button_border_width_top = 0;
      $button_border_width_bottom = 0;
    }
    $button_padding_top = $settings['button_padding']['top'];
    $button_padding_bottom = $settings['button_padding']['bottom'];
    $button_padding_left = $settings['button_padding']['left'];
    $button_padding_right = $settings['button_padding']['right'];
    $button_padding_unit = $settings['button_padding']['unit'];
    $button_radius_unit = $settings['button_border_radius']['unit'];
    $button_radius_left = ($settings['button_border_radius']['left']=='')?0:$settings['button_border_radius']['left'];
    $button_radius_right = ($settings['button_border_radius']['right']=='')?0:$settings['button_border_radius']['right'];
    $button_radius_top = ($settings['button_border_radius']['top']=='')?0:$settings['button_border_radius']['top'];
    $button_radius_bottom = ($settings['button_border_radius']['bottom']=='')?0:$settings['button_border_radius']['bottom'];

    $button_font_family = ($settings['select_button_typography_font_family']=='')?'Arial':$settings['select_button_typography_font_family'];
    $button_font_size = ($settings['select_button_typography_font_size']['size'] == '')?14:$settings['select_button_typography_font_size']['size'];
    $button_font_size_unit = ($settings['select_button_typography_font_size']['unit']=='')?'px':$settings['select_button_typography_font_size']['unit'];
    $button_font_weight = ($settings['select_button_typography_font_weight']=='')?"500":$settings['select_button_typography_font_weight'];
    $button_font_transform = ($settings['select_button_typography_text_transform']=='')?'none':$settings['select_button_typography_text_transform'];
    $button_font_style = ($settings['select_button_typography_font_style']=='')?'normal':$settings['select_button_typography_font_style'];
    $button_font_decoration = ($settings['select_button_typography_text_decoration']=='')?'none':$settings['select_button_typography_text_decoration'];
    $button_line_height = 'inherit';$button_line_height_unit = '';
    if ($settings['select_button_typography_line_height']['size']) {
      $button_line_height = $settings['select_button_typography_line_height']['size'];
      $button_line_height_unit = $settings['select_button_typography_line_height']['unit'];
    }
    $button_letter_spacing = ($settings['select_button_typography_letter_spacing']['size']=='')?0:$settings['select_button_typography_letter_spacing']['size'];
    $button_letter_spacing_unit = $settings['select_button_typography_letter_spacing']['unit'];

    $styles = "#EFSmartApplyContainer .careerEmbedMode .panel{padding:0px; background:none !important;}.no-padding{display:none}
    $vertical_align_css
    #EFSmartApplyContainer .go-button{font-size:".$button_font_size.$button_font_size_unit.";
    background-color:".$button_background_normal_color.";
    padding:".$button_padding_top.$button_padding_unit." ".$button_padding_right.$button_padding_unit." ".$button_padding_bottom.$button_padding_unit." ".$button_padding_left.$button_padding_unit.";
    border-radius:".$button_radius_top.$button_radius_unit." ".$button_radius_right.$button_radius_unit." ".$button_radius_bottom.$button_radius_unit." ".$button_radius_left.$button_radius_unit.";
    border-width:".$button_border_width_top.$button_border_width_unit." ".$button_border_width_right.$button_border_width_unit." ".$button_border_width_bottom.$button_border_width_unit." ".$button_border_width_left.$button_border_width_unit.";
    color:".$button_text_color." !important;font-weight:".$button_font_weight.";font-style:".$button_font_style.";
    text-decoration:".$button_font_decoration.";line-height:".$button_line_height.$button_line_height_unit.";letter-spacing:".$button_letter_spacing.$button_letter_spacing_unit.";
    text-transform:".$button_font_transform.";border-style:".$button_border_type.";border-color:".$button_border_color." !important;
    font-family:".$button_font_family." !important;}#EFSmartApplyContainer .go-button:hover{background-color:".$button_background_hover_color." !important;color:".$button_text_hover_color." !important;}
    #EFSmartApplyContainer .Select-control{font-size:".$cta_font_size.$cta_font_size_unit.";letter-spacing:".$cta_letter_spacing.$cta_letter_spacing_unit.";
    color:".$cta_color.";text-transform:".$cta_font_transform.";font-weight:".$cta_font_weight.";font-style:".$cta_font_style.";background-color:".$cta_background.";
    border-color:".$cta_border." !important;border-width:".$cta_border_width_top.$cta_border_width_unit." ".$cta_border_width_right.$cta_border_width_unit." ".$cta_border_width_bottom.$cta_border_width_unit." ".$cta_border_width_left.$cta_border_width_unit." !important;
    border-radius:".$cta_border_radius_top.$cta_border_radius_unit." ".$cta_border_radius_right.$cta_border_radius_unit." ".$cta_border_radius_bottom.$cta_border_radius_unit." ".$cta_border_radius_left.$cta_border_radius_unit." !important;
    font-family:".$cta_font_family." !important;text-decoration:".$cta_font_decoration.";line-height:".$cta_line_height.$cta_line_height_unit.";}
    .Select-input > input{letter-spacing:".$cta_letter_spacing.$cta_letter_spacing_unit.";text-transform:".$cta_font_transform.";font-weight:".$cta_font_weight.";
    }
    .search-dropdown{width:100% !important;margin-right:12px !important;}.position-facets{margin-top: 30px;}.search-box{margin-right:-19px !important;}
    #EFSmartApplyContainer .position-facets h3{color:".$facet_color.";font-size:".$facet_font_size.$facet_font_size_unit." !important;font-weight:".$facet_font_weight.";
    text-decoration:".$facet_font_decoration.";text-transform:".$facet_font_transform.";
    line-height:".$facet_line_height.$facet_line_height_unit.";letter-spacing:".$facet_letter_spacing.$facet_letter_spacing_unit.";
    font-style:".$facet_font_style.";font-family:".$facet_font_family." !important;}
    #EFSmartApplyContainer a.pillTitle{color:".$pill_color." !important;font-size:".$pill_font_size.$pill_font_size_unit.";font-weight:".$pill_font_weight.";
    text-decoration:".$pill_font_decoration.";text-transform:".$pill_font_transform.";
    line-height:".$pill_line_height.$pill_line_height_unit.";letter-spacing:".$pill_letter_spacing.$pill_letter_spacing_unit.";
    font-style:".$pill_font_style." !important;font-family:".$pill_font_family." !important;
    padding:".$pill_padding_top.$pill_padding_unit." ".$pill_padding_right.$pill_padding_unit." ".$pill_padding_bottom.$pill_padding_unit." ".$pill_padding_left.$pill_padding_unit.";}
    #EFSmartApplyContainer .pillContainer{border-style:".$pill_border_type.";border-color:".$pill_border_color." !important;
    border-width:".$pill_border_width_top.$pill_border_width_unit." ".$pill_border_width_right.$pill_border_width_unit." ".$pill_border_width_bottom.$pill_border_width_unit." ".$pill_border_width_left.$pill_border_width_unit.";
    border-radius:".$pill_border_radius_top.$pill_border_radius_unit." ".$pill_border_radius_right.$pill_border_radius_unit." ".$pill_border_radius_bottom.$pill_border_radius_unit." ".$pill_border_radius_left.$pill_border_radius_unit.";}
    #EFSmartApplyContainer a.pillTitle:hover{color:".$pill_hover_color." !important;}
    #EFSmartApplyContainer .pillContainer:hover{border-color:".$pill_hover_border_color." !important;}
    @media (max-width: 1440px) {.location-search{max-width: 100% !important;}}$background_image $center_align_css";

    create_css_file($widget_id, $styles);

    echo '<iframe id="ef-pcs-search" src="'.$embed_url.'/careers/embed?" title="search" style="z-index: 100000000;width :100%;height:'.$settings['iframeheight'].'px;"></iframe>
		<script type="text/javascript">
		var searchEmbeddedConfig = {
			visibilityConfig : {
				showAdvancedFilterOptions: '.$show_advanced_filter.',
				showLocationFilterOption: '.$show_location_filter.',
				showSearchFilterOption: '.$show_search_filter.'
			},
			textConfig : {
				submitButtonText : "'.$settings["buttonText"].'",
				advancedOptionText : "'.$settings["advancedtext"].'"
			},
      cssConfigUrl : encodeURIComponent(window.location.origin + "'.$css_file.'")
		};
		!function(){if(searchEmbeddedConfig){var e=document.getElementById("ef-pcs-search").src;document.getElementById("ef-pcs-search").src=e+"&config="+JSON.stringify(searchEmbeddedConfig)}}();
    </script>';
  }

}
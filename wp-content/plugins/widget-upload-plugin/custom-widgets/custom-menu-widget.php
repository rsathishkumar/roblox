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
class Custom_elementor_menu_widget extends \Elementor\Widget_Base {

  /**
   * Class constructor.
   *
   * @param array $data Widget data.
   * @param array $args Widget arguments.
   */
  public function __construct( $data = array(), $args = null ) {
    parent::__construct( $data, $args );

    wp_register_style( 'custommenu-style1', plugins_url('../css/sm-core-css.css', __FILE__), array('elementor-icons-fa-solid'), '1.0.0' );
  //  wp_register_style( 'custommenu-style2', plugins_url('../css/sm-simple.css', __FILE__), array(), '1.0.0' );
    wp_register_style( 'eightfold-icon-css', plugins_url('../../../uploads/elementor/custom-icons/eightfold-icon/css/eightfold-icon.css', __FILE__), array(), '1.0.0' );
    wp_register_script( 'custommenu-js', plugins_url('../js/jquery.smartmenus.js', __FILE__), ['jquery'], '1.0.0' );
  }

  /**
   * A list of style that the widgets is depended in
   **/
  public function get_style_depends() {
    return [
      'custommenu-style1',
      'custommenu-style2',
      'eightfold-icon-css'
    ];
  }
  /**
   * A list of scripts that the widgets is depended in
   **/
  public function get_script_depends() {
    return [
      'custommenu-js'
    ];
  }

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
    return 'custommenuwidget';
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
    return __( 'Menu Widget', 'plugin-name' );
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
    return 'eicon-nav-menu';
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
      $link = get_permalink($page->ID);
      $options[ $link ] = $page->post_title;
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
      'section_menu',
      [
        'label' => __( 'Menu content', 'elementor' ),
      ]
    );

    $pages = $this->get_available_pages();
    $pages['other'] = 'Custom Page link';

    $repeater_submenu = new \Elementor\Repeater();

    $repeater_submenu->add_control(
      'submenu_title',
      [
        'label' => __( 'Title', 'elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Sub Menu Title', 'elementor' ),
        'placeholder' => __( 'Sub Menu Title', 'elementor' ),
        'label_block' => true,
      ]
    );

    $repeater_submenu->add_control(
      'submenu_page_link',
      [
        'label' => __( 'Sub menu Page', 'elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => __( 'https://your-link.com', 'elementor' ),
      ]
    );

    $repeater_submenu->add_control(
      'submenu_link',
      [
        'label' => __( 'Sub menu Link', 'elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => __( 'https://your-link.com', 'elementor' ),
        'condition' => [
          'submenu_page_link' => 'other',
        ],
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'menu_title',
      [
        'label' => __( 'Title', 'elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( '', 'elementor' ),
        'placeholder' => __( 'Menu Title', 'elementor' ),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'submenu_page',
      [
        'label' => __( 'Sub menu Page', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => $pages,
        'default' => array_keys( $pages )[0],
        'save_default' => true
      ]
    );

    $repeater->add_control(
      'menu_link',
      [
        'label' => __( 'Link', 'elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => __( 'https://your-link.com', 'elementor' ),
        'condition' => [
          'submenu_page' => 'other',
        ],
      ]
    );

    $repeater->add_control(
      'submenu_list',
      [
        'label' => __( 'Child menu items', 'elementor' ),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater_submenu->get_controls(),
        'default' => [],
        'title_field' => '{{{ menu_title }}}',
        'item_actions' => ['drag_n_drop' => true, 'duplicate' => false]
      ]
    );

    $this->add_control(
      'menu_list',
      [
        'label' => __( 'Menu Items', 'elementor' ),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'text' => __( 'Menu Item #1', 'elementor' ),
            'selected_icon' => [
              'value' => 'fas fa-check',
              'library' => 'fa-solid',
            ],
          ],
          [
            'text' => __( 'Menu Item #2', 'elementor' ),
            'selected_icon' => [
              'value' => 'fas fa-times',
              'library' => 'fa-solid',
            ],
          ],
          [
            'text' => __( 'Menu Item #3', 'elementor' ),
            'selected_icon' => [
              'value' => 'fas fa-dot-circle',
              'library' => 'fa-solid',
            ],
          ],
        ],
        'title_field' => '{{{ menu_title }}}',
        'item_actions' => ['drag_n_drop' => true, 'duplicate' => false]
      ]
    );

    $this->add_control(
      'hr',
      [
        'type' => \Elementor\Controls_Manager::DIVIDER,
      ]
    );

    $this->add_control(
      'layout',
      [
        'label' => __( 'Layout', 'elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'horizontal',
        'options' => [
          'horizontal' => __( 'Horizontal', 'elementor' ),
          'vertical' => __( 'Vertical', 'elementor' ),
          'dropdown' => __( 'Dropdown', 'elementor' ),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'menu_type',
      [
        'label' => __( 'Mega menu', 'elementor' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'elementor' ),
        'label_off' => __( 'No', 'elementor' ),
        'return_value' => 'yes',
        'default' => 'yes',
        'condition' => [
          'layout' => 'horizontal',
        ]
      ]
    );

    $this->add_control(
      'align_submenu',
      [
        'label' => __( 'Align submenu', 'elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'left',
        'options' => [
          'none' => __( 'None', 'elementor' ),
          'unset' => __( 'Center', 'elementor' ),
          'relative' => __( 'Left', 'elementor' ),
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu li' => 'position: {{VALUE}}',
        ],
        'condition' => [
          'menu_type' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'mega_menu_column',
      [
        'label' => __( 'Mega menu column', 'elementor' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __( '2', 'elementor' ),
        'condition' => [
          'menu_type' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'align_items',
      [
        'label' => __( 'Align', 'elementor' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor' ),
            'icon' => 'eicon-h-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor' ),
            'icon' => 'eicon-h-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor' ),
            'icon' => 'eicon-h-align-right',
          ],
          'justify' => [
            'title' => __( 'Stretch', 'elementor' ),
            'icon' => 'eicon-h-align-stretch',
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main' => 'text-align: {{VALUE}}',
          ],
        'condition' => [
          'layout!' => 'dropdown',
        ],
      ]
    );

    $this->add_control(
      'pointer',
      [
        'label' => __( 'Pointer', 'elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'underline',
        'options' => [
          'none' => __( 'None', 'elementor' ),
          'underline' => __( 'Underline', 'elementor' ),
          'overline' => __( 'Overline', 'elementor' ),
          'double-line' => __( 'Double Line', 'elementor' ),
          'framed' => __( 'Framed', 'elementor' ),
          'background' => __( 'Background', 'elementor' ),
          'text' => __( 'Text', 'elementor' ),
        ],
        'style_transfer' => true,
        'condition' => [
          'layout!' => 'dropdown',
        ],
      ]
    );

    $this->add_control(
      'animation_line',
      [
        'label' => __( 'Animation', 'elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'fade',
        'options' => [
          'fade' => 'Fade',
          'slide' => 'Slide',
          'grow' => 'Grow',
          'drop-in' => 'Drop In',
          'drop-out' => 'Drop Out',
          'none' => 'None',
        ],
        'condition' => [
          'layout!' => 'dropdown',
          'pointer' => [ 'underline', 'overline', 'double-line' ],
        ],
      ]
    );

    $this->add_control(
      'animation_framed',
      [
        'label' => __( 'Animation', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'fade',
        'options' => [
          'fade' => 'Fade',
          'grow' => 'Grow',
          'shrink' => 'Shrink',
          'draw' => 'Draw',
          'corners' => 'Corners',
          'none' => 'None',
        ],
        'condition' => [
          'layout!' => 'dropdown',
          'pointer' => 'framed',
        ],
      ]
    );

    $this->add_control(
      'animation_background',
      [
        'label' => __( 'Animation', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'fade',
        'options' => [
          'fade' => 'Fade',
          'grow' => 'Grow',
          'shrink' => 'Shrink',
          'sweep-left' => 'Sweep Left',
          'sweep-right' => 'Sweep Right',
          'sweep-up' => 'Sweep Up',
          'sweep-down' => 'Sweep Down',
          'shutter-in-vertical' => 'Shutter In Vertical',
          'shutter-out-vertical' => 'Shutter Out Vertical',
          'shutter-in-horizontal' => 'Shutter In Horizontal',
          'shutter-out-horizontal' => 'Shutter Out Horizontal',
          'none' => 'None',
        ],
        'condition' => [
          'layout!' => 'dropdown',
          'pointer' => 'background',
        ],
      ]
    );

    $this->add_control(
      'animation_text',
      [
        'label' => __( 'Animation', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'grow',
        'options' => [
          'grow' => 'Grow',
          'shrink' => 'Shrink',
          'sink' => 'Sink',
          'float' => 'Float',
          'skew' => 'Skew',
          'rotate' => 'Rotate',
          'none' => 'None',
        ],
        'condition' => [
          'layout!' => 'dropdown',
          'pointer' => 'text',
        ],
      ]
    );

    $this->add_control(
      'indicator',
      [
        'label' => __( 'Submenu Indicator', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'classic',
        'options' => [
          'none' => __( 'None', 'elementor-pro' ),
          'classic' => __( 'Classic', 'elementor' ),
          'chevron' => __( 'Chevron', 'elementor-pro' ),
          'angle' => __( 'Angle', 'elementor-pro' ),
          'plus' => __( 'Plus', 'elementor-pro' ),
        ],
        'prefix_class' => 'elementor-nav-menu--indicator-',
      ]
    );

    $this->add_control(
      'heading_mobile_dropdown',
      [
        'label' => __( 'Mobile Dropdown', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => [
          'layout!' => 'dropdown',
        ],
      ]
    );

    $breakpoints =  \Elementor\Core\Responsive\Responsive::get_breakpoints();

    $this->add_control(
      'dropdown',
      [
        'label' => __( 'Breakpoint', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'tablet',
        'options' => [
          /* translators: %d: Breakpoint number. */
          'mobile' => sprintf( __( 'Mobile (< %dpx)', 'elementor-pro' ), $breakpoints['md'] ),
          /* translators: %d: Breakpoint number. */
          'tablet' => sprintf( __( 'Tablet (< %dpx)', 'elementor-pro' ), $breakpoints['lg'] ),
          'none' => __( 'None', 'elementor-pro' ),
        ],
        'prefix_class' => 'elementor-smartmenu--dropdown-',
        'condition' => [
          'layout!' => 'dropdown',
        ],
      ]
    );

    $this->add_control(
      'full_width',
      [
        'label' => __( 'Full Width', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'description' => __( 'Stretch the dropdown of the menu to full width.', 'elementor-pro' ),
        'prefix_class' => 'elementor-nav-menu--',
        'return_value' => 'stretch',
        'frontend_available' => true,
        'condition' => [
          'dropdown!' => 'none',
        ],
      ]
    );

    $this->add_control(
      'text_align',
      [
        'label' => __( 'Align', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'aside',
        'options' => [
          'aside' => __( 'Aside', 'elementor-pro' ),
          'center' => __( 'Center', 'elementor-pro' ),
        ],
        'prefix_class' => 'elementor-nav-menu__text-align-',
        'condition' => [
          'dropdown!' => 'none',
        ],
      ]
    );

    $this->add_control(
      'toggle',
      [
        'label' => __( 'Toggle Button', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'burger',
        'options' => [
          '' => __( 'None', 'elementor-pro' ),
          'burger' => __( 'Hamburger', 'elementor-pro' ),
        ],
        'prefix_class' => 'elementor-nav-menu--toggle elementor-nav-menu--',
        'render_type' => 'template',
        'frontend_available' => true,
        'condition' => [
          'dropdown!' => 'none',
        ],
      ]
    );

    $this->add_control(
      'toggle_align',
      [
        'label' => __( 'Toggle Align', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'default' => 'center',
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor-pro' ),
            'icon' => 'eicon-h-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor-pro' ),
            'icon' => 'eicon-h-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor-pro' ),
            'icon' => 'eicon-h-align-right',
          ],
        ],
        'selectors_dictionary' => [
          'left' => 'margin-right: auto',
          'center' => 'margin: 0 auto',
          'right' => 'margin-left: auto',
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-menu-toggle' => '{{VALUE}}',
        ],
        'condition' => [
          'toggle!' => '',
          'dropdown!' => 'none',
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_main_menu_style',
      [
        'label' => __( 'Main menu', 'elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'menu_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_ACCENT,
        ],
        'selector' => '{{WRAPPER}} .elementor-nav-menu .elementor-item',
      ]
    );

    $this->start_controls_tabs( 'tabs_menu_item_style' );

    $this->start_controls_tab(
      'tab_menu_item_normal',
      [
        'label' => __( 'Normal', 'elementor' ),
      ]
    );

    $this->add_control(
      'color_menu_item_normal',
      [
        'label' => __( 'Text Color', 'elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu .elementor-item' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_menu_item_hover',
      [
        'label' => __( 'Hover', 'elementor' ),
      ]
    );

    $this->add_control(
      'color_menu_item_hover',
      [
        'label' => __( 'Text Color', 'elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
           {{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'pointer!' => 'background',
        ],
      ]
    );

    $this->add_responsive_control(
      'background_color_menu_item_hover',
      [
        'label' => __( 'Menu Hover Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
           {{WRAPPER}} .elementor-nav-menu--main .elementor-item.highlighted,
           {{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus' => 'background-color: {{VALUE}} !important',
        ],
        'separator' => 'none',
      ]
    );


    $this->add_control(
      'color_menu_item_hover_pointer_bg',
      [
        'label' => __( 'Text Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => Global_Colors::COLOR_TEXT,
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
          {{WRAPPER}} .elementor-nav-menu--main .elementor-item.highlighted,
          {{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'pointer' => 'background',
        ],
      ]
    );

    $this->add_control(
      'pointer_color_menu_item_hover',
      [
        'label' => __( 'Pointer Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_ACCENT,
        ],
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:before,
          {{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
          '{{WRAPPER}} .e--pointer-framed .elementor-item:before,
          {{WRAPPER}} .e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}',
        ],
        'condition' => [
          'pointer!' => [ 'none', 'text' ],
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_menu_item_active',
      [
        'label' => __( 'Active', 'elementor' ),
      ]
    );

    $this->add_control(
      'color_menu_item_active',
      [
        'label' => __( 'Text Color', 'elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'global' => [
          'default' => Global_Colors::COLOR_TEXT,
        ],
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'pointer_color_menu_item_active',
      [
        'label' => __( 'Pointer Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:before,
          {{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:after' => 'background-color: {{VALUE}}',
          '{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:before,
          {{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:after' => 'border-color: {{VALUE}}',
        ],
        'condition' => [
          'pointer!' => [ 'none', 'text' ],
        ],
      ]
    );

    $this->add_responsive_control(
      'background_color_menu_item_active',
      [
        'label' => __( 'Menu Active Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active' => 'background-color: {{VALUE}}',
        ],
        'separator' => 'none',
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    /* This control is required to handle with complicated conditions */
    $this->add_control(
      'hr',
      [
        'type' => \Elementor\Controls_Manager::DIVIDER,
      ]
    );

    $this->add_responsive_control(
      'background_color_menu',
      [
        'label' => __( 'Background Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu' => 'background-color: {{VALUE}}',
        ],
        'separator' => 'none',
      ]
    );

    $this->add_responsive_control(
      'pointer_width',
      [
        'label' => __( 'Pointer Width', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .e--pointer-framed .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
          '{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
          '{{WRAPPER}} .e--pointer-underline .elementor-item:after,
           {{WRAPPER}} .e--pointer-overline .elementor-item:before,
           {{WRAPPER}} .e--pointer-double-line .elementor-item:before,
           {{WRAPPER}} .e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
        ],
        'condition' => [
          'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
        ],
      ]
    );

    $this->add_responsive_control(
      'padding_horizontal_menu_item',
      [
        'label' => __( 'Horizontal Padding', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'padding_vertical_menu_item',
      [
        'label' => __( 'Vertical Padding', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'menu_space_between',
      [
        'label' => __( 'Space Between', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 100,
          ],
        ],
        'selectors' => [
          'body:not(.rtl) {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
          'body.rtl {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .elementor-nav-menu--main:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'border_radius_menu_item',
      [
        'label' => __( 'Border Radius', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
          '{{WRAPPER}} .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
          '{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
          '{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
        ],
        'condition' => [
          'pointer' => 'background',
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_style_dropdown',
      [
        'label' => __( 'Dropdown', 'elementor-pro' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'dropdown_description',
      [
        'raw' => __( 'On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::RAW_HTML,
        'content_classes' => 'elementor-descriptor',
      ]
    );

    $this->start_controls_tabs( 'tabs_dropdown_item_style' );

    $this->start_controls_tab(
      'tab_dropdown_item_normal',
      [
        'label' => __( 'Normal', 'elementor-pro' ),
      ]
    );

    $this->add_responsive_control(
      'color_dropdown_item',
      [
        'label' => __( 'Text Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a, {{WRAPPER}} .elementor-menu-toggle' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'background_color_dropdown_item',
      [
        'label' => __( 'Background Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown' => 'background-color: {{VALUE}}',
        ],
        'separator' => 'none',
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_dropdown_item_hover',
      [
        'label' => __( 'Hover', 'elementor-pro' ),
      ]
    );

    $this->add_responsive_control(
      'color_dropdown_item_hover',
      [
        'label' => __( 'Text Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a:hover,
          {{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active,
          {{WRAPPER}} .elementor-nav-menu--dropdown a.highlighted,
          {{WRAPPER}} .elementor-menu-toggle:hover' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'background_color_dropdown_item_hover',
      [
        'label' => __( 'Background Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a:hover,
          {{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active,
          {{WRAPPER}} .elementor-nav-menu--dropdown a.highlighted' => 'background-color: {{VALUE}}',
        ],
        'separator' => 'none',
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_dropdown_item_active',
      [
        'label' => __( 'Active', 'elementor-pro' ),
      ]
    );

    $this->add_control(
      'color_dropdown_item_active',
      [
        'label' => __( 'Text Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'background_color_dropdown_item_active',
      [
        'label' => __( 'Background Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active' => 'background-color: {{VALUE}}',
        ],
        'separator' => 'none',
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'dropdown_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_ACCENT,
        ],
        'exclude' => [ 'line_height' ],
        'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown .elementor-item, {{WRAPPER}} .elementor-nav-menu--dropdown  .elementor-sub-item',
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'dropdown_border',
        'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'dropdown_border_radius',
      [
        'label' => __( 'Border Radius', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .elementor-nav-menu--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
          '{{WRAPPER}} .elementor-nav-menu--dropdown li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'dropdown_box_shadow',
        'exclude' => [
          'box_shadow_position',
        ],
        'selector' => '{{WRAPPER}} .elementor-nav-menu--main .elementor-nav-menu--dropdown, {{WRAPPER}} .elementor-nav-menu__container.elementor-nav-menu--dropdown',
      ]
    );

    $this->add_responsive_control(
      'padding_horizontal_dropdown_item',
      [
        'label' => __( 'Horizontal Padding', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
        ],
        'separator' => 'before',

      ]
    );

    $this->add_responsive_control(
      'padding_vertical_dropdown_item',
      [
        'label' => __( 'Vertical Padding', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'heading_dropdown_divider',
      [
        'label' => __( 'Divider', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'dropdown_divider',
        'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown li:not(:last-child)',
        'exclude' => [ 'width' ],
      ]
    );

    $this->add_responsive_control(
      'dropdown_divider_width',
      [
        'label' => __( 'Border Width', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
        ],
        'condition' => [
          'dropdown_divider_border!' => '',
        ],
      ]
    );

    $this->add_responsive_control(
      'dropdown_top_distance',
      [
        'label' => __( 'Distance', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => -100,
            'max' => 100,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .elementor-nav-menu--main > .elementor-nav-menu > li > .elementor-nav-menu--dropdown, {{WRAPPER}} .elementor-nav-menu__container.elementor-nav-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
        ],
        'separator' => 'before',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section( 'style_toggle',
      [
        'label' => __( 'Toggle Button', 'elementor-pro' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
          'toggle!' => '',
          'dropdown!' => 'none',
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
      'toggle_color',
      [
        'label' => __( 'Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn-icon:before' => 'background: {{VALUE}}', // Harder selector to override text color control
          '{{WRAPPER}} .main-menu-btn-icon:after' => 'background: {{VALUE}}', // Harder selector to override text color control
          '{{WRAPPER}} .main-menu-btn-icon' => 'background: {{VALUE}}' // Harder selector to override text color control
        ],
      ]
    );

    $this->add_control(
      'toggle_background_color',
      [
        'label' => __( 'Background Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn' => 'background-color: {{VALUE}}',
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
      'toggle_color_hover',
      [
        'label' => __( 'Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn-icon:hover::before' => 'background: {{VALUE}}', // Harder selector to override text color control
          '{{WRAPPER}} .main-menu-btn-icon:hover::after' => 'background: {{VALUE}}', // Harder selector to override text color control
          '{{WRAPPER}} .main-menu-btn-icon:hover' => 'background: {{VALUE}}', // Harder selector to override text color control
        ],
      ]
    );

    $this->add_control(
      'toggle_background_color_hover',
      [
        'label' => __( 'Background Color', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn:hover' => 'background-color: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->add_responsive_control(
      'toggle_size',
      [
        'label' => __( 'Size', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 15,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn' => 'width: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .main-menu-btn-icon' => 'width: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .main-menu-btn-icon:hover::before' => 'width: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .main-menu-btn-icon:hover::after' => 'width: {{SIZE}}{{UNIT}}'
        ],
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'toggle_border_width',
      [
        'label' => __( 'Border Width', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'max' => 10,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn' => 'border-width: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'toggle_border_radius',
      [
        'label' => __( 'Border Radius', 'elementor-pro' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .main-menu-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
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
    $mega_menu = '';
    $megamenu_class = 'vertical_menu';
    $min_width = 10;
    $max_width = 40;
    $column_width = 100;
    $show_vertical = 0;
    $elementor_id = "main_menu_".$this->get_id();
    if ($settings['menu_type'] == 'yes') {
      $mega_menu = 'mega-menu';
      $megamenu_class = '';
      $max_width += ($settings['mega_menu_column'] + 10);
      $min_width += ($settings['mega_menu_column'] + 20);
      $column_width = number_format($column_width / $settings['mega_menu_column'],2);
    }

    $vertical = $settings['layout'] == 'vertical'?"sm-vertical":'';
    if ($settings['layout'] != 'horizontal') {
      $min_width = 10;
      $max_width = 40;
      $column_width = 100;
      $show_vertical = 1;
    }

    if ( $settings['menu_list'] ) {

      $this->add_render_attribute( 'main-menu', 'class', [
        'elementor-nav-menu--main',
        'elementor-nav-menu__container',
        'elementor-nav-menu--layout-' . $settings['layout'],
      ] );

      if ( $settings['pointer'] ) :
        $this->add_render_attribute( 'main-menu', 'class', 'e--pointer-' . $settings['pointer'] );

        foreach ( $settings as $key => $value ) :
          if ( 0 === strpos( $key, 'animation' ) && $value ) :
            $this->add_render_attribute( 'main-menu', 'class', 'e--animation-' . $value );

            break;
          endif;
        endforeach;
      endif;

      echo '<nav id="main-nav" '. $this->get_render_attribute_string( 'main-menu' ) .'>';
      if (!empty($settings['toggle'])) {
        echo '<input id="main-menu-state" type="checkbox" style="display: none;" /><label class="main-menu-btn" for="main-menu-state"><span class="main-menu-btn-icon"></span></label>';
      }

      echo '<ul id="main-menu" class="elementor-nav-menu sm sm-simple '.$elementor_id . ' ' . $vertical.' ' .$megamenu_class. '">';
      foreach (  $settings['menu_list'] as $item ) {
        $page_link = ($item['submenu_page'] == 'other')?$item['menu_link']['url']:$item['submenu_page'];
        $is_external = ($item['menu_link']['is_external'] == 'on')?'target="_blank"':"";
        echo '<li><a href="'.$page_link.'" '.$is_external;
        if ($item['submenu_list']) {
          $subitem_list = '';
          foreach (  $item['submenu_list'] as $subitem ) {
            if ($subitem['menu_title']) {
              $page_link = ($subitem['submenu_page'] == 'other')?$subitem['menu_link']['url']:$subitem['submenu_page'];
              $subitem_list .= '<li style="width:'.$column_width.'%"><a href="'.$page_link.'" class="elementor-sub-item">' . $subitem['menu_title'] . '</a></li>';
            }
          }
          if ($subitem_list) {
            echo ' class="elementor-item has-submenu">' . $item['menu_title'] . '<span class="sub-arrow"></span></a>';
            echo '<ul class="elementor-nav-menu--dropdown '.$mega_menu.'">'.$subitem_list.'</ul>';
          }
          else {
            echo ' class="elementor-item">' . $item['menu_title'] . '</a>';
          }
        }
        else {
          echo ' class="elementor-item">' . $item['menu_title'] . '</a>';
        }
        echo '</li>';
      }
      echo '</ul></nav>';
      echo '<script type="text/javascript">jQuery(function() {
      jQuery(".'.$elementor_id.'").smartmenus({
      mainMenuSubOffsetX: -1,
        mainMenuSubOffsetY: 0,
        subMenusSubOffsetX: 6,
        subMenusSubOffsetY: -6,
        subMenusMaxWidth: "'.$max_width.'em",
        subMenusMinWidth: "'.$min_width.'em",
        showOnClick: '.$show_vertical.',
        subIndicatorsPos:   "append"
      });
    });
    var url = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.search;
    jQuery("#main-menu li:first a").addClass("elementor-item-active");
    jQuery("#main-menu a").each(function() {
      var href = jQuery(this).attr("href");
      if (url == href) {
        if (jQuery(this).hasClass("elementor-sub-item")) {
          jQuery("#main-menu li:first a").removeClass("elementor-item-active");
          jQuery(this).parents("li:eq(1)").children("a").addClass("elementor-item-active");
        }
        else {
          jQuery("#main-menu li:first a").removeClass("elementor-item-active");
          jQuery(this).addClass("elementor-item-active");
        }
      }
    })
    </script>';
    }

  }

}

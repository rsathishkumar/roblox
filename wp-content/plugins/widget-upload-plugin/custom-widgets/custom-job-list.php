<?php

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;

/**
 * Custom elementor widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Custom_job_list_widget extends \Elementor\Widget_Base {

    /**
     * Class constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct( $data = array(), $args = null ) {
        parent::__construct( $data, $args );



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
        return 'job_list_widget';
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
        return __('Jobs List', 'job-list-widget');
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
        return 'eicon-table-of-contents';
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

        // start first section 1
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'job-list-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_keyword',
            [
                'label' => __( 'Search Keyword', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'java', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'location',
            [
                'label' => __( 'Location', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Amsterdam', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'set_limit',
            [
                'label' => __( 'Set Limit', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '5', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'authorization_key',
            [
                'label' => __( 'Authorization Key', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Basic ryxqrzhmahvyrrowkbbibphuwxvuaelc', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => __( 'Url', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'https://api-eu.eightfold.ai/v1/position/search', 'job-list-widget' ),
            ]
        );

        $this->add_responsive_control(
            'hide_button',
            [
                'label' => __( 'Hide Button', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Hide', 'job-list-widget' ),
                'label_off' => __( 'Show', 'job-list-widget' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .right-column' => 'display:{{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Apply Job', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => __( 'Show Description', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'job-list-widget' ),
                'label_off' => __( 'Hide', 'job-list-widget' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'filter_option',
            [
                'label' => __( 'Show only External and Open jobs', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'job-list-widget' ),
                'label_off' => __( 'Hide', 'job-list-widget' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'jobs_link_url',
            [
                'label' => __( 'Jobs Link', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'https://app.eightfold.ai/careers', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'jobs_list_domain',
            [
                'label' => __( 'Jobs List Domain', 'job-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'job-list-widget' ),
            ]
        );

        $this->add_control(
            'description_length',
            [
                'label' => __( 'Description Length', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => __( '200', 'job-list-widget' ),
                'condition' => [
                    'show_description' => 'yes',
                ]
            ]
        );

      $this->add_control(
        'button_icon',
        [
          'label' => __('Button Icon', 'custom-job_list-widget'),
          'type' => \Elementor\Controls_Manager::ICONS,
          'fa4compatibility' => 'icon',
          'default' => [
            'value' => 'fa fa-search',
            'library' => 'fa-search',
          ],
        ]
      );


      // end first section 1
        $this->end_controls_section();

        $this->start_controls_section(
            'general_style',
            [
                'label' => __('General', 'custom-job_list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'number_columns',
            [
                'label' => __( 'Column', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'One',
                'options' => [
                    '100%' => __( 'One', 'custom-job_list-widget' ),
                    '50%' => __( 'Two', 'custom-job_list-widget' ),
                    '33.33%' => __( 'Three', 'custom-job_list-widget' ),
                    '25%' => __( 'Four', 'custom-job_list-widget' ),
                    '20%' => __( 'Five', 'custom-job_list-widget' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container' => 'display:inline-flex;flex-wrap:wrap;width:100%;',
                    '{{WRAPPER}} .flex-container .jobs-list' => '--width: {{VALUE}};'
                ],
            ]
        );

      $this->add_responsive_control(
        'column_gap',
        [
          'label' => __( 'Column Gap', 'custom-job_list-widget' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'px' => [
              'max' => 50,
            ],
          ],
          'selectors' => [
            '{{WRAPPER}} .flex-container' => 'column-gap: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .flex-container .jobs-list' => 'flex:0 0 calc(var(--width) - {{SIZE}}{{UNIT}});'
         ],
        ]
      );

      $this->add_responsive_control(
        'row_gap',
        [
          'label' => __( 'Row Gap', 'custom-job_list-widget' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'px' => [
              'max' => 50,
            ],
          ],
          'selectors' => [
            '{{WRAPPER}} .flex-container' => 'row-gap: {{SIZE}}{{UNIT}};'
          ],
        ]
      );

      $this->add_group_control(
          \Elementor\Group_Control_Box_Shadow::get_type(),
          [
            'name' => 'list_box_shadow',
            'selector' => '{{WRAPPER}} .flex-container .jobs-list',
          ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => __( 'Button Position', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => __( 'None', 'custom-job_list-widget' ),
                    'flex' => __( 'Left', 'custom-job_list-widget' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list ' => 'display:{{VALUE}};flex-direction: row;',
                    '{{WRAPPER}} .flex-container .jobs-list .right-column ' => 'flex: 1 0 0;',
                    '{{WRAPPER}} .flex-container .jobs-list .left-column ' => 'flex: 2 0 0;',
                ],
                'condition' => [
                    'hide_button!' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_alignment',
            [
                'label' => __( 'Button Alignment', 'custom-search-job-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'none' => __( 'None', 'custom-search-job-widget' ),
                    'left' => __( 'Left', 'custom-search-job-widget' ),
                    'right' => __( 'Right', 'custom-search-job-widget' ),
                    'center' => __( 'Center', 'custom-search-job-widget' )
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .right-column' => 'text-align: {{VALUE}}',
                ],
                'condition' => [
                    'hide_button!' => 'none'
                ]
            ]
        );


        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => __('Item Spacing', 'custom-job_list-widget'),
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
                    '{{WRAPPER}} .flex-container .jobs-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

      $this->add_control(
        'list-border-style',
        [
          'label' => __( 'List Border style', 'custom-job_list-widget' ),
          'type' => \Elementor\Controls_Manager::SELECT,
          'default' => 'none',
          'options' => [
            'none' => __( 'None', 'custom-search-job-widget' ),
            'solid' => __( 'Solid', 'custom-search-job-widget' ),
            'double' => __( 'Double', 'custom-search-job-widget' ),
            'dotted' => __( 'Dotted', 'custom-search-job-widget' ),
            'dashed' => __( 'Dashed', 'custom-search-job-widget' ),
            'groove' => __( 'groove', 'custom-search-job-widget' ),
          ],
          'selectors' => [
            '{{WRAPPER}} .flex-container .jobs-list' => 'border-style: {{VALUE}}',
          ],
        ]
      );

      $this->add_control(
        'job_list_border_color',
        [
          'label' => __('Border color', 'custom-job_list-widget'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'default' => Global_Colors::COLOR_ACCENT,
          'separator' => 'none',
          'selectors' => [
            '{{WRAPPER}} .flex-container .jobs-list' => 'border-color: {{VALUE}}',
          ],
          'condition' => [
            'list-border-style!' => 'none',
          ]
        ]
      );


      $this->add_responsive_control(
        'list-border_width',
        [
          'label' => __( 'List Border Width', 'custom-job_list-widget' ),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'selectors' => [
            '{{WRAPPER}} .flex-container .jobs-list' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
          ],
        ]
      );

      $this->end_controls_section();

        // start first section 3
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Job Title', 'job-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .job-title a',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-title a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'title-spacing',
            [
                'label' => __( 'Title Spacing', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        // end first section 3
        $this->end_controls_section();

        // start first section 4
        $this->start_controls_section(
            'section_description_style',
            [
                'label' => __('Job Description', 'custom-job_list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .job-description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Description Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        // start first section 4
        $this->end_controls_section();

        // start first section 4
        $this->start_controls_section(
            'section_location_style',
            [
                'label' => __('Job Location', 'custom-job_list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'location_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .job-location',
            ]
        );

        $this->add_control(
            'location_text_color',
            [
                'label' => __( 'Location Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-location' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'location-spacing',
            [
                'label' => __( 'Location Spacing', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-location' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );


        $this->end_controls_section();


        // start first button style section
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Job Button', 'custom-job_list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'hide_button!' => 'none'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .job-button',
            ]
        );

        $this->add_responsive_control(
            'right_column_spacing',
            [
                'label' => __('Right Column Padding', 'custom-job_list-widget'),
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
                    '{{WRAPPER}} .flex-container .jobs-list .right-column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_spacing',
            [
                'label' => __('Button Padding', 'custom-job_list-widget'),
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
                    '{{WRAPPER}} .flex-container .jobs-list .right-column .job-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'border-style',
            [
                'label' => __( 'Border style', 'custom-search-job-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'none' => __( 'None', 'custom-search-job-widget' ),
                    'solid' => __( 'Solid', 'custom-search-job-widget' ),
                    'double' => __( 'Double', 'custom-search-job-widget' ),
                    'dotted' => __( 'Dotted', 'custom-search-job-widget' ),
                    'dashed' => __( 'Dashed', 'custom-search-job-widget' ),
                    'groove' => __( 'groove', 'custom-search-job-widget' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button' => 'border-style: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_width',
            [
                'label' => __( 'Border Width', 'custom-search-job-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'custom-search-job-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );


        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'custom-job_list-widget' ),
            ]
        );


        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Background Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => __( 'Border Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border-style!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'custom-job_list-widget' ),
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Text Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button:hover svg *' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'custom-job_list-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .flex-container .jobs-list .job-button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border-style!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // end button style section
        $this->end_controls_section();

    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to 0generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $search_keyword = $settings['search_keyword'];
        $column_width = $settings['number_columns'];
        $column_gap = ($settings['column_gap']['size']=='')?0:$settings['column_gap']['size'];
      $migrated = isset($settings['__fa4_migrated']['button_icon']);
      $is_new = !isset($settings['icon']) && \Elementor\Icons_Manager::is_migration_allowed();

      if (!$is_new && empty($settings['icon_align'])) {
        // @todo: remove when deprecated
        // added as bc in 2.6
        //old default
        $settings['icon_align'] = $this->get_settings('icon_align');
      }
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


        $location = $settings['location'];
        $authorization_key = $settings['authorization_key'];
        $set_limit = $settings['set_limit'];
        if (!$set_limit) {
            $set_limit = 5;
        }
        $length = $settings["description_length"];
        $show_description = $settings['show_description'];
        $filter_option = $settings['filter_option'];

        $url = $settings["url"];
        $job_link_url = $settings["jobs_link_url"];
        $job_list_domain = $settings["jobs_list_domain"];
        $button_text = $settings["button_text"];
        $api_url = $url."?limit=".$set_limit."&include=atsdata";
        if ($search_keyword != '') {
          $api_url .= '&query='.$search_keyword;
        }
        if ($filter_option) {
          $api_url .= '&filterQuery=isOpen%20eq%20true%20and%20postedFor%20eq%20%27external%27';
        }
        if ($location != '') {
          $api_url .= '%20AND%20locations:'.$location;
        }
        $date = date("Y-m-d H:i:s");
        $result = '';

        global $wpdb;
        $query_result = $wpdb->get_results('SELECT job_api_response FROM '.$wpdb->prefix.'tbl_cache_jobs_api WHERE job_api_url = "'.$api_url.'" and expire_date > "'.$date.'"');

        if (empty($query_result)) {
            $curl = curl_init();

            $header = array(
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: $authorization_key"
            );
            curl_setopt_array($curl, [
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER =>  $header,
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            }
            else {
                $wherecondition=array(
                    'job_api_url'=>$api_url
                );
                global $wpdb;
                $wpdb->delete($wpdb->prefix . 'tbl_cache_jobs_api', $wherecondition);
                $data =array(
                    'expire_date' => date("Y-m-d H:i:s", strtotime('+4 hours', strtotime($date))),
                    'job_api_url'    => $api_url,
                    'job_api_response' => $response,
                    'created_date' => $date
                );
                $wpdb->insert($wpdb->prefix . 'tbl_cache_jobs_api', $data);
                $result = json_decode($response);
            }
        }
        else {
            $json = $query_result[0]->job_api_response;
            $result = json_decode($json);
        }

        echo '<div class="job-listing"><div class="flex-container">';
        $noresult = false;
        if (!empty($result)) {
            $results = $result->results;
            if($results){
                foreach($results as $value){
                    $title = $value->atsData->postingTitle;
                    if (!$title) continue;
                    $description = $value->atsData->description;
                    $positionId = $value->positionId;
                    $postingUrl = $job_link_url.'?pid='.$positionId;
                    if ($job_list_domain) {
                      $postingUrl .= "&domain=".$job_list_domain;
                    }
                    $url = $postingUrl;
                    $location = $value->atsData->location[0];

                    $description_div = $this->modify_description($description, $url, $show_description, $length);

                    $content = '<div class="jobs-list">
                    <div class="left-column">
                        <div class="job-title"><a href="'.$url.'">'.$title.'</a></div>
                        <div class="job-location">Location: '.$location.'</div>
                        '.$description_div.'
                    </div>';
                    $content .= '<div class="right-column">
                    <a class="job-button" href="'.$url.'">' . $button_text . ' ' .$button_icon. '</a>
                </div>';
                    $content .= '</div>';
                    echo $content;
                }
            }
            else{
                $noresult = true;
            }

        }
        else{
            $noresult = true;
        }

        if ($noresult) {
            echo '<div>No Jobs</div>';
        }
        echo '</div></div>';

    }

    function modify_description($description, $url, $show_description, $length){

        $description_div = '';
        if($show_description == ''){ return $description_div; }

        $description = strip_tags($description);
        if (strlen($description) > $length) {
            // truncate string
            $stringCut = substr($description, 0, $length);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $description .= '... <span class="read_more"><a href="'.$url.'">Read More</a></span>';
        }

        return '<div class="job-description">'.$description.'</div>';

    }




}
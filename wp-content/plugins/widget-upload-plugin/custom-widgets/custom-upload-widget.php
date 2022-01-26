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
class Custom_elementor_widget extends \Elementor\Widget_Base {

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
    return 'fileuploadwidget';
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
    return __('Upload Resume Widget', 'plugin-name');
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
    return 'iconeightfold icon-eightfoldupload-resume_icon-copy';
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
      'content_section',
      [
        'label' => __('Content', 'resume-upload-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'headertext',
      [
        'label' => __('Header Text', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'default' => __('Upload your resume and see jobs that match your skills and experience', 'plugin-domain'),
        'placeholder' => __('Type header text', 'plugin-domain'),
      ]
    );

    $this->add_control(
      'CTAText',
      [
        'label' => __('CTA Text', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Drop Resume Here', 'plugin-domain'),
        'placeholder' => __('Enter text', 'plugin-domain'),
      ]
    );

    $this->add_control(
      'Selecttext',
      [
        'label' => __('Select Text', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Select File', 'plugin-domain'),
        'placeholder' => __('Enter text', 'plugin-domain'),
      ]
    );

    $this->add_control(
      'iframeheight',
      [
        'label' => __('Iframe Height', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __('225', 'plugin-domain'),
      ]
    );

    $this->add_control(
      'show_header',
      [
        'label' => __('Show Header', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Show', 'your-plugin'),
        'label_off' => __('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'iframe_color',
      [
        'label' => __('Background Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FAFAFA',
        'separator' => 'none',
      ]
    );


    $this->end_controls_section();

    $this->start_controls_section(
      'section_header_style',
      [
        'label' => __('Heading Text', 'resume-upload-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'heading_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
      ]
    );

    $this->add_control(
      'heading_color',
      [
        'label' => __('Heading Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#222222',
        'separator' => 'none',
      ]
    );

    $this->add_control(
      'header_align',
      [
        'label' => __( 'Align', 'resume-upload-widget' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'resume-upload-widget' ),
            'icon' => 'eicon-h-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'resume-upload-widget' ),
            'icon' => 'eicon-h-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'resume-upload-widget' ),
            'icon' => 'eicon-h-align-right',
          ],
          'justify' => [
            'title' => __( 'Stretch', 'resume-upload-widget' ),
            'icon' => 'eicon-h-align-stretch',
          ],
        ],
        'default'=>'center',
      ]
    );

    $this->add_control(
      'hidden_refresh',
      [
        'label' => __( 'View', 'resume-upload-widget' ),
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'refreshiframe',
      ]
    );
    $this->end_controls_section();

    $this->start_controls_section(
      'section_cta_text_style',
      [
        'label' => __('CTA Text', 'resume-upload-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'cta_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
        'selector' => '{{WRAPPER}} .elementor-heading-title',
      ]
    );

    $this->add_control(
      'cta_text_color',
      [
        'label' => __('CTA Text Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#222222',
        'separator' => 'none',
      ]
    );

    $this->add_control(
      'hidden_refresh2',
      [
        'label' => __( 'View', 'resume-upload-widget' ),
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'refreshiframe',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_select_button_style',
      [
        'label' => __('Select Button', 'resume-upload-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'select_button_typography',
        'global' => [
          'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'button_text_shadow',
        'exclude' => [
          'box_shadow_position',
        ],
        'selector' => '{{WRAPPER}} iframe widget',
      ]
    );

    $this->start_controls_tabs('button_item_style');

    $this->start_controls_tab(
      'button_item_normal',
      [
        'label' => __('Normal', 'resume-upload-widget'),
      ]
    );

    $this->add_control(
      'button_text_normal_item',
      [
        'label' => __('Button Text Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FFFFFF'
      ]
    );

    $this->add_control(
      'background_color_normal_item',
      [
        'label' => __('Background Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#61CE70',
        'separator' => 'none',
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'button_item_hover',
      [
        'label' => __('Hover', 'resume-upload-widget'),
      ]
    );

    $this->add_control(
      'button_text_hover_item',
      [
        'label' => __('Button Text Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'none',
      ]
    );

    $this->add_control(
      'background_color_hover_item',
      [
        'label' => __('Background Color', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'none',
        'separator' => 'after',
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'button_border',
        'separator' => 'none',
        'default'=>'none',
        'selector' => '{{WRAPPER}} iframe widget',
      ]
    );

    $this->add_responsive_control(
      'button_border_radius',
      [
        'label' => __('Border Radius', 'resume-upload-widget'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'default' => [
          'top' => '0',
          'bottom' => '0',
          'left' => '0',
          'right' => '0',
          'unit' => 'px',
        ],
        'selector' => '{{WRAPPER}} iframe widget',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'button_box_shadow',
        'exclude' => [
          'box_shadow_position',
        ],
        'selector' => '{{WRAPPER}} iframe widget',
      ]
    );

    $this->add_responsive_control(
      'button_padding',
      [
        'label' => __('Padding', 'resume-upload-widget'),
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
      'hidden_refresh3',
      [
        'label' => __( 'View', 'resume-upload-widget' ),
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

    $show_header = ($settings['show_header'] == 'yes') ? 1 : 0;

    $widget_id = $this->get_id();

    $time = microtime(TRUE);
    $css_file = "/wp-content/uploads/elementor/css/" . $widget_id . "_style.css?q=" . $time;

    $header_align = $settings['header_align'];
    $iframe_color = $settings['iframe_color'];
    $heading_color = $settings['heading_color'];
    $cta_text_color = $settings['cta_text_color'];
    $button_text_color = ($settings['button_text_normal_item']=='')?'':'color:'.$settings['button_text_normal_item'].' !important;';
    $button_background_normal_color = ($settings['background_color_normal_item']=='')?'':'background-color:'.$settings['background_color_normal_item'].' !important;';
    $button_background_hover_color = ($settings['background_color_hover_item']=='')?'':'background-color:'.$settings['background_color_hover_item'].' !important;';
    $button_text_hover_color = ($settings['button_text_hover_item']=='')?'':'color:'.$settings['button_text_hover_item'].' !important;';
    $button_border_type = ($settings['button_border_border']=='')?'':'border-style:'.$settings['button_border_border'].';';
    $button_border_color = ($settings['button_border_color']=='')?'':'border-color:'.$settings['button_border_color'].' !important;';

    $array = ['heading_typography' => '', 'cta_typography' => '', 'select_button_typography' => ''];
    foreach ($array as $key=>$val) {
      foreach ($settings as $k => $v) {
        if (strpos($k, $key) !== false) {
          $font_property = str_replace($key.'_', '', $k );
          if ($font_property == 'typography') {
            continue;
          }
          $font_property = str_replace('_','-',$font_property);
          if (is_array($v)) {
            $size = '';
            if ($v['size'] != '') {
              $size = $v['size'].$v['unit'];
              $array[$key] .= "$font_property:$size !important;";
            }
          }
          else {
            if ($v != '') {
              $array[$key] .= "$font_property:$v !important;";
            }
          }
        }
      }
    }

    $button_border_width = $button_padding = $button_border_width = $button_border_radius = '';
    if ($settings['button_padding'] && $settings['button_padding']['left'] != '') {
      $button_padding = 'padding:' . $settings['button_padding']['top'] . $settings['button_padding']['unit'] . ' ' .
        $settings['button_padding']['right'] . $settings['button_padding']['unit'] . ' ' .
        $settings['button_padding']['bottom'] . $settings['button_padding']['unit'] . ' ' .
        $settings['button_padding']['left'] . $settings['button_padding']['unit'] . ';';
    }

    if ($settings['button_border_width'] && $settings['button_border_width']['left'] != '') {
      $button_border_width = 'border-width:'.$settings['button_border_width']['top'] . $settings['button_border_width']['unit'] . ' ' .
        $settings['button_border_width']['right'] . $settings['button_border_width']['unit'] . ' ' .
        $settings['button_border_width']['bottom'] . $settings['button_border_width']['unit'] . ' ' .
        $settings['button_border_width']['left'] . $settings['button_border_width']['unit'] . ';';
    }

    if ($settings['button_border_radius'] && $settings['button_border_radius']['left'] != '') {
      $button_border_radius = 'border-radius:'.$settings['button_border_radius']['top'] . $settings['button_border_radius']['unit'] . ' ' .
        $settings['button_border_radius']['right'] . $settings['button_border_radius']['unit'] . ' ' .
        $settings['button_border_radius']['bottom'] . $settings['button_border_radius']['unit'] . ' ' .
        $settings['button_border_radius']['left'] . $settings['button_border_radius']['unit'] . ';';
    }

    $box_shadow = ''; $text_shadow = '';
    if ($settings['button_box_shadow_box_shadow_type'] == 'yes') {
      $box_shadow = 'box-shadow:'.$settings['button_box_shadow_box_shadow']['horizontal'] . 'px ' . $settings['button_box_shadow_box_shadow']['vertical'] . 'px ' . $settings['button_box_shadow_box_shadow']['blur'] . 'px ' . $settings['button_box_shadow_box_shadow']['spread'] . 'px ' . $settings['button_box_shadow_box_shadow']['color'] . ';';
    }

    if ($settings['button_text_shadow_box_shadow_type'] == 'yes') {
      $text_shadow = 'box-shadow:'.$settings['button_text_shadow_box_shadow']['horizontal'] . 'px ' . $settings['button_text_shadow_box_shadow']['vertical'] . 'px ' . $settings['button_text_shadow_box_shadow']['blur'] . 'px ' . $settings['button_text_shadow_box_shadow']['spread'] . 'px ' . $settings['button_text_shadow_box_shadow']['color'] . ';';
    }

    $styles = "#eightfold-resume-embed #upload-resume-component h2.upload-resume-title{top:0px;margin-top:5px;position:relative !important;left:0;
    color:".$heading_color.";text-align:".$header_align.";".$array['heading_typography']."}
    #eightfold-resume-embed #upload-resume-component .dropzone{position:relative !important;padding:0px;font-size:2.6em;}
    #page-wrapper{padding:0px;}.dropzone{border:none;background:".$iframe_color.";}
    .dropzone-content{margin-top:36px;}
    #eightfold-resume-embed #upload-resume-component h3.drop-resume-text{
    margin-top:20px !important;color:".$cta_text_color.";".$array['cta_typography']."}
    #eightfold-resume-embed #upload-resume-component a.browse-button:hover{".$button_background_hover_color.$button_text_hover_color."}
    #eightfold-resume-embed #upload-resume-component a.browse-button{margin-top:24px;
    ".$button_background_normal_color.$button_padding.$button_border_width.$button_border_radius."
    ".$button_text_color.$button_border_type.$button_border_color.$text_shadow.$box_shadow.$array['select_button_typography']."}
    .col-md-5{width:100% !important;}";

    create_css_file($widget_id, $styles);

    echo '<iframe allowtransparency="true" name="efPcsResume" id="efPcsResume"
		src="'.$embed_url.'/careers/resume/embed" title="resume" style="z-index:
		100000000;width :100%;height:' . $settings['iframeheight'] . 'px;"></iframe>
		<script type="text/javascript">
		var resumeEmbedConfig = {
		visibilityConfig : {showHeader : ' . $show_header . '},
		textConfig : {
		headerText : "' . $settings['headertext'] . '",
		ctaText : "' . $settings['CTAText'] . '",
		selectionText : "' . $settings['Selecttext'] . '" },
		cssConfigUrl : encodeURIComponent(window.location.origin + "' . $css_file . '")
		};
		// js snippet for handling configuration options
		!function(){if(resumeEmbedConfig){var
		e=document.getElementById("efPcsResume").src;document.getElementById("efPcsResume").src=e+"?config="+JSON.stringify(resumeEmbedConfig)}}();
		</script>
		';

  }

}
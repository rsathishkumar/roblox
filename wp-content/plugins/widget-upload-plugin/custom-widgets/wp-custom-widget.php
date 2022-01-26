<?php

add_filter( 'wppb_available_addons', 'prefix_custom_addon_include' );
if ( ! function_exists('prefix_custom_addon_include')){
    function prefix_custom_addon_include($addons){
        $addons[] = 'Custom_Addon';
        // Add Other Custom Addon class name in here, at a time.
        return $addons;
    }
}


class Custom_Addon{
    public function get_name(){
        return 'resume-upload';
    }
    public function get_title(){
        return 'Resume Upload';
    }
    public function get_icon() {
        return 'wppb-font-interface';
    }
    public function get_category_name() {
      return 'Addon Category';
    }

    // Textarea Settings Fields
    public function get_settings() {
      $settings = array(
        'headertext' => array(
          'type' => 'textarea',
          'title' => 'Header Text',
          'placeholder' => 'Enter header text',
          'std' => 'Upload your resume and see jobs that match your skills and experience'
        ),
        'ctatext' => array(
          'type' => 'text',
          'title' => 'CTA Text',
          'placeholder' => 'Enter text',
          'std' => 'Drop Resume Here'
        ),
        'selecttext' => array(
          'type' => 'text',
          'title' => 'Select text',
          'placeholder' => 'Enter text',
          'std' => 'Select File'
        ),
        'header_show' => array(
          'type' => 'switch',
          'title' => __('Show Header','wp-pagebuilder'),
          'std' => '1',
          'section' => 'Header Text',
        )
      );
        return $settings;
    }

    public function render($data = null){
        $settings = $data['settings'];
        $show_header = ($settings['header_show'] == 1)?1:0;

        return '<iframe name="efPcsResume" id="efPcsResume"
		src="https://app.eightfold.ai/careers/resume/embed" title="resume" style="z-index:
		100000000;width :100%;height:225px;"></iframe>
		<script type="text/javascript">
		var resumeEmbedConfig = {
		visibilityConfig : {showHeader : '.$show_header.'},
		textConfig : {
		headerText : "'.$settings['headertext'].'",
		ctaText : "'.$settings['ctatext'].'",
		selectionText : "'.$settings['selecttext'].'" },
		cssConfigUrl : encodeURIComponent(window.location.origin + "/embed/css/config.css")
		};
		// js snippet for handling configuration options
		!function(){if(resumeEmbedConfig){var
		e=document.getElementById("efPcsResume").src;document.getElementById("efPcsResume").src=e+"?config="+JSON.stringify(resumeEmbedConfig)}}();
		</script>';
    }

}
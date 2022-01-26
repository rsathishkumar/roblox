<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file: 
 * 
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * Example: 
 */

?>
<div class="fl-example-text">
  <iframe name="efPcsResume" id="efPcsResume"
          src="https://app.eightfold.ai/careers/resume/embed" title="resume" style="z-index:
		100000000;width :100%;height:225px;"></iframe>
  <script type="text/javascript">
    var resumeEmbedConfig = {
      visibilityConfig : {showHeader : <?php echo ($settings->show_header?$settings->show_header:0); ?>},
      textConfig : {
        headerText : "<?php echo $settings->textarea_field; ?>",
        ctaText : "<?php echo $settings->ctatext; ?>",
        selectionText : "<?php echo $settings->selectiontext; ?>" },
      cssConfigUrl : encodeURIComponent(window.location.origin + "/embed/css/config.css")
    };
    // js snippet for handling configuration options
    !function(){if(resumeEmbedConfig){var
      e=document.getElementById("efPcsResume").src;document.getElementById("efPcsResume").src=e+"?config="+JSON.stringify(resumeEmbedConfig)}}();
  </script>
</div>
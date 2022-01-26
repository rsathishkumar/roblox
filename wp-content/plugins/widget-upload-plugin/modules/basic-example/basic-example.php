<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLBasicExampleModule
 */
class CustomFileUploadWidgetModule extends FLBuilderModule {

    /** 
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Basic Example', 'fl-builder'),
            'description'   => __('An basic example for coding new modules.', 'fl-builder'),
            'category'		=> __('Example Modules', 'fl-builder'),
            'dir'           => FL_MODULE_DIR . 'modules/basic-example/',
            'url'           => FL_MODULE_URL . 'modules/basic-example/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('CustomFileUploadWidgetModule', array(
  'general'       => array( // Tab
    'title'         => __('General', 'fl-builder'), // Tab title
    'sections'      => array( // Tab Sections
      'general'       => array( // Section
        'title'         => __('General', 'fl-builder'), // Section Title
        'fields'        => array( // Section Fields
          'ctatext'     => array(
            'type'          => 'text',
            'label'         => __('CTAtext', 'fl-builder'),
            'default'       => '',
            'maxlength'     => '200',
            'placeholder'   => 'Drag and drop files',
            'help'          => 'Header text to be displayed on top of the widget.'
          ),
          'textarea_field' => array(
            'type'          => 'textarea',
            'label'         => __('Header text', 'fl-builder'),
            'default'       => '',
            'placeholder'   => __('Upload file', 'fl-builder'),
            'rows'          => '6'
          ),
          'selectiontext'     => array(
            'type'          => 'text',
            'label'         => __('Selection text', 'fl-builder'),
            'default'       => '',
            'maxlength'     => '200',
            'placeholder'   => 'Upload files',
            'help'          => 'Text displayed below button.'
          ),
          'show_header' => array(
            'type'          => 'my-custom-field',
            'label'         => __('Show Header', 'fl-builder'),
            'default'       => "1"
          ),
        )
      )
    )
  )
));
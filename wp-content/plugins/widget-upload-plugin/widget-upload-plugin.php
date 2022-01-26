<?php
/*
Plugin Name: Custom upload file widget plugin
Plugin URI: 
Description: Upload files.
Version: 1.0
Author: 
Author URI: 
License: GPL2
*/

define( 'FL_MODULE_DIR', plugin_dir_path( __FILE__ ) );
define( 'FL_MODULE_URL', plugins_url( '/', __FILE__ ) );
define('CUSTOM_WIDGET_URL', plugins_url('/', __FILE__ ) );


/**
 * Class Custom_elementor_Extension
 *
 * initialize all custom widgets
 *
 */
final class Custom_elementor_Extension {

  private static $_instance = null;


  public static function instance() {

    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;

  }


  public function __construct() {

    add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

  }

  public function init() {

    // Add Plugin actions
    // add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
  }

  public function init_widgets() {

    // Include Widget files
    require_once( __DIR__ . '/custom-widgets/custom-upload-widget.php' );
    require_once( __DIR__ . '/custom-widgets/custom-search-widget.php' );
    require_once( __DIR__ . '/custom-widgets/custom-menu-widget.php' );
    require_once( __DIR__ . '/custom-widgets/custom-map-widget.php' );
    require_once( __DIR__ . '/custom-widgets/custom-chat-widget.php' );
    require_once( __DIR__ . '/forms/widgets/form.php' );
    require_once( __DIR__ . '/custom-widgets/custom-slides.php' );
    require_once( __DIR__ . '/custom-widgets/custom-translate-widget.php' );
    require_once( __DIR__ . '/custom-widgets/custom-search-widget-api.php' );
    require_once( __DIR__ . '/custom-widgets/custom-job-list.php' );
	
    // Register widget
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_elementor_widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_elementor_search_widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_elementor_menu_widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_elementor_map_widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_elementor_chat_widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Ef_Form() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \CustomSlides() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_translate_menu_widget() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_search_widget_api() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Custom_job_list_widget() );

  }

}

/**
 * Init Custom_elementor_Extension class and add menu css to the header
 *
 */
function custom_load_module() {

  wp_enqueue_style(
    'custommenu-style2',
    plugins_url('css/sm-simple.css', __FILE__),
    array()
  );

  Custom_elementor_Extension::instance();
}
add_action( 'init', 'custom_load_module' );

/**
 * Load elementor css
 *
 */
function custom_admin_css_for_widgets() {
  wp_enqueue_style( 'eightfold_admin_resource', CUSTOM_WIDGET_URL.'css/editor-admin.css', array(), '1.0.0', 'all');
}
add_action( 'elementor/editor/before_enqueue_scripts', 'custom_admin_css_for_widgets' );

/**
 * Hook function to create Custom category on the Elementor sidebar
 * @param $elements_manager
 */
function add_elementor_widget_categories( $elements_manager ) {

  $elements_manager->add_category(
    'eightfold-category',
    [
      'title' => __( 'Eightfold', 'plugin-name' ),
      'icon' => 'fa fa-plug',
    ]
  );

}

add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
add_action( 'wp_print_scripts', 'drw_timelinr_dequeue' );

/**
 * Hook function to override our modified elementor-editor js file
 *
 */
function drw_timelinr_dequeue () {

  // Dequeue and deregister elementor-editor-modules
  wp_dequeue_script( 'elementor-editor-modules' );
  wp_deregister_script( 'elementor-editor-modules' );
  wp_enqueue_script('elementor-editor-modules', CUSTOM_WIDGET_URL.'js/editor-modules.min.js', array('elementor-common-modules'), '1.9.7', true);

  // Dequeue and deregister elementor-pro-frontend-js
  wp_dequeue_script( 'elementor-pro-frontend' );
  wp_deregister_script( 'elementor-pro-frontend' );
  wp_enqueue_script('elementor-pro-frontend', CUSTOM_WIDGET_URL.'js/frontend.min.js', array('elementor-frontend-modules', 'elementor-sticky'), '3.0.4', true);

  // Dequeue and deregister elementor-editor
  wp_deregister_script( 'elementor-editor' );
  wp_dequeue_script( 'elementor-editor' );

  // Re-register elementor-frontend without the elementor-dialog dependency.
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  wp_register_script(
    'elementor-editor',
    CUSTOM_WIDGET_URL . 'js/editor'.$suffix.'.js',
    [
      'elementor-common',
      'elementor-editor-modules',
      'elementor-editor-document',
      'wp-auth-check',
      'jquery-ui-sortable',
      'jquery-ui-resizable',
      'perfect-scrollbar',
      'nprogress',
      'tipsy',
      'imagesloaded',
      'heartbeat',
      'jquery-elementor-select2',
      'flatpickr',
      'ace',
      'ace-language-tools',
      'jquery-hover-intent',
      'nouislider',
      'pickr',
      'react',
      'react-dom',
    ],
    ELEMENTOR_VERSION,
    true
  );

  wp_enqueue_script( 'custom-script', plugins_url( '/js/iframejsrender.js', __FILE__ ), ['elementor-editor'],false, true );

}

/**
 * Hook function to modify CURL request send by the EF Form widget
 *
 */
add_action( 'elementor_pro/forms/webhooks/request_args', function( $args, $record ) {
  $hooks = new Requests_Hooks();
  $hooks->register('requests.before_request', 'webhook_before_request');

  $body = $record->get( 'form_settings' );
  $webhook = $body['webhooks'];

  if ($webhook == 'https://api.eightfold.ai/v1/candidate/talent-pool') {

    foreach ($args['body']['fields'] as $key=>$val) {
      if ($key == 'urls') {
        $args['body']['fields'][$key]['raw_value'] = $args['body']['fields'][$key]['value'];
        $args['body']['fields'][$key]['value'] = $args['body']['fields'][$key]['raw_value'];
      }
    }
    foreach ($args['body']['fields'] as $key=>$val) {
      if ($key == 'resume' && $val != '') {
        $args['stream'] = true;
        $args['filename'] = $args['body']['fields']['resume']['raw_value'];
        $args[$key] = $args['filename'];
      }
      else {
        $args[$key] = $val['value'];
      }

    }

    $headers = array(
      'Authorization' => 'Basic sihqwwsafdeeatqrmvdtrjccfmzhcntc'
    );

    $args['headers'] = $headers;


  }
  return $args;

}, 10, 3 );

/**
 * Hook function to initialize Classes to add global settings for Eightfold
 *
 */
add_action( 'elementor_pro/init', function(){
  include_once( FL_MODULE_DIR.'/custom-widgets/custom-file-upload-field.php' );
  include_once( FL_MODULE_DIR.'/custom-widgets/custom-password.php' );
  include_once( FL_MODULE_DIR.'/custom-widgets/custom-address.php' );
  include_once( FL_MODULE_DIR.'/settings/manager.php' );
  include_once( FL_MODULE_DIR.'/settings/model.php' );

  // form Action class
  include_once( FL_MODULE_DIR.'/forms/actions/eightfold_webhook.php' );
  $webhook = new EightfoldWebhook();
  \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $webhook->get_name(), $webhook );

  include_once( FL_MODULE_DIR.'/forms/actions/account_provisioning_webhook.php' );
  $webhook = new AccountProvisioningWebhook();
  \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $webhook->get_name(), $webhook );

  new CustomUpload();
  new CustomPassword();
  new GoogleAddressField();
  $custom_manager = new \CustomWidget\Settings\Manager();
  \Elementor\Core\Settings\Manager::add_settings_manager($custom_manager);
} );


add_action('wp_ajax_locationList', 'locationList_function');
add_action( 'wp_ajax_nopriv_locationList', 'locationList_function' );

/**
 * Ajax request to send curl request for location search
 * prints locations list
 */
function locationList_function(){
  $data = $_REQUEST['data'];
  $domain = $_REQUEST['domain'];

  $global_settings = get_option( 'elementor_custom_settings' );
  $embed_url = 'https://app.eightfold.ai';
  if ($global_settings) {
    $embed_url = $global_settings['iframeURL'];
  }

  $cURLConnection = curl_init();

  curl_setopt($cURLConnection, CURLOPT_URL, $embed_url . '/api/suggest?term='.$data.'&dictionary=location&domain='.$domain);
  curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

  $location_list = curl_exec($cURLConnection);
  curl_close($cURLConnection);

  echo $location_list;
  exit();
}

/**
 * Hook function to move the header template css to the <head> section
 * so the css wont break
 *
 */
add_action( 'wp_enqueue_scripts', function() {
  if ( ! class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
    return;
  }

  $header_page_id = get_meta_values('add_css_file_header','elementor_library');
  foreach ($header_page_id as $k => $v) {
    $css_file = new \Elementor\Core\Files\CSS\Post($v);
    $css_file->enqueue();
  }

  $options = get_option( 'elementor_custom_settings' );

  $scriptData = array(
    'iframeURL' => $options['iframeURL'],
  );

  wp_localize_script('search-widget', '_options', $scriptData);

}, 500 );


/* Below hook functions to create option in the header template post */
/* wheather the css should be added to the header */

/* Define the custom box */
add_action( 'add_meta_boxes', 'custom_eightfold_add_custom_box' );
/* Do something with the data entered */
add_action( 'save_post', 'custom_eightfold_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function custom_eightfold_add_custom_box() {
  add_meta_box(
    'custom_eightfold_sectionid',
    'CSS File',
    'custom_eightfold_inner_custom_box',
    'elementor_library',
    'side',
    'high'
  );
}

/* Prints the box content */
function custom_eightfold_inner_custom_box($post)
{
  // Use nonce for verification
  wp_nonce_field( 'custom_eightfold_header_cssfile_field_nonce', 'header_cssfile_field_nonce' );

  // Get saved value, if none exists, "default" is selected
  $saved = get_post_meta( $post->ID, 'add_css_file_header', true);
  if( !$saved )
    $saved = 'default';

  $fields = array(
    'yes'       => __('Add CSS to the header section', 'custom_eightfold'),
  );

  foreach($fields as $key => $label)
  {
    printf(
      '<input type="checkbox" name="add_css_file_header" value="%1$s" id="add_css_file_header[%1$s]" %3$s />'.
      '<label for="add_css_file_header[%1$s]"> %2$s ' .
      '</label><br>',
      esc_attr($key),
      esc_html($label),
      checked($saved, $key, false)
    );
  }
}

/* When the post is saved, saves our custom data */
function custom_eightfold_save_postdata( $post_id )
{
  // verify if this is an auto save routine.
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( !wp_verify_nonce( $_POST['header_cssfile_field_nonce'], 'custom_eightfold_header_cssfile_field_nonce' ) )
    return;

  if ( isset($_POST['add_css_file_header']) && $_POST['add_css_file_header'] != "" ){
    update_post_meta( $post_id, 'add_css_file_header', $_POST['add_css_file_header'] );
  }
  else {
    update_post_meta( $post_id, 'add_css_file_header', '' );
  }
}

/**
 * Custom function to get list of posts where the given key value is true
 *
 * @param $key: post meta key
 *
 * @return array of post id
 */
function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

  global $wpdb;

  if( empty( $key ) )
    return;

  $r = $wpdb->get_col( $wpdb->prepare( "SELECT p.ID FROM
    {$wpdb->postmeta} pm LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = %s AND p.post_status = %s AND pm.meta_value = 'yes'
    AND p.post_type = %s", $key, $status, $type )
  );

  return $r;
}

/**
 * Custom function to create dynamic css file with the widget options to send
 * with embed URL
 */
function create_css_file($widget_id, $styles) {

  $upload_dir = wp_upload_dir();

  $file = $upload_dir['basedir']."/elementor/css/".$widget_id."_style.css";

  if (file_exists($file)) {
    $fh = fopen($file, 'w');
    fwrite($fh, $styles."\n");
  } else {
    $fh = fopen($file, 'w');
    fwrite($fh, $styles."\n");
  }
  fclose($fh);

}

add_action( 'http_api_curl', 'webhook_before_request', 10, 3 );


function webhook_before_request($parameters, $request, $url) {
  if ($url) {
    return;
  }

}

// Validate the Organization name field
add_action( 'elementor_pro/forms/validation/text', function ( $field, $record, $ajax_handler ) {

    if ( $field['id'] == 'organization_name' ) {
      if(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $field['value'])){
        $ajax_handler->add_error( $field['id'], 'Cannot include special characters in company name.' );
      }
    }
}, 10, 3 );

function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
}
add_action('init','add_cors_http_header');

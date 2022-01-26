<?php

use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class AccountProvisioningWebhook extends Action_Base {

	public function get_name() {
		return 'account_provisioning_webhook';
	}

	public function get_label() {
		return __( 'Account Provisioning Webhook', 'elementor-pro' );
	}

	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_account_provisioning_webhook',
			[
				'label' => __( 'Account Provisioning Webhook', 'elementor-pro' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
          'account_provisioning_webhook_url',
          [
            'label' => __( 'Webhook URL', 'elementor-pro' ),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __( 'https://your-webhook-url.com', 'elementor-pro' ),
            'label_block' => true,
            'separator' => 'before',
            'description' => __( 'Enter the integration URL (like Zapier) that will receive the form\'s submitted data.', 'elementor-pro' ),
            'render_type' => 'none',
          ]
		);

        $widget->add_control(
          'account_provisioning_authorize_key',
          [
            'label' => __( 'Webhook Authorize Key', 'elementor-pro' ),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __( 'Basic sihqwwsafdeeatqrmvdtrjccfmzhcntc', 'elementor-pro' ),
            'separator' => 'before',
            'description' => __( 'Enter the Authorization key to add it to the header.', 'elementor-pro' ),
            'render_type' => 'none',
          ]
        );

        $widget->add_control(
          'account_provisioning_content_type_header',
          [
            'label' => __( 'Webhook Content type', 'elementor-pro' ),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __( 'multipart/form-data', 'elementor-pro' ),
            'separator' => 'before',
            'description' => __( 'Enter the Content type to add it to the header.', 'elementor-pro' ),
            'render_type' => 'none',
          ]
        );

        $widget->add_control(
          'account_provisioning_webhook_advanced_data',
          [
            'label' => __( 'Advanced Data', 'elementor-pro' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
            'render_type' => 'none',
          ]
		);

		$widget->end_controls_section();
	}

	public function on_export( $element ) {}

	public function run( $record, $ajax_handler ) {
      $settings = $record->get( 'form_settings' );

      if ( empty( $settings['account_provisioning_webhook_url'] ) ) {
          return;
      }

      if ( isset( $settings['account_provisioning_webhook_advanced_data'] ) && 'yes' === $settings['account_provisioning_webhook_advanced_data'] ) {
          $body['form'] = [
              'id' => $settings['id'],
              'name' => $settings['form_name'],
          ];

          $body['fields'] = $record->get( 'fields' );
          $body['meta'] = $record->get( 'meta' );
      } else {
          $body = $record->get_formatted_data( true );
          $body['form_id'] = $settings['id'];
          $body['form_name'] = $settings['form_name'];
      }

      $post_array = [];
      $skip_fields = ['step', 'html', 'hr'];
      foreach($body['fields'] as $key=>$val) {
        if (in_array($body['fields'][$key]['type'],$skip_fields)) {
          continue;
        }
        $post_array[$key] = $body['fields'][$key]['value'];
        if ($key == 'resume') {
          $finfo = new finfo();
          $info = pathinfo($body['fields'][$key]['value']);
          $application_type = $finfo->file($body['fields'][$key]['raw_value'], FILEINFO_MIME);
          $post_array[$key] = new CURLFile($body['fields'][$key]['raw_value'], $application_type, $info['basename']);
        }
        if ($body['fields'][$key]['type'] == 'google_address_field') {
          $address = $_POST['form_fields'];
        //  $post_array['address_line1'] = $address['address_line1'];
          $post_array['state'] = $address['state'];
          $post_array['city'] = $address['city'];
          $post_array['country'] = $address['country'];
        }
      }

      if ($settings['account_provisioning_content_type_header'] == 'application/json') {
        $args = [
          'data' => $post_array,
        ];
        $post_array = json_encode($args);
      }

      $headers = array (
        'Content-Type:'.$settings['account_provisioning_content_type_header'],
      );

      if (!empty($settings['account_provisioning_authorize_key'])) {
        $headers[] = 'Authorization:'.$settings['account_provisioning_authorize_key'];
      }

      $result = [];

      try {

        $ch = curl_init();
        if ($ch === false) {
          throw new Exception('failed to initialize');
        }
        curl_setopt($ch, CURLOPT_URL,$settings['account_provisioning_webhook_url']);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result=curl_exec ($ch);
        curl_close ($ch);
      } catch(Exception $e) {
        $ajax_handler->add_admin_error_message( $e->getMessage() );
      }

      if ($result) {
        $results = json_decode($result);
        if (empty($results)) {
          $ajax_handler->add_error_message( 'Something went wrong, Try submitting again.' );
        }
        else if ($results->status != 200) {
        //  $ajax_handler->add_response_data('success', $results->data->successMsg);
          $error_message = $results->error->errorMsg;
          if ($results->error->errorMsg) {
            $error = strpos($results->error->errorMsg, "account already exists");
            if ($error !== false) {
              $error_message = "Company by this name already exists on the platform";
            }
          }
          $ajax_handler->add_error_message($error_message);
        }
      }
      else {
        $ajax_handler->add_error_message( 'Something went wrong, Try submitting again.' );
      }

	}
}

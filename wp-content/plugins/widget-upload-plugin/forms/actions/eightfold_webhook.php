<?php

use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class EightfoldWebhook extends Action_Base {

	public function get_name() {
		return 'job_posting_webhook';
	}

	public function get_label() {
		return __( 'Job Posting Webhook', 'elementor-pro' );
	}

	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_job_posting_webhook',
			[
				'label' => __( 'Job Posting Webhook', 'elementor-pro' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
          'job_posting_webhook_url',
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
          'job_posting_authorize_key',
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
          'job_posting_webhook_advanced_data',
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

      if ( empty( $settings['job_posting_webhook_url'] ) ) {
          return;
      }

      if ( isset( $settings['job_posting_webhook_advanced_data'] ) && 'yes' === $settings['job_posting_webhook_advanced_data'] ) {
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

      $args = [
          'body' => $body,
      ];

      $post_array = [];
      foreach($body['fields'] as $key=>$val) {
        $post_array[$key] = $body['fields'][$key]['value'];
        if ($key == 'resume') {
          $finfo = new finfo();
          $info = pathinfo($body['fields'][$key]['value']);
          $application_type = $finfo->file($body['fields'][$key]['raw_value'], FILEINFO_MIME);
          $post_array[$key] = new CURLFile($body['fields'][$key]['raw_value'], $application_type, $info['basename']);
        }
      }

      $headers = array (
        'Content-Type:multipart/form-data'
      );

      if (!empty($settings['job_posting_authorize_key'])) {
        $headers[] = 'Authorization:'.$settings['job_posting_authorize_key'];
      }

      $result = [];

      try {

        $ch = curl_init();
        if ($ch === false) {
          throw new Exception('failed to initialize');
        }
        curl_setopt($ch, CURLOPT_URL,$settings['job_posting_webhook_url']);
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
        $ajax_handler->add_response_data('success', $results->message . ' Profile ID: '.$results->profileEncId);
      }
      else {
        $ajax_handler->add_admin_error_message( 'Webhook Error' );
      }

	}
}

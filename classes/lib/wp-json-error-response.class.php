<?php

if(class_exists('WP_JSON_Response')):

class WP_JSON_Error_Response extends WP_JSON_Response {
	/**
	 * Constructor
	 *
	 * @param mixed $data Response data
	 * @param integer $status HTTP status code
	 * @param array $headers HTTP header map
	 */
	public function __construct( $wp_error) {

		if($wp_error instanceof WP_Error === false){
			$data = $wp_error;
			parent::__construct($data);
			return;
		}

		$data = array();
		$data['code'] = $wp_error->get_error_code();
		$data['error'] = $wp_error->get_error_message();

		$error_data = $wp_error->get_error_data($data['code']);
		$status = isset($error_data['status']) ? $error_data['status'] : 400;

		parent::__construct($data, $status);
	}

}

function  json_ensure_error_response($wp_error){
	if($wp_error instanceof WP_Error === false)
		return $wp_error;

	return new WP_JSON_Error_Response($wp_error);
}

endif;

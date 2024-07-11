<?php

namespace Palasthotel\WordPress\Headless\Extensions;

use WP_Post;
use WP_REST_Request;
use WP_REST_Response;

class Title extends AbsPostExtensionPost {

	function response( WP_REST_Response $response, WP_Post $post, WP_REST_Request $request ): WP_REST_Response {
		$data = $response->get_data();
		$data["title"]["rendered"] = html_entity_decode($data["title"]["rendered"]);
		$response->set_data( $data );
		return $response;
	}
}
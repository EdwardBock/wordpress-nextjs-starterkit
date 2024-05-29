<?php

namespace Palasthotel\WordPress\Headless\Interfaces;

use WP_REST_Request;
use WP_REST_Response;

interface ITermRouteExtension {

	/**
	 * @return string[]
	 */
	function taxonomies(): array;

	function response( WP_REST_Response $response, \WP_Term $comment, WP_REST_Request $request): WP_REST_Response;
}

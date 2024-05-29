<?php

namespace Palasthotel\WordPress\Headless\Interfaces;

use WP_Post;
use WP_REST_Request;
use WP_REST_Response;

interface IPostRouteExtension {
	function response( WP_REST_Response $response, WP_Post $post, WP_REST_Request $request): WP_REST_Response;
}
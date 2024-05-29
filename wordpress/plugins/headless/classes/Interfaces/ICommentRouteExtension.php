<?php

namespace Palasthotel\WordPress\Headless\Interfaces;

use WP_REST_Request;
use WP_REST_Response;

interface ICommentRouteExtension {
	function response( WP_REST_Response $response, \WP_Comment $comment, WP_REST_Request $request): WP_REST_Response;
}
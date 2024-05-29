<?php

namespace Palasthotel\WordPress\Headless\Extensions;

use Palasthotel\WordPress\Headless\Interfaces\ICommentRouteExtension;
use WP_REST_Request;
use WP_REST_Response;

class CommentAuthorUser implements ICommentRouteExtension {

	function response( WP_REST_Response $response, \WP_Comment $comment, WP_REST_Request $request ): WP_REST_Response {
		$data = $response->get_data();
		$user = get_user_by("ID",$comment->user_id);

		if($user instanceof \WP_User){
			$data["author_user"]= [
				"display_name" => $user->display_name,
				"nickname" => $user->nickname,
			];
		}  else {
			$data["author_user"] = null;
		}

		$response->set_data($data);

		return $response;
	}
}
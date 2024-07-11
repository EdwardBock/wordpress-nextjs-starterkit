<?php

namespace Palasthotel\WordPress\Headless;

class Headers extends Components\Component {
	public function onCreate() {
		parent::onCreate();
		add_filter('rest_post_dispatch', [$this, 'rest_post_dispatch']);
	}

	public function rest_post_dispatch(\WP_REST_Response $response){
		if($this->plugin->security->isHeadlessRequest()){
			$headers = $response->get_headers();
			// use cache while we are revalidating in the background
			$headers["Cache-Control"] = "max-age=300, public, stale-while-revalidate=604800";
			$headers = apply_filters(Plugin::FILTER_REST_RESPONSE_HEADERS, $headers, $headers);
			$response->set_headers($headers);
		}
		return $response;
	}
}

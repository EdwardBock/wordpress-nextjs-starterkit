<?php

namespace Palasthotel\WordPress\Headless\Routes;

use Palasthotel\WordPress\Headless\Components\Component;
use Palasthotel\WordPress\Headless\Plugin;

class Settings extends Component {

	public function init(){
		register_rest_route( Plugin::REST_NAMESPACE, '/settings', array(
			'methods'             => \WP_REST_Server::READABLE,
			'callback'            => [ $this, 'get_settings' ],
			'permission_callback' => function(){
				return $this->plugin->security->isHeadlessRequest() &&
				       $this->plugin->security->hasApiKeyAccess();
			},
		) );
	}

	public function get_settings() {
		return [
			"front_page" => get_option( 'show_on_front' ),
			"page_on_front" => get_option( 'page_on_front' ),
			"home_url" => home_url(),
		];
	}
}
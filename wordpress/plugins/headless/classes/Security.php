<?php

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Components\Component;

class Security extends Component {

	public function onCreate() {
		parent::onCreate();
		add_filter('wp_is_application_passwords_available', '__return_true');
	}

	public function isHeadlessRequest(): bool {
		return isset( $_GET[ HEADLESS_REST_PARAM ] ) && HEADLESS_REST_VALUE == $_GET[ HEADLESS_REST_PARAM ];
	}

	public function isHeadlessRequestVariant(string $variant): bool {
		return isset( $_GET[ HEADLESS_REST_VARIANT_PARAM ] ) && $variant == $_GET[ HEADLESS_REST_VARIANT_PARAM ];
	}

	public function hasApiKeyAccess(): bool {

		if ( empty(HEADLESS_API_KEY_HEADER_KEY) || empty(HEADLESS_API_KEY_HEADER_VALUE)) {
			// if api key values are empty there is no api key restriction
			return true;
		}

		$header =  "HTTP_" . strtoupper( str_replace("-", "_",HEADLESS_API_KEY_HEADER_KEY ));
		if ( ! isset( $_SERVER[ $header ] ) ) {
			// on missing header in request deny access
			return false;
		}
		return $_SERVER[$header] === HEADLESS_API_KEY_HEADER_VALUE;
	}

}

<?php

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Components\Component;
use Palasthotel\WordPress\Headless\Model\Frontend;

class Headquarter extends Component {

	/**
	 * @return Frontend[]
	 */
	public function getFrontends(): array {
		$baseUrl = trailingslashit(
			empty( HEADLESS_HEAD_BASE_URL ) ? home_url() : HEADLESS_HEAD_BASE_URL
		);

		return apply_filters( Plugin::FILTER_FRONTENDS, [
			new Frontend( $baseUrl )
		], $baseUrl );
	}


}

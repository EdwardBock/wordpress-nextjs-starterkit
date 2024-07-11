<?php

namespace Palasthotel\WordPress\Headless\Extensions;

use Palasthotel\WordPress\Headless\Interfaces\IPostRouteExtension;
use Palasthotel\WordPress\Headless\Plugin;

abstract class AbsPostExtensionPost implements IPostRouteExtension {

	public function __construct() {
		add_filter(Plugin::ACTION_REGISTER_POST_ROUTE_EXTENSIONS, [$this, 'register']);
	}

	/**
	 * @param IPostRouteExtension[] $extensions
	 *
	 * @return IPostRouteExtension[]
	 */
	public function register(array $extensions){
		$extensions[] = $this;
		return $extensions;
	}
}
<?php

namespace Palasthotel\WordPress\Headless\Model;

use Palasthotel\WordPress\Headless\Interfaces\IUserRouteExtension;

class UserRouteExtensions {

	/**
	 * @var IUserRouteExtension[]
	 */
	private array $items = [];

	public function add( IUserRouteExtension $extension ) {
		$this->items[] = $extension;
	}

	public function get(){
		return $this->items;
	}


}

<?php

namespace Palasthotel\WordPress\Headless\Model;

use Palasthotel\WordPress\Headless\Interfaces\ITermRouteExtension;

class TermRouteExtensions {

	/**
	 * @var ITermRouteExtension[]
	 */
	private array $items = [];

	public function add( ITermRouteExtension $extension ) {
		$this->items[] = $extension;
	}

	public function get(){
		return $this->items;
	}


}

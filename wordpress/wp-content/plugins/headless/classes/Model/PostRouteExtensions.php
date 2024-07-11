<?php

namespace Palasthotel\WordPress\Headless\Model;

use Palasthotel\WordPress\Headless\Interfaces\IPostRouteExtension;

class PostRouteExtensions {

	/**
	 * @var IPostRouteExtension[] $postRouteExtensions
	 */
	private array $items = [];

	public function add( IPostRouteExtension $extension ) {
		$this->items[] = $extension;
	}

	public function get(){
		return $this->items;
	}


}
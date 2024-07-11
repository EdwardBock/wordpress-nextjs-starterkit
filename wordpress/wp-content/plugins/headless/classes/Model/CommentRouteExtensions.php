<?php

namespace Palasthotel\WordPress\Headless\Model;

use Palasthotel\WordPress\Headless\Interfaces\ICommentRouteExtension;

class CommentRouteExtensions {

	/**
	 * @var ICommentRouteExtension[]
	 */
	private array $items = [];

	public function add( ICommentRouteExtension $extension ) {
		$this->items[] = $extension;
	}

	public function get(){
		return $this->items;
	}


}

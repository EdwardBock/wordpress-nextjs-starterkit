<?php

namespace Palasthotel\WordPress\Headless\Model;

use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;

class BlockPreparations {

	/**
	 * @var IBlockPreparation[]
	 */
	private array $items = [];

	public function add( IBlockPreparation $extension ) {
		$this->items[] = $extension;
	}

	public function get(){
		return $this->items;
	}

}
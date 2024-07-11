<?php

namespace Palasthotel\WordPress\Headless\BlockPreparations;

use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;
use Palasthotel\WordPress\Headless\Model\BlockName;

class MoreBlockPreparation implements IBlockPreparation {

	function blockName(): BlockName {
		return new BlockName("core", "more");
	}

	function prepare( array $block ): array {
		return [
			"blockName" => $block["blockName"],
		];
	}
}
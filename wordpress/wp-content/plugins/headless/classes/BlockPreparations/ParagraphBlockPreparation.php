<?php

namespace Palasthotel\WordPress\Headless\BlockPreparations;

use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;
use Palasthotel\WordPress\Headless\Model\BlockName;

class ParagraphBlockPreparation implements IBlockPreparation {

	function blockName(): ?BlockName {
		return new BlockName("core", "paragraph");
	}

	function prepare( array $block ): array {

		unset($block["innerContent"]);

		return $block;
	}
}
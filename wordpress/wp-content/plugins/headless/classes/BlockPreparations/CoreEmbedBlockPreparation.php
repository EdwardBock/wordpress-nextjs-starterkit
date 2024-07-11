<?php

namespace Palasthotel\WordPress\Headless\BlockPreparations;

use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;
use Palasthotel\WordPress\Headless\Model\BlockName;

class CoreEmbedBlockPreparation implements IBlockPreparation {

	function blockName(): ?BlockName {
		return new BlockName("core-embed", "wordpress");
	}

	function prepare( array $block ): array {

		$block["blockName"] = "core/embed";

		return $block;
	}
}
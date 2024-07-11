<?php

namespace Palasthotel\WordPress\Headless\BlockPreparations;

use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;
use Palasthotel\WordPress\Headless\Model\BlockName;

class FreeFormBlockPreparation implements IBlockPreparation {

	function blockName(): ?BlockName {
		return null;
	}

	function prepare( array $block ): array {

		if ( ! empty( $block["innerHTML"] ) && is_string( $block["innerHTML"] ) ) {
			$block["innerHTML"] = do_shortcode( $block["innerHTML"] );
		}

		unset($block["innerContent"]);

		return $block;
	}
}
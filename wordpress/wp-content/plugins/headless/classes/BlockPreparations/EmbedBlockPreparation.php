<?php

namespace Palasthotel\WordPress\Headless\BlockPreparations;

use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;
use Palasthotel\WordPress\Headless\Model\BlockName;

class EmbedBlockPreparation implements IBlockPreparation {

	function blockName(): ?BlockName {
		return new BlockName("core", "embed");
	}

	function prepare( array $block ): array {

		if ( ! empty( $block["attrs"] ) && !empty($block["attrs"]["url"]) ) {
			$url = $block["attrs"]["url"];
			$oembed = wp_oembed_get($url);
			$block["attrs"]["isResolved"] = $oembed !== false;
			$block["attrs"]["resolvedHTML"] = $oembed;
		}

		unset($block["innerContent"]);

		return $block;
	}
}
<?php

namespace Palasthotel\WordPress\Headless\Interfaces;

use Palasthotel\WordPress\Headless\Model\BlockName;

interface IBlockPreparation {

	function blockName(): ?BlockName;

	function prepare( array $block ): array;
}
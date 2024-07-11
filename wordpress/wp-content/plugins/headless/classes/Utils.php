<?php

namespace Palasthotel\WordPress\Headless;

class Utils {
	public static function prepareHTML($html){
		return  str_replace( "\n", "", wp_kses(
			$html,
			[
				"a"      => [
					"href" => [],
					"target" => [],
					"rel" => [],
				],
				"b"      => [],
				"i"      => [],
				"strong" => []
			]
		));
	}
}
<?php

namespace Palasthotel\WordPress\Headless\BlockPreparations;

use Palasthotel\WordPress\Headless\Extensions\FeaturedMedia;
use Palasthotel\WordPress\Headless\Interfaces\IBlockPreparation;
use Palasthotel\WordPress\Headless\Model\BlockName;
use Palasthotel\WordPress\Headless\Model\PostContentAttachmentCollector;

class TagCloudPreparation implements IBlockPreparation {

	function blockName(): BlockName {
		return new BlockName("core", "tag-cloud");
	}

	function prepare( array $block ): array {

		if(isset($block["attrs"]) && is_array($block["attrs"])){
			$attrs = $block["attrs"];
			$args = [
				"echo" => false,
				"format" => "array",
				'orderby' => 'count',
				'order'   => 'DESC',
			];
			if(!empty($attrs["taxonomy"])){
				$args["taxonomy"] = $attrs["taxonomy"];
			}
			if(!empty($attrs["numberOfTags"])){
				$args["number"] = $attrs["numberOfTags"];
			}
			$block["attrs"]["tags"] = array_map(function(\WP_Term $term){
				return [
					"term_id" => $term->term_id,
					"name" => $term->name,
					"slug" => $term->slug,
					"description" => $term->description,
					"count" => $term->count,
					"parent" => $term->parent,
				];
			},get_terms($args));
		}

		unset($block["innerBlocks"]);
		unset($block["innerHTML"]);
		unset($block["innerContent"]);

		return $block;
	}

	public static function addAttachmentAttributes($id, $attrs, $innerHTML){
		$attrs["src"] = wp_get_attachment_image_src($id, 'full');

		$attrs["sizes"] = FeaturedMedia::imageSizes($id);

		$attrs["alt"] = get_post_meta($id, '_wp_attachment_image_alt', true);
		$attrs["caption"] = str_replace(
			["\n","\r"],
			'',
			wp_kses($innerHTML, ["br" => [], 'b' => [], 'em' => [], 'i' => [], 'a' => ['href' => [], 'title' => []], 'strong' => []])
		);
		return $attrs;
	}
}
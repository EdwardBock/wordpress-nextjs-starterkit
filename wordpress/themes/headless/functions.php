<?php

add_filter('allowed_block_types_all', function() {
	return true;
	return [
		"core/archives",
		"core/button",
		"core/buttons",
		"core/embed",
		"core/gallery",
		"core/heading",
		"core/image",
		"core/list",
		"core/list-item",
		"core/paragraph",
		"core/pullquote",
		"core/quote",
	];
});
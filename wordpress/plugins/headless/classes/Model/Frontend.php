<?php

namespace Palasthotel\WordPress\Headless\Model;

class Frontend {
	private string $baseUrl;
	public function __construct( string $baseUrl ) {
		$this->baseUrl = $baseUrl;
	}

	public function getBaseUrl(): string {
		return $this->baseUrl;
	}
}

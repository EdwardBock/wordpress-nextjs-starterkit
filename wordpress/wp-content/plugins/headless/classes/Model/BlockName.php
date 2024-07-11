<?php

namespace Palasthotel\WordPress\Headless\Model;

class BlockName {

	private string $namespace;
	private string $id;

	public function __construct(string $namespace, string $id) {
		$this->namespace = $namespace;
		$this->id = $id;
	}

	public static function build(string $namespace, string $id){
		return new static($namespace, $id);
	}

	public function __toString(): string {
		return $this->namespace."/".$this->id;
	}
}
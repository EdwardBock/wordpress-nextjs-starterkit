<?php

namespace Palasthotel\WordPress\Headless\Model;

class PostContentAttachmentCollector {

	public static array $map = [];

	public static function get($postId){
		return static::$map[ $postId ] ?? [];
	}

	public static function add($postId, $attachmentId){
		$attachmentId = intval($attachmentId);
		if(!isset(static::$map[$postId])){
			static::$map[$postId] = [];
		}

		if(!in_array($attachmentId, static::$map[$postId])){
			static::$map[$postId][] = $attachmentId;
		}
	}
}
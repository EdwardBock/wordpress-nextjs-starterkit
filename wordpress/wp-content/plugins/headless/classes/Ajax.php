<?php

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Components\Component;

class Ajax extends Component {

	const GET_ACTION = "headless_revalidate";
	const GET_ACTION_PENDING = "headless_revalidate_pending";
	const GET_FRONTEND_INDEX = "frontend";
	const GET_PATH = "path";
	const GET_POST_ID = "post_id";

	public function onCreate() {
		parent::onCreate();
		add_action('wp_ajax_'.self::GET_ACTION, [$this, 'revalidate']);
		add_action('wp_ajax_'.self::GET_ACTION_PENDING, [$this, 'revalidate_pending']);
	}

	public function revalidate(){

		if(!current_user_can('edit_posts')){
			wp_send_json_error();
			exit;
		}

		if(!isset($_GET[self::GET_FRONTEND_INDEX])){
			wp_send_json_error([
				"message" => "missing frontend index"
			]);
			exit;
		}
		$frontendIndex = intval($_GET[self::GET_FRONTEND_INDEX]);
		$frontends = $this->plugin->headquarter->getFrontends();
		if(!isset($frontends[$frontendIndex])){
			wp_send_json_error([
				"message" => "Invalid frontend",
			]);
			exit;
		}

		if(isset($_GET[self::GET_PATH]) && !empty($_GET[self::GET_PATH])){

			$path = sanitize_text_field($_GET[self::GET_PATH]);

			$result = $this->plugin->revalidate->revalidateByPath($frontends[$frontendIndex], $path);
			if($result instanceof \WP_Error){
				wp_send_json_error($result);
			} else {
				wp_send_json_success($result);
			}
			exit;
		}

		if(isset($_GET[self::GET_POST_ID]) && !empty($_GET[self::GET_POST_ID])){
			$postId = intval($_GET[self::GET_POST_ID]);
			$result = $this->plugin->revalidate->revalidateByPathByPostId($frontends[$frontendIndex], $postId);
			if($result instanceof \WP_Error){
				wp_send_json_error($result);
			} else {
				wp_send_json_success($result);
			}
			exit;
		}

		wp_send_json_error([
			"message" => "invalid request",
		]);
		exit;

	}


	function revalidate_pending() {
		if(!current_user_can('edit_posts')){
			wp_send_json_error();
			exit;
		}
		$this->plugin->schedule->revalidate();
		wp_send_json_success([
			"success" => true,
		]);
		exit;
	}
}

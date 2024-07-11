<?php

namespace Palasthotel\WordPress\Headless\Extensions;

use WP_Post;
use WP_REST_Request;
use WP_REST_Response;

class Taxonomies extends AbsPostExtensionPost {

	/**
	 *
	 * add missing taxonomies for custom post types with hl_post_type request
	 *
	 * @param WP_REST_Response $response
	 * @param WP_Post $post
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	function response( WP_REST_Response $response, WP_Post $post, WP_REST_Request $request ): WP_REST_Response {
		$data = $response->get_data();

		/**
		 * @var \WP_Taxonomy[] $taxonomies
		 */
		$taxonomies = wp_list_filter( get_object_taxonomies( $post->post_type, 'objects' ), array( 'show_in_rest' => true ) );
		foreach ($taxonomies as $tax) {
			if(!isset($data[$tax->name])){
				$terms = get_the_terms($post->ID, $tax->name);
				if(is_array($terms)){
					$data[$tax->name] = array_map(function($t){
						return $t->term_id;
					}, $terms);
				}
			}
		}

		$response->set_data( $data );
		return $response;
	}
}
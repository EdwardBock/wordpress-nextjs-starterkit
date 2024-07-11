<?php

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Components\Component;

class Query extends Component {

	const META_KEYS = "hl_meta_keys";
	const META_VALUES = "hl_meta_values";
	const META_COMPARES = "hl_meta_compares";
	const META_EXISTS = "hl_meta_exists";
	const META_NOT_EXISTS = "hl_meta_not_exists";
	const META_RELATION = "hl_meta_relation";
	const POST_TYPE = "hl_post_type";

	public function onCreate() {
		parent::onCreate();

		if ( ! $this->plugin->security->hasApiKeyAccess() ) {
			return;
		}

		foreach ( get_post_types( [ 'show_in_rest' => true, "public" => true ] ) as $post_type ) {
			add_filter( 'rest_' . $post_type . '_query', [ $this, 'rest_query' ], 10, 2 );
		}
	}

	public static function getRequestPostTypes( \WP_REST_Request $request ) {
		$post_types = $request->get_param( static::POST_TYPE );
		if(is_array($post_types) && in_array("any",$post_types)){
			return ["any"];
		}
		if ( empty( $post_types ) ) {
			return [];
		}
		if ( is_string( $post_types ) ) {
			return [ $post_types ];
		}

		return array_filter( $post_types, function ( $type ) {
			return post_type_exists( $type ) && is_post_type_viewable( $type );
		} );
	}

	public function rest_query( array $args, \WP_REST_Request $request ) {

		$metas = $request->get_param(static::META_KEYS);
		$values = $request->get_param(static::META_VALUES);
		$compares = $request->get_param(static::META_COMPARES);
		$comparesMap = [
			"eq" => "=",
			"neq" => "!=",
			"like" => "LIKE",
		];
		$validCompares = array_keys($comparesMap);
		$meta_query = [];
		if(!empty($metas) && is_array($metas)){
			foreach ($metas as $index =>  $metaKey) {
				$compare = "=";
				if(is_array($compares) && !empty($compares[$index]) && in_array($compares[$index], $validCompares)){
					$compare = $comparesMap[$compares[$index]];
				}
				if(is_array($values) && isset($values[$index])){
					$meta_query[] = [
						"key" => sanitize_text_field($metaKey),
						"value" => sanitize_text_field($values[$index]),
						"compare" => $compare,
					];
				}

			}
		}

		$metaExists = $request->get_param( static::META_EXISTS );
		if ( ! empty( $metaExists ) ) {
			$meta_query[] = array(
				array(
					'key'     => sanitize_text_field( $metaExists ),
					'compare' => 'EXISTS',
				),
			);
		}

		$metaNotExists = $request->get_param( static::META_NOT_EXISTS );
		if ( ! empty( $metaNotExists ) ) {
			$meta_query[] = array(
				array(
					'key'     => sanitize_text_field( $metaNotExists ),
					'compare' => 'NOT EXISTS',
				),
			);
		}

		if(count($meta_query) > 0){
			$relation = "AND";
			if($request->get_param(static::META_RELATION) == "OR"){
				$relation = "OR";
			}
			$meta_query['relation'] = $relation;
			$args['meta_query'] = $meta_query;
		}


		$post_types = static::getRequestPostTypes( $request );
		if ( ! empty( $post_types ) ) {
			$args['post_type'] = $post_types;
		}

		return $args;
	}

}
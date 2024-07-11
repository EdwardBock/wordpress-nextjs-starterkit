<?php

namespace Palasthotel\WordPress\Headless\Routes;

use Palasthotel\WordPress\Headless\Components\Component;
use Palasthotel\WordPress\Headless\Plugin;

class Menus extends Component {

	private $menu;

	public function init(){
		register_rest_route( Plugin::REST_NAMESPACE, '/menus', array(
			'methods'             => 'GET',
			'callback'            => [ $this, 'get_all_menus' ],
			'permission_callback' => function(){
				return $this->plugin->security->isHeadlessRequest() &&
				       $this->plugin->security->hasApiKeyAccess();
			},
		) );
		register_rest_route( Plugin::REST_NAMESPACE, '/menus/(?P<menu>[\S]+)', array(
			'methods'             => 'GET',
			'callback'            => [ $this, 'get_menu' ],
			'permission_callback' => function(){
				return $this->plugin->security->isHeadlessRequest() &&
				       $this->plugin->security->hasApiKeyAccess();
			},
			'args'                => [
				'menu' => [
					'validate_callback' => function ( $value, $request, $param ) {
						$value = sanitize_text_field( $value );
						$menu  = $this->getMenuResponse($value);
						if ( ! $menu ) {

							return false;
						}
						$this->menu = $menu;

						return true;

					},
				],
			]
		) );
	}

	public function get_all_menus() {
		$menus = wp_get_nav_menus();
		$menusResponse = [];
		foreach ($menus as $menu){
			$menusResponse[$menu->slug] = $this->getMenuResponse($menu);
		}
		return $menusResponse;
	}

	public function get_menu() {
		return $this->menu;
	}

	private function getMenuResponse($menu) {
		$menu  = wp_get_nav_menu_items( $menu );
		if ( ! $menu ) {
			return false;
		}

		return array_map( function ( $menuItem ) {
			if ( isset( $menuItem->title ) ) {
				$menuItem->title = html_entity_decode( $menuItem->title );
			}
			if ( isset( $menuItem->attr_title ) ) {
				$menuItem->attr_title = html_entity_decode( $menuItem->attr_title );
			}

			return $menuItem;
		}, $menu );
	}
}
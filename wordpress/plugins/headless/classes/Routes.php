<?php

namespace Palasthotel\WordPress\Headless;


use Palasthotel\WordPress\Headless\Routes\Menus;
use Palasthotel\WordPress\Headless\Routes\Settings;

/**
 * @property Menus $menus
 * @property Settings $settings
 */
class Routes extends Components\Component {

	public function onCreate() {
		parent::onCreate();
		add_action( 'rest_api_init', [ $this, 'rest_api_init' ] );
	}

	public function rest_api_init() {

		$this->settings = new Settings($this->plugin);
		$this->settings->init();

		$this->menus = new Menus($this->plugin);
		$this->menus->init();

	}



}
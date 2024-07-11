<?php


namespace Palasthotel\WordPress\Headless\Components;

/**
 * Class Component
 *
 * @property \Palasthotel\WordPress\Headless\Plugin plugin
 *
 * @package Palasthotel\WordPress
 * @version 0.1.2
 */
abstract class Component {
	/**
	 * _Component constructor.
	 *
	 * @param \Palasthotel\WordPress\Headless\Plugin $plugin
	 */
	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		$this->onCreate();
	}

	/**
	 * overwrite this method in component implementations
	 */
	public function onCreate(){
		// init your hooks and stuff
	}
}
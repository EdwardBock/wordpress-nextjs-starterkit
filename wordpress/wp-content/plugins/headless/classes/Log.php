<?php

namespace Palasthotel\WordPress\Headless;

class Log extends Components\Component {
	/**
	 * @var null|\CronLogger\Log
	 */
	private $log;

	public function onCreate() {
		parent::onCreate();
		add_action("cron_logger_init", function(\CronLogger\Plugin $logger){
			$this->log = $logger->log;
		});
	}

	public function add($message){
		if(class_exists('\CronLogger\Log') && $this->log instanceof \CronLogger\Log){
			$this->log->addInfo($message);
		} else {
			error_log($message);
		}
		if(class_exists("\WP_CLI")){
			\WP_CLI::log($message);
		}
	}

	public function warning($message){
		if(class_exists('\CronLogger\Log') && $this->log instanceof \CronLogger\Log){
			$this->log->addInfo("WARNING: ".$message);
		} else {
			error_log("WARNING: ".$message);
		}
		if(class_exists("\WP_CLI")){
			\WP_CLI::warning($message);
		}
	}
}

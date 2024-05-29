<?php

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Components\Component;

class Schedule extends Component {

	public function onCreate() {
		parent::onCreate();

		add_action('admin_init', [$this, 'init']);
		add_action(Plugin::SCHEDULE_REVALIDATE, [$this, 'revalidate']);
	}

	public function init(){
		if(!wp_next_scheduled(Plugin::SCHEDULE_REVALIDATE)){
			wp_schedule_event(time(), 'hourly', Plugin::SCHEDULE_REVALIDATE);
		}
	}

	public function getNextSchedule(){
		return wp_next_scheduled(Plugin::SCHEDULE_REVALIDATE);
	}

	public function getLastRevalidationRun(): int{
		return intval(get_option(Plugin::OPTION_LAST_REVALIDATION_RUN, 0));
	}

	public function setLastRevalidationRun(int $time) {
		update_option(Plugin::OPTION_LAST_REVALIDATION_RUN, $time);
	}

	public function revalidate(){
		$lastRun = $this->getLastRevalidationRun();
		$now = time();

		$commentIds = $this->plugin->dbRevalidation->getPendingComments();
		foreach ($commentIds as $id){
			$comment = get_comment($id);
			$postId = $comment->comment_post_ID;
			$results = $this->plugin->revalidate->revalidateComments($postId);

			$success = true;
			foreach ($results as $result){
				if($result instanceof \WP_Error){
					$this->plugin->log->warning($result->get_error_message());
					$title = get_the_title($id);
					$this->plugin->log->warning("revalidate comment id: $id ; post: $postId $title");
					$success = false;
				}
			}

			if($success){
				$this->plugin->dbRevalidation->setCommentState($id);
			} else {
				$this->plugin->dbRevalidation->setCommentState($id, "error");
			}
		}

		$postIds = $this->plugin->dbRevalidation->getPendingPosts();

		$this->plugin->log->add("headless: lastRun $lastRun ");
		$this->plugin->log->add("headless: revalidate post ids ".implode(", ", $postIds));

		foreach ($postIds as $id){
			$results = $this->plugin->revalidate->revalidatePost($id);

			$success = true;
			foreach ($results as $result){
				if($result instanceof \WP_Error){
					$this->plugin->log->warning($result->get_error_message());
					$title = get_the_title($id);
					$this->plugin->log->warning("revalidate post id: $id $title");
					$success = false;
				}
			}

			if($success){
				$this->plugin->dbRevalidation->setPostState($id);
			} else {
				$this->plugin->dbRevalidation->setPostState($id, "error");
			}
		}




		// do stuff like revalidating landingpages
		do_action(Plugin::ACTION_REVALIDATION_SIDE_EFFECT, $postIds);



		$this->setLastRevalidationRun($now);

	}


}

<?php


namespace Palasthotel\WordPress\Headless\Store;


use Palasthotel\WordPress\Headless\Components\Database;

/**
 * @property string $table
 */
class RevalidationDatabase extends Database {

	const TYPE_POST = "post";
	const TYPE_COMMENT = "comment";

	function init() {
		$this->table = $this->wpdb->prefix . "headless_revalidate";
	}

	private function addContent(string $id, string $type) {
		return $this->wpdb->replace(
			$this->table,
			[
				"content_id" => $id,
				"content_type" => $type,
				"revalidated_at" => null,
				"revalidation_state" => "pending",
			]
		);
	}

	public function addPost(int $post_id) {
		return $this->addContent($post_id, self::TYPE_POST);
	}

	public function addComment(string $comment_id) {
		return $this->addContent($comment_id, self::TYPE_COMMENT);
	}


	/**
	 * @return Int[]
	 */
	private function getPendingContents(string $type): array {
		$sql = $this->wpdb->prepare(
			"SELECT content_id FROM $this->table WHERE content_type = '%s' AND revalidation_state = 'pending'",
			$type
		);
		return $this->wpdb->get_col($sql);
	}

	/**
	 *
	 * @return Int[]
	 */
	public function getPendingPosts(): array {
		return $this->getPendingContents(self::TYPE_POST);
	}

	public function getPendingComments(): array {
		return $this->getPendingContents(self::TYPE_COMMENT);
	}


	private function countPendingContents(string $type): int {
		$sql = $this->wpdb->prepare(
			"SELECT count(content_id) FROM $this->table WHERE content_type = '%s' AND revalidation_state = 'pending'",
			$type
		);
		return intval($this->wpdb->get_var($sql));
	}

	public function countPendingPosts(): int {
		return $this->countPendingContents(self::TYPE_POST);
	}

	public function countPendingComments(): int {
		return $this->countPendingContents(self::TYPE_COMMENT);
	}

	public function setContentState(int $id, string $type, $state = "revalidated") {
		return $this->wpdb->update(
			$this->table,
			[
				"revalidated_at" => current_time('mysql'),
				"revalidation_state" => $state,
			],
			[
				"content_id" => $id,
				"content_type" => $type,
			],
			["%s", "%s"],
			["%d", "%s"]
		);
	}

	public function setPostState(int $post_id, $state = "revalidated") {
		return $this->setContentState($post_id, self::TYPE_POST, $state);
	}

	public function setCommentState(int $comment_id, $state = "revalidated") {
		return $this->setContentState($comment_id, self::TYPE_COMMENT, $state);
	}

	public function createTables() {
		parent::createTables();
		\dbDelta("CREATE TABLE IF NOT EXISTS $this->table
			(
			 id bigint(20) unsigned auto_increment,
    		 content_id bigint(20) unsigned NOT NULL,
    		 content_type varchar(40) NOT NULL,
    		 revalidation_state varchar(30),
    		 revalidated_at TIMESTAMP default null,
			 primary key (id),
    		 key (content_id),
			 key (content_type),
    		 key (revalidation_state),
    		 key (revalidated_at),
    		 unique key exact_content (content_id, content_type)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
	}
}

<?php

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Components\Component;
use WP_Post;

class Preview extends Component {

	const POST_ID_PLACEHOLDER = "{{post_id}}";

	public function onCreate() {
		parent::onCreate();

		add_filter( 'preview_post_link', [ $this, 'preview_post_link' ], 10, 2 );
		add_action( 'wp_ajax_headless_preview', [ $this, 'admin_preview' ] );
		add_action( 'wp_ajax_nopriv_headless_preview', [ $this, 'no_permission' ] );
	}

	public function getRedirectLink( $id ) {
		if($id == null){
			$id = self::POST_ID_PLACEHOLDER;
		}

		return rtrim(get_admin_url(),"/") . "/admin-ajax.php?action=headless_preview&post=$id";
	}

    public function getHeadlessPreviewPath(){
        return "/api/preview?secret_token=".HEADLESS_SECRET_TOKEN;
    }

    /**
     * @param WP_Post|null $post
     * @return string
     */
	public function getHeadlessPreviewLink( $post = null ) {

        $path = $this->getHeadlessPreviewPath();

		$link = untrailingslashit( HEADLESS_HEAD_BASE_URL ) . $path;

        if($post instanceof WP_Post){
            $link .= "&post=$post->ID&post_type=$post->post_type";
        }

		return apply_filters( Plugin::FILTER_PREVIEW_URL, $link, $post, $link );
	}

	public function preview_post_link( string $link, WP_Post $post ) {

		if(!$this->plugin->post->isHeadlessPostType($post->post_type)) return $link;

		return apply_filters(
			Plugin::FILTER_PREVIEW_REDIRECT_URL,
			$this->plugin->preview->getRedirectLink( $post->ID ),
			$post,
			$link
		);
	}

	public function admin_preview() {
		$postId = intval( $_GET["post"] );
		$post   = get_post( $postId );
		if ( ! ( $post instanceof WP_Post ) ) {
			echo "Post not found";
			exit;
		}
		if ( ! current_user_can( "edit_post", $postId ) ) {
			echo "Sorry, not allowed";
			exit;
		}

		$redirect = $this->getHeadlessPreviewLink( $post );
		wp_redirect( $redirect );
		exit;
	}

	public function no_permission() {
		header('HTTP/1.0 403 Forbidden');
		die('Missing permission to access this area!');
	}


}

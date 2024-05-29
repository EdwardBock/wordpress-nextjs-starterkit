<?php

/**
 * Plugin Name: Headless
 * Plugin URI: https://github.com/palasthotel/headless
 * Description: Adds features to use WordPress as headless CMS
 * Version: 2.2.4
 * Author: Palasthotel (Edward Bock) <edward.bock@palasthotel.de>
 * Author URI: http://www.palasthotel.de
 * Requires at least: 5.0
 * Tested up to: 6.5.2
 * Requires PHP: 8.0
 * Text Domain: headless
 * License: http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @copyright Copyright by Palasthotel
 * @package Palasthotel\WordPress\Headless
 *
 */

namespace Palasthotel\WordPress\Headless;

use Palasthotel\WordPress\Headless\Store\RevalidationDatabase;

if ( ! defined( 'HEADLESS_HEAD_BASE_URL' ) ) {
	define( 'HEADLESS_HEAD_BASE_URL', '' );
}

if ( ! defined( 'HEADLESS_SECRET_TOKEN' ) ) {
	define( 'HEADLESS_SECRET_TOKEN', "" );
}

if ( ! defined( 'HEADLESS_REST_PARAM' ) ) {
	define( 'HEADLESS_REST_PARAM', "headless" );
}
if ( ! defined( 'HEADLESS_REST_VALUE' ) ) {
	define( 'HEADLESS_REST_VALUE', 'true' );
}

if ( ! defined( 'HEADLESS_REST_VARIANT_PARAM' ) ) {
	define( 'HEADLESS_REST_VARIANT_PARAM', "headless_variant" );
}
if ( ! defined( 'HEADLESS_REST_VARIANT_TEASERS_VALUE' ) ) {
	define( 'HEADLESS_REST_VARIANT_TEASERS_VALUE', 'teaser' );
}

if ( ! defined( 'HEADLESS_API_KEY_HEADER_KEY' ) ) {
	define( 'HEADLESS_API_KEY_HEADER_KEY', "" );
}
if ( ! defined( 'HEADLESS_API_KEY_HEADER_VALUE' ) ) {
	define( 'HEADLESS_API_KEY_HEADER_VALUE', "" );
}

require_once __DIR__ . "/vendor/autoload.php";

/**
 * @property Routes $routes
 * @property Extensions $extensions
 * @property Security $security
 * @property Preview $preview
 * @property Query $query
 * @property Revalidate $revalidate
 * @property RevalidationDatabase $dbRevalidation
 * @property Schedule $schedule
 * @property PluginAssets $gutenberg
 * @property Headers $headers
 * @property Post $post
 * @property Dashboard $dashboard
 * @property Headquarter $headquarter
 * @property Ajax $ajax
 * @property Log $log
 */
class Plugin extends Components\Plugin {

	const DOMAIN = "headless";

	const REST_NAMESPACE = "headless/v1";
	const FILTER_IS_HEADLESS_POST_TYPE = "headless_is_headless_post_type";

	const FILTER_PREVIEW_REDIRECT_URL = "headless_preview_redirect_url";
	const FILTER_PREVIEW_URL = "headless_preview_url";

	const ACTION_REGISTER_BLOCK_PREPARATION_EXTENSIONS = "headless_register_block_preparation_extensions";
	const ACTION_REGISTER_POST_ROUTE_EXTENSIONS = "headless_register_post_route_extensions";
	const ACTION_REGISTER_COMMENT_ROUTE_EXTENSIONS = "headless_register_comment_route_extensions";
	const ACTION_REGISTER_USER_ROUTE_EXTENSIONS = "headless_register_user_route_extensions";
	const ACTION_REGISTER_TERM_ROUTE_EXTENSIONS = "headless_register_term_route_extensions";

	const FILTER_BLOCKS_PREPARE_FILTER = "headless_rest_api_prepare_filter";
	const FILTER_BLOCKS_PREPARE_BLOCK = "headless_rest_api_prepare_block";
	const FILTER_PREPARE_POST = "headless_rest_api_prepare_post";

	const FILTER_REST_RESPONSE_HEADERS = "headless_rest_response_headers";
    const FILTER_REST_RESPONSE_DATA = "headless_rest_response_data";

    const FILTER_FRONTENDS = "headless_frontends";
	const FILTER_REVALIDATE_BY_PATH_URL = "headless_revalidate_by_path_url";
	const FILTER_REVALIDATE_BY_TAG_URL = "headless_revalidate_by_tag_url";
	const FILTER_REVALIDATE_COMMENTS_BY_TAG = "headless_revalidate_comments_by_tag";
	const FILTER_REVALIDATE_PERMALINK_PATH = "headless_revalidate_permalink_path";
	const OPTION_LAST_REVALIDATION_RUN = "headless_last_revalidation_run";
	const SCHEDULE_REVALIDATE = "headless_schedule_revalidate";
	const ACTION_REVALIDATION_SIDE_EFFECT = "headless_revalidation_side_effect";

	const OPTION_SCHEMA_VERSION = "headless_schema_version";


	function onCreate() {

		$this->dbRevalidation = new RevalidationDatabase();
		$this->log            = new Log( $this );

		$this->security    = new Security( $this );
		$this->headers     = new Headers( $this );
		$this->routes      = new Routes( $this );
		$this->extensions  = new Extensions( $this );
		$this->query       = new Query( $this );
		$this->preview     = new Preview( $this );
		$this->headquarter = new Headquarter( $this );
		$this->revalidate  = new Revalidate( $this );
		$this->gutenberg   = new PluginAssets( $this );
		$this->post        = new Post( $this );
		$this->dashboard   = new Dashboard( $this );
		$this->ajax        = new Ajax( $this );
		$this->schedule    = new Schedule( $this );

		new Migration( $this );

	}

	public function onSiteActivation() {
		parent::onSiteActivation();
		$this->dbRevalidation->createTables();

	}
}

Plugin::instance();

require_once __DIR__ . "/public-functions.php";

=== Headless ===
Contributors: palasthotel, edwardbock
Donate link: http://palasthotel.de/
Tags: gutenberg, block, developer, utils
Requires at least: 5.0
Tested up to: 6.5.2
Requires PHP: 8.0
Stable tag: 2.2.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl

Adds features to use WordPress as headless CMS

== Description ==

Adds features to use WordPress as headless CMS

== Installation ==

1. Upload `headless.zip` to the `/wp-content/plugins/` directory
1. Extract the Plugin to a `headless` Folder
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 2.2.4 =
* Feature: Add filter "headless_rest_response_data"
* Fix: Gutenberg preview in new tab link

= 2.2.3 =
* Bugfix: fatal error without hl_post_type in rest api

= 2.2.2 =
* Feature: revalidate comments on schedule
* Bugfix: hl_post_type filter with any now working


= 2.2.0 =
* Feature: Revalidate pending posts via dashboard button
* Fix: date format on dashboard

= 2.1.2 =
* parallel to npm package update

= 2.1.0 =
* Feature: smaller response sizes with headless_variant=teaser

= 2.0.0 =
* BREAKING CHANGES
* Moves from @palasthotel/wp-fetch to @palasthotel/wp-rest

= 1.9.3 =
* Bugfix: post preview with wordpress 6.4.x fixed

= 1.9.2 =
* Bugfix: Allow revalidation timestamp to be null

= 1.9.1 =
* Bugfix: Undefined property innerHTML in ImageBockPreparation.php

= 1.9.0 =
* Feature: Add headless_revalidate_permalink_path filter
* Optimization: Add revalidation state "error"
* Optimization: Add cli log messages
* Optimization: Add cron logger support for messages

= 1.8.0 =
* Feature: Dashboard widget
* Refactor: revalidation hooks and process
* Optimization: Gutenberg panel
* Optimization: migration to new revalidation database schema

= 1.7.5 =
* Optimization: Preview links are only changed for headless post types

= 1.7.4 =
* Bugfix: view preview notice fix

= 1.7.3 =
* Bugfix: save post in draft state before open preview tab

= 1.7.2 =
* Added: Filter 'headless_is_headless_post_type'
* Fixed some issues with previews

= 1.7.1 =
* Use taxonomy name for headless posts as fallback for rest_base

= 1.7.0 =
* BREAKING CHANGE: core/block for block references has changed
* Optimization: changed preview url magic to redirect
* Removed: filter headless_post_link because it is not healthy
* Removed: filter headless_preview_redirect because it is not in use

= 1.6.2 =
* Add headless_rest_api_prepare_post filter for uniform post responses

= 1.6.1 =
* Optimization: revalidation uses url array
* Bugfix: Remove domain from page rest api response

= 1.6.0 =
* Feature: Tag Cloud Block extension
* Feature: User extensions
* Feature: Term extensions
* Optimization: stale-while-revalidate cache-control header for headless requests to the rest api
* Optimization: api key restriction

= 1.5.5 =
* Headless settings as rest api

= 1.5.3 =
* Featured media sizes to rest api

= 1.5.1 =
* Optimization: add image sizes

= 1.5.0 =
* Feature: Comment extensions with display_name and nickname
* Feature: Revalidation via gutenberg button
* Feature: Revalidation system via schedules

= 1.4.2 =
* add embed block preparations
* update wp fetch lib

= 1.4.1 =
* renamed attribute for reference block because of react attribute name problems

= 1.4.0 =
* add reference block preparation for content resolution
* add paragraph block preparation for smaller response size

= 1.3.0 =
* add featured media attributes to posts
* extend core/image and core/gallery

= 1.2.1 =
* Allow blockName null for freeform blocks

= 1.2.0 =
* Post Meta Query for rest requests

= 1.1.1 =
* Preview feature

= 1.0.0 =
* First release

== Upgrade Notice ==

== Arbitrary section ==

* BREAKING CHANGE 1.7.0: core/block for block references has changed

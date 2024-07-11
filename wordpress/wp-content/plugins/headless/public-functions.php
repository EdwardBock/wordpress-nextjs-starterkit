<?php

use Palasthotel\WordPress\Headless\Plugin;

function headless_plugin() {
	return Plugin::instance();
}

function headless_revalidate_by_post_id( $id ) {
	return headless_plugin()->revalidate->revalidatePost( $id );
}

function headless_revalidate_by_path( $path ) {
	$frontends = headless_plugin()->headquarter->getFrontends();

	return array_map( function ( $frontend ) use ( $path ) {
		return headless_plugin()->revalidate->revalidateByPath( $frontend, $path );
	}, $frontends );
}

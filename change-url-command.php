<?php

namespace WP_CLI\ChangeUrl;

use WP_CLI;

if ( ! class_exists( '\WP_CLI' ) ) {
	return;
}

$wpcli_change_url_autoloader = __DIR__ . '/vendor/autoload.php';

if ( file_exists( $wpcli_change_url_autoloader ) ) {
	require_once $wpcli_change_url_autoloader;
}

WP_CLI::add_command( 'change-url', ChangeUrlCommand::class );

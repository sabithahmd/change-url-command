<?php
namespace WP_CLI\ChangeUrl;

use WP_CLI;
use WP_CLI_Command;

class ChangeUrlCommand extends WpCliHelper {

	/**
	 * Greets the world.
	 *
	 * ## EXAMPLES
	 *
	 *     # Greet the world.
	 *     $ wp hello-world
	 *     Success: Hello World!
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Indexed array of positional arguments.
	 * @param array $assoc_args Associative array of associative arguments.
	 */
	public function __invoke( $args, $assoc_args ) {

		require_once ABSPATH.'wp-load.php';

		$this->showCurrentUrls();
		$action = $this->askOptions(['title' => 'Choose an option to continue', 'options' => ['1' => 'Change site url', '2' => 'Change home url', '3' => 'Change both urls']]);
		$this->nl("Enter new url");
		$url = readline(":");
		$this->changeUlrs($action, $url);
		WP_CLI::success( "Urls changed successfully to {$url}");
		
	}

	/**
	 * Change Urls based on action.
	 *
	 * @param string $action
	 * @param string $url
	 * @return void
	 */
	private function changeUlrs($action, $url)
	{
		if($action == '1' || $action == '3') //site url
		{
			$noSiteUrlInConfig = WP_CLI::launch_self('config has', ['WP_SITEURL'], [], false);
			if(!$noSiteUrlInConfig)
			{
				$error = WP_CLI::launch_self('config set',['WP_SITEURL', $url], [], false);
				if($error)
				{
					WP_CLI::error("Unable to update WP_SITEURL in config file");
				}
			}
			
			$error = WP_CLI::launch_self('option update',['siteurl', $url], [], false);
			if($error)
			{
				WP_CLI::error("Unable to update siteurl in database");
			}
		}

		if($action == '2' || $action == '3')
		{
			$noHomeUrlInConfig = WP_CLI::launch_self('config has', ['WP_HOME'], [], false);
			if(!$noSiteUrlInConfig)
			{
				$error = WP_CLI::launch_self('config set',['WP_HOME', $url], [], false);
				if($error)
				{
					WP_CLI::error("Unable to update WP_HOME in config file");
				}
			}

			$error = WP_CLI::launch_self('option update',['home', $url], [], false);
			if($error)
			{
				WP_CLI::error("Unable to update home in database");
			}
		}
	}

	/**
	 * Display current Urls
	 */
	private function showCurrentUrls()
	{
		$site_url = get_site_url();
		$home_url = get_home_url();
		$this->u("Current Urls");
		$this->nl();
		$this->nl("Site Url: {$site_url}");
		$this->nl("Home Url: {$home_url}");
		$this->nl();
	}
}

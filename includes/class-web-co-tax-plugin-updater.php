<?php

/**
 * The Web Co Plugin custom updater
 *
 * @link       https://thewebco.uk
 * @since      1.1.2
 *
 * @package    Web_Co_Tax_Plugin
 * @subpackage Web_Co_Tax_Plugin/includes
 */

/**
 * Automatically pull plugin updates from the update server
 *
 * @package    Web_Co_Tax_Plugin
 * @subpackage Web_Co_Tax_Plugin/includes
 */
class Web_Co_Tax_Plugin_Updater {

	/**
	 * The Plugin Slug
	 *
	 * @since    1.1.2
	 * @var      string    $plugin_slug    The Plugin Slug
	 */
	public $plugin_slug;

	/**
	 * The Plugin Version
	 *
	 * @since    1.1.2
	 * @var      string    $version    The Plugin Version
	 */
	public $version;

	/**
	 * Cache Key
	 *
	 * @since    1.1.2
	 * @var      string    $cache_key   Cache Key
	 */
	public $cache_key;

	/**
	 * Updater Server URL
	 *
	 * @since    1.1.2
	 * @var      string    $server_url   Updater Server URL
	 */
	public $server_url;

	/**
	 * Cache Allowed Bool
	 *
	 * @since    1.1.2
	 * @var      bool    $cache_key   Cache Allowed Bool
	 */
	public $cache_allowed;

	/**
	 * Initialize the updater class
	 *
	 * @since    1.1.2
	 */
	public function __construct() {

		if ( defined( 'WEB_CO_PLUGIN_VERSION' ) ) {
			$this->version = WEB_CO_PLUGIN_VERSION;
		} else {
			$this->version = '1.1.3';
		}

		$this->plugin_slug   = plugin_basename( dirname( __DIR__ ) );
		$this->cache_key     = 'web_co_tax_plugin';
		$this->cache_allowed = true;
		$this->server_url    = 'https://plugins.thewebco.uk';

		add_filter( 'plugins_api', array( $this, 'info' ), 20, 3 );
		add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
		add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );
	}

	/**
	 * Request the information from the updater server
	 * 
	 * @since    1.1.2
	 * @return   object
	 */
	public function request() {

		$remote = get_transient( $this->cache_key );

		if ( false === $remote || ! $this->cache_allowed ) {

			$remote = wp_remote_get(
				$this->server_url . '/updater/info.json',
				array(
					'timeout' => 10,
					'headers' => array(
						'Accept' => 'application/json'
					)
				)
			);

			if (
				is_wp_error( $remote )
				|| 200 !== wp_remote_retrieve_response_code( $remote )
				|| empty( wp_remote_retrieve_body( $remote ) )
			) {
				return false;
			}

			set_transient( $this->cache_key, $remote, 4 * HOUR_IN_SECONDS );

		}

		$remote = json_decode( wp_remote_retrieve_body( $remote ) );

		return $remote;

	}

	/**
	 * Attached to the plugins_api hook
	 * 
	 * Filters the response for the current WordPress.org Plugin Installation API request.
	 *
	 * Returning a non-false value will effectively short-circuit the WordPress.org API request.
	 *
	 * @since    1.1.2
	 * @param    object|WP_Error $res    Response object or WP_Error.
	 * @param    string          $action The type of information being requested from the Plugin Installation API.
	 * @param    object          $args   Plugin API arguments.
	 * @return   object|WP_Error $res    Response object or WP_Error.
	 */
	public function info( $res, $action, $args ) {

		// do nothing if you're not getting plugin information right now
		if ( 'plugin_information' !== $action ) {
			return $res;
		}

		// do nothing if it is not our plugin
		if ( $this->plugin_slug !== $args->slug ) {
			return $res;
		}

		// get updates
		$remote = $this->request();

		if ( ! $remote ) {
			return $res;
		}

		$res = new stdClass();

		$res->name = $remote->name;
		$res->slug = $remote->slug;
		$res->version = $remote->version;
		$res->tested = $remote->tested;
		$res->requires = $remote->requires;
		$res->author = $remote->author;
		$res->author_profile = $remote->author_profile;
		$res->download_link = $remote->download_url;
		$res->trunk = $remote->download_url;
		$res->requires_php = $remote->requires_php;
		$res->last_updated = $remote->last_updated;

		$res->sections = array(
			'description' => $remote->sections->description,
			'installation' => $remote->sections->installation,
			'changelog' => $remote->sections->changelog
		);

		if ( ! empty( $remote->banners ) ) {
			$res->banners = array(
				'low' => $remote->banners->low,
				'high' => $remote->banners->high
			);
		}

		return $res;

	}

	/**
	 * Checks for plugin update
	 *
	 * @since    1.1.2
	 * @return   object
	 */
	public function update( $transient ) {
		
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$remote = $this->request();

		if (
			$remote
			&& version_compare( $this->version, $remote->version, '<' )
			&& version_compare( $remote->requires, get_bloginfo( 'version' ), '<=' )
			&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
		) {
			$res = new stdClass();
			$res->slug = $this->plugin_slug;
			$res->plugin = plugin_basename( WEB_CO_PLUGIN_FILE );
			$res->new_version = $remote->version;
			$res->tested = $remote->tested;
			$res->package = $remote->download_url;

			$transient->response[ $res->plugin ] = $res;
		}

		return $transient;

	}

	/**
	 * Fires when the upgrader process is complete.
	 * 
	 * Used to clear the cache when new plugin version is installed
	 *
	 * See also {@see 'upgrader_package_options'}.
	 *
	 * @since    1.1.2
	 * @param WP_Upgrader $upgrader   WP_Upgrader instance. In other contexts this might be a
	 *                                Theme_Upgrader, Plugin_Upgrader, Core_Upgrade, or Language_Pack_Upgrader instance.
	 */
	public function purge( $upgrader, $options ) {
		if (
			$this->cache_allowed
			&& 'update' === $options['action']
			&& 'plugin' === $options[ 'type' ]
		) {
			delete_transient( $this->cache_key );
		}
	}

}

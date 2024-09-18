<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://thewebco.uk
 * @since      1.0.0
 *
 * @package    Web_Co_Tax_Plugin
 * @subpackage Web_Co_Tax_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Web_Co_Tax_Plugin
 * @subpackage Web_Co_Tax_Plugin/admin
 */
class Web_Co_Tax_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Web_Co_Tax_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Web_Co_Tax_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/web-co-tax-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Web_Co_Tax_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Web_Co_Tax_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Not needed just yet
		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/web-co-tax-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

}

// Includes (just to keep things tidy)
include( plugin_dir_path( __FILE__ ) . 'includes/web-co-tax-widget.php');
include( plugin_dir_path( __FILE__ ) . 'includes/web-co-tax-options.php');

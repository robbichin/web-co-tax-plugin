<?php

/**
 * The plugin setup file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thewebco.uk
 * @since             1.0.0
 * @package           Web_Co_Tax_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Customer Tax Toggle
 * Plugin URI:        https://woo.com/products/woo-customer-tax-toggle/
 * Description:       Allow customers to toggle WooCommerce taxes with a shortcode, menu item, widget or floating bar, with full control over colours, positioning.
 * Version:           1.1.3
 * Update URI: https://api.freemius.com
 * Author:            The Web Co.
 * Author URI:        https://thewebco.uk
 * Developer:         Robert Chin
 * Developer URI:     http://thewebco.uk/
 * Text Domain:       web-co-tax-plugin
 * Domain Path:       /languages
 *
 * Woo: 
 * WC requires at least: 6.0
 * WC tested up to: 8.4
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( !function_exists( 'wctp_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wctp_fs()
    {
        global  $wctp_fs ;
        
        if ( !isset( $wctp_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $wctp_fs = fs_dynamic_init( array(
                'id'               => '14879',
                'slug'             => 'web-co-tax-plugin',
                'premium_slug'     => 'web-co-tax-plugin',
                'type'             => 'plugin',
                'public_key'       => 'pk_5cf8018c4502146adb54078e29f14',
                'is_premium'       => true,
                'is_premium_only'  => true,
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'menu'             => array(
                'slug'           => 'web-co-tax-plugin',
                'override_exact' => true,
                'contact'        => false,
                'support'        => false,
                'parent'         => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'          => true,
            ) );
        }
        
        return $wctp_fs;
    }
    
    // Init Freemius.
    wctp_fs();
    // Signal that SDK was initiated.
    do_action( 'wctp_fs_loaded' );
    function wctp_fs_settings_url()
    {
        return admin_url( 'options-general.php?page=web-co-tax-plugin' );
    }
    
    wctp_fs()->add_filter( 'connect_url', 'wctp_fs_settings_url' );
    wctp_fs()->add_filter( 'after_skip_url', 'wctp_fs_settings_url' );
    wctp_fs()->add_filter( 'after_connect_url', 'wctp_fs_settings_url' );
    wctp_fs()->add_filter( 'after_pending_connect_url', 'wctp_fs_settings_url' );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WEB_CO_PLUGIN_VERSION', '1.1.3' );
/**
 * Plugin file
 */
define( 'WEB_CO_PLUGIN_FILE', __FILE__ );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-web-co-tax-plugin-activator.php
 */
function activate_web_co_tax_plugin()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-web-co-tax-plugin-activator.php';
    Web_Co_Tax_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-web-co-tax-plugin-deactivator.php
 */
function deactivate_web_co_tax_plugin()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-web-co-tax-plugin-deactivator.php';
    Web_Co_Tax_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_web_co_tax_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_web_co_tax_plugin' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-web-co-tax-plugin.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_web_co_tax_plugin()
{
    $plugin = new Web_Co_Tax_Plugin();
    $plugin->run();
}

run_web_co_tax_plugin();

if ( !defined( 'WP_AWESOME__PLUGIN_DIR' ) ) {
    define( 'WP_AWESOME__PLUGIN_DIR', dirname( __FILE__ ) );
    define( 'WP_AWESOME__PLUGIN_URL', plugins_url( plugin_basename( WP_AWESOME__PLUGIN_DIR ) ) );
}

if ( !function_exists( 'wctp_fs' ) ) {
    function wctp_fs()
    {
        // ... integration code ...
    }

}
add_action( 'before_woocommerce_init', function () {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );
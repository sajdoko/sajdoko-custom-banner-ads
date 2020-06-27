<?php

/**
 * Plugin Name:       Custom Banner Ads
 * Plugin URI:        #pluginurl
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            sajdoko
 * Author URI:        #authorurl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sajdoko-custom-banner-ads
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'SAJDOKO_CUSTOM_BANNER_ADS_VERSION', '1.0.0' );

function activate_sajdoko_custom_banner_ads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sajdoko-custom-banner-ads-activator.php';
	Sajdoko_Custom_Banner_Ads_Activator::activate();
}

function deactivate_sajdoko_custom_banner_ads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sajdoko-custom-banner-ads-deactivator.php';
	Sajdoko_Custom_Banner_Ads_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sajdoko_custom_banner_ads' );
register_deactivation_hook( __FILE__, 'deactivate_sajdoko_custom_banner_ads' );

require plugin_dir_path( __FILE__ ) . 'includes/class-sajdoko-custom-banner-ads.php';

function run_sajdoko_custom_banner_ads() {

	$plugin = new Sajdoko_Custom_Banner_Ads();
	$plugin->run();

}
run_sajdoko_custom_banner_ads();

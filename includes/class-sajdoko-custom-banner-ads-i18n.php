<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       #authorurl
 * @since      1.0.0
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/includes
 * @author     sajdoko <#authoremail>
 */
class Sajdoko_Custom_Banner_Ads_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sajdoko-custom-banner-ads',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #authorurl
 * @since      1.0.0
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/admin
 * @author     sajdoko <#authoremail>
 */
class Sajdoko_Custom_Banner_Ads_Admin {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function remove_revolution_slider_meta_boxes() {
		remove_meta_box( 'mymetabox_revslider_0', 'banner-ads', 'normal' );
	}

  public function sajdoko_banner_ads_admin_submenu() {
		add_submenu_page('edit.php?post_type=banner-ads', __('Help', $this->version), __('Help', $this->version), 'manage_options', $this->plugin_name . '_banner_ads', array($this, 'sajdoko_banner_ads_display_page'));
	 }

	public function sajdoko_banner_ads_display_page() {
		include_once 'partials/sajdoko-custom-banner-ads-admin-display.php';
	}

}

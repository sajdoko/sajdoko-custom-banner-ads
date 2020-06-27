<?php

/**
 * The file that defines the core plugin class
 *
 * @link       #authorurl
 * @since      1.0.0
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/includes
 * @author     sajdoko <#authoremail>
 */
class Sajdoko_Custom_Banner_Ads {
	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'SAJDOKO_CUSTOM_BANNER_ADS_VERSION' ) ) {
			$this->version = SAJDOKO_CUSTOM_BANNER_ADS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sajdoko-custom-banner-ads';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_cpt_hooks();
		$this->define_public_hooks();
		$this->sajdoko_banner_ads_schedule_single_event();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sajdoko-custom-banner-ads-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sajdoko-custom-banner-ads-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sajdoko-custom-banner-ads-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sajdoko-custom-banner-ads-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sajdoko-custom-banner-ads-public.php';

		$this->loader = new Sajdoko_Custom_Banner_Ads_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Sajdoko_Custom_Banner_Ads_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Sajdoko_Custom_Banner_Ads_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'sajdoko_banner_ads_admin_submenu', 99 );
		$this->loader->add_action( 'do_meta_boxes', $plugin_admin, 'remove_revolution_slider_meta_boxes' );

	}

	private function define_cpt_hooks() {

		$plugin_cpt = new Sajdoko_Custom_Banner_Ads_Cpt( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_cpt, 'sajdoko_banner_ads_register_cpt', 0 );
		$this->loader->add_action( 'admin_init', $plugin_cpt, 'sajdoko_banner_ads_move_metabox' );
		$this->loader->add_action( 'admin_footer', $plugin_cpt, 'sajdoko_banner_ads_limit_one_size' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_cpt, 'sajdoko_banner_ads_add_metabox' );
		$this->loader->add_action( 'save_post', $plugin_cpt, 'sajdoko_banner_ads_save_metabox' );

		$this->loader->add_filter( 'admin_post_thumbnail_html', $plugin_cpt, 'sajdoko_banner_ads_thumbnail_html' );

		$this->loader->add_filter( 'manage_posts_columns', $plugin_cpt, 'sajdoko_banner_ads_posts_columns', 5 );
		$this->loader->add_filter( 'manage_posts_custom_column', $plugin_cpt, 'sajdoko_banner_ads_posts_custom_columns', 5, 2 );
		$this->loader->add_filter( 'manage_post-type_posts_columns', $plugin_cpt, 'sajdoko_banner_ads_posts_columns', 5 );
		$this->loader->add_filter( 'manage_post-type_posts_custom_column', $plugin_cpt, 'sajdoko_banner_ads_posts_custom_columns', 5, 2 );

	}

	private function define_public_hooks() {

		$plugin_public = new Sajdoko_Custom_Banner_Ads_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_public, 'sajdoko_banner_ads_display_front');

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

	private function sajdoko_banner_ads_schedule_single_event() {
    $sajdoko_banner_ads_version = get_option('sajdoko_banner_ads_version', '1.0.0');
    if (version_compare($sajdoko_banner_ads_version,  '1.0.0') == 0) {
      if (!wp_next_scheduled('sajdoko_banner_ads_single_event')) {
        wp_schedule_single_event( time() + 10, 'sajdoko_banner_ads_single_event' , array($sajdoko_banner_ads_version) );
      }
      add_action('sajdoko_banner_ads_single_event', array( __CLASS__, 'sajdoko_banner_ads_single_event_run' ));
    } else {
      if (wp_next_scheduled('sajdoko_banner_ads_single_event')) {
        wp_clear_scheduled_hook( 'sajdoko_banner_ads_single_event' );
      }
    }
	}
	public static function sajdoko_banner_ads_single_event_run($sajdoko_banner_ads_version) {
		$default_banner_sizes = array(
			array('name' => '88x31 micro bar', 'slug' => '88x31', 'description' => '88x31 micro bar'),
			array('name' => '120x90 button 1', 'slug' => '120x90', 'description' => 'button 1'),
			array('name' => '120x60 button 2', 'slug' => '120x60', 'description' => 'button 2'),
			array('name' => '125x125 square button', 'slug' => '125x125', 'description' => 'square button'),
			array('name' => '120x240 vertical banner', 'slug' => '120x240', 'description' => 'vertical banner'),
			array('name' => '234x60 half banner', 'slug' => '234x60', 'description' => 'half banner'),
			array('name' => '468x60 full banner', 'slug' => '468x60', 'description' => 'full banner'),
			array('name' => '180x150 rectangle', 'slug' => '180x150', 'description' => 'rectangle'),
			array('name' => '300x100 3:1 rectangle', 'slug' => '300x100', 'description' => '3:1 rectangle'),
			array('name' => '240x400 vertical rectangle', 'slug' => '240x400', 'description' => 'vertical rectangle'),
			array('name' => '300x250 medium rectangle', 'slug' => '300x250', 'description' => 'medium rectangle'),
			array('name' => '336x280 large rectangle', 'slug' => '336x280', 'description' => 'large rectangle'),
			array('name' => '120x600 skyscraper', 'slug' => '120x600', 'description' => 'skyscraper'),
			array('name' => '160x600 wide skyscraper', 'slug' => '160x600', 'description' => 'wide skyscraper'),
			array('name' => '250x250 square pop-up', 'slug' => '250x250', 'description' => 'square pop-up'),
			array('name' => '720x300 pop-under', 'slug' => '720x300', 'description' => 'pop-under'),
			array('name' => '300x600 half-page ad', 'slug' => '300x600', 'description' => 'half-page ad'),
			array('name' => '728x90 leaderboard', 'slug' => '728x90', 'description' => 'leaderboard'),
		);

		foreach ($default_banner_sizes as $banner_term) {
			wp_insert_term(
				$banner_term['name'],
				'banner_size',
				array(
					'description'=> $banner_term['description'],
					'slug' => $banner_term['slug']
				)
			);
		}
		update_option('sajdoko_banner_ads_version', '1.0.1');
	}

}

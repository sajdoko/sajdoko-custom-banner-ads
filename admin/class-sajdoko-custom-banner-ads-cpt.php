<?php

/**
 * Create banner-ads custom post type.
 *
 * @link       #authorurl
 * @since      1.0.0
 *
 * @package    Sajdoko_Custom_Banner_Cpt
 * @subpackage Sajdoko_Custom_Banner_Cpt/admin
 * @author     sajdoko <#authoremail>
 */

class Sajdoko_Custom_Banner_Ads_Cpt {
  private $plugin_name;
  private $version;

  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  public function sajdoko_banner_ads_register_cpt() {

    $labels = array(
      'name' => _x('Banner Ads', 'Post Type General Name', $this->plugin_name),
      'singular_name' => _x('Banner Ad', 'Post Type Singular Name', $this->plugin_name),
      'menu_name' => __('Banner Ads', $this->plugin_name),
      'name_admin_bar' => __('Banner Ads', $this->plugin_name),
      'archives' => __('Banner Archives', $this->plugin_name),
      'attributes' => __('Banner Attributes', $this->plugin_name),
      'parent_item_colon' => __('Parent Banner:', $this->plugin_name),
      'all_items' => __('All Banners', $this->plugin_name),
      'add_new_item' => __('Add New Banner', $this->plugin_name),
      'add_new' => __('Add New Banner', $this->plugin_name),
      'new_item' => __('New Banner', $this->plugin_name),
      'edit_item' => __('Edit Banner', $this->plugin_name),
      'update_item' => __('Update Banner', $this->plugin_name),
      'view_item' => __('View Banner', $this->plugin_name),
      'view_items' => __('View Banner', $this->plugin_name),
      'search_items' => __('Search Banner', $this->plugin_name),
      'not_found' => __('Not found', $this->plugin_name),
      'not_found_in_trash' => __('Not found in Trash', $this->plugin_name),
      'featured_image' => __('Featured Image', $this->plugin_name),
      'set_featured_image' => __('Set featured image', $this->plugin_name),
      'remove_featured_image' => __('Remove featured image', $this->plugin_name),
      'use_featured_image' => __('Use as featured image', $this->plugin_name),
      'insert_into_item' => __('Insert into Banner', $this->plugin_name),
      'uploaded_to_this_item' => __('Uploaded to this Banner', $this->plugin_name),
      'items_list' => __('Banners list', $this->plugin_name),
      'items_list_navigation' => __('Banners list navigation', $this->plugin_name),
      'filter_items_list' => __('Filter Banners list', $this->plugin_name),
    );
    $args = array(
      'label' => __('Banner Ad', $this->plugin_name),
      'description' => __('Custom Banner Ads', $this->plugin_name),
      'labels' => $labels,
      'supports' => array('title', 'thumbnail'),
      'taxonomies' => array('banner_size'),
      'hierarchical' => false,
      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 25,
      'menu_icon' => 'dashicons-images-alt2',
      'show_in_admin_bar' => true,
      'show_in_nav_menus' => true,
      'can_export' => true,
      'has_archive' => false,
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'rewrite' => false,
      'capability_type' => 'post',
      'show_in_rest' => false,
    );
    register_post_type('banner-ads', $args);

    $labels = array(
      'name' => _x('Banner Sizes', 'Taxonomy General Name', $this->plugin_name),
      'singular_name' => _x('Banner Size', 'Taxonomy Singular Name', $this->plugin_name),
      'menu_name' => __('Banner Size', $this->plugin_name),
      'all_items' => __('All Banner Sizes', $this->plugin_name),
      'parent_item' => __('Parent Banner Size', $this->plugin_name),
      'parent_item_colon' => __('Parent Banner Size:', $this->plugin_name),
      'new_item_name' => __('New Banner Size Name', $this->plugin_name),
      'add_new_item' => __('Add New Banner Size', $this->plugin_name),
      'edit_item' => __('Edit Banner Size', $this->plugin_name),
      'update_item' => __('Update Banner Size', $this->plugin_name),
      'view_item' => __('View Banner Size', $this->plugin_name),
      'separate_items_with_commas' => __('Separate Banner Sizes with commas', $this->plugin_name),
      'add_or_remove_items' => __('Add or remove Banner Sizes', $this->plugin_name),
      'choose_from_most_used' => __('Choose from the most used', $this->plugin_name),
      'popular_items' => __('Popular Banner Sizes', $this->plugin_name),
      'search_items' => __('Search Banner Sizes', $this->plugin_name),
      'not_found' => __('Not Found', $this->plugin_name),
      'no_terms' => __('No Banner Sizes', $this->plugin_name),
      'items_list' => __('Banner Sizes list', $this->plugin_name),
      'items_list_navigation' => __('Banner Sizes list navigation', $this->plugin_name),
    );
    $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => false,
      'show_tagcloud' => false,
      'show_in_rest' => false,
    );
    register_taxonomy('banner_size', array('banner-ads'), $args);

  }

  public function sajdoko_banner_ads_move_metabox() {
    remove_meta_box('banner_sizediv', 'banner-ads', 'side');
    add_meta_box('banner_normaldiv', 'Banner Size', 'post_categories_meta_box', 'banner-ads', 'normal', 'high', array('taxonomy' => 'banner_size'));
  }

  public function sajdoko_banner_ads_limit_one_size() {
    if (get_current_screen()->post_type != 'banner-ads') return;
    echo '<script type="text/javascript">jQuery("#banner_sizechecklist input, ul.banner_size-checklist input, #banner_sizechecklist-pop input").each(function(){this.type="radio"});jQuery( "#banner_size-tabs li:nth-child(2), #banner_size-adder").hide();</script>';
  }

  public function sajdoko_banner_ads_thumbnail_html($content) {
    if (get_current_screen()->post_type != 'banner-ads') return $content;
    return $content = str_replace(__('Set featured image'), __('Set Banner Image', $this->plugin_name), $content);
  }

  public function sajdoko_banner_ads_posts_columns($defaults) {
    if (get_current_screen()->post_type != 'banner-ads') return $defaults;
    $defaults['banner_ads_post_thumbs'] = __('Banner Image');
    return $defaults;
  }

  public function sajdoko_banner_ads_posts_custom_columns($column_name, $id) {
    if (get_current_screen()->post_type != 'banner-ads') return;
    if ($column_name === 'banner_ads_post_thumbs') {
      if (has_post_thumbnail()) {
        echo the_post_thumbnail(array(70));
      } else {
        _e('Image not found', $this->plugin_name);
      }
    }
  }

  public function sajdoko_banner_ads_add_metabox() {
    add_meta_box(
      'sajdoko_banner_ads_url_section',
      __('Banner URL', $this->plugin_name),
      array($this, 'sajdoko_banner_ads_metabox_callback'),
      'banner-ads',
      'normal'
    );
  }

  public function sajdoko_banner_ads_metabox_callback($post) {
    wp_nonce_field('sajdoko_banner_ads_url_metabox', 'sajdoko_banner_ads_url_metabox_nonce');
    $url = get_post_meta($post->ID, '_sajdoko_banner_ads_url', true);
    echo '<p><input type="text" name="sajdoko_banner_ads_url" value="' . esc_url($url) . '" class="regular-text" /></p>';
  }

  public function sajdoko_banner_ads_save_metabox($post_id) {
    if (!isset($_POST['sajdoko_banner_ads_url_metabox_nonce'])) {
      return;
    }

    $nonce = $_POST['sajdoko_banner_ads_url_metabox_nonce'];

    if (!wp_verify_nonce($nonce, 'sajdoko_banner_ads_url_metabox')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    if (!isset($_POST['sajdoko_banner_ads_url'])) {
      return;
    }
    $url = esc_url_raw($_POST['sajdoko_banner_ads_url']);

    if (empty($url)) {
      delete_post_meta($post_id, '_sajdoko_banner_ads_url');
    } else {
      update_post_meta($post_id, '_sajdoko_banner_ads_url', $url);
    }
  }

}

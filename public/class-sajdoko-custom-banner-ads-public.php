<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #authorurl
 * @since      1.0.0
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/public
 * @author     sajdoko <#authoremail>
 */
class Sajdoko_Custom_Banner_Ads_Public {

  private $plugin_name;
  private $version;

  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  public function sajdoko_banner_ads_display_front() {

    function sajdoko_banner_ads_display_shortcode($atts) {

      $atts = shortcode_atts(
        array(
          'banner_size' => '720x90',
          'banner_limit' => 14,
        ),
        $atts,
        'banner_ads'
      );

      $args = array(
        'post_type' => array('banner-ads'),
				'post_status' => array('publish'),
				'posts_per_page' => intval($atts['banner_limit']),
        'order' => 'ASC',
        'orderby' => 'id',
        'tax_query' => array(
          array(
            'taxonomy' => 'banner_size',
            'field' => 'slug',
            'terms' => array( sanitize_text_field( $atts['banner_size'] ) ),
          ),
        ),
      );

      $sajdoko_banner_ads_query = new WP_Query($args);

      $html_out = '';
      if ( $sajdoko_banner_ads_query->have_posts() ) {
        $sajdoko_banner_ads_rand_char = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3);
        $html_out .= '<span class="sajdoko_banner_ads_menu_'.$sajdoko_banner_ads_rand_char.'" style="display:none;vertical-align: middle;">';
        while ( $sajdoko_banner_ads_query->have_posts() ) {
          $sajdoko_banner_ads_query->the_post();
          $url = (get_post_meta( get_the_ID(), '_sajdoko_banner_ads_url', true )) ? get_post_meta( get_the_ID(), '_sajdoko_banner_ads_url', true ) : '#';
          $html_out .= '<a href="'.$url.'" target="_blank">'.get_the_post_thumbnail( get_the_ID(), explode("x",$atts['banner_size']), array( 'class' => "sajdoko_banner_ads_".$sajdoko_banner_ads_rand_char ) ).'</a>';
        }
        $html_out .= '<script>
        jQuery( window ).load(function() {
          var slideIndex = 0;
          function sajdoko_banner_ads_carousel_'.$sajdoko_banner_ads_rand_char.'() {
            var i;
            var x = document.getElementsByClassName("sajdoko_banner_ads_'.$sajdoko_banner_ads_rand_char.'");
            var bannerAdsSpan = document.getElementsByClassName("sajdoko_banner_ads_menu_'.$sajdoko_banner_ads_rand_char.'");
            if (x) {
              for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
              }
              slideIndex++;
              if (slideIndex > x.length) {
                slideIndex = 1;
              }
              x[slideIndex - 1].style.display = "block";
              x[slideIndex - 1].style.width = "auto";
              setTimeout(sajdoko_banner_ads_carousel_'.$sajdoko_banner_ads_rand_char.', 6000); // Change image every 6 seconds
              bannerAdsSpan[0].style.display = "inline-block";
            }
          }
          sajdoko_banner_ads_carousel_'.$sajdoko_banner_ads_rand_char.'();
        });
        </script>';
        $html_out .= '</span>';
      }
      return $html_out;
      wp_reset_postdata();

    }
    add_shortcode('banner_ads', 'sajdoko_banner_ads_display_shortcode');
  }

}

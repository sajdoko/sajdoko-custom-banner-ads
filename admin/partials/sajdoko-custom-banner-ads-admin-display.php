<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #authorurl
 * @since      1.0.0
 *
 * @package    Sajdoko_Custom_Banner_Ads
 * @subpackage Sajdoko_Custom_Banner_Ads/admin/partials
 */
?>

<?php if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}?>

<div class="wrap">

  <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
  <hr>

  <div id="poststuff" class="lw-aio">
    <div id="post-body" class="metabox-holder columns-2">
      <!-- main content -->
      <div id="post-body-content">
        <div class="postbox">
          <div class="inside">

            <table class="form-table">
              <tr valign="top">
                <td scope="row">
                  <?php esc_attr_e( 'Shortcode with default options:', $this->plugin_name ); ?>
                </td>
                <td>
                  <code><?php esc_attr_e( '[banner_ads]', $this->plugin_name ); ?></code>
                </td>
              </tr>
              <tr valign="top">
                <td scope="row">
                  <?php esc_attr_e( 'To specify banner size add:', $this->plugin_name ); ?>
                </td>
                <td>
                  <code>banner_size="468x60"</code> <?php _e( 'to the shortcode. Chanege <em>468x60</em> to the desidered size.', $this->plugin_name ); ?>
                </td>
              </tr>
              <tr valign="top">
                <td scope="row">
                  <?php esc_attr_e( 'To specify banner limit add:', $this->plugin_name ); ?>
                </td>
                <td>
                  <code>banner_limit="14"</code> <?php _e( 'to the shortcode. Chanege <em>14</em> to the desidered number.', $this->plugin_name ); ?>
                </td>
              </tr>
              <tr valign="top">
                <td scope="row">
                  <?php esc_attr_e( 'Shortcode with all options:', $this->plugin_name ); ?>
                </td>
                <td>
                  <code><?php esc_attr_e( '[banner_ads banner_size="468x60" banner_limit="14"]', $this->plugin_name ); ?></code>
                </td>
              </tr>
            </table>

            <br class="clear" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
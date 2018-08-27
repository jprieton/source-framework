<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Html;

/**
 * Media_Page class
 *
 * @package        SMGTools
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Media_Page {

  /**
   * Constructor
   *
   * @since   2.0.0
   */
  public function __construct() {
    add_action( 'admin_init', [ $this, 'register_settings' ] );

    /**
     * Action to shows the thumbnail column if is enabled
     * Since    2.0.0
     */
    add_action( 'current_screen', [ __CLASS__, 'thumbnail_column' ] );
  }

  /**
   * Add field to Media Settings page
   *
   * @since   2.0.0
   */
  public function register_settings() {
    register_setting( 'media', 'thumbnail_column' );
    add_settings_section( 'thumbnail_column_section', __( 'Thumbnails', SF_TEXTDOMAIN ), [ $this, '_settings_field' ], 'media' );
  }

  /**
   * Shows the field
   *
   * @since   2.0.0
   */
  public function _settings_field() {
    $checked = (get_option( 'thumbnail_column', 'no' ) == 'yes') ?: 'no';
    ?>
    <table class="form-table">
      <tbody>
        <tr>
          <td class="td-full">
            <input type="hidden" name="thumbnail_column" value="no">
            <label for="thumbnail_column">
              <input name="thumbnail_column" id="thumbnail_column" value="yes" type="checkbox" <?php checked( $checked ) ?>>
              <?php _e( 'Shows a thumbnail column in post types with thumbnail support.', SF_TEXTDOMAIN ) ?></label>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }

  /**
   * Add thumbnail column in post types enabled
   *
   * @since   2.0.0
   */
  public static function thumbnail_column() {
    $show_column = (get_option( 'thumbnail_column', 'no' ) == 'yes');
    $screen      = get_current_screen();

    if ( !$show_column || empty( $screen->post_type ) ) {
      return;
    }

    $post_types_disabled = apply_filters( 'post_types_disabled_thumbnail_column', [ 'attachment' ] );

    // Product post_type in WooCommerce already have a thumbnail column
    if ( function_exists( 'WC' ) && 'product' == $screen->post_type ) {
      $post_types_disabled[] = 'product';
    }

    if ( in_array( $screen->post_type, $post_types_disabled ) ) {
      return;
    }

    add_action( 'manage_posts_custom_column', [ __CLASS__, 'manage_custom_columns' ], 10, 2 );
    add_action( 'manage_pages_custom_column', [ __CLASS__, 'manage_custom_columns' ], 10, 2 );
    add_action( 'manage_posts_columns', [ __CLASS__, 'manage_columns' ] );
    add_action( 'manage_pages_columns', [ __CLASS__, 'manage_columns' ] );
  }

  /**
   * Add featured column to admin pages
   *
   * @since   2.0.0
   *
   * @param   string    $column_name
   * @param   int       $post_id
   */
  public static function manage_custom_columns( $column_name, $post_id ) {
    if ( 'thumbnail' == $column_name ) {
      echo Html::tag( 'span.media-icon.image-icon', get_the_post_thumbnail( $post_id, 'thumbnail', [ 'class' => 'attachment-60x60 size-60x60' ] ) );
    }
  }

  /**
   * Add featured column to admin pages
   *
   * @since   2.0.0
   *
   * @param   array     $posts_columns
   * @return  array
   */
  public static function manage_columns( $posts_columns ) {
    $new = array(
        'cb'        => $posts_columns['cb'],
        'thumbnail' => __( 'Thumbnail', SF_TEXTDOMAIN )
    );

    $posts_columns = array_merge( $new, $posts_columns );
    return $posts_columns;
  }

}

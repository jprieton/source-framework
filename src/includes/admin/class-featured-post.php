<?php

namespace SMGTools\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SMGTools\Template\Html;
use SMGTools\Settings\Settings_Group;
use WP_Error;

/**
 * FeaturedPost class
 *
 * @package        Admin
 * @since          1.0.0
 * @author         Javier Prieto
 */
class Featured_Post {

  public function __construct() {
    /**
     * Action to shows the featured column if is enabled
     * Since    2.0.0
     */
    add_action( 'current_screen', [ __CLASS__, 'featured_column' ] );

    /**
     * Enable ajax featured post toggle
     * Since    2.0.0
     */
    add_action( 'wp_ajax_toggle_featured_post', [ __CLASS__, 'toggle_featured_post' ] );
  }

  /**
   * Add thumbnail column in post types enabled
   *
   * @since   2.0.0
   */
  public static function featured_column() {
    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new Settings_Group( 'advanced_settings' );
    }

    $show_column = $advanced_setting_group->get_bool_option( 'featured-posts-enabled' );
    $screen      = get_current_screen();

    if ( !$show_column || empty( $screen->post_type ) ) {
      return;
    }

    $post_types_disabled = apply_filters( 'post_types_disabled_featured_column', [ 'attachment' ] );

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
   * @since   1.0.0
   *
   * @param   string    $column_name
   * @param   int       $post_id
   * @return  null
   */
  public static function manage_custom_columns( $column_name, $post_id ) {

    if ( 'featured' != $column_name ) {
      return;
    }

    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new Settings_Group( 'advanced_settings' );
    }

    $enabled = $advanced_setting_group->get_bool_option( 'featured-posts-enabled' );

    if ( !$enabled ) {
      return;
    }

    $featured = get_post_meta( $post_id, '_featured', true ) == 'yes';
    $filled   = $featured ? 'filled' : 'empty';

    echo Html::a( '#', '', [
        'data-id' => $post_id,
        'class'   => "dashicons dashicons-star-{$filled} toggle-featured"
    ] );
  }

  /**
   * Add featured column to admin pages
   *
   * @since   1.0.0
   *
   * @param   array     $posts_columns
   * @param   string    $post_type
   * @return  array
   */
  public static function manage_columns( $posts_columns ) {
    $new = array(
        'cb'       => $posts_columns['cb'],
        'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', SMGTOOLS_TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', SMGTOOLS_TEXTDOMAIN ) . '</span></span>'
    );

    $posts_columns = array_merge( $new, $posts_columns );
    return $posts_columns;
  }

  /**
   * Add backend funcionality to toggle featured posts
   *
   * @since   1.0.0
   */
  public static function toggle_featured_post() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
      error_reporting( E_ALL );
      ini_set( 'display_errors', 1 );
    }

    if ( !is_admin() ) {
      $error = new WP_Error( 'unauthorized', __( 'You are not authorized to perform this action.', SMGTOOLS_TEXTDOMAIN ), $data );
      wp_send_json_error( $error );
    }

    $post_id = (int) filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

    if ( empty( $post_id ) ) {
      $error = new WP_Error( 'invalid_data', __( 'The data that you entered is invalid.', SMGTOOLS_TEXTDOMAIN ), $data );
      wp_send_json_error( $error );
    }

    $post = get_post( $post_id );

    if ( empty( $post ) ) {
      $error = new WP_Error( 'invalid_data', __( 'The data that you entered is invalid.', SMGTOOLS_TEXTDOMAIN ), $data );
      wp_send_json_error( $error );
    }

    $featured = get_post_meta( $post_id, '_featured', true );

    if ( 'yes' == $featured ) {
      delete_post_meta( $post_id, '_featured' );
      $featured = false;
    } else {
      update_post_meta( $post_id, '_featured', 'yes' );
      $featured = true;
    }

    wp_send_json_success( compact( 'featured' ) );
  }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SourceFramework\Admin;

use SourceFramework\Template\Tag;
use WP_Error;

/**
 * Description of FeaturedPost
 *
 * @author perseo
 */
class FeaturedPost {

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

    $featured = get_post_meta( $post_id, '_featured', true );
    if ( in_array( $featured, array( 'yes', 1 ) ) ) {
      echo Tag::html( 'a.dashicons.dashicons-star-filled.toggle-featured', '', [ 'data-id' => $post_id ] );
    } else {
      echo Tag::html( 'a.dashicons.dashicons-star-empty.toggle-featured', '', [ 'data-id' => $post_id ] );
    }
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
  public static function manage_columns( $posts_columns, $post_type ) {
    $new = array(
        'cb'       => $posts_columns['cb'],
        'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', \SourceFramework\TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', \SourceFramework\TEXTDOMAIN ) . '</span></span>'
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
      $error = new WP_Error( 'unauthorized', __( 'You are not authorized to perform this action.', \SourceFramework\TEXTDOMAIN ), $data );
      wp_send_json_error( $error );
    }

    $post_id = (int) filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

    if ( empty( $post_id ) ) {
      $error = new WP_Error( 'invalid_data', __( 'The data that you entered is invalid.', \SourceFramework\TEXTDOMAIN ), $data );
      wp_send_json_error( $error );
    }

    $post = get_post( $post_id );

    if ( empty( $post ) ) {
      $error = new WP_Error( 'invalid_data', __( 'The data that you entered is invalid.', \SourceFramework\TEXTDOMAIN ), $data );
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

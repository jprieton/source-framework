<?php

namespace SourceFramework\Data;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Core\Error_Message;
use WC_Admin_Duplicate_Product;
use WP_Error;

/**
 * Description of Post
 *
 * @author perseo
 */
class Post {

  /**
   * Duplicate a post and set status to draft
   *
   * @param   int           $post_id
   * @return  int|WP_Error  Returns the post_ID of the duplicated post
   */
  public static function duplicate( $post_id ) {
    $post_id = absint( $post_id );

    if ( empty( $post_id ) ) {
      return Error_Message::invalid_data();
    }

    $post = get_post( $post_id );

    if ( empty( $post_id ) ) {
      return Error_Message::invalid_data();
    }

    // If the post_type is product and WooCommerce is active then use their duplicator
    if ( 'product' == $post->post_type && class_exists( 'WC_Admin_Duplicate_Product' ) ) {
      $wcadp   = new WC_Admin_Duplicate_Product();
      $product = $wcadp->product_duplicate( wc_get_product( $post_id ) );
      return (int) $product->id;
    }

    // Set publish status to draft
    $post->post_status = 'draft';
    $post->post_title  = sprintf( __( '%s (Copy)', SF_TEXTDOMAIN ), $post->post_title );

    // Removes old unnecesary data
    unset( $post->ID, $post->guid );

    // Filter data before create post
    $post = apply_filters( 'duplicate_post_data', $post );

    // Creates new post
    $new_post_id = wp_insert_post( (array) $post );

    // Clone metadata
    $data = get_post_meta( $post_id );
    foreach ( $data as $key => $values ) {
      foreach ( $values as $value ) {
        add_post_meta( $new_post_id, $key, $value );
      }
    }

    // Clone taxonomies
    $taxonomies = get_object_taxonomies( $post['post_type'] );
    foreach ( $taxonomies as $taxonomy ) {
      $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
      wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
    }

    return (int) $new_post_id;
  }

}

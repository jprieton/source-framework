<?php

namespace SourceFramework\Data;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Error;
use SourceFramework\Core\Error_Message;

/**
 * Description of Post
 *
 * @author perseo
 */
class Post {

  public static function duplicate( $post_id ) {
    $post_id = absint( $post_id );

    if ( empty( $post_id ) ) {
      return Error_Message::invalid_data();
    }

    $post = (array) get_post( $post_id );

    if ( empty( $post_id ) ) {
      return Error_Message::invalid_data();
    }

    // Set current user as author
    $post['post_author'] = get_current_user_id();

    // Set publish status to draft
    $post['post_status'] = 'draft';

    // Removes old unnecesary data
    unset( $post['ID'], $post['post_date'], $post['post_date_gmt'], $post['post_name'],
            $post['post_modified'], $post['post_modified_gmt'], $post['guid'] );

    // Filter data before create post
    $post = apply_filters( 'duplicate_post_data', $post );

    // Creates new post
    $new_post_id = wp_insert_post( $post );

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

    return $new_post_id;
  }

}

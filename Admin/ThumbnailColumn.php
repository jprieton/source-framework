<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Template\Tag;
use WP_Error;

class ThumbnailColumn {

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

    if ( 'thumbnail' != $column_name ) {
      return;
    }
    echo Tag::html( 'span.media-icon.image-icon', get_the_post_thumbnail( $post_id, 'thumbnail', [ 'class' => 'attachment-60x60 size-60x60' ] ) );
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
        'cb'        => $posts_columns['cb'],
        'thumbnail' =>  __( 'Thumbnail', \SourceFramework\TEXTDOMAIN )
    );

    $posts_columns = array_merge( $new, $posts_columns );
    return $posts_columns;
  }

}

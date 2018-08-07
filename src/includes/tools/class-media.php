<?php

namespace SourceFramework\Tools;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 *
 * @package        SourceFramework
 * @subpackage     Tools
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Media {

  /**
   * @since   2.0.0
   *
   * @param   int     $orig_w
   * @param   int     $orig_h
   * @return  array
   */
  public static function image_resize_dimensions( $orig_w, $orig_h ) {
    return [ $orig_w, $orig_h, 0, 0, $orig_w, $orig_h, $orig_w, $orig_h ];
  }

  /**
   * @since   2.0.0
   *
   * @param   array    $handle_upload    Response of the `wp_handle_upload` function
   * @return  int
   */
  public static function insert_attachment( $handle_upload, $args = [] ) {
    $post_title = preg_replace( '/\.[^.]+$/', '', basename( $handle_upload['file'] ) );

    $defaults  = [
        'post_mime_type' => $handle_upload['type'],
        'post_title'     => $post_title,
        'post_content'   => '',
        'post_status'    => 'inherit',
        'guid'           => $handle_upload['url']
    ];
    $post_data = wp_parse_args( $args, $defaults );

    if ( !function_exists( 'wp_generate_attachment_metadata' ) ) {
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/media.php');
    }

    $upload_dir      = wp_upload_dir();
    $filename        = str_replace( $upload_dir      ['baseurl'] . '/', '', $handle_upload['url'] );
    $attachment_id   = wp_insert_attachment( $post_data, $filename );
    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $handle_upload['file'] );
    wp_update_attachment_metadata( $attachment_id, $attachment_data );
    return $attachment_id;
  }

}

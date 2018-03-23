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
   * @param   array    $image_data    Response of the `wp_handle_upload` function
   * @return  int
   */
  public static function insert_attachment( $image_data, $args = [] ) {
    $post_title = preg_replace( '/\.[^.]+$/', '', basename( $image_data['file'] ) );

    $defaults  = [
        'post_mime_type' => $image_data['type'],
        'post_title'     => $post_title,
        'post_content'   => '',
        'post_status'    => 'inherit',
        'guid'           => $image_data['url']
    ];
    $post_data = wp_parse_args( $args, $defaults );

    if ( !function_exists( 'wp_generate_attachment_metadata' ) ) {
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/media.php');
    }

    $wp_upload_dir   = wp_upload_dir();
    $filename        = str_replace( $wp_upload_dir['baseurl'] . '/', '', $image_data['url'] );
    $attachment_id   = wp_insert_attachment( $post_data, $filename );
    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $image_data['file'] );
    wp_update_attachment_metadata( $attachment_id, $attachment_data );
    return $attachment_id;
  }

}
